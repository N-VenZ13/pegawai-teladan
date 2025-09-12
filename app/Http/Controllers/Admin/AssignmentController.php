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
        $users = User::role(['Pegawai', 'Pimpinan'])->get();
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
                if ($voter->hasRole('Pegawai') && $target->hasRole('Pimpinan')) {
                    continue; // Lewati iterasi ini
                }

                // Aturan Lama: Pimpinan tidak menilai sesama Pimpinan di form ini
                if ($voter->hasRole('Pimpinan') && $target->hasRole('Pimpinan')) {
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

        return redirect()->route('admin.assignments.index', $period->id)
            ->with('success', 'Tugas penilaian berhasil di-generate ulang!');
    }
}
