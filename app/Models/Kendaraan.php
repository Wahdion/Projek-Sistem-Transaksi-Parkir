<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kendaraan extends Model
{
    use HasFactory;

    // 1. Nama tabel sesuai di phpMyAdmin kamu
    protected $table = 'tb_kendaraan';
    
    // 2. Primary Key sesuai gambar
    protected $primaryKey = 'id_kendaraan';

    // 3. Timestamps aktif (karena ada kolom created_at & updated_at di gambar)
    public $timestamps = true;

    /**
     * 4. Field yang boleh diisi (Fillable)
     * Saya hapus 'pemilik' dan 'id_user' karena tidak ada di gambar database kamu.
     */
    protected $fillable = [
        'plat_nomor',
        'jenis_kendaraan',
        'warna',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELASI
    |--------------------------------------------------------------------------
    */

    /**
     * Relasi ke tabel Transaksi
     */
    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'id_kendaraan', 'id_kendaraan');
    }
}