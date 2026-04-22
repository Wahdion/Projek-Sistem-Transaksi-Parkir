<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class LogController extends Controller
{
    public function index()
    {
        // Menggunakan Join untuk mengambil nama user dari tb_users
        $logs = DB::table('tb_log_aktivitas')
            ->join('tb_users', 'tb_log_aktivitas.id_user', '=', 'tb_users.id_user')
            ->select('tb_log_aktivitas.*', 'tb_users.nama')
            ->orderBy('waktu', 'desc')
            ->get();

        return view('admin.log.index', compact('logs'));
    }
}