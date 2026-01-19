<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Skpd;

class SkpdController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $skpd = Skpd::when($search, function ($query, $search) {
                $query->where('nama_skpd', 'like', "%{$search}%");
            })
            ->paginate(3)
            ->withQueryString();
        return view('pages.skpd.index', compact('skpd','search'));
    }

    public function create()
    {
        return view('pages.skpd.form', [
            'skpd' => null,
            'title' => 'Tambah SKPD'
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_skpd' => 'required|string|max:255',
            'jenis' => 'required|string|max:255',
        ]);

        Skpd::create([
            'nama_skpd' => $request->nama_skpd,
            'jenis' => $request->jenis,
        ]);

        return redirect()->route('admin.skpd.index')->with('success', 'SKPD berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $skpd = Skpd::findOrFail($id);
        return view('pages.skpd.form', [
            'skpd' => $skpd,
            'title' => 'Edit SKPD'
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_skpd' => 'required|string|max:255',
            'jenis' => 'required|string|max:255',
        ]);

        $skpd = Skpd::findOrFail($id);
        $skpd->update([
            'nama_skpd' => $request->nama_skpd,
            'jenis' => $request->jenis,
        ]);

        return redirect()->route('admin.skpd.index')->with('success', 'SKPD berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $skpd = Skpd::findOrFail($id);
        $skpd->delete();

        return redirect()->route('admin.skpd.index')->with('success', 'SKPD berhasil dihapus.');
    }
}
