<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Pengecekan session manual
        if (!session('login')) {
            return redirect('/login')->with('error', 'Silahkan login terlebih dahulu');
        }

        // Statistik widget kartu
        $count_user      = DB::table('tb_users')->count();
        $count_tarif     = DB::table('tb_tarif')->count(); 
        $count_area      = DB::table('tb_area_parkir')->count();
        $count_logs      = DB::table('tb_log_aktivitas')->count();
        $count_kendaraan = DB::table('tb_kendaraan')->count();

        // Ambil 5 log terbaru
        $recent_logs = DB::table('tb_log_aktivitas')
            ->join('tb_users', 'tb_log_aktivitas.id_user', '=', 'tb_users.id_user')
            ->select('tb_log_aktivitas.*', 'tb_users.nama')
            ->orderBy('waktu', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'count_user', 'count_tarif', 'count_area', 
            'count_logs', 'count_kendaraan', 'recent_logs'
        ));
    }

   public function getChartData()
{
    // Set timezone ke WITA secara eksplisit
    $now = \Carbon\Carbon::now('Asia/Makassar');
    $today = $now->copy()->startOfDay();
    $endDay = $now->copy()->endOfDay();

    // 1. Data Arus Kendaraan
    $arusKendaraan = DB::table('tb_transaksi')
        ->select(DB::raw("HOUR(waktu_masuk) as jam"), DB::raw('count(*) as total'))
        ->whereBetween('waktu_masuk', [$today, $endDay])
        ->groupBy(DB::raw('HOUR(waktu_masuk)'))
        ->get();

    // 2. Data Log Aktivitas
    $logAktivitas = DB::table('tb_log_aktivitas')
        ->select(DB::raw("HOUR(waktu) as jam"), DB::raw('count(*) as total'))
        ->whereBetween('waktu', [$today, $endDay])
        ->groupBy(DB::raw('HOUR(waktu)'))
        ->get();

    // Looping labels 00:00 - 23:00 (Tetap sama)
    $labels = [];
    $dataKendaraan = [];
    $dataLogs = [];

    for ($i = 0; $i < 24; $i++) {
        $labels[] = sprintf('%02d:00', $i);
        $dataKendaraan[] = $arusKendaraan->where('jam', $i)->first()->total ?? 0;
        $dataLogs[] = $logAktivitas->where('jam', $i)->first()->total ?? 0;
    }

    return response()->json([
        'labels' => $labels,
        'datasets' => [
            ['label' => 'Arus Kendaraan', 'data' => $dataKendaraan],
            ['label' => 'Log Aktivitas', 'data' => $dataLogs]
        ]
    ]);
}
}