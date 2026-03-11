<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tproduk;
use App\Models\Tprodukfavorite;
use App\Models\Tiklan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class DashboardApiController extends Controller
{
    public function dashboardproduk()
    {
        $produk = Tprodukfavorite::leftJoin('tproduks', 'tprodukfavorites.produk_id', '=', 'tproduks.id_produk')
                    ->select('tprodukfavorites.*', 'tproduks.nama_produk','tproduks.harga_retail', 'tproduks.sisa_stok','tproduks.gambar')
                    ->orderBy('tprodukfavorites.tanggal', 'DESC')
                    ->limit(5)
                    ->get();

        $produk->map(function ($item) {
            $item->gambar = $item->gambar 
                ? asset('storage/produk/' . $item->gambar)
                : null;
            return $item;
        });

        return response()->json([
            'success' => true,
            'message' => 'Daftar Produk',
            'data' => $produk
        ]);
    }

    public function dashboardiklan()
    {
        $produk = Tiklan::orderBy('tanggal', 'DESC')
                    ->get();

        $produk->map(function ($item) {
            $item->gambar = $item->gambar 
                ? asset('storage/iklan/' . $item->gambar)
                : null;
            return $item;
        });

        return response()->json([
            'success' => true,
            'message' => 'Daftar Produk',
            'data' => $produk
        ]);
    }
}