<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DisciplineCriterion;
use Illuminate\Http\Request;

class DisciplineCriterionController extends Controller
{
    public function index()
    {
        $criteria = DisciplineCriterion::latest()->paginate(10);
        return view('discipline-criteria.index', compact('criteria'));
    }

    public function create()
    {
        return view('discipline-criteria.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        DisciplineCriterion::create([
            'name' => $request->name,
            'is_active' => $request->has('is_active'),
        ]);
        return redirect()->route('discipline.criteria.index')
            ->with('success', 'Kriteria Disiplin berhasil dibuat.');
    }

    public function edit(DisciplineCriterion $criterion)
    {
        // return view('discipline-criteria.edit', ['criterion' => $disciplineCriterion]);
        return view('discipline-criteria.edit', compact('criterion'));
    }

    public function update(Request $request, DisciplineCriterion $criterion)
    {
        $request->validate(['name' => 'required|string|max:255']);
        $criterion->update([
            'name' => $request->name,
            'is_active' => $request->has('is_active'),
        ]);
        return redirect()->route('discipline.criteria.index')
            ->with('success', 'Kriteria Disiplin berhasil diperbarui.');
    }

    public function destroy(DisciplineCriterion $criterion)
    {
        $criterion->delete();
        return redirect()->route('discipline.criteria.index')
            ->with('success', 'Kriteria Disiplin berhasil dihapus.');
    }
}
