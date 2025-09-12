<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DisciplineCriterion;
use App\Models\DisciplineScore;
use App\Models\Period;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DisciplineScoreController extends Controller
{
    public function index()
    {
        $activePeriod = Period::where('status', 'active')->first();
        if (!$activePeriod) {
            return view('discipline-scores.no_period');
        }
        // $users = User::role(['Pegawai', 'Pimpinan'])->orderBy('name')->get();
        $users = User::role('Pegawai')->orderBy('name')->get();
        $criteria = DisciplineCriterion::where('is_active', true)->get();
        $existingScores = DisciplineScore::where('period_id', $activePeriod->id)
            ->get()
            ->keyBy(fn($item) => $item->user_id . '-' . $item->discipline_criterion_id)
            ->map(fn($item) => $item->score);

        return view('discipline-scores.index', compact('activePeriod', 'users', 'criteria', 'existingScores'));
    }

    public function store(Request $request)
    {
        $activePeriod = Period::where('status', 'active')->firstOrFail();
        $request->validate([
            'scores' => 'present|array',
            'scores.*.*' => 'nullable|integer|min:0|max:100',
        ]);

        DB::beginTransaction();
        try {
            foreach ($request->scores as $userId => $criterionScores) {
                foreach ($criterionScores as $criterionId => $score) {
                    DisciplineScore::updateOrCreate(
                        [
                            'period_id' => $activePeriod->id,
                            'user_id' => $userId,
                            'discipline_criterion_id' => $criterionId,
                        ],
                        ['score' => $score ?? 0]
                    );
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
        return redirect()->back()->with('success', 'Nilai Disiplin berhasil disimpan.');
    }
}
