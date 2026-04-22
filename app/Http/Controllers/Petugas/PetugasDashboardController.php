<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AreaParkir;
use App\Models\Transaksi;
use App\Models\LogAktivitas;
use Illuminate\Support\Facades\Auth;

class PetugasDashboardController extends Controller
{
    public function index()
    {
        // 1. Ambil area parkir beserta hitungan transaksi yang HANYA berstatus 'masuk'
        // Gunakan withCount dengan fungsi anonymous agar angka 'terisi' akurat
        $areas = AreaParkir::withCount(['transaksi as transaksi_masuk_count' => function($query) {
            $query->where('status', 'masuk');
        }])->get();

        // 2. Hitung jumlah total kendaraan aktif (Sudah Benar)
        $total_kendaraan_aktif = Transaksi::where('status', 'masuk')->count();

        // 3. Ambil 5 log aktivitas terbaru
        $logs = LogAktivitas::where('id_user', session('id_user'))
                            ->latest('waktu')
                            ->take(5)
                            ->get();

        return view('petugas.dashboard', compact(
            'areas', 
            'total_kendaraan_aktif', 
            'logs'
        ));
    }
}