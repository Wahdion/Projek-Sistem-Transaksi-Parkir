<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Helpers\LogHelper; 

class UserController extends Controller
{
    public function index()
    {
        $users = DB::table('tb_users')->orderBy('id_user', 'desc')->get();
        return view('admin.user.index', compact('users'));
    }

    public function create()
    {
        return view('admin.user.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'username' => 'required|unique:tb_users,username',
            'password' => 'required|min:5',
            'role' => 'required|in:admin,petugas,owner'
        ]);

        DB::table('tb_users')->insert([
            'nama' => $request->nama,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // MENCATAT LOG: Tambah User
        LogHelper::simpanLog("Menambahkan user baru: " . $request->username . " dengan role: " . $request->role);

        return redirect()->route('admin.user.index')->with('success', 'User berhasil ditambahkan');
    }

    public function edit($id)
    {
        $user = DB::table('tb_users')->where('id_user', $id)->first();

        if (!$user) {
            return redirect()->route('admin.user.index')->with('error', 'Data tidak ditemukan');
        }

        return view('admin.user.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'username' => 'required|unique:tb_users,username,'.$id.',id_user',
            'role' => 'required|in:admin,petugas,owner'
        ]);

        $data = [
            'nama' => $request->nama,
            'username' => $request->username,
            'role' => $request->role,
            'updated_at' => now()
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        DB::table('tb_users')->where('id_user', $id)->update($data);

        // MENCATAT LOG: Update User
        LogHelper::simpanLog("Memperbarui data user: " . $request->username);

        return redirect()->route('admin.user.index')->with('success', 'User berhasil diupdate');
    }

    public function destroy($id)
    {
        // Ambil data sebelum dihapus untuk log
        $user = DB::table('tb_users')->where('id_user', $id)->first();

        if ($user) {
            // MENCATAT LOG: Hapus User
            LogHelper::simpanLog("Menghapus user: " . $user->username);
            
            DB::table('tb_users')->where('id_user', $id)->delete();
        }

        return redirect()->route('admin.user.index')->with('success', 'User berhasil dihapus');
    }
}