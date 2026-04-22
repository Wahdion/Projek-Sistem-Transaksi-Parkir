<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;

class LogHelper
{
    public static function simpanLog($aktivitas)
    {
        // Ambil ID dari session manual yang kamu buat di AuthController
        $userId = session('id_user'); 

        if ($userId) {
            DB::table('tb_log_aktivitas')->insert([
                'id_user'   => $userId,
                'aktivitas' => $aktivitas,
                'waktu'     => now(),
            ]);
        }
    }
}