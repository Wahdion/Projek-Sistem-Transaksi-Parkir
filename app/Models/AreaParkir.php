<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AreaParkir extends Model
{
    use HasFactory;

    // 1. Nama tabel sesuai di phpMyAdmin kamu
    protected $table = 'tb_area_parkir';

    // 2. Primary key sesuai skema
    protected $primaryKey = 'id_area';

    // 3. Timestamps aktif sesuai tren database kamu sebelumnya
    public $timestamps = true;

    // 4. Kolom yang boleh diisi
    protected $fillable = [
        'nama_area',
        'kapasitas',
        'terisi'
    ];

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS (Helper untuk Tampilan)
    |--------------------------------------------------------------------------
    */

    /**
     * Memanggil di Blade: {{ $area->sisa_slot }}
     */
    public function getSisaSlotAttribute()
    {
        // Pastikan tidak menghasilkan angka negatif
        $sisa = $this->kapasitas - $this->terisi;
        return $sisa < 0 ? 0 : $sisa;
    }

    /**
     * Memanggil di Blade: {{ $area->status_area }}
     * Berguna untuk memberikan warna badge (Merah jika penuh, Hijau jika tersedia)
     */
    public function getStatusAreaAttribute()
    {
        if ($this->terisi >= $this->kapasitas) {
            return 'Penuh';
        }
        return 'Tersedia';
    }

    /*
    |--------------------------------------------------------------------------
    | RELASI (Relationships)
    |--------------------------------------------------------------------------
    */

    /**
     * Satu area bisa memiliki banyak transaksi parkir
     */
    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'id_area', 'id_area');
    }
}