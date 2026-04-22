<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Helpers\LogHelper; // Import LogHelper agar bisa mencatat aktivitas

class KendaraanController extends Controller
{
    public function index()
    {
        $kendaraans = DB::table('tb_kendaraan')->get();
        return view('admin.kendaraan.index', compact('kendaraans'));
    }

    public function create()
    {
        return view('admin.kendaraan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'plat_nomor' => 'required|max:15|unique:tb_kendaraan,plat_nomor',
            'jenis_kendaraan' => 'required',
            'warna' => 'required|max:20',
        ]);

        $plat = strtoupper($request->plat_nomor);

        DB::table('tb_kendaraan')->insert([
            'plat_nomor' => $plat,
            'jenis_kendaraan' => $request->jenis_kendaraan,
            'warna' => $request->warna,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // MENCATAT LOG: Registrasi Kendaraan Baru
        LogHelper::simpanLog("Mendaftarkan kendaraan baru dengan plat nomor: " . $plat);

        return redirect()->route('admin.kendaraan.index')->with('success', 'Data kendaraan berhasil didaftarkan!');
    }

    public function edit($id)
    {
        $kendaraan = DB::table('tb_kendaraan')->where('id_kendaraan', $id)->first();
        return view('admin.kendaraan.edit', compact('kendaraan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'plat_nomor' => 'required|max:15',
            'jenis_kendaraan' => 'required',
            'warna' => 'required|max:20',
        ]);

        $plat = strtoupper($request->plat_nomor);

        DB::table('tb_kendaraan')->where('id_kendaraan', $id)->update([
            'plat_nomor' => $plat,
            'jenis_kendaraan' => $request->jenis_kendaraan,
            'warna' => $request->warna,
            'updated_at' => now(),
        ]);

        // MENCATAT LOG: Update Data Kendaraan
        LogHelper::simpanLog("Memperbarui data kendaraan dengan plat nomor: " . $plat);

        return redirect()->route('admin.kendaraan.index')->with('success', 'Data kendaraan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        // Ambil data sebelum dihapus untuk keterangan di log
        $kendaraan = DB::table('tb_kendaraan')->where('id_kendaraan', $id)->first();

        if ($kendaraan) {
            // MENCATAT LOG: Hapus Kendaraan
            LogHelper::simpanLog("Menghapus data kendaraan dengan plat nomor: " . $kendaraan->plat_nomor);
            
            DB::table('tb_kendaraan')->where('id_kendaraan', $id)->delete();
        }

        return redirect()->route('admin.kendaraan.index')->with('success', 'Data kendaraan dihapus!');
    }
}