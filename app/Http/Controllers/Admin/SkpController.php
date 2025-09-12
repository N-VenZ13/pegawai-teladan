<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Period;
use App\Models\SkpScore;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SkpController extends Controller
{
    public function index()
    {
        $activePeriod = Period::where('status', 'active')->first();
        if (!$activePeriod) {
            return view('admin.skp.no_period');
        }

        // Ambil semua user yang relevan (Pegawai & Pimpinan)
        // $users = User::role(['Pegawai', 'Pimpinan'])->orderBy('name')->get();
        $users = User::role('Pegawai')->orderBy('name')->get();

        // Ambil data nilai SKP yang sudah ada. Strukturnya sedikit berbeda
        $existingScores = SkpScore::where('period_id', $activePeriod->id)
            ->get()
            ->keyBy('user_id'); // Jadikan user_id sebagai key utama

        return view('admin.skp.index', compact('activePeriod', 'users', 'existingScores'));
    }

    public function store(Request $request)
    {
        $activePeriod = Period::where('status', 'active')->firstOrFail();

        $request->validate([
            'scores' => 'present|array',
            'scores.*.month_1' => 'nullable|numeric|gte:0|max:100', // Validasi nested array
            'scores.*.month_2' => 'nullable|numeric|gte:0|max:100',
            'scores.*.month_3' => 'nullable|numeric|gte:0|max:100',
        ]);

        DB::beginTransaction(); // Gunakan DB Transaction untuk keamanan
        try {
            foreach ($request->scores as $userId => $monthlyScores) {
                SkpScore::updateOrCreate(
                    [
                        'period_id' => $activePeriod->id,
                        'user_id' => $userId,
                    ],
                    [
                        'month_1_score' => $monthlyScores['month_1'] ?? 0,
                        'month_2_score' => $monthlyScores['month_2'] ?? 0,
                        'month_3_score' => $monthlyScores['month_3'] ?? 0,
                    ]
                );
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Nilai SKP berhasil disimpan.');
    }
}
