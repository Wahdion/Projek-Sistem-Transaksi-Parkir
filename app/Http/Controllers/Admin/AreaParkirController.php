<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Helpers\LogHelper; // Import Helper Log

class AreaParkirController extends Controller
{
    public function index()
    {
        $areas = DB::table('tb_area_parkir')->get();
        return view('admin.area.index', compact('areas'));
    }

    public function create()
    {
        return view('admin.area.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_area' => 'required|max:50',
            'kapasitas' => 'required|integer|min:1',
        ]);

        DB::table('tb_area_parkir')->insert([
            'nama_area' => $request->nama_area,
            'kapasitas' => $request->kapasitas,
            'terisi' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Simpan Log Aktivitas
        LogHelper::simpanLog("Menambahkan area parkir baru: " . $request->nama_area);

        return redirect()->route('admin.area.index')->with('success', 'Area parkir berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $area = DB::table('tb_area_parkir')->where('id_area', $id)->first();
        return view('admin.area.edit', compact('area'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_area' => 'required|max:50',
            'kapasitas' => 'required|integer|min:0',
        ]);

        // Ambil data lama untuk pesan log yang lebih detail
        $areaLama = DB::table('tb_area_parkir')->where('id_area', $id)->first();

        DB::table('tb_area_parkir')->where('id_area', $id)->update([
            'nama_area' => $request->nama_area,
            'kapasitas' => $request->kapasitas,
            'updated_at' => now(),
        ]);

        // Simpan Log Aktivitas
        LogHelper::simpanLog("Mengubah area parkir " . $areaLama->nama_area . " menjadi " . $request->nama_area);

        return redirect()->route('admin.area.index')->with('success', 'Area parkir berhasil diperbarui!');
    }

    public function destroy($id)
    {
        // Ambil data sebelum dihapus agar bisa mencatat nama area di log
        $area = DB::table('tb_area_parkir')->where('id_area', $id)->first();

        if ($area) {
            // Simpan Log Aktivitas
            LogHelper::simpanLog("Menghapus area parkir: " . $area->nama_area);
            
            DB::table('tb_area_parkir')->where('id_area', $id)->delete();
        }

        return redirect()->route('admin.area.index')->with('success', 'Area parkir berhasil dihapus!');
    }
}