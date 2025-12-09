<?php

namespace App\Http\Controllers\Admin;

use App\Exports\KetuaTimTeladanExport;
use App\Exports\PeerToPeerExport;
use App\Exports\PegawaiTeladanExport;
use App\Exports\TeamLeaderPeerExport;
use App\Http\Controllers\Controller;
use App\Models\DisciplineScore;
use App\Models\LeaderAnswer;
use App\Models\Period;
use App\Models\User;
use App\Models\Winner;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;

class RecapController extends Controller
{
    public function selectPeriod()
    {
        // $periods = Period::whereIn('status', ['finished', 'published'])->latest()->get();
        // return view('admin.recap.select_period', compact('periods'));

        // baru ada daftarnya
        $periods = Period::whereIn('status', ['finished', 'published'])
            ->orderBy('start_date', 'desc') // Urutkan berdasarkan tanggal mulai
            ->get()
            ->groupBy(function ($period) {
                // Kelompokkan berdasarkan tahun dari 'start_date'
                return $period->start_date->year;
            });

        return view('admin.recap.select_period', compact('periods'));
    }

    public function show(Period $period)
    {
        $recapPegawai = $this->calculateRecap($period, 'pegawai');
        $recapKetuaTim = $this->calculateRecap($period, 'ketua_tim');
        return view('admin.recap.show', compact('period', 'recapPegawai', 'recapKetuaTim'));
    }

    public function calculateRecap(Period $period, string $targetRole = 'all')
    {
        // Mengambil total skor penilaian rekan (C1)
        $peerScores = DB::table('assignments')
            ->join('answers', 'assignments.id', '=', 'answers.assignment_id')
            ->where('assignments.period_id', $period->id)
            ->groupBy('assignments.target_id')
            ->select('assignments.target_id as user_id', DB::raw('SUM(answers.score) as total_score'))
            ->pluck('total_score', 'user_id');

        // Mengambil total skor evaluasi kepala (C2)
        $leaderScores = LeaderAnswer::where('period_id', $period->id)
            ->groupBy('target_id')
            ->select('target_id as user_id', DB::raw('SUM(score) as total_score'))
            ->pluck('total_score', 'user_id');

        $skpScores = $period->skpScores()->get()->mapWithKeys(function ($item) {
            $total = $item->month_1_score + $item->month_2_score + $item->month_3_score;
            return [$item->user_id => $total];
        });

        $disciplineScores = DisciplineScore::where('period_id', $period->id)
            ->groupBy('user_id')
            ->select('user_id', DB::raw('SUM(score) as total_score'))
            ->pluck('total_score', 'user_id');

        $userIdsInPeriod = collect($peerScores->keys())
            ->merge($leaderScores->keys())
            ->merge($skpScores->keys())
            ->merge($disciplineScores->keys())
            ->unique();

        if ($userIdsInPeriod->isEmpty()) {
            return collect();
        }

        $usersQuery = User::whereIn('id', $userIdsInPeriod)->withTrashed();

        if ($targetRole === 'pegawai') {
            $usersQuery->role('Pegawai')->where('is_ketua_tim', false);
        } elseif ($targetRole === 'ketua_tim') {
            $usersQuery->role(['Pegawai', 'Kepala BPS'])->where('is_ketua_tim', true);
        }

        $users = $usersQuery->orderBy('name')->get();

        $results = [];
        foreach ($users as $user) {
            $peerScore = $peerScores->get($user->id, 0);
            $leaderScore = $leaderScores->get($user->id, 0);
            $skpScore = $skpScores->get($user->id, 0);
            $disciplineScore = $disciplineScores->get($user->id, 0);

            // inisiaslisasi bobot
            $bobot_peer = 0.30;
            $bobot_leader = 0.30;
            $bobot_skp = 0.10;
            $bobot_discipline = 0.30;

            // proses perhitungan final score
            $finalScore =
                ($peerScore * $bobot_peer) +
                ($leaderScore * $bobot_leader) +
                ($skpScore * $bobot_skp) +
                ($disciplineScore * $bobot_discipline);

            // memasukkan data ke array hasil
            $results[] = [
                'user' => $user,
                'peer_score' => $peerScore,
                'leader_score' => $leaderScore,
                'skp_score' => $skpScore,
                'discipline_score' => $disciplineScore,
                'final_score' => round($finalScore, 2),
            ];
        }

        $sortedResults = collect($results)->sortByDesc('final_score');
        return $sortedResults->values();
    }

