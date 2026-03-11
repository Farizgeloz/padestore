<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tstok;
use App\Models\Tproduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StokApiController extends Controller
{
    // ambil semua stok
    public function index()
    {
        $stok = Tstok::leftJoin('tproduks', 'tstoks.produk_id', '=', 'tproduks.id_produk')
                ->select('tstoks.*', 'tproduks.nama_produk')
                ->where('tstoks.tipe', 'Masuk')
                ->orderBy('id_stok', 'DESC')->get();

        return response()->json([
            'success' => true,
            'message' => 'Daftar Stok Masuk',
            'data' => $stok
        ]);
    }

    public function indexByProduk($produkId)
    {
        $stok = Tstok::leftJoin('tproduks', 'tstoks.produk_id', '=', 'tproduks.id_produk')
                ->select('tstoks.*', 'tproduks.nama_produk')
                ->where('tstoks.tipe', 'Masuk')
                ->where('tstoks.produk_id', $produkId)
                ->orderBy('id_stok', 'DESC')->get();

        return response()->json([
            'success' => true,
            'message' => 'Daftar Stok Masuk',
            'data' => $stok
        ]);
    }

    // detail stok
    public function show($id)
    {
        $stok = Tstok::find($id);

        if (!$stok) {
            return response()->json([
                'success' => false,
                'message' => 'Stok tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $stok
        ]);
    }

    // tambah stok
    public function store(Request $request)
    {
        $request->validate([
            "produk_id" => 'required',
            "tipe" => 'required',
            "qty" => 'required|integer|min:0'
        ]);

        DB::transaction(function() use ($request, &$stok) {
            $stok = Tstok::create([
                'produk_id' => $request->produk_id,
                'tipe' => $request->tipe,
                'qty' => $request->qty,
                'referensi' => $request->referensi,
                'keterangan' => $request->keterangan,
                'tanggal' => $request->tanggal
            ]);
        });

        return response()->json([
            'success' => true,
            'message' => 'Stok berhasil ditambahkan',
            'data' => $stok
        ]);
    }

    // update stok
    public function update(Request $request, $id)
    {
        $stok = Tstok::find($id);

        if (!$stok) {
            return response()->json([
                'success' => false,
                'message' => 'Stok tidak ditemukan'
            ], 404);
        }

        $request->validate([
            "produk_id" => 'required',
            "tipe" => 'required|in:Masuk,Keluar',
            "qty" => 'required|integer|min:0'
        ]);

        DB::transaction(function() use ($request, $stok) {

            // Produk lama
            $produkLama = Tproduk::find($stok->produk_id);

            // 1️⃣ Kembalikan efek stok lama
            if ($stok->tipe == "Masuk") {
                $produkLama->decrement('sisa_stok', $stok->qty);
            } elseif ($stok->tipe == "Keluar") {
                $produkLama->increment('sisa_stok', $stok->qty);
            }

            // 2️⃣ Ambil produk baru
            $produkBaru = Tproduk::find($request->produk_id);

            // 3️⃣ Terapkan efek stok baru
            if ($request->tipe == "Masuk") {
                $produkBaru->increment('sisa_stok', $request->qty);
            } elseif ($request->tipe == "Keluar") {
                $produkBaru->decrement('sisa_stok', $request->qty);
            }

            // 4️⃣ Update stok
            $stok->update([
                'produk_id' => $request->produk_id,
                'tipe' => $request->tipe,
                'qty' => $request->qty,
                'referensi' => $request->referensi,
                'keterangan' => $request->keterangan,
                'tanggal' => $request->tanggal ?? $stok->tanggal
            ]);
        });

        return response()->json([
            'success' => true,
            'message' => 'Stok berhasil diupdate',
            'data' => $stok->fresh()
        ]);
    }

    // hapus stok
    public function destroy($id)
    {
        $stok = Tstok::find($id);

        if (!$stok) {
            return response()->json([
                'success' => false,
                'message' => 'Stok tidak ditemukan'
            ], 404);
        }

        // Cek apakah stok terkait dengan pesanan
        if ($stok->pesanans()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Stok tidak bisa dihapus karena ada pesanan terkait'
            ], 400);
        }

        DB::transaction(function() use ($stok) {
            $stok->delete();
        });

        return response()->json([
            'success' => true,
            'message' => 'Stok berhasil dihapus'
        ]);
    }
}