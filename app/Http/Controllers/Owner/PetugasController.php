<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class PetugasController extends Controller
{
    public function index()
    {
        // PERBAIKAN: Gunakan -> bukan . sebelum get()
        $petugas = User::where('role', 'petugas')
            ->orderBy('nama', 'asc')
            ->get(); // <-- Pastikan ini pakai tanda panah (->)

        $totalPetugas = $petugas->count();

        return view('owner.petugas.index', compact('petugas', 'totalPetugas'));
    }
}