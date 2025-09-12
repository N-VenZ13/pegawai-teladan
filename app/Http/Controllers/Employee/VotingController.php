<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Admin\RecapController;
use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Assignment;
use App\Models\Period;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VotingController extends Controller
{
    public function index()
    {
        // 1. Cari periode yang sedang aktif
        $activePeriod = Period::where('status', 'active')->first();

        // Jika tidak ada periode aktif, tampilkan halaman kosong
        if (!$activePeriod) {
            return view('employee.voting.no_period');
        }

        // 2. Ambil semua tugas penilaian untuk user yang sedang login di periode aktif
        /** @var \App\Models\User $user */ // Ini adalah "petunjuk" untuk editor
        $user = Auth::user();

        $assignments = $user->assignmentsAsVoter()
            ->where('period_id', $activePeriod->id)
            ->with('target')
            ->get();

        // 3. Pisahkan antara yang sudah dan belum selesai
        $completedAssignments = $assignments->where('status', 'completed');
        $pendingAssignments = $assignments->where('status', 'pending');

        return view('employee.voting.index', compact(
            'activePeriod',
            'pendingAssignments',
            'completedAssignments'
        ));
    }

    public function show(Assignment $assignment)
    {
        // Keamanan 1: Pastikan user yang mengakses adalah voter yang benar
        if ($assignment->voter_id !== Auth::id()) {
            abort(403, 'AKSI TIDAK DIIZINKAN');
        }

        // Keamanan 2: Pastikan assignment ini belum selesai dinilai
        if ($assignment->status === 'completed') {
            return redirect()->route('voting.index')->with('error', 'Anda sudah menyelesaikan penilaian ini.');
        }

        // Ambil pertanyaan yang relevan
        // Jika target adalah ketua tim, ambil pertanyaan 'ketua_tim'. Jika bukan, ambil 'pegawai'
        $type = $assignment->target->is_ketua_tim ? 'ketua_tim' : 'pegawai';

        $questions = Question::where('type', $type)
            ->where('is_active', true)
            ->get();

        return view('employee.voting.show', compact('assignment', 'questions'));
    }

    public function store(Request $request, Assignment $assignment)
    {
        // Keamanan (sama seperti di method show)
        if ($assignment->voter_id !== Auth::id() || $assignment->status === 'completed') {
            abort(403);
        }

        // Ambil ID dari pertanyaan yang relevan untuk validasi
        $type = $assignment->target->is_ketua_tim ? 'ketua_tim' : 'pegawai';
        $questionIds = Question::where('type', $type)->where('is_active', true)->pluck('id');

        // Validasi
        $request->validate([
            // Pastikan 'scores' adalah array
            'scores' => 'required|array',
            // Pastikan setiap item dalam 'scores' punya key yang valid (ID pertanyaan)
            'scores.*' => 'required|integer|min:1|max:10',
        ]);

        // DB Transaction: memastikan semua query berhasil atau tidak sama sekali
        DB::beginTransaction();
        try {
            $answers = [];
            $now = now();

            foreach ($request->scores as $questionId => $score) {
                // Pastikan questionId yang di-submit ada dalam daftar pertanyaan yang valid
                if ($questionIds->contains($questionId)) {
                    $answers[] = [
                        'assignment_id' => $assignment->id,
                        'question_id' => $questionId,
                        'score' => $score,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];
                }
            }

            // Simpan semua jawaban dalam satu query
            Answer::insert($answers);

            // Update status assignment menjadi 'completed'
            $assignment->update(['status' => 'completed']);

            DB::commit(); // Jika semua berhasil, simpan permanen

        } catch (\Exception $e) {
            DB::rollBack(); // Jika ada error, batalkan semua query
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan penilaian.');
        }

        return redirect()->route('voting.index')->with('success', 'Terima kasih, penilaian Anda telah disimpan.');
    }

    public function listPublishedPeriods()
    {
        $publishedPeriods = Period::where('status', 'published')->latest()->get();
        return view('employee.results.list', compact('publishedPeriods'));
    }

    public function showResult(Period $period)
    {
        // Pastikan periode yang diakses sudah published
        if ($period->status !== 'published') {
            abort(404);
        }

        // Pinjam logika kalkulasi dari RecapController
        // Ini cara cepat, cara yang lebih ideal adalah memindahkan logika kalkulasi ke "Service Class"
        // tersendiri, tapi untuk sekarang ini sudah cukup.
        $recapController = new RecapController();
        $recapData = $recapController->calculateRecap($period); // Kita akan buat method ini

        return view('employee.results.show', compact('period', 'recapData'));
    }
}
