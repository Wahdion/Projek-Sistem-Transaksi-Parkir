<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class OwnerDashboardController extends Controller
{
    public function index()
    {
        Carbon::setLocale('id');
        $today = Carbon::today();

        // 1. Statistik Ringkasan (Tetap sama)
        $pendapatanHariIni = DB::table('tb_transaksi')
            ->where('status', 'keluar')
            ->whereDate('waktu_keluar', $today)
            ->sum('biaya_total');

        $parkirAktif = DB::table('tb_transaksi')
            ->where('status', 'masuk')
            ->count();

        $areaStats = DB::table('tb_area_parkir')
            ->selectRaw('SUM(kapasitas) as total_kapasitas, SUM(terisi) as total_terisi')
            ->first();
        
        $totalKapasitas = $areaStats->total_kapasitas ?? 0;
        $totalTerisi = $areaStats->total_terisi ?? 0;
        $persentaseOkupansi = $totalKapasitas > 0 ? round(($totalTerisi / $totalKapasitas) * 100) : 0;

        // 2. LOGIKA GRAFIK DINAMIS (Relasi tb_transaksi & tb_kendaraan)

        // A. Ambil semua kategori unik (Mobil, Motor, dll) dari tb_kendaraan
        $jenisKendaraanTerdaftar = DB::table('tb_kendaraan')
            ->distinct()
            ->pluck('jenis_kendaraan'); 

        $labelGrafik = [];
        $datasetKendaraan = [];
        $grafikPendapatan = [];

        // B. Siapkan struktur array kosong untuk setiap jenis
        foreach ($jenisKendaraanTerdaftar as $jenis) {
            $datasetKendaraan[$jenis] = [];
        }

        // C. Looping 7 Hari Terakhir
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $labelGrafik[] = $date->isoFormat('ddd'); 
            
            // 1. Hitung Pendapatan
            $pendapatan = DB::table('tb_transaksi')
                ->where('status', 'keluar')
                ->whereDate('waktu_keluar', $date)
                ->sum('biaya_total');
            $grafikPendapatan[] = (int) $pendapatan;

            // 2. Hitung Jumlah Kendaraan per Jenis dengan JOIN yang Akurat
            foreach ($jenisKendaraanTerdaftar as $jenis) {
                $count = DB::table('tb_transaksi')
                    // Sesuaikan: tb_transaksi.id_kendaraan TERHUBUNG KE tb_kendaraan.id_kendaraan
                    ->join('tb_kendaraan', 'tb_transaksi.id_kendaraan', '=', 'tb_kendaraan.id_kendaraan')
                    ->where('tb_transaksi.status', 'keluar')
                    ->whereDate('tb_transaksi.waktu_keluar', $date)
                    ->where('tb_kendaraan.jenis_kendaraan', $jenis)
                    ->count();
                
                $datasetKendaraan[$jenis][] = $count;
            }
        }

        $listArea = DB::table('tb_area_parkir')->get();

        return view('owner.dashboard', compact(
            'pendapatanHariIni', 
            'parkirAktif', 
            'persentaseOkupansi', 
            'listArea',
            'labelGrafik', 
            'grafikPendapatan', 
            'datasetKendaraan'
        ));
    }
}