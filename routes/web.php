<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController; 
// Import Controller untuk Admin
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\TarifController;
use App\Http\Controllers\Admin\AreaParkirController; 
use App\Http\Controllers\Admin\KendaraanController; 
use App\Http\Controllers\Admin\LogController; 
// Import Controller untuk Petugas
use App\Http\Controllers\Petugas\TransaksiController;
use App\Http\Controllers\Petugas\PetugasDashboardController;
// Import Controller untuk Owner
use App\Http\Controllers\Owner\OwnerDashboardController; // Nama sesuai permintaanmu
use App\Http\Controllers\Owner\LaporanController;
use App\Http\Controllers\Owner\PetugasController;
/*
|--------------------------------------------------------------------------
| AUTH & PUBLIC
|--------------------------------------------------------------------------
*/
Route::get('/', fn() => redirect()->route('login'));

Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| AREA SETELAH LOGIN (Middleware)
|--------------------------------------------------------------------------
*/
Route::middleware('cekLogin')->group(function () {

    // Redirect dashboard utama ke dashboard sesuai role
    Route::get('/dashboard', function () {
        return match (session('role')) {
            'admin'   => redirect()->route('admin.dashboard'),
            'petugas' => redirect()->route('petugas.dashboard'),
            'owner'   => redirect()->route('owner.dashboard'),
            default   => redirect()->route('login'),
        };
    })->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | ROLE: ADMIN
    |--------------------------------------------------------------------------
    */
    Route::middleware('cekRole:admin')->prefix('admin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('/chart-data', [DashboardController::class, 'getChartData'])->name('admin.chart-data');

        // CRUD Master Data
        Route::resource('user', UserController::class)->names('admin.user')->except(['show']);
        Route::resource('tarif', TarifController::class)->names('admin.tarif')->except(['show']);
        Route::resource('area', AreaParkirController::class)->names('admin.area')->except(['show']);
        Route::resource('kendaraan', KendaraanController::class)->names('admin.kendaraan')->except(['show']);

        // Monitoring Log
        Route::get('/logs', [LogController::class, 'index'])->name('admin.logs.index');
    });

    /*
    |--------------------------------------------------------------------------
    | ROLE: PETUGAS
    |--------------------------------------------------------------------------
    */
    Route::middleware(['cekRole:petugas'])->prefix('petugas')->group(function () {
        
        // Dashboard Khusus Petugas
        Route::get('/dashboard', [PetugasDashboardController::class, 'index'])->name('petugas.dashboard');

        // Transaksi Parkir (Dikelompokkan dalam Controller Transaksi)
        Route::controller(TransaksiController::class)->prefix('transaksi')->group(function () {
            
            // 1. Monitoring Kendaraan Aktif (Index)
            Route::get('/', 'index')->name('petugas.transaksi.index'); 
            
            // 2. Registrasi Kendaraan Masuk (Check-in)
            Route::get('/masuk', 'create')->name('petugas.transaksi.create');
            Route::post('/masuk', 'store')->name('petugas.transaksi.store');

            // 3. API Auto-fill AJAX (Cek Plat Nomor)
            Route::get('/get-kendaraan/{plat}', 'getKendaraan')->name('petugas.transaksi.get-kendaraan');
            
            // 4. Cetak Struk (Digunakan oleh Check-in & Check-out)
            // Menggunakan penamaan yang konsisten dengan JavaScript di Blade
            Route::get('/print/{id_parkir}', 'print')->name('petugas.transaksi.print');   

            // 5. Proses Checkout (Keluar)
            Route::put('/keluar/{id_parkir}', 'update')->name('petugas.transaksi.update'); 
        }); 
    }); 
    
    /*
    |--------------------------------------------------------------------------
    | ROLE: OWNER
    |--------------------------------------------------------------------------
    */
    Route::middleware('cekRole:owner')->prefix('owner')->group(function () {
        // URL otomatis menjadi /owner/dashboard
        Route::get('/dashboard', [OwnerDashboardController::class, 'index'])->name('owner.dashboard');
        
        // URL otomatis menjadi /owner/laporan
        Route::get('/laporan', [LaporanController::class, 'index'])->name('owner.laporan.index');
        Route::get('/laporan/cetak', [LaporanController::class, 'print'])->name('owner.laporan.print');
        
        // PERBAIKAN: Hapus prefix 'owner' di dalam sini
        Route::get('/laporan/export-csv', [LaporanController::class, 'exportCsv'])->name('owner.laporan.export.csv');
        
        // PERBAIKAN: Cukup tulis '/petugas', URL akan menjadi /owner/petugas
        Route::get('/petugas', [PetugasController::class, 'index'])->name('owner.petugas.index');
    });

});