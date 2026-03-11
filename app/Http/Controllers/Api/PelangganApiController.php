<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tpelanggan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PelangganApiController extends Controller
{
    // ambil semua pelanggan
    public function index()
    {
        $pelanggan = Tpelanggan::orderBy('id_pelanggan', 'DESC')->get();

        return response()->json([
            'success' => true,
            'message' => 'Daftar Pelanggan',
            'data' => $pelanggan
        ]);
    }

    public function indexPaging(Request $request)
    {
        $search = $request->search;

        $pelanggan = Tpelanggan::leftJoin('users', 'tpelanggans.akun', '=', 'users.id')
            ->select(
                'tpelanggans.*',
                'users.akun As akun_user',
                'users.role As role_user'
            )
            ->orderBy('tpelanggans.status', 'ASC');

        if ($search) {
            $pelanggan->where(function($q) use ($search) {
                $q->where('tpelanggans.nama_pelanggan', 'like', "%$search%")
                ->orWhere('users.akun', 'like', "%$search%");
            });
        }

        $pelanggan = $pelanggan->paginate(10);

        return response()->json($pelanggan);
    }

    public function indexuseraktif()
    {
        $akun = User::leftJoin('tpelanggans', 'users.id', '=', 'tpelanggans.akun')
                ->select('users.*', 'tpelanggans.nama_pelanggan')
                ->where('users.status', 'Aktif')
                ->where('users.role', 'Pelanggan')
        ->orderBy('users.created_at', 'DESC')->get();

        return response()->json([
            'success' => true,
            'message' => 'Daftar Akun Aktif',
            'data' => $akun
        ]);
    }

    // detail pelanggan
    public function show($id)
    {
        $pelanggan = Tpelanggan::find($id);

        if (!$pelanggan) {
            return response()->json([
                'success' => false,
                'message' => 'Pelanggan tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $pelanggan
        ]);
    }

    // tambah produk
    public function store(Request $request)
    {
        $request->validate([
            "nama_pelanggan" => 'required',
            "alamat" => 'required',
            "telpon" => 'required'
        ]);

        DB::transaction(function() use ($request, &$pelanggan) {

            $data = [
                'nama_pelanggan' => $request->nama_pelanggan,
                'alamat'         => $request->alamat,
                'telpon'         => $request->telpon,
                'wilayah'        => $request->wilayah,
                'status'         => $request->status
            ];

            // ✅ Jika akun dikirim, tambahkan ke data
            if ($request->filled('akun')) {
                $data['akun'] = $request->akun;
            }

            $pelanggan = Tpelanggan::create($data);
        });

        return response()->json([
            'success' => true,
            'message' => 'Pelanggan berhasil ditambahkan',
            'data'    => $pelanggan
        ]);
    }

    // update pelanggan
    public function update(Request $request, $id)
    {
        $pelanggan = Tpelanggan::find($id);

        if (!$pelanggan) {
            return response()->json([
                'success' => false,
                'message' => 'Pelanggan tidak ditemukan'
            ], 404);
        }

        $request->validate([
            "nama_pelanggan" => 'required',
            "alamat" => 'required',
            "telpon" => 'required',
            "status" => 'required',
        ]);

        DB::transaction(function() use ($request, $pelanggan) {
            $pelanggan->update([
                'nama_pelanggan' => $request->nama_pelanggan,
                'akun' => $request->akun,
                'alamat' => $request->alamat,
                'telpon' => $request->telpon,
                'wilayah' => $request->wilayah,
                'status' => $request->status
            ]);
        });

        return response()->json([
            'success' => true,
            'message' => 'Pelanggan berhasil diupdate',
            'data' => $pelanggan
        ]);
    }

    // hapus pelanggan
    public function destroy($id)
    {
        $pelanggan = Tpelanggan::findOrFail($id);

        if (!$pelanggan) {
            return response()->json([
                'success' => false,
                'message' => 'Pelanggan tidak ditemukan'
            ], 404);
        }

        // Cek apakah pelanggan terkait dengan pesanan
        if ($pelanggan->pesanans()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Pelanggan tidak bisa dihapus karena ada pesanan terkait'
            ], 400);
        }

        DB::transaction(function() use ($pelanggan) {
            $pelanggan->delete();
        });

        return response()->json([
            'success' => true,
            'message' => 'Pelanggan berhasil dihapus'
        ]);
    }
}