<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    // Fungsi bantuan agar logika filter tetap konsisten antara Index dan Export
    private function getLaporanQuery(Request $request)
    {
        $query = DB::table('tb_transaksi')
            ->join('tb_area_parkir', 'tb_transaksi.id_area', '=', 'tb_area_parkir.id_area')
            ->join('tb_kendaraan', 'tb_transaksi.id_kendaraan', '=', 'tb_kendaraan.id_kendaraan')
            ->select(
                'tb_transaksi.id_parkir',
                'tb_transaksi.waktu_masuk',
                'tb_transaksi.waktu_keluar',
                'tb_transaksi.biaya_total',
                'tb_transaksi.status',
                'tb_area_parkir.nama_area', 
                'tb_kendaraan.plat_nomor', 
                'tb_kendaraan.jenis_kendaraan'
            )
            ->where('tb_transaksi.status', 'keluar');

        // Filter Rentang Waktu
        if ($request->tgl_mulai && $request->tgl_selesai) {
            $query->whereBetween('tb_transaksi.waktu_keluar', [
                $request->tgl_mulai . ' 00:00:00', 
                $request->tgl_selesai . ' 23:59:59'
            ]);
        }

        // Filter Area
        if ($request->id_area) {
            $query->where('tb_transaksi.id_area', $request->id_area);
        }

        return $query->orderBy('tb_transaksi.waktu_keluar', 'desc');
    }

    public function index(Request $request)
    {
        $laporan = $this->getLaporanQuery($request)->get();
        $totalPendapatan = $laporan->sum('biaya_total');
        $listArea = DB::table('tb_area_parkir')->get();

        return view('owner.laporan.index', compact('laporan', 'listArea', 'totalPendapatan'));
    }

    public function exportCsv(Request $request)
{
    $laporan = $this->getLaporanQuery($request)->get();
    $fileName = 'Laporan_YonParkir_' . date('Y-m-d_H-i') . '.csv';
    
    $headers = [
        "Content-type"        => "text/csv; charset=utf-8",
        "Content-Disposition" => "attachment; filename=$fileName",
        "Pragma"              => "no-cache",
        "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
        "Expires"             => "0"
    ];

    $callback = function() use($laporan, $request) {
        $file = fopen('php://output', 'w');
        
        // 1. Tambahkan BOM agar Excel mengenali UTF-8
        fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

        fputcsv($file, ['LAPORAN TRANSAKSI PARKIR - YONPARKIR', '', '', '', '', ''], ';');

        // 3. INFO FILTER (Baris 2)
        $periode = 'Semua Waktu';
        if ($request->tgl_mulai && $request->tgl_selesai) {
            $periode = $request->tgl_mulai . ' s/d ' . $request->tgl_selesai;
        }
        fputcsv($file, ['Periode: ' . $periode, '', '', '', '', ''], ';');

        // 4. BARIS KOSONG (Agar ada jarak antara judul dan tabel)
        fputcsv($file, [], ';');

        // 5. HEADER TABEL
        fputcsv($file, ['Waktu Masuk', 'Waktu Keluar', 'Plat Nomor', 'Jenis', 'Area', 'Total Bayar'], ';');

        // 6. ISI DATA
        foreach ($laporan as $row) {
            fputcsv($file, [
                $row->waktu_masuk ? date('d/m/Y H:i', strtotime($row->waktu_masuk)) : '-',
                $row->waktu_keluar ? date('d/m/Y H:i', strtotime($row->waktu_keluar)) : '-',
                strtoupper($row->plat_nomor),
                ucfirst($row->jenis_kendaraan),
                ucwords($row->nama_area),
                $row->biaya_total
            ], ';');
        }

        fclose($file);
    };

    return response()->stream($callback, 200, $headers);
}
}