<?php

namespace App\Http\Controllers;

use App\Models\Rekonsiliasi;
use App\Models\Periode;
use Illuminate\Http\Request;
use App\Models\Skpd;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        // ── Dropdown options ──
        $allPeriode = Periode::orderBy('tahun', 'desc')->orderBy('nama_periode')->get();
        $allTahun   = Periode::select('tahun')->distinct()->orderBy('tahun', 'desc')->pluck('tahun');

        $selectedPeriode = $request->input('periode_id');
        $selectedTahun   = $request->input('tahun');

        // ── Base query dengan filter global ──
        $baseQuery = Rekonsiliasi::query();

        if ($selectedPeriode) {
            $baseQuery->where('periode_id', $selectedPeriode);
        } elseif ($selectedTahun) {
            $baseQuery->whereHas('periode', fn($q) => $q->where('tahun', $selectedTahun));
        }

        // ── Label filter aktif ──
        $labelFilter = 'Semua Periode';
        if ($selectedPeriode) {
            $p = $allPeriode->firstWhere('id', $selectedPeriode);
            $labelFilter = $p ? $p->nama_periode . ' ' . $p->tahun : 'Periode Dipilih';
        } elseif ($selectedTahun) {
            $labelFilter = 'Tahun ' . $selectedTahun;
        }

        // ── Stat cards ──
        $totalRekonsiliasi = (clone $baseQuery)->count();
        $dalamProses       = (clone $baseQuery)->where('status', 'dalam_proses')->count();
        $valid             = (clone $baseQuery)->where('status', 'valid')->count();
        $selisih           = (clone $baseQuery)->where('status', 'selisih')->count();
        $totalNilaiSkpd    = (clone $baseQuery)->sum('nilai_skpd');
        $totalNilaiBpkad   = (clone $baseQuery)->sum('nilai_bpkad');

        // ── Chart status (pie) ──
        $chartStatus = [
            'valid'   => $valid,
            'selisih' => $selisih,
            'proses'  => $dalamProses,
        ];

        // ── Chart rekonsiliasi per SKPD (admin/validator) ──
        $rekapSkpd = (clone $baseQuery)
            ->select('skpd_id', DB::raw('count(*) as total'))
            ->groupBy('skpd_id')
            ->with('skpd')
            ->get();
        $skpdLabels = $rekapSkpd->pluck('skpd.nama_skpd');
        $skpdData   = $rekapSkpd->pluck('total');

        // ── Tabel rekonsiliasi terbaru (admin) ──
        $rekonsiliasiTerbaru = (clone $baseQuery)
            ->with(['skpd', 'periode'])
            ->latest()
            ->limit(5)
            ->get();

        // ── Tabel rekonsiliasi saya (operator) ──
        $rekonsiliasiSaya = (clone $baseQuery)
            ->with(['rekening'])
            ->where('skpd_id', $user->skpd_id)
            ->latest()
            ->limit(5)
            ->get();

        // ── Tabel perlu validasi (validator) ──
        $perluValidasi = (clone $baseQuery)
            ->with(['skpd', 'periode'])
            ->where('status', 'dalam_proses')
            ->latest()
            ->limit(5)
            ->get();

        // ── Chart status operator ──
        $chartStatusOperator = (clone $baseQuery)
            ->select('status', DB::raw('count(*) as total'))
            ->where('skpd_id', $user->skpd_id)
            ->groupBy('status')
            ->pluck('total', 'status');

        // ── Chart rekening operator ──
        $rekapRekening = (clone $baseQuery)
            ->select('rekening_id', DB::raw('count(*) as total'))
            ->where('skpd_id', $user->skpd_id)
            ->groupBy('rekening_id')
            ->with('rekening')
            ->get();
        $rekeningLabels = $rekapRekening->pluck('rekening.nama_rekening');
        $rekeningData   = $rekapRekening->pluck('total');

        // ── Chart status validator ──
        $chartStatusValidator = (clone $baseQuery)
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        // ── Chart SKPD validator ──
        $rekapSkpdValidator = (clone $baseQuery)
            ->select('skpd_id', DB::raw('count(*) as total'))
            ->groupBy('skpd_id')
            ->with('skpd')
            ->get();
        $validatorSkpdLabels = $rekapSkpdValidator->pluck('skpd.nama_skpd');
        $validatorSkpdData   = $rekapSkpdValidator->pluck('total');

        return view('dashboard', compact(
            'totalRekonsiliasi', 'dalamProses', 'valid', 'selisih',
            'chartStatus', 'skpdLabels', 'skpdData',
            'rekonsiliasiTerbaru', 'rekonsiliasiSaya', 'perluValidasi',
            'chartStatusOperator', 'rekeningLabels', 'rekeningData',
            'chartStatusValidator', 'validatorSkpdLabels', 'validatorSkpdData',
            'totalNilaiSkpd', 'totalNilaiBpkad',
            'allPeriode', 'allTahun', 'selectedPeriode', 'selectedTahun', 'labelFilter',
        ));
    }
}
