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
        $periods = Period::whereIn('status', ['finished', 'published'])->latest()->get();
        return view('admin.recap.select_period', compact('periods'));
    }

    // Hanya ada SATU method show()
    public function show(Period $period)
    {
        // Panggil calculateRecap dengan parameter default 'all' untuk tampilan web
        $recapData = $this->calculateRecap($period, 'all');
        return view('admin.recap.show', compact('period', 'recapData'));
    }

    // Hanya ada SATU method calculateRecap()
    public function calculateRecap(Period $period, string $targetRole = 'all')
    {
        if ($targetRole === 'pegawai') {
            $users = User::role('Pegawai')->where('is_ketua_tim', false)->orderBy('name')->get();
        } elseif ($targetRole === 'ketua_tim') {
            $users = User::role(['Pegawai', 'Pimpinan'])->where('is_ketua_tim', true)->orderBy('name')->get();
        } else {
            $users = User::role(['Pegawai', 'Pimpinan'])->orderBy('name')->get();
        }

        $peerScores = DB::table('assignments')
            ->join('answers', 'assignments.id', '=', 'answers.assignment_id')
            ->where('assignments.period_id', $period->id)
            ->groupBy('assignments.target_id')
            ->select('assignments.target_id as user_id', DB::raw('AVG(answers.score) as average_score'))
            ->pluck('average_score', 'user_id');

        $leaderScores = LeaderAnswer::where('period_id', $period->id)
            ->groupBy('target_id')
            ->select('target_id as user_id', DB::raw('SUM(score) as total_score'))
            ->pluck('total_score', 'user_id');

        $skpScores = $period->skpScores()->get()->mapWithKeys(function ($item) {
            $avg = ($item->month_1_score + $item->month_2_score + $item->month_3_score) / 3;
            return [$item->user_id => $avg];
        });

        $disciplineScores = DisciplineScore::where('period_id', $period->id)
            ->groupBy('user_id')
            ->select('user_id', DB::raw('SUM(score) as total_score'))
            ->pluck('total_score', 'user_id');

        $results = [];
        foreach ($users as $user) {
            $peerScore = $peerScores->get($user->id, 0);
            $leaderScore = $leaderScores->get($user->id, 0);
            $skpScore = $skpScores->get($user->id, 0);
            $disciplineScore = $disciplineScores->get($user->id, 0);

            $finalScore =
                (($peerScore * 10) * 0.10) +
                ($leaderScore * 0.40) +
                ($skpScore * 0.30) +
                ($disciplineScore * 0.20);

            $results[] = [
                'user' => $user,
                'peer_score' => round($peerScore, 2),
                'leader_score' => $leaderScore,
                'skp_score' => round($skpScore, 2),
                'discipline_score' => $disciplineScore,
                'final_score' => round($finalScore, 2),
            ];
        }

        return collect($results)->sortByDesc('final_score');
    }

    public function publish(Period $period)
    {
        // Hanya Pimpinan yang bisa publish
        /** @var \App\Models\User $user */ // <-- Beri petunjuk pada editor
        $user = Auth::user();

        // Hanya Pimpinan yang bisa publish
        if (!$user || !$user->hasRole('Pimpinan')) {
            abort(403, 'Hanya Pimpinan yang dapat mempublikasikan hasil.');
        }

        $period->update(['status' => 'published']);

        return redirect()->route('recap.show', $period->id)
            ->with('success', 'Hasil penilaian berhasil dipublikasikan!');
    }

    public function uploadFiles(Request $request, Period $period)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!$user || !$user->hasRole('Pimpinan')) {
            abort(403);
        }

        $request->validate([
            'sk_file' => 'nullable|file|mimes:pdf|max:2048', // maks 2MB
            'sertifikat_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('sk_file')) {
            // Hapus file lama jika ada
            if ($period->sk_file_path) {
                Storage::disk('public')->delete($period->sk_file_path);
            }
            $path = $request->file('sk_file')->store('documents/sk', 'public');
            $period->update(['sk_file_path' => $path]);
        }

        if ($request->hasFile('sertifikat_file')) {
            if ($period->sertifikat_file_path) {
                Storage::disk('public')->delete($period->sertifikat_file_path);
            }
            $path = $request->file('sertifikat_file')->store('documents/sertifikat', 'public');
            $period->update(['sertifikat_file_path' => $path]);
        }

        return redirect()->back()->with('success', 'File berhasil diunggah.');
    }

    public function exportPeerToPeer(Period $period)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Cek jika user ada DAN punya salah satu dari role yang diizinkan
        if (!$user || !$user->hasRole(['Admin', 'Pimpinan'])) {
            abort(403, 'Aksi tidak diizinkan.');
        }

        // Tentukan nama file
        $fileName = 'Laporan_PeerToPeer_Pegawai_' . Str::slug($period->name) . '.xlsx';

        // Panggil Laravel Excel untuk men-download
        return Excel::download(new PeerToPeerExport($period), $fileName);
    }

    public function exportTeamLeaderPeer(Period $period)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Cek jika user ada DAN punya salah satu dari role yang diizinkan
        if (!$user || !$user->hasRole(['Admin', 'Pimpinan'])) {
            abort(403, 'Aksi tidak diizinkan.');
        }
        $fileName = 'Laporan_PeerToPeer_KetuaTim_' . Str::slug($period->name) . '.xlsx';
        return Excel::download(new TeamLeaderPeerExport($period), $fileName);
    }

    public function exportPegawaiTeladan(Period $period) {
        $fileName = 'Rekap_Pegawai_Teladan_' . Str::slug($period->name) . '.xlsx';
        return Excel::download(new PegawaiTeladanExport($period), $fileName);
    }
    
    public function exportKetuaTimTeladan(Period $period) {
        $fileName = 'Rekap_Ketua_Tim_Teladan_' . Str::slug($period->name) . '.xlsx';
        return Excel::download(new KetuaTimTeladanExport($period), $fileName);
    }

    
}
