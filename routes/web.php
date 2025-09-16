<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PeriodController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\LeaderCriterionController;
use App\Http\Controllers\Admin\AssignmentController;
use App\Http\Controllers\DisciplineCriterionController;
use App\Http\Controllers\DisciplineScoreController;
use App\Http\Controllers\SkpController;
use App\Http\Controllers\Leader\EvaluationController;
use App\Http\Controllers\Employee\VotingController;
use App\Http\Controllers\Admin\RecapController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // --- RUTE KHUSUS ADMIN ---
    Route::middleware(['role:Admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::resource('users', UserController::class);
        Route::resource('periods', PeriodController::class);
        Route::resource('questions', QuestionController::class);
        Route::resource('leader-criteria', LeaderCriterionController::class);
        Route::get('periods/{period}/assignments', [AssignmentController::class, 'index'])->name('assignments.index');
        Route::post('periods/{period}/assignments', [AssignmentController::class, 'generate'])->name('assignments.generate');
    });

    // --- RUTE UNTUK BAGIAN UMUM (DAN ADMIN) ---
    Route::prefix('discipline')->name('discipline.')->middleware(['role:Admin|Bagian Umum'])->group(function () {
        Route::resource('criteria', DisciplineCriterionController::class)->names('criteria');
        Route::get('scores', [DisciplineScoreController::class, 'index'])->name('scores.index');
        Route::post('scores', [DisciplineScoreController::class, 'store'])->name('scores.store');
    });

    Route::prefix('skp-scores')->name('skp.')->middleware(['role:Admin|Bagian Umum'])->group(function () {
        Route::get('/', [SkpController::class, 'index'])->name('index');
        Route::post('/', [SkpController::class, 'store'])->name('store');
    });

    // --- RUTE KHUSUS PIMPINAN ---
    Route::prefix('evaluasi-pimpinan')->name('leader.evaluation.')->middleware(['role:Pimpinan'])->group(function () {
        Route::get('/', [EvaluationController::class, 'index'])->name('index');
        Route::post('/', [EvaluationController::class, 'store'])->name('store');
    });

    // --- RUTE REKAPITULASI (ADMIN & PIMPINAN) ---
    Route::prefix('rekapitulasi')->name('recap.')->middleware(['role:Admin|Pimpinan'])->group(function () {
        Route::get('/', [RecapController::class, 'selectPeriod'])->name('select_period');
        Route::get('/{period}', [RecapController::class, 'show'])->name('show');
        Route::post('/{period}/publish', [RecapController::class, 'publish'])->name('publish');
        Route::post('/{period}/upload', [RecapController::class, 'uploadFiles'])->name('upload_files');
        Route::get('/{period}/export/peer-to-peer', [RecapController::class, 'exportPeerToPeer'])->name('export.peer_to_peer');
        Route::get('/{period}/export/team-leader-peer', [RecapController::class, 'exportTeamLeaderPeer'])->name('export.team_leader_peer');
        Route::get('/{period}/export/pegawai-teladan', [RecapController::class, 'exportPegawaiTeladan'])->name('export.pegawai_teladan');
        Route::get('/{period}/export/ketua-tim-teladan', [RecapController::class, 'exportKetuaTimTeladan'])->name('export.ketua_tim_teladan');
    });

    // --- RUTE PEGAWAI & PIMPINAN ---
    Route::prefix('penilaian')->name('voting.')->middleware(['role:Pegawai|Pimpinan'])->group(function () {
        Route::get('/tugas-saya', [VotingController::class, 'index'])->name('index');
        Route::get('/hasil', [VotingController::class, 'listPublishedPeriods'])->name('results.list');
        Route::get('/hasil/{period}', [VotingController::class, 'showResult'])->name('results.show');
        Route::get('/{assignment}', [VotingController::class, 'show'])->name('show');
        Route::post('/{assignment}', [VotingController::class, 'store'])->name('store');
    });
});

require __DIR__ . '/auth.php';
