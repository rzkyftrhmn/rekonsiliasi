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
            ->orderBy('tahun', 'desc')
            ->orderByRaw("FIELD(nama_periode,'Januari','Februari','Maret','April','Mei','Juni',
                'Juli','Agustus','September','Oktober','November','Desember')")
            ->paginate(12)
            ->withQueryString();

        // Untuk dropdown generate
        $tahunSekarang = now()->year;

        return view('pages.periode.index', compact('periode', 'search', 'tahunSekarang'));
    }

    public function create()
    {
        return view('pages.periode.form', [
            'periode' => null,
            'title'   => 'Tambah Periode'
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_periode' => 'required|string|max:255',
            'tahun'        => 'required|integer|min:2000|max:' . (date('Y') + 1),
        ]);

        Periode::create($validated);

        return redirect()->route('admin.periode.index')
            ->with('success', 'Periode berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $periode = Periode::findOrFail($id);
        return view('pages.periode.form', [
            'periode' => $periode,
            'title'   => 'Edit Periode'
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_periode' => 'required|string|max:255',
            'tahun'        => 'required|digits:4|integer|min:2000|max:' . (date('Y') + 1),
        ]);

        $periode = Periode::findOrFail($id);
        $periode->update($validated);

        return redirect()->route('admin.periode.index')
            ->with('success', 'Periode berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $periode = Periode::findOrFail($id);
        $periode->delete();

        return redirect()->route('admin.periode.index')
            ->with('success', 'Periode berhasil dihapus.');
    }

    /**
     * Generate 12 periode (Januari–Desember) untuk tahun yang dipilih.
     * Skip bulan yang sudah ada, tidak duplikat.
     */
    public function generate(Request $request)
    {
        $request->validate([
            'tahun' => 'required|integer|min:2000|max:' . (date('Y') + 5),
        ]);

        $tahun = (int) $request->input('tahun');

        $bulanList = [
            'Januari','Februari','Maret','April','Mei','Juni',
            'Juli','Agustus','September','Oktober','November','Desember'
        ];

        $dibuat = 0;
        $skip   = 0;

        foreach ($bulanList as $bulan) {
            $sudahAda = Periode::where('nama_periode', $bulan)
                ->where('tahun', $tahun)
                ->exists();

            if (!$sudahAda) {
                Periode::create([
                    'nama_periode' => $bulan,
                    'tahun'        => $tahun,
                ]);
                $dibuat++;
            } else {
                $skip++;
            }
        }

        $pesan = "Generate selesai untuk tahun {$tahun}. ";
        $pesan .= "{$dibuat} periode dibuat";
        if ($skip > 0) {
            $pesan .= ", {$skip} sudah ada (dilewati)";
        }
        $pesan .= '.';

        return redirect()->route('admin.periode.index')->with('success', $pesan);
    }
}