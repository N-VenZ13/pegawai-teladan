<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LeaderCriterion;
use Illuminate\Http\Request;

class LeaderCriterionController extends Controller
{
    public function index()
    {
        $criteria = LeaderCriterion::latest()->paginate(10); // <-- Diubah
        return view('admin.leader-criteria.index', compact('criteria')); // <-- Diubah
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.leader-criteria.create'); // <-- Diubah
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255', // <-- Diubah (dari 'text')
            'description' => 'nullable|string',
            'target_type' => 'required|in:pegawai,ketua_tim',
            'target_type' => 'required|in:pegawai,ketua_tim,semua',
        ]);

        LeaderCriterion::create([ // <-- Diubah
            'name' => $request->name, // <-- Diubah
            'description' => $request->description,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.leader-criteria.index') // <-- Diubah
            ->with('success', 'Kriteria Pimpinan berhasil dibuat.'); // <-- Diubah
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LeaderCriterion $leaderCriterion) // <-- Diubah
    {
        return view('admin.leader-criteria.edit', ['criterion' => $leaderCriterion]); // <-- Diubah
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LeaderCriterion $leaderCriterion) // <-- Diubah
    {
        $request->validate([
            'name' => 'required|string|max:255', // <-- Diubah
            'description' => 'nullable|string',
        ]);

        $leaderCriterion->update([ // <-- Diubah
            'name' => $request->name, // <-- Diubah
            'description' => $request->description,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.leader-criteria.index') // <-- Diubah
            ->with('success', 'Kriteria Pimpinan berhasil diperbarui.'); // <-- Diubah
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LeaderCriterion $leaderCriterion) // <-- Diubah
    {
        $leaderCriterion->delete(); // <-- Diubah
        return redirect()->route('admin.leader-criteria.index') // <-- Diubah
            ->with('success', 'Kriteria Pimpinan berhasil dihapus.'); // <-- Diubah
    }
}
