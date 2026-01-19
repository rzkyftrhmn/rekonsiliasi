<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rekening;

class RekeningController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $rekening = Rekening::when($search, function ($query, $search) {
                $query->where('nama_rekening', 'like', "%{$search}%");
            })
            ->paginate(3)
            ->withQueryString();
        return view('pages.rekening.index', compact('rekening','search'));
    }

    public function create()
    {
        return view('pages.rekening.form', [
            'rekening' => null,
            'title' => 'Tambah Rekening'
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'kode_rekening' => 'required|string|max:50',
            'nama_rekening' => 'required|string|max:255',
        ]);

        Rekening::create($validatedData);

        return redirect()->route('admin.rekening.index')->with('success', 'Rekening berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $rekening = Rekening::findOrFail($id);
        return view('pages.rekening.form', [
            'rekening' => $rekening,
            'title' => 'Edit Rekening'
        ]);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'kode_rekening' => 'required|string|max:50',
            'nama_rekening' => 'required|string|max:255',
        ]);

        $rekening = Rekening::findOrFail($id);
        $rekening->update($validatedData);

        return redirect()->route('admin.rekening.index')->with('success', 'Rekening berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $rekening = Rekening::findOrFail($id);
        $rekening->delete();

        return redirect()->route('admin.rekening.index')->with('success', 'Rekening berhasil dihapus.');
    }
}
