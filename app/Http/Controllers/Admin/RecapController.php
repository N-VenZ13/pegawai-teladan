<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DisciplineScore;
use App\Models\LeaderAnswer;
use App\Models\Period;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class RecapController extends Controller
{
    public function selectPeriod()
    {
        // Ambil semua periode yang sudah selesai atau sudah dipublikasi
        $periods = Period::whereIn('status', ['finished', 'published'])->latest()->get();
        return view('admin.recap.select_period', compact('periods'));
    }

    public function show(Period $period)
    {
        // Panggil method kalkulasi yang sudah kita buat
        $recapData = $this->calculateRecap($period);

        // Langsung kirim hasilnya ke view
        return view('admin.recap.show', compact('period', 'recapData'));
    }

    public function calculateRecap(Period $period)
    {
        $users = User::role(['Pegawai', 'Pimpinan'])->orderBy('name')->get();

        // 1. Ambil Rata-rata Nilai Voting Rekan Kerja (SAMA SEPERTI SEBELUMNYA)
        $peerScores = DB::table('assignments')
            ->join('answers', 'assignments.id', '=', 'answers.assignment_id')
            ->where('assignments.period_id', $period->id)
            ->groupBy('assignments.target_id')
            ->select('assignments.target_id as user_id', DB::raw('AVG(answers.score) as average_score'))
            ->pluck('average_score', 'user_id');

        // --- LOGIKA BARU ---

        // 2. Ambil TOTAL Nilai Kriteria dari Pimpinan
        $leaderScores = LeaderAnswer::where('period_id', $period->id)
            ->groupBy('target_id')
            ->select('target_id as user_id', DB::raw('SUM(score) as total_score'))
            ->pluck('total_score', 'user_id');

        // 3. Ambil RATA-RATA Nilai SKP Bulanan
        $skpScores = $period->skpScores()->get()->mapWithKeys(function ($item) {
            $avg = ($item->month_1_score + $item->month_2_score + $item->month_3_score) / 3;
            return [$item->user_id => $avg];
        });

        // 4. Ambil TOTAL Nilai Kriteria Disiplin
        $disciplineScores = DisciplineScore::where('period_id', $period->id)
            ->groupBy('user_id')
            ->select('user_id', DB::raw('SUM(score) as total_score'))
            ->pluck('total_score', 'user_id');

        // 5. Proses Kalkulasi dengan Formula Baru
        $results = [];
        foreach ($users as $user) {
            $peerScore = $peerScores->get($user->id, 0);
            $leaderScore = $leaderScores->get($user->id, 0);
            $skpScore = $skpScores->get($user->id, 0);
            $disciplineScore = $disciplineScores->get($user->id, 0);

            // --- FORMULA PERHITUNGAN BARU (SESUAIKAN BOBOTNYA!) ---
            // Contoh bobot:
            // Peer/360: 10%, Leader: 40%, SKP: 30%, Disiplin: 20%
            // CATATAN: Sesuaikan angka pembagi dan bobot sesuai aturan perusahaan Anda!
            $finalScore =
                // Nilai rekan (skala 1-10, dijadikan 1-100)
                (($peerScore * 10) * 0.10) +
                // Nilai Pimpinan (jumlah total, mungkin perlu dibagi jumlah kriteria lalu dikali bobot)
                // Asumsi: Nilai total / jumlah kriteria * bobot
                // (Kita sederhanakan dulu, langsung kali bobot)
                ($leaderScore * 0.40) +
                // Rata-rata SKP (sudah skala 1-100)
                ($skpScore * 0.30) +
                // Total Nilai Disiplin (asumsi sama seperti pimpinan)
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
}
