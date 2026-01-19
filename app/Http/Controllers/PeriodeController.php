<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Periode;

class PeriodeController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $periode = Periode::when($search, function ($query, $search) {
                $query->where('nama_periode', 'like', "%{$search}%");
            })
            ->paginate(3)
            ->withQueryString();
        return view('pages.periode.index', compact('periode','search'));
    }

    public function create()
    {
        return view('pages.periode.form', [
            'periode' => null,
            'title' => 'Tambah Periode'
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_periode' => 'required|string|max:255',
            'tahun' => 'required|integer|min:2000|max:' . date('Y'),
        ]);

        Periode::create($validated);

        return redirect()->route('admin.periode.index')->with('success', 'Periode berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $periode = Periode::findOrFail($id);
        return view('pages.periode.form', [
            'periode' => $periode,
            'title' => 'Edit Periode'
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_periode' => 'required|string|max:255',
            'tahun' => 'required|digits:4|integer|min:2000|max:' . date('Y'),
        ]);

        $periode = Periode::findOrFail($id);
        $periode->update($validated);

        return redirect()->route('admin.periode.index')->with('success', 'Periode berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $periode = Periode::findOrFail($id);
        $periode->delete();

        return redirect()->route('admin.periode.index')->with('success', 'Periode berhasil dihapus.');
    }
}
