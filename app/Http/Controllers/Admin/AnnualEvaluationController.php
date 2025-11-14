<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AnnualEvaluation;
use App\Models\User;
use App\Models\Winner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnnualEvaluationController extends Controller
{
    /**
     * Menampilkan form untuk input/edit skor evaluasi tahunan.
     */
    public function create(Request $request)
    {
        // Tentukan tahun yang akan diproses, default ke tahun saat ini jika tidak ada input
        $year = $request->input('year', now()->year);

        // 1. Ambil ID unik dari semua pemenang di tahun yang dipilih
        $winnerUserIds = Winner::where('year', $year)->pluck('user_id')->unique();

        // 2. Ambil data lengkap para kandidat (pemenang)
        $candidates = User::whereIn('id', $winnerUserIds)->orderBy('name')->get();

        // 3. Ambil skor yang mungkin sudah ada di database untuk ditampilkan kembali di form
        $existingScores = AnnualEvaluation::where('year', $year)
            ->pluck('score', 'user_id');

        return view('admin.annual-evaluation.form', compact('year', 'candidates', 'existingScores'));
    }

    /**
     * Menyimpan atau memperbarui skor evaluasi tahunan.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'year' => 'required|integer',
            'scores' => 'required|array',
            'scores.*' => 'nullable|integer|min:0|max:100', // Boleh null jika tidak diisi
        ]);

        foreach ($validated['scores'] as $userId => $score) {
            // Jika skor tidak diisi (kosong), lewati saja
            if (is_null($score)) {
                continue;
            }

            AnnualEvaluation::updateOrCreate(
                [
                    'year' => $validated['year'],
                    'user_id' => $userId,
                ],
                [
                    'score' => $score,
                    'evaluator_id' => Auth::id(),
                ]
            );
        }

        return redirect()->back()->with('success', 'Skor evaluasi tahunan berhasil disimpan!');
    }

    /**
     * Menampilkan halaman rekapitulasi peringkat tahunan.
     */
    public function show(Request $request)
    {
        $year = $request->input('year', now()->year);

        // Ambil semua data evaluasi untuk tahun yang dipilih, urutkan berdasarkan skor tertinggi
        $results = AnnualEvaluation::where('year', $year)
            ->with('user') // Eager load data user untuk efisiensi
            ->orderBy('score', 'desc')
            ->get();

        return view('admin.annual-evaluation.recap', compact('year', 'results'));
    }
}
