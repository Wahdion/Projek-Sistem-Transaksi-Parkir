<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Kendaraan;
use App\Models\Tarif;
use App\Models\AreaParkir;
use App\Models\LogAktivitas;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{
    // 1. Daftar kendaraan aktif dengan Live Search Fragment
    public function index(Request $request)
    {
        $query = Transaksi::with(['kendaraan', 'area', 'tarif'])
            ->where('status', 'masuk');

        if ($request->filled('search')) {
            $search = str_replace([' ', '-'], '', $request->search); 
            $query->whereHas('kendaraan', function($q) use ($search) {
                $q->where('plat_nomor', 'like', '%' . $search . '%');
            });
        }

        $transaksi = $query->latest('waktu_masuk')->get();

        if ($request->ajax()) {
            return view('petugas.transaksi.index', compact('transaksi'))
                ->fragment('table-pencarian');
        }

        return view('petugas.transaksi.index', compact('transaksi'));
    }

    // 2. Form Masuk dengan Sinkronisasi Kapasitas Real-time
    public function create()
    {
        $areas = AreaParkir::all()->map(function($area) {
            // Hitung ulang jumlah kendaraan aktif di lokasi (Real-time)
            $currentCount = Transaksi::where('id_area', $area->id_area)
                                     ->where('status', 'masuk')
                                     ->count();
            
            // Update kolom 'terisi' agar database selalu sinkron
            $area->update(['terisi' => $currentCount]);
            
            return $area;
        });

        // Hanya ambil area yang benar-benar masih ada sisa
        $availableAreas = $areas->filter(fn($a) => $a->terisi < $a->kapasitas);
        $tarifs = Tarif::all();

        return view('petugas.transaksi.create', [
            'areas' => $availableAreas,
            'tarifs' => $tarifs
        ]);
    }

    // 3. API Auto-fill
    public function getKendaraan($plat)
    {
        $platClean = strtoupper(str_replace([' ', '-'], '', $plat));
        $kendaraan = Kendaraan::where('plat_nomor', $platClean)->first();
        return response()->json($kendaraan);
    }

    // 4. Simpan Check-in (Perbaikan logika Session Struk)
    public function store(Request $request)
    {
        $request->validate([
            'plat_nomor' => 'required|string|max:15',
            'warna'      => 'required|string',
            'id_tarif'   => 'required|exists:tb_tarif,id_tarif',
            'id_area'    => 'required|exists:tb_area_parkir,id_area',
        ]);

        // Jalankan transaksi dan ambil object transaksinya
        $transaksiBaru = DB::transaction(function () use ($request) {
            $tarif = Tarif::findOrFail($request->id_tarif);
            $platNomor = strtoupper(str_replace([' ', '-'], '', $request->plat_nomor));

            $area = AreaParkir::where('id_area', $request->id_area)->lockForUpdate()->firstOrFail();
            $realCount = Transaksi::where('id_area', $area->id_area)->where('status', 'masuk')->count();
            
            if ($realCount >= $area->kapasitas) {
                return null; 
            }

            $kendaraan = Kendaraan::updateOrCreate(
                ['plat_nomor' => $platNomor], 
                [
                    'jenis_kendaraan' => $tarif->jenis_kendaraan,
                    'warna' => strtoupper($request->warna)
                ]
            );

            $transaksi = Transaksi::create([
                'id_kendaraan' => $kendaraan->id_kendaraan,
                'id_area'      => $request->id_area,
                'id_tarif'     => $request->id_tarif,
                'id_user'      => Auth::id() ?? session('id_user'), 
                'waktu_masuk'  => now(),
                'status'       => 'masuk',
                'biaya_total'  => 0 
            ]);

            $area->update(['terisi' => $realCount + 1]);

            LogAktivitas::create([
                'id_user'   => Auth::id() ?? session('id_user'),
                'aktivitas' => "Check-in: " . $platNomor . " di " . $area->nama_area,
                'waktu'     => now()
            ]);

            return $transaksi;
        });

        if (!$transaksiBaru) {
            return back()->with('error', 'Maaf, Area Parkir ini penuh!');
        }

        // Redirect di luar closure agar session 'with' terbaca oleh Blade untuk cetak struk
        return redirect()->route('petugas.transaksi.index')
            ->with('success', 'Kendaraan berhasil masuk!')
            ->with('download_struk', $transaksiBaru->id_parkir);
    }

    // 5. Checkout (Hitung Biaya & Sinkronisasi Area)
    public function update(Request $request, $id_parkir)
    {
        $prosesCheckout = DB::transaction(function () use ($id_parkir) {
            $transaksi = Transaksi::with(['tarif', 'kendaraan'])->findOrFail($id_parkir);

            if ($transaksi->status == 'keluar') {
                return false;
            }

            $waktuKeluar = now();
            $durasiMenit = $transaksi->waktu_masuk->diffInMinutes($waktuKeluar);
            $durasiJam = ceil($durasiMenit / 60); 
            if ($durasiJam <= 0) $durasiJam = 1; 

            $totalBiaya = $durasiJam * $transaksi->tarif->tarif_per_jam;

            $transaksi->update([
                'waktu_keluar' => $waktuKeluar,
                'durasi_jam'   => $durasiJam,
                'biaya_total'  => $totalBiaya,
                'status'       => 'keluar',
                'id_user'      => Auth::id() ?? session('id_user')
            ]);

            $currentCount = Transaksi::where('id_area', $transaksi->id_area)
                                     ->where('status', 'masuk')
                                     ->count();
            
            AreaParkir::where('id_area', $transaksi->id_area)->update(['terisi' => $currentCount]);

            LogAktivitas::create([
                'id_user'   => Auth::id() ?? session('id_user'),
                'aktivitas' => "Check-out: " . $transaksi->kendaraan->plat_nomor . " | Total: Rp " . number_format($totalBiaya, 0, ',', '.'),
                'waktu'     => now()
            ]);

            return true;
        });

        if (!$prosesCheckout) {
            return back()->with('error', 'Data sudah pernah diproses keluar.');
        }

        return redirect()->route('petugas.transaksi.index')
            ->with('success', 'Checkout berhasil!')
            ->with('download_struk', $id_parkir);
    }

    // 6. Cetak Struk
    public function print($id_parkir)
    {
        $transaksi = Transaksi::with(['kendaraan', 'area', 'tarif', 'user'])->findOrFail($id_parkir);
        return view('petugas.transaksi.print', compact('transaksi'));
    }
}