    public function publish(Period $period): RedirectResponse
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!$user || !$user->hasRole(['Admin', 'Kepala BPS'])) {
            abort(403, 'Hanya Pimpinan yang dapat mempublikasikan hasil.');
        }

        $year = $period->created_at->year;

        DB::transaction(function () use ($period, $year) {
            $pegawaiWinnerData = $this->calculateRecap($period, 'pegawai')->first();
            if ($pegawaiWinnerData) {
                Winner::updateOrCreate(
                    ['period_id' => $period->id, 'category' => 'pegawai'],
                    ['user_id' => $pegawaiWinnerData['user']->id, 'year' => $year]
                );
            }

            $ketuaTimWinnerData = $this->calculateRecap($period, 'ketua_tim')->first();
            if ($ketuaTimWinnerData) {
                Winner::updateOrCreate(
                    ['period_id' => $period->id, 'category' => 'ketua_tim'],
                    ['user_id' => $ketuaTimWinnerData['user']->id, 'year' => $year]
                );
            }

            $period->update(['status' => 'published']);
        });

        return redirect()->route('recap.show', $period->id)
            ->with('success', 'Hasil penilaian berhasil dipublikasikan dan data pemenang telah dicatat.');
    }

    public function uploadFiles(Request $request, Period $period)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!$user || !$user->hasRole(['Admin', 'Kepala BPS'])) {
            abort(403);
        }

        $request->validate([
            'sk_pegawai' => 'nullable|file|mimes:pdf|max:2048',
            'sertifikat_pegawai' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'sk_ketua_tim' => 'nullable|file|mimes:pdf|max:2048',
            'sertifikat_ketua_tim' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $filesToUpdate = [
            'sk_pegawai' => 'sk_pegawai_path',
            'sertifikat_pegawai' => 'sertifikat_pegawai_path',
            'sk_ketua_tim' => 'sk_ketua_tim_path',
            'sertifikat_ketua_tim' => 'sertifikat_ketua_tim_path',
        ];

        foreach ($filesToUpdate as $inputName => $columnName) {
            if ($request->hasFile($inputName)) {
                if ($period->$columnName) {
                    Storage::disk('public')->delete($period->$columnName);
                }
                $path = $request->file($inputName)->store('documents/' . $inputName, 'public');
                $period->update([$columnName => $path]);
            }
        }
        return redirect()->back()->with('success', 'File berhasil diunggah.');
    }

    public function exportPeerToPeer(Period $period)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!$user || !$user->hasRole(['Admin', 'Kepala BPS'])) {
            abort(403, 'Aksi tidak diizinkan.');
        }

        $fileName = 'Laporan_PeerToPeer_Pegawai_' . Str::slug($period->name) . '.xlsx';
        return Excel::download(new PeerToPeerExport($period), $fileName);
    }

    public function exportTeamLeaderPeer(Period $period)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!$user || !$user->hasRole(['Admin', 'Kepala BPS'])) {
            abort(403, 'Aksi tidak diizinkan.');
        }
        $fileName = 'Laporan_PeerToPeer_KetuaTim_' . Str::slug($period->name) . '.xlsx';
        return Excel::download(new TeamLeaderPeerExport($period), $fileName);
    }

    public function exportPegawaiTeladan(Period $period)
    {
        $fileName = 'Laporan_Anggota_Tim_Teladan_' . Str::slug($period->name) . '.xlsx';
        return Excel::download(new PegawaiTeladanExport($period), $fileName);
    }

    public function exportKetuaTimTeladan(Period $period)
    {
        $fileName = 'Laporan_Ketua_Tim_Teladan_' . Str::slug($period->name) . '.xlsx';
        return Excel::download(new KetuaTimTeladanExport($period), $fileName);
    }
}
