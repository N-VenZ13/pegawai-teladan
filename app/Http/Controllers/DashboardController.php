<?php

namespace App\Http\Controllers;

use App\Models\Period;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Jika user tidak ada (kasus aneh), tampilkan halaman login
        if (!$user) {
            return redirect()->route('login');
        }

        // Jika Admin, tampilkan dashboard admin
        if ($user->hasRole('Admin')) {
            return $this->adminDashboard();
        }

        // Untuk SEMUA role lain (Pegawai, Pimpinan, Bagian Umum),
        // tampilkan dashboard karyawan/pegawai.
        if ($user->hasRole(['Pegawai', 'Pimpinan', 'Bagian Umum'])) {
            return $this->employeeDashboard($user);
        }

        // Jika ada role lain di masa depan yang belum terdefinisi,
        // kita bisa buat halaman default.
        // Untuk sekarang, kita arahkan saja ke halaman profile.
        return redirect()->route('profile.edit');
    }

    private function adminDashboard()
    {
        $totalPegawai = User::role('Pegawai')->count();
        $totalPimpinan = User::role('Pimpinan')->count();
        $activePeriod = Period::where('status', 'active')->first();

        // --- PERBAIKAN DI SINI ---
        // Inisialisasi kedua variabel di awal
        $progress = ['completed' => 0, 'total' => 0, 'percentage' => 0];
        $publishedResults = null;
        // -------------------------

        if ($activePeriod) {
            $completed = $activePeriod->assignments()->where('status', 'completed')->count();
            $total = $activePeriod->assignments()->count();
            if ($total > 0) { // Tambahan: Mencegah pembagian dengan nol
                $progress['completed'] = $completed;
                $progress['total'] = $total;
                $progress['percentage'] = round(($completed / $total) * 100);
            }
        } else {
            // Jika tidak ada periode aktif, baru cari hasil yang sudah dipublikasi
            $publishedResults = Period::where('status', 'published')->latest()->first();
        }

        return view('admin.dashboard', compact(
            'totalPegawai',
            'totalPimpinan',
            'activePeriod',
            'progress',
            'publishedResults'
        ));
    }

    private function employeeDashboard(User $user)
    {
        $activePeriod = Period::where('status', 'active')->first();

        $pendingAssignmentsCount = 0;
        if ($activePeriod) {
            $pendingAssignmentsCount = $user->assignmentsAsVoter()
                ->where('period_id', $activePeriod->id)
                ->where('status', 'pending')
                ->count();
        }

        $latestPublishedPeriod = Period::where('status', 'published')->latest()->first();

        return view('dashboard', compact(
            'user',
            'activePeriod',
            'pendingAssignmentsCount',
            'latestPublishedPeriod'
        ));
    }
}
