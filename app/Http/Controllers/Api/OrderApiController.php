<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tproduk;
use App\Models\Torder;
use App\Models\Tpesanan;
use App\Models\Tpelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OrderApiController extends Controller
{
    // ambil semua produk
    public function index()
    {
        $order = Torder::leftJoin('tproduks', 'torders.produk_id', '=', 'tproduks.id_produk')
                ->leftJoin('tpelanggans', 'torders.pelanggan', '=', 'tpelanggans.id_pelanggan')
                ->select('torders.*', 'tproduks.nama_produk', 'tproduks.gambar', 'tpelanggans.nama_pelanggan')
        ->orderBy('sisa_pesanan', 'DESC')->get();

        $order->map(function ($item) {
            $item->gambar = $item->gambar 
                ? asset('storage/produk/' . $item->gambar)
                : null;
            return $item;
        });

        return response()->json([
            'success' => true,
            'message' => 'Daftar Order',
            'data' => $order
        ]);
    }

    public function indexPaging(Request $request)
    {
        $limit  = $request->get('limit', 10);
        $page   = $request->get('page', 1);
        $search = trim($request->get('search', null));
        $filter = (int) $request->get('filter', 0);

        $query = Torder::leftJoin('tproduks', 'torders.produk_id', '=', 'tproduks.id_produk')
            ->leftJoin('tpelanggans', 'torders.pelanggan', '=', 'tpelanggans.id_pelanggan')
            ->select(
                'torders.*',
                'tproduks.nama_produk',
                'tproduks.gambar',
                'tpelanggans.nama_pelanggan'
            );

        // 🔎 SEARCH
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('tproduks.nama_produk', 'like', "%{$search}%")
                ->orWhere('tpelanggans.nama_pelanggan', 'like', "%{$search}%")
                ->orWhere('torders.kode_order', 'like', "%{$search}%");
            });
        }

        // ===== FILTER DENGAN COALESCE =====
        switch ($filter) {

            case 0: // Belum Bayar
                $query->where('torders.status', 'Belum Bayar');
                break;

            case 1: // Dikemas
                $query->where('torders.status', 'Dikemas');
                break;

            case 2: // Dikirim
                $query->where('torders.status', 'Dikirim');
                break;

            case 3: // Selesai
                $query->where('torders.status', 'Selesai');
                break;

            default: // Semua / Terbaru
                break;
        }

        // ===== SORT TERBARU =====
        $query->orderBy('torders.id_order', 'desc');

        // ===== PAGINATE =====
        $order = $query->paginate($limit, ['*'], 'page', $page);

        // ===== TRANSFORM GAMBAR =====
        $order->getCollection()->transform(function ($item) {
            $item->gambar = $item->gambar
                ? asset('storage/produk/' . $item->gambar)
                : null;
            return $item;
        });

        // ===== RESPONSE JSON =====
        return response()->json([
            'success' => true,
            'message' => 'Daftar Order',
            'data' => $order->items(),
            'pagination' => [
                'current_page' => $order->currentPage(),
                'last_page'    => $order->lastPage(),
                'per_page'     => $order->perPage(),
                'total'        => $order->total(),
            ]
        ]);
    }

    public function indexaktif()
    {
        $order = Torder::leftJoin('tproduks', 'torders.produk_id', '=', 'tproduks.id_produk')
                ->leftJoin('tpelanggans', 'torders.pelanggan', '=', 'tpelanggans.id_pelanggan')
                ->select('torders.*', 'tproduks.nama_produk','tproduks.harga_retail', 'tpelanggans.nama_pelanggan')
                ->whereNot('torders.status', 'Selesai')
        ->orderBy('sisa_pesanan', 'DESC')->get();

        return response()->json([
            'success' => true,
            'message' => 'Daftar Order',
            'data' => $order
        ]);
    }

    // detail produk
    public function show($id)
    {
        $order = Torder::leftJoin('tproduks', 'torders.produk_id', '=', 'tproduks.id_produk')
                ->leftJoin('tpelanggans', 'torders.pelanggan', '=', 'tpelanggans.id_pelanggan')
                ->select('torders.*', 'tproduks.nama_produk','tproduks.harga_retail', 'tproduks.sisa_stok', 'tpelanggans.nama_pelanggan')
                ->where('torders.id_order', $id)
        ->orderBy('torders.updated_at', 'DESC')->first();

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order tidak ditemukan'
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
            "pelanggan" => 'required',
            "metode_bayar" => 'required',
            "jumlah_pesanan" => 'required',
            "keluar_pesanan" => 'required',
            "sisa_pesanan" => 'required',
            "produk_id" => 'required|integer|min:0',
        ]);


        do {

            $today = Carbon::now()->format('Ymd');

            // Ambil invoice terakhir hari ini
            $lastOrder = Torder::whereDate('created_at', Carbon::today())
                ->orderBy('id_order', 'desc')
                ->first();

            if ($lastOrder) {
                $lastNumber = (int) substr($lastOrder->kode_order, -4);
                $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
            } else {
                $newNumber = '0001';
            }

            $kodeOrder = "ODR-$today-$newNumber";

        } while (Torder::where('kode_order', $kodeOrder)->exists());

        //PESANAN
        $storeCodePesanan = "PS"; // kode toko
        $cityCodePesanan  = "PR"; // kode kota / lokasi
        $todayPesanan = Carbon::now()->format('ymd'); // format tanggal: YYMMDD

        // Ambil pesanan terakhir hari ini
        $lastPesanan = Tpesanan::whereDate('created_at', Carbon::today())
            ->orderBy('id_pesanan', 'desc')
            ->first();

        if ($lastPesanan) {
            // Ambil nomor urut terakhir dari bagian setelah tanggal
            $lastNumberPesanan = (int) substr($lastPesanan->kode_pesanan, strrpos($lastPesanan->kode_pesanan, '-') + 1);
            $newNumberPesanan = str_pad($lastNumberPesanan + 1, 4, '0', STR_PAD_LEFT); // otomatis 4 digit
        } else {
            $newNumberPesanan = '0001';
        }

        $kodePesanan = "{$storeCodePesanan}-{$cityCodePesanan}-{$todayPesanan}-{$newNumberPesanan}";

        // Cek apakah kode sudah ada (jika sistem berjalan paralel)
        while (Tpesanan::where('kode_pesanan', $kodePesanan)->exists()) {
            $newNumberPesanan = str_pad((int)$newNumberPesanan + 1, 4, '0', STR_PAD_LEFT);
            $kodePesanan = "{$storeCodePesanan}-{$cityCodePesanan}-{$todayPesanan}-{$newNumberPesanan}";
        }


        DB::transaction(function() use ($request, &$order, $kodeOrder,$kodePesanan) {
            
            $order = Torder::create([
                'kode_order'     => $kodeOrder,
                'pelanggan' => $request->pelanggan,
                'metode_bayar' => $request->metode_bayar,
                'produk_id' => $request->produk_id,
                'jumlah_pesanan' => $request->jumlah_pesanan,
                'keluar_pesanan' => 0,
                'catatan' => $request->catatan,
                'sisa_pesanan' => $request->jumlah_pesanan,
                'status' => $request->status ?? 'Belum Bayar',
                'tanggal' => now()
            ]);
            
            $produk = Tproduk::where('id_produk', $request->produk_id)->firstOrFail();

            $qty = $request->jumlah_pesanan;
            $harga_retail =  $produk->harga_retail ?? 0;
            $harga_akumulasi = $harga_retail * $qty;

            $pesanan = Tpesanan::create([
                'order_id' => $kodeOrder,
                'kode_pesanan' => $kodePesanan,
                'pelanggan' => $request->pelanggan,
                'produk' => $request->produk_id,
                'qty' => $qty,
                'harga' => $harga_retail,
                'harga_akumulasi' => $harga_akumulasi,
                'status' => 'Belum Bayar',
                'tanggal' => now()
            ]);

             // hapus dari keranjang
           
            // 2️⃣ Ambil produk terkait
           


            // 3️⃣ Kurangi sisa_stok sesuai jumlah pesanan
            /* $produk->update([
                'sisa_stok' => ($produk->sisa_stok ?? 0) - $request->jumlah_pesanan
            ]); */
        });

        return response()->json([
            'success' => true,
            'message' => 'Order berhasil ditambahkan',
            'data' => $order
        ]);
    }

    public function storeuser(Request $request)
    {
        $request->validate([
            "pelanggan" => 'required',
            "metode_bayar" => 'required',
            "jumlah_pesanan" => 'required',
            "produk_id" => 'required|integer|min:0',
        ]);


        do {

            $today = Carbon::now()->format('Ymd');

            // Ambil invoice terakhir hari ini
            $lastOrder = Torder::whereDate('created_at', Carbon::today())
                ->orderBy('id_order', 'desc')
                ->first();

            if ($lastOrder) {
                $lastNumber = (int) substr($lastOrder->kode_order, -4);
                $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
            } else {
                $newNumber = '0001';
            }

            $kodeOrder = "ODR-$today-$newNumber";

        } while (Torder::where('kode_order', $kodeOrder)->exists());

        //PESANAN
        $storeCodePesanan = "PS"; // kode toko
        $cityCodePesanan  = "PR"; // kode kota / lokasi
        $todayPesanan = Carbon::now()->format('ymd'); // format tanggal: YYMMDD

        // Ambil pesanan terakhir hari ini
        $lastPesanan = Tpesanan::whereDate('created_at', Carbon::today())
            ->orderBy('id_pesanan', 'desc')
            ->first();

        if ($lastPesanan) {
            // Ambil nomor urut terakhir dari bagian setelah tanggal
            $lastNumberPesanan = (int) substr($lastPesanan->kode_pesanan, strrpos($lastPesanan->kode_pesanan, '-') + 1);
            $newNumberPesanan = str_pad($lastNumberPesanan + 1, 4, '0', STR_PAD_LEFT); // otomatis 4 digit
        } else {
            $newNumberPesanan = '0001';
        }

        $kodePesanan = "{$storeCodePesanan}-{$cityCodePesanan}-{$todayPesanan}-{$newNumberPesanan}";

        // Cek apakah kode sudah ada (jika sistem berjalan paralel)
        while (Tpesanan::where('kode_pesanan', $kodePesanan)->exists()) {
            $newNumberPesanan = str_pad((int)$newNumberPesanan + 1, 4, '0', STR_PAD_LEFT);
            $kodePesanan = "{$storeCodePesanan}-{$cityCodePesanan}-{$todayPesanan}-{$newNumberPesanan}";
        }


        DB::transaction(function() use ($request, &$order, $kodeOrder, $kodePesanan) {

            $pelanggan = Tpelanggan::leftJoin('users', 'tpelanggans.akun', '=', 'users.id')
            ->select(
                'tpelanggans.*',
                'users.akun As akun_user',
                'users.role As role_user'
            )
            ->orderBy('tpelanggans.status', 'ASC');

            $order = Torder::create([
                'kode_order'     => $kodeOrder,
                'pelanggan' => $request->pelanggan,
                'metode_bayar' => $request->metode_bayar,
                'produk_id' => $request->produk_id,
                'jumlah_pesanan' => $request->jumlah_pesanan,
                'keluar_pesanan' => 0,
                'catatan' => $request->catatan,
                'sisa_pesanan' => $request->jumlah_pesanan,
                'status' => $request->status ?? 'Belum Bayar',
                'tanggal' => now()
            ]);

            $produk = Tproduk::where('id_produk', $request->produk_id)->firstOrFail();

            $qty = $request->jumlah_pesanan;
            $harga_retail =  $produk->harga_retail ?? 0;
            $harga_akumulasi = $harga_retail * $qty;

            $pesanan = Tpesanan::create([
                'order_id' => $kodeOrder,
                'kode_pesanan' => $kodePesanan,
                'pelanggan' => $request->pelanggan,
                'produk' => $request->produk_id,
                'qty' => $qty,
                'harga' => $harga_retail,
                'harga_akumulasi' => $harga_akumulasi,
                'status' => 'Belum Bayar',
                'tanggal' => now()
            ]);
            // 2️⃣ Ambil produk terkait
            /* $produk = Tproduk::where('id_produk', $request->produk_id)->firstOrFail();

            // 3️⃣ Kurangi sisa_stok sesuai jumlah pesanan
            $produk->update([
                'sisa_stok' => ($produk->sisa_stok ?? 0) - $request->jumlah_pesanan
            ]); */
        });

        return response()->json([
            'success' => true,
            'message' => 'Order berhasil ditambahkan',
            'data' => $order
        ]);
    }

    // update produk
    public function update(Request $request, $id)
    {
        /* $request->validate([
            "pelanggan" => 'required',
            "metode_bayar" => 'required',
            "produk_id" => 'required',
            "jumlah_pesanan" => 'required|numeric|min:1',
            "keluar_pesanan" => 'required|numeric|min:0'
        ]); */

         // get data by id produk
         $orderku = Torder::findOrFail($id);
            
        
        

        if (!$orderku) {
            return response()->json([
                'success' => false,
                'message' => 'Order tidak ditemukan'
            ], 404);
        }

        $request->validate([
            "pelanggan" => 'required',
            "metode_bayar" => 'required',
            "jumlah_pesanan" => 'required',
            "keluar_pesanan" => 'required',
            "sisa_pesanan" => 'required',
            "produk_id" => 'required|integer|min:0',
        ]);

       
        // ubah data sesuai inputan
       
        

        DB::transaction(function() use ($request, $orderku, $id) {

            $pesananku = Tpesanan::where('order_id', $id)->firstOrFail();

            $produkku = Tproduk::where('id_produk', $request->produk_id)->firstOrFail();

            $status = $request->sisa_pesanan == 0 ? 'Selesai' : 'Aktif';

            $harga_retail = $produkku->harga_retail;

            $total_akumulasi = $harga_retail * $request->jumlah_pesanan;

            $orderku->update([
                'pelanggan' => $request->pelanggan,
                'metode_bayar' => $request->metode_bayar,
                'produk_id' => $request->produk_id,
                'jumlah_pesanan' => $request->jumlah_pesanan,
                'keluar_pesanan' => $request->keluar_pesanan,
                'sisa_pesanan' => $request->sisa_pesanan,
                'status' => $status,
            ]);

            $produkku->update([
                'sisa_stok' => $request->sisa_stok
            ]);

            $pesananku->update([
                'pelanggan' => $request->pelanggan,
                'produk' => $request->produk_id,
                'harga' => $harga_retail,
                'harga_akumulasi' => $total_akumulasi
            ]);
        });

        return response()->json([
            'success' => true,
            'message' => 'Order berhasil diupdate',
            'data' => $orderku
        ]);
    }

    // hapus produk
    public function destroy($id)
    {
        // Cari order, otomatis 404 jika tidak ada
        $order = Torder::findOrFail($id);
        

        // Cek apakah ada pesanan terkait
        if ($order->pesanans()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Order tidak bisa dihapus karena ada pesanan terkait'
            ], 400);
        }

         

        // Hapus order dalam transaction
       DB::transaction(function() use ($order) {

            // Hapus order
            $order->delete();

            // Ambil produk terkait
            $produkku = Tproduk::where('id_produk', $order->produk_id)->firstOrFail();

            // Hitung sisa stok baru
            $sisaStokBaru = ($produkku->sisa_stok ?? 0) + ($order->jumlah_pesanan ?? 0);

            // Update stok
            $produkku->update([
                'sisa_stok' => $sisaStokBaru
            ]);
        });

        return response()->json([
            'success' => true,
            'message' => 'Order berhasil dihapus'
        ]);
    }
}