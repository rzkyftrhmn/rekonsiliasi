<?php

namespace App\Http\Controllers;

use App\Models\Rekonsiliasi;
use App\Models\Skpd;
use App\Models\Rekening;
use App\Models\Periode;
use App\Models\DokumenRekonsiliasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RekonsiliasiController extends Controller
{
    /**
     * LIST DATA REKONSILIASI
     */
    public function index(Request $request)
    {
        $query = Rekonsiliasi::with([
            'skpd',
            'rekening',
            'periode',
            'validator'
        ]);

        // FILTER PERIODE
        if ($request->filled('periode_id')) {
            $query->where('periode_id', $request->periode_id);
        }

        // FILTER STATUS
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // SEARCH (SKPD / REKENING)
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->whereHas('skpd', function ($q2) use ($request) {
                    $q2->where('nama_skpd', 'like', '%' . $request->search . '%');
                })
                ->orWhereHas('rekening', function ($q2) use ($request) {
                    $q2->where('nama_rekening', 'like', '%' . $request->search . '%');
                });
            });
        }

        // DATA LIST
        $rekonsiliasis = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        // HITUNG STATUS (CARD)
        $countDalamProses = Rekonsiliasi::where('status', 'dalam_proses')->count();
        $countSelisih     = Rekonsiliasi::where('status', 'selisih')->count();
        $countValid       = Rekonsiliasi::where('status', 'valid')->count();

        // DATA PERIODE (DROPDOWN)
        $periodes = Periode::orderBy('tahun', 'desc')->get();

        return view('pages.rekonsiliasi.index', compact(
            'rekonsiliasis',
            'periodes',
            'countDalamProses',
            'countSelisih',
            'countValid'
        ));
    }


    /**
     * FORM TAMBAH REKONSILIASI
     */
    public function create()
    {
        return view('pages.rekonsiliasi.form', [
            'rekonsiliasi' => null,
            'skpds'        => Skpd::where('jenis', 'skpd')->get(),
            'rekenings'    => Rekening::all(),
            'periodes'     => Periode::where('aktif', true)->get(),
            'title'        => 'Tambah Rekonsiliasi'
        ]);
    }

    /**
     * SIMPAN DATA REKONSILIASI
     */
    public function store(Request $request)
    {
        $request->validate([
            'skpd_id'      => 'required|exists:skpds,id',
            'rekening_id'  => 'required|exists:rekenings,id',
            'periode_id'   => 'required|exists:periodes,id',
            'nilai_skpd'   => 'required|numeric|min:0',
            'dokumen.*'    => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ], [
            'dokumen.*.mimes' => 'Dokumen harus berupa PDF, JPG, atau PNG.',
            'dokumen.*.max'   => 'Ukuran dokumen maksimal 2MB.',
        ]);

        $rekonsiliasi = Rekonsiliasi::create([
            'skpd_id'     => $request->skpd_id,
            'rekening_id' => $request->rekening_id,
            'periode_id'  => $request->periode_id,
            'nilai_skpd'  => $request->nilai_skpd,
            'status'      => 'dalam_proses',
        ]);

        // SIMPAN DOKUMEN (jika ada)
        if ($request->hasFile('dokumen')) {
            foreach ($request->file('dokumen') as $file) {
                $path = $file->store('dokumen_rekonsiliasi', 'public');

                DokumenRekonsiliasi::create([
                    'rekonsiliasi_id' => $rekonsiliasi->id,
                    'nama_file'       => $file->getClientOriginalName(),
                    'path_file'       => $path,
                ]);
            }
        }

        return redirect()
            ->route('rekonsiliasi.index')
            ->with('success', 'Rekonsiliasi berhasil disimpan');
    }

    /**
     * DETAIL REKONSILIASI
     */
    public function show(Rekonsiliasi $rekonsiliasi)
    {
        $rekonsiliasi->load([
            'skpd',
            'rekening',
            'periode',
            'dokumen',
            'validator'
        ]);

        return view('pages.rekonsiliasi.show', compact('rekonsiliasi'));
    }

    /**
     * FORM EDIT (PERBAIKAN DATA)
     */
    public function edit(Rekonsiliasi $rekonsiliasi)
    {
        
        return view('pages.rekonsiliasi.form', [
            'rekonsiliasi' => $rekonsiliasi,
            'skpds'        => Skpd::where('jenis', 'skpd')->get(),
            'rekenings'    => Rekening::all(),
            'periodes'     => Periode::where('aktif', true)->get(),
            'title'        => 'Edit Rekonsiliasi'
        ]);
    }

    /**
     * UPDATE DATA REKONSILIASI
     */
    public function update(Request $request, Rekonsiliasi $rekonsiliasi)
    {
        
        $request->validate([
            'nilai_skpd'  => 'required|numeric|min:0',
            'dokumen.*'   => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ], [
            'dokumen.*.mimes' => 'Dokumen harus berupa PDF, JPG, atau PNG.',
            'dokumen.*.max'   => 'Ukuran dokumen maksimal 2MB.',
        ]);

        $rekonsiliasi->update([
            'nilai_skpd' => $request->nilai_skpd,
            'status'     => 'dalam_proses',
        ]);

        // upload dokumen tambahan
        if ($request->hasFile('dokumen')) {
            foreach ($request->file('dokumen') as $file) {
                $path = $file->store('dokumen_rekonsiliasi', 'public');

                DokumenRekonsiliasi::create([
                    'rekonsiliasi_id' => $rekonsiliasi->id,
                    'nama_file'       => $file->getClientOriginalName(),
                    'path_file'       => $path,
                ]);
            }
        }

        return redirect()
            ->route('rekonsiliasi.index')
            ->with('success', 'Rekonsiliasi berhasil diperbarui');
    }

    /**
     * HAPUS REKONSILIASI
     */
    public function destroy(Rekonsiliasi $rekonsiliasi)
    {
        // hapus file fisik
        foreach ($rekonsiliasi->dokumen as $doc) {
            Storage::disk('public')->delete($doc->path_file);
        }

        $rekonsiliasi->delete();

        return redirect()
            ->route('rekonsiliasi.index')
            ->with('success', 'Rekonsiliasi berhasil dihapus');
    }

    /**
     * FORM VALIDASI (VALIDATOR)
     */
    public function validasiForm(Rekonsiliasi $rekonsiliasi)
    {
        return view('pages.rekonsiliasi.validasi', compact('rekonsiliasi'));
    }

    /**
     * SIMPAN VALIDASI
     */
    public function validasiStore(Request $request, Rekonsiliasi $rekonsiliasi)
    {
        $request->validate([
            'nilai_bpkad' => 'required|numeric|min:0',
            'status'      => 'required|in:valid,selisih',
            'catatan'     => 'nullable|string',
        ]);

        $rekonsiliasi->update([
            'nilai_bpkad'  => $request->nilai_bpkad,
            'status'       => $request->status,
            'catatan'      => $request->catatan,
            'validator_id' => auth()->id(),
        ]);

        return redirect()
            ->route('rekonsiliasi.index')
            ->with('success', 'Rekonsiliasi berhasil divalidasi');
    }

}
