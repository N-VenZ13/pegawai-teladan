<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\Period;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AssignmentController extends Controller
{
    public function index(Period $period)
    {
        // Load data assignment beserta nama penilai dan yang dinilai
        $assignments = $period->assignments()->with(['voter', 'target'])->paginate(20);
        return view('admin.assignments.index', compact('period', 'assignments'));
    }

    public function generate(Period $period)
    {
        $users = User::role(['Pegawai', 'Kepala BPS'])->get();
        $period->assignments()->delete();
        $assignments = [];
        $now = now();

        foreach ($users as $voter) {
            foreach ($users as $target) {
                // Aturan 1: Tidak boleh menilai diri sendiri
                if ($voter->id == $target->id) {
                    continue;
                }

                // ATURAN BARU: Pegawai tidak boleh menilai Pimpinan
                if ($voter->hasRole('Pegawai') && $target->hasRole('Kepala BPS')) {
                    continue; // Lewati iterasi ini
                }

                // Aturan Lama: Pimpinan tidak menilai sesama Pimpinan di form ini
                if ($voter->hasRole('Pimpinan') && $target->hasRole('Kepala BPS')) {
                    continue;
                }

                $assignments[] = [
                    'period_id' => $period->id,
                    'voter_id' => $voter->id,
                    'target_id' => $target->id,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }

        Assignment::insert($assignments);

        return redirect()->route('monitoring.show', $period->id)
            ->with('success', 'Tugas penilaian berhasil di-generate ulang!');
    }

    public function monitoring(Period $period)
    {
        // 1. Ambil semua user yang memiliki tugas untuk menilai (voter) di periode ini
        $voterIds = $period->assignments()->select('voter_id')->distinct()->pluck('voter_id');
        $voters = User::whereIn('id', $voterIds)->orderBy('name')->get();

        // 2. Lakukan query untuk menghitung total tugas dan tugas yang selesai untuk setiap voter
        $progressStats = $period->assignments()
            ->select(
                'voter_id',
                DB::raw('COUNT(*) as total_assignments'),
                DB::raw('SUM(CASE WHEN status = "completed" THEN 1 ELSE 0 END) as completed_assignments')
            )
            ->groupBy('voter_id')
            ->get()
            ->keyBy('voter_id'); // Jadikan voter_id sebagai key agar mudah diakses

        // 3. Gabungkan data user dengan data progresnya
        $monitoringData = $voters->map(function ($voter) use ($progressStats) {
            $stats = $progressStats->get($voter->id);

            $total = $stats ? $stats->total_assignments : 0;
            $completed = $stats ? $stats->completed_assignments : 0;
            $percentage = $total > 0 ? round(($completed / $total) * 100) : 0;

            return (object) [
                'user' => $voter,
                'total' => $total,
                'completed' => $completed,
                'percentage' => $percentage,
            ];
        });

        return view('admin.monitoring.show', compact('period', 'monitoringData'));
    }
}
