<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Pesanan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $produks = Produk::all();

    // menghitung total jumlah_pesanan untuk setiap produk
    foreach ($produks as $produk) {
        $produk->total_dipesan = Pesanan::where('id_produk', $produk->id)->sum('jumlah_pesanan');
    }

    return view('dashboard', compact('produks'));
    }

}
