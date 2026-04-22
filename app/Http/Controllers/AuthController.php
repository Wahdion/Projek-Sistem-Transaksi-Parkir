<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Helpers\LogHelper; 

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $user = DB::table('tb_users')
            ->where('username', $request->username)
            ->first();

        if ($user && Hash::check($request->password, $user->password)) {

            session([
                'login'   => true,
                'id_user' => $user->id_user,
                'nama'    => $user->nama,
                'role'    => $user->role
            ]);

            // MENCATAT LOG: Login Berhasil
            // Kita panggil log di sini setelah session di-set agar id_user terbaca
            LogHelper::simpanLog("User berhasil login ke sistem");

            return redirect('/dashboard');
        }

        return back()->with('error', 'Username atau password salah');
    }

    public function logout()
    {
        // MENCATAT LOG: Logout (Lakukan SEBELUM session di-flush)
        LogHelper::simpanLog("User melakukan logout");

        session()->flush();
        return redirect('/login');
    }
}