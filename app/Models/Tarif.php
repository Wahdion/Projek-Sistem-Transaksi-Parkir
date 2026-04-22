<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarif extends Model
{
    use HasFactory;

    // 1. Nama tabel sesuai di phpMyAdmin
    protected $table = 'tb_tarif';
    
    // 2. Primary Key sesuai skema
    protected $primaryKey = 'id_tarif';

    // 3. Timestamps aktif sesuai migration
    public $timestamps = true;

    /**
     * 4. Field yang boleh diisi
     * Pastikan 'tarif_per_jam' sesuai dengan yang ada di gambar database kamu.
     */
    protected $fillable = [
        'jenis_kendaraan',
        'tarif_per_jam',
    ];

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS (Tambahan Agar Tampilan Bagus)
    |--------------------------------------------------------------------------
    */

    /**
     * Memanggil di Blade: {{ $tarif->format_harga }}
     * Hasil: Rp 2.000
     */
    public function getFormatHargaAttribute()
    {
        return 'Rp ' . number_format($this->tarif_per_jam, 0, ',', '.');
    }

    /*
    |--------------------------------------------------------------------------
    | RELASI
    |--------------------------------------------------------------------------
    */

    /**
     * Satu tarif bisa digunakan oleh banyak transaksi parkir
     */
    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'id_tarif', 'id_tarif');
    }
}