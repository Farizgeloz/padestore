<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tpesanan;
use App\Models\Tpengeluaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OtherApiController extends Controller
{
    // ambil semua produk
    public function ringkasanKeuangan()
    {
         $today = now();
    
        // PEMASUKAN
        $pemasukan_hari = Tpesanan::where('status','Selesai')
            ->whereDate('tanggal', $today)
            ->sum('harga_akumulasi');

        $pemasukan_bulan = Tpesanan::where('status','Selesai')
            ->whereMonth('tanggal', $today->month)
            ->whereYear('tanggal', $today->year)
            ->sum('harga_akumulasi');

        $pemasukan_tahun = Tpesanan::where('status','Selesai')
            ->whereYear('tanggal', $today->year)
            ->sum('harga_akumulasi');

        // PENGELUARAN
        $pengeluaran_hari = Tpengeluaran::whereDate('tanggal', $today)
            ->sum('nominal');

        $pengeluaran_bulan = Tpengeluaran::whereMonth('tanggal', $today->month)
            ->whereYear('tanggal', $today->year)
            ->sum('nominal');

        $pengeluaran_tahun = Tpengeluaran::whereYear('tanggal', $today->year)
            ->sum('nominal');

        return response()->json([
            'success' => true,
            'data' => [
                'pemasukan' => [
                    'hari' => $pemasukan_hari,
                    'bulan' => $pemasukan_bulan,
                    'tahun' => $pemasukan_tahun,
                ],
                'pengeluaran' => [
                    'hari' => $pengeluaran_hari,
                    'bulan' => $pengeluaran_bulan,
                    'tahun' => $pengeluaran_tahun,
                ]
            ]
        ]);
    }

   
}