<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogAktivitas extends Model
{
    use HasFactory;

    protected $table = 'tb_log_aktivitas';
    protected $primaryKey = 'id_log';

    // Karena kamu pakai $table->datetime('waktu')->useCurrent(), 
    // maka kita matikan timestamps default Laravel (created_at/updated_at)
    public $timestamps = false; 

    protected $fillable = [
        'id_user',
        'aktivitas',
        'waktu' // Sesuaikan dengan migration
    ];

    // Agar kolom 'waktu' terbaca sebagai object Carbon (bisa pakai diffForHumans)
    protected $casts = [
        'waktu' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}