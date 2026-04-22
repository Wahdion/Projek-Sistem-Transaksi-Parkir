<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'tb_transaksi';
    protected $primaryKey = 'id_parkir';
    
    public $timestamps = true;

    protected $fillable = [
        'id_kendaraan',
        'id_area',
        'id_tarif',
        'id_user', // FK ke tb_user
        'waktu_masuk',
        'waktu_keluar',
        'durasi_jam',
        'biaya_total',
        'status'
    ];

    protected $casts = [
        'waktu_masuk'  => 'datetime',
        'waktu_keluar' => 'datetime',
        'biaya_total'  => 'integer', 
        'durasi_jam'   => 'integer',
    ];

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    public function getFormatBiayaAttribute()
    {
        return 'Rp ' . number_format($this->biaya_total, 0, ',', '.');
    }

    public function getWaktuMasukIndoAttribute()
    {
        return $this->waktu_masuk ? $this->waktu_masuk->format('d/m/Y H:i') : '-';
    }

    // Accessor tambahan untuk memudahkan tampilan di struk keluar
    public function getWaktuKeluarIndoAttribute()
    {
        return $this->waktu_keluar ? $this->waktu_keluar->format('d/m/Y H:i') : '-';
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class, 'id_kendaraan', 'id_kendaraan')->withDefault([
            'plat_nomor' => 'Dihapus',
            'warna' => '-'
        ]);
    }

    public function area()
    {
        return $this->belongsTo(AreaParkir::class, 'id_area', 'id_area')->withDefault([
            'nama_area' => 'Tidak Diketahui'
        ]);
    }

    public function tarif()
    {
        return $this->belongsTo(Tarif::class, 'id_tarif', 'id_tarif')->withDefault([
            'jenis_kendaraan' => '-',
            'tarif_per_jam' => 0
        ]);
    }

    /**
     * Relasi ke User (Petugas)
     * Sangat penting agar nama petugas bisa muncul di struk
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user')->withDefault([
            'nama_lengkap' => 'Petugas' // Sesuai kolom di tb_user
        ]);
    }
}