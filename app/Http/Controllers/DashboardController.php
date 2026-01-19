<?php

namespace App\Http\Controllers;

use App\Models\Rekonsiliasi;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $totalRekonsiliasi = Rekonsiliasi::count();
        $dalamProses = Rekonsiliasi::where('status', 'dalam_proses')->count();

        $rekonsiliasiTerbaru = Rekonsiliasi::with(['skpd', 'periode'])
            ->latest()
            ->limit(5)
            ->get();

        $rekonsiliasiSaya = Rekonsiliasi::with(['rekening'])
            ->where('skpd_id', $user->skpd_id)
            ->latest()
            ->limit(5)
            ->get();

        $perluValidasi = Rekonsiliasi::with(['skpd', 'periode'])
            ->where('status', 'dalam_proses')
            ->latest()
            ->limit(5)
            ->get();

        return view('dashboard', compact(
            'totalRekonsiliasi',
            'dalamProses',
            'rekonsiliasiTerbaru',
            'rekonsiliasiSaya',
            'perluValidasi'
        ));
    }
}
