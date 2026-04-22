<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Helpers\LogHelper; // Import Helper Log

class TarifController extends Controller
{
    public function index()
    {
        $tarifs = DB::table('tb_tarif')->orderBy('id_tarif', 'desc')->get();
        return view('admin.tarif.index', compact('tarifs'));
    }

    public function create()
    {
        return view('admin.tarif.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis_kendaraan' => 'required|in:motor,mobil',
            'tarif_per_jam' => 'required|numeric'
        ]);

        DB::table('tb_tarif')->insert([
            'jenis_kendaraan' => $request->jenis_kendaraan,
            'tarif_per_jam' => $request->tarif_per_jam,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // MENCATAT LOG: Tambah Tarif
        LogHelper::simpanLog("Menambah tarif baru untuk jenis: " . $request->jenis_kendaraan . " (Rp " . number_format($request->tarif_per_jam) . ")");

        return redirect()->route('admin.tarif.index')->with('success', 'Tarif berhasil ditambah');
    }

    public function edit($id)
    {
        $tarif = DB::table('tb_tarif')->where('id_tarif', $id)->first();
        return view('admin.tarif.edit', compact('tarif'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'jenis_kendaraan' => 'required',
            'tarif_per_jam' => 'required|numeric',
        ]);

        DB::table('tb_tarif')->where('id_tarif', $id)->update([
            'jenis_kendaraan' => $request->jenis_kendaraan,
            'tarif_per_jam' => $request->tarif_per_jam,
            'updated_at' => now(),
        ]);

        // MENCATAT LOG: Update Tarif
        LogHelper::simpanLog("Memperbarui tarif " . $request->jenis_kendaraan . " menjadi Rp " . number_format($request->tarif_per_jam));

        return redirect()->route('admin.tarif.index')->with('success', 'Tarif berhasil diupdate');
    }

    public function destroy($id)
    {
        $tarif = DB::table('tb_tarif')->where('id_tarif', $id)->first();

        if ($tarif) {
            // MENCATAT LOG: Hapus Tarif
            LogHelper::simpanLog("Menghapus data tarif untuk jenis kendaraan: " . $tarif->jenis_kendaraan);
            
            DB::table('tb_tarif')->where('id_tarif', $id)->delete();
        }

        return redirect()->route('admin.tarif.index')->with('success', 'Tarif berhasil dihapus');
    }
}