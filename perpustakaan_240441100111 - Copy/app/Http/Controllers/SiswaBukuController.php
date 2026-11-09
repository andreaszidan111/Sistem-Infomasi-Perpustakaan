<?php

namespace App\Http\Controllers;

use App\Models\kategori;
use Illuminate\Http\Request;

class SiswaBukuController extends Controller
{
    public function index()
    {
        $kategori = kategori::orderBy('nama')->get();

        return view('siswa.buku', compact('kategori'));
    }
}
