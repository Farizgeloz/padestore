<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tmetodebayar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MetodeBayarApiController extends Controller
{
    // ambil semua metode bayar
    public function index()
    {
        $order = Tmetodebayar::orderBy('nama_metode_bayar', 'ASC')->get();

        return response()->json([
            'success' => true,
            'message' => 'Daftar Metode Bayar',
            'data' => $order
        ]);
    }

    // detail metode bayar
    public function show($id)
    {
        $order = Tmetodebayar::find($id);

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Metode Bayar tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $order
        ]);
    }


    // tambah produk
    public function store(Request $request)
    {
        $request->validate([
            "nama_metode_bayar" => 'required'
        ]);

        DB::transaction(function() use ($request, &$metode_bayar) {
            $metode_bayar = Tmetodebayar::create([
                'nama_metode_bayar' => $request->nama_metode_bayar
            ]);
        });

        return response()->json([
            'success' => true,
            'message' => 'Metode Bayar berhasil ditambahkan',
            'data' => $metode_bayar
        ]);
    }

    // update metode bayar
    public function update(Request $request, $id)
    {
        $metode_bayar = Tmetodebayar::find($id);

        if (!$metode_bayar) {
            return response()->json([
                'success' => false,
                'message' => 'Metode Bayar tidak ditemukan'
            ], 404);
        }

        $request->validate([
            "nama_metode_bayar" => 'required',
        ]);

        DB::transaction(function() use ($request, $metode_bayar) {
            $metode_bayar->update([
                'nama_metode_bayar' => $request->nama_metode_bayar,
            ]);
        });

        return response()->json([
            'success' => true,
            'message' => 'Metode Bayar berhasil diupdate',
            'data' => $metode_bayar
        ]);
    }

    // hapus produk
    public function destroy($id)
    {
        $metode_bayar = Tmetodebayar::findOrFail($id);

        if (!$metode_bayar) {
            return response()->json([
                'success' => false,
                'message' => 'Metode Bayar tidak ditemukan'
            ], 404);
        }

        // Cek apakah metode bayar terkait dengan pesanan
        if ($metode_bayar->pesanans()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Metode Bayar tidak bisa dihapus karena ada pesanan terkait'
            ], 400);
        }

        DB::transaction(function() use ($metode_bayar) {
            $metode_bayar->delete();
        });

        return response()->json([
            'success' => true,
            'message' => 'Metode Bayar berhasil dihapus'
        ]);
    }
}