<?php

namespace App\Http\Controllers\Leader;

use App\Http\Controllers\Controller;
use App\Models\LeaderAnswer;
use App\Models\LeaderCriterion;
use App\Models\LeaderEvaluation;
use App\Models\Period;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EvaluationController extends Controller
{
    public function index()
    {
        $activePeriod = Period::where('status', 'active')->first();
        if (!$activePeriod) {
            return view('leader.evaluation.no_period'); // Buat view ini
        }

        // Ambil semua user kecuali Admin dan pimpinan itu sendiri
        $users = User::role(['Pegawai', 'Pimpinan'])
            ->where('id', '!=', Auth::id())
            ->get();

        // Ambil SEMUA kriteria yang aktif
        $criteria = LeaderCriterion::where('is_active', true)->get();

        // Ambil nilai yang sudah ada, tapi strukturnya sekarang beda
        $existingScores = LeaderAnswer::where('period_id', $activePeriod->id)
            ->where('leader_id', Auth::id())
            ->get()
            ->keyBy(function ($item) {
                // Buat key unik: "targetId-criterionId" -> "12-1"
                return $item->target_id . '-' . $item->leader_criterion_id;
            })
            ->map(function ($item) {
                // Hanya ambil skornya
                return $item->score;
            });

        return view('leader.evaluation.index', compact('activePeriod', 'users', 'criteria', 'existingScores'));
    }

    public function store(Request $request)
    {
        $activePeriod = Period::where('status', 'active')->firstOrFail();
        $leaderId = Auth::id();

        $request->validate([
            'scores' => 'present|array', // 'present' memastikan 'scores' ada, meskipun kosong
            'scores.*.*' => 'nullable|integer|min:0|max:100',
        ]);

        DB::beginTransaction();
        try {
            foreach ($request->scores as $targetId => $criterionScores) {
                foreach ($criterionScores as $criterionId => $score) {
                    // Gunakan updateOrCreate untuk menangani per baris data
                    // Ini lebih jelas dan aman daripada upsert untuk kasus nested array
                    LeaderAnswer::updateOrCreate(
                        [
                            // Kondisi untuk mencari baris data
                            'period_id' => $activePeriod->id,
                            'leader_id' => $leaderId,
                            'target_id' => $targetId,
                            'leader_criterion_id' => $criterionId,
                        ],
                        [
                            // Data untuk di-update atau di-create
                            'score' => $score ?? 0, // Jika score null, simpan sebagai 0
                        ]
                    );
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            // Tampilkan error untuk debugging, bisa dihapus saat production
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Penilaian berhasil disimpan.');
    }
}
