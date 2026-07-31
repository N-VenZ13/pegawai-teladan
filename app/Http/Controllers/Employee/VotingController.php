<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Admin\RecapController;
use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Assignment;
use App\Models\Period;
use App\Models\Question;
use App\Models\User;
use App\Models\Winner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VotingController extends Controller
{
    public function index()
    {
        // 1. Cari periode yang sedang aktif
        $activePeriod = Period::where('status', 'active')->first();

        if (!$activePeriod) {
            return view('employee.voting.no_period');
        }

        // --- MULAI BLOK LOGIKA BARU ---
        $currentYear = $activePeriod->created_at->year;

        // 2. Ambil ID semua pemenang di tahun ini dari tabel 'winners'
        $quarantinedUserIds = Winner::where('year', $currentYear)->pluck('user_id');

        // 3. Ambil data lengkap user yang dikarantina
        $quarantinedUsers = User::whereIn('id', $quarantinedUserIds)->with('roles')->get();
        // --- SELESAI BLOK LOGIKA BARU ---

        /** @var \App\Models\User $user */ // <-- TAMBAHKAN PETUNJUK INI
        $user = Auth::user();

        // Gunakan variabel $user yang sudah jelas tipenya
        $allAssignments = $user->assignmentsAsVoter()
            ->where('period_id', $activePeriod->id)
            ->with('target')
            ->get()
            ->filter(fn($assignment) => $assignment->target !== null); 

        $completedAssignments = $allAssignments->where('status', 'completed');
        $pendingAssignments = $allAssignments->where('status', 'pending');

        $pendingPegawai = $pendingAssignments->filter(fn($a) => !$a->target->is_ketua_tim);
        $pendingKetuaTim = $pendingAssignments->filter(fn($a) => $a->target->is_ketua_tim);

        return view('employee.voting.index', compact(
            'activePeriod',
            'pendingPegawai',
            'pendingKetuaTim',
            'completedAssignments',
            'quarantinedUsers' // variabel baru untuk user yang dikarantina
        ));
    }

    public function show(Assignment $assignment)
    {
        // Keamanan 1: Pastikan user yang mengakses adalah voter yang benar
        if ($assignment->voter_id != Auth::id()) {
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
        if ((int)$assignment->voter_id !== (int)Auth::id() || $assignment->status === 'completed') {
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
        // $publishedPeriods = Period::where('status', 'published')->latest()->get();
        // return view('employee.results.list', compact('publishedPeriods'));

        $publishedPeriods = Period::where('status', 'published')
            ->orderBy('start_date', 'desc') // Urutkan berdasarkan tanggal mulai
            ->get()
            ->groupBy(function ($period) {
                // Kelompokkan berdasarkan tahun dari 'start_date'
                return $period->start_date->year;
            });

        return view('employee.results.list', compact('publishedPeriods'));
    }

    public function showResult(Period $period)
    {
        if ($period->status !== 'published') {
            abort(404);
        }

        // Buat instance dari RecapController untuk meminjam logikanya
        $recapController = new RecapController();

        // Panggil method kalkulasi DUA KALI
        $recapPegawai = $recapController->calculateRecap($period, 'pegawai');
        $recapKetuaTim = $recapController->calculateRecap($period, 'ketua_tim');

        return view('employee.results.show', compact('period', 'recapPegawai', 'recapKetuaTim'));
    }
}
