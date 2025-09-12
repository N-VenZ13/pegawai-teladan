<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Period;
use Illuminate\Http\Request;

class PeriodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $periods = Period::latest()->paginate(10);
        // return view('admin.periods.index', compact('periods'));
        // withCount akan membuat properti 'assignments_count' secara virtual
        $periods = Period::withCount('assignments')->latest()->paginate(10);
        return view('admin.periods.index', compact('periods'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.periods.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'month_1_name' => 'nullable|string|max:50|required_with:month_2_name,month_3_name',
            'month_2_name' => 'nullable|string|max:50|required_with:month_1_name,month_3_name',
            'month_3_name' => 'nullable|string|max:50|required_with:month_1_name,month_2_name',
        ]);

        Period::create($request->all());

        return redirect()->route('admin.periods.index')
            ->with('success', 'Periode berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Period $period)
    {
        return view('admin.periods.edit', compact('period'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Period $period)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            // Kita juga tambahkan validasi untuk status
            'status' => 'required|in:draft,active,finished,published',
            'month_1_name' => 'nullable|string|max:50|required_with:month_2_name,month_3_name',
            'month_2_name' => 'nullable|string|max:50|required_with:month_1_name,month_3_name',
            'month_3_name' => 'nullable|string|max:50|required_with:month_1_name,month_2_name',
        ]);

        $period->update($request->all());

        return redirect()->route('admin.periods.index')
            ->with('success', 'Periode berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Period $period)
    {
        // Karena kita set onDelete('cascade') di migration,
        // menghapus periode akan otomatis menghapus semua assignment, answer, dll.
        $period->delete();

        return redirect()->route('admin.periods.index')
            ->with('success', 'Periode berhasil dihapus.');
    }
}
