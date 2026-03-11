<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tproduk;
use App\Models\Torder;
use App\Models\Torderdetail;
use App\Models\Tkeranjang;
use App\Models\Tpesanan;
use App\Models\Tpelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class KeranjangApiController extends Controller
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

    $query = Tkeranjang::leftJoin('tproduks', 'tkeranjangs.produk_id', '=', 'tproduks.id_produk')
        ->leftJoin('tpelanggans', 'tkeranjangs.pelanggan', '=', 'tpelanggans.id_pelanggan')
        ->select(
            'tkeranjangs.*',
            'tproduks.nama_produk',
            'tproduks.harga_retail',
            'tproduks.ukuran',
            'tproduks.satuan',
            'tproduks.gambar',
            'tpelanggans.nama_pelanggan'
        );

    // 🔎 SEARCH
    if (!empty($search)) {
        $query->where(function ($q) use ($search) {
            $q->where('tproduks.nama_produk', 'like', "%{$search}%")
              ->orWhere('tpelanggans.nama_pelanggan', 'like', "%{$search}%")
              ->orWhere('tkeranjangs.kode_order', 'like', "%{$search}%");
        });
    }

    // ===== FILTER DENGAN COALESCE =====
    switch ($filter) {
        case 1: // Nama Produk A-Z
            $query->orderByRaw('COALESCE(tproduks.nama_produk, "") ASC')
                  ->orderBy('tkeranjangs.id_keranjang', 'desc');
            break;
        case 2: // Nama Produk Z-A
            $query->orderByRaw('COALESCE(tproduks.nama_produk, "") DESC')
                  ->orderBy('tkeranjangs.id_keranjang', 'desc');
            break;
        case 3: // Nama Pelanggan A-Z
            $query->orderByRaw('COALESCE(tpelanggans.nama_pelanggan, "") ASC')
                  ->orderBy('tkeranjangs.id_keranjang', 'desc');
            break;
       
        default: // Default: terbaru
            $query->orderBy('tkeranjangs.id_keranjang', 'desc');
            break;
    }

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
                ->where('torders.status', 'Aktif')
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
            'pelanggan' => 'required|integer',
            'metode_bayar' => 'required|string',
            'produk_id' => 'required|integer',
            'jumlah' => 'required|integer|min:1'
        ]);

        DB::beginTransaction();

        try {

            $today = Carbon::now()->format('Ymd');

            $lastOrder = Torder::whereDate('created_at', Carbon::today())
                ->orderBy('id_order','desc')
                ->first();

            if ($lastOrder) {
                $lastNumber = (int) substr($lastOrder->kode_order,-4);
                $newNumber = str_pad($lastNumber + 1,4,'0',STR_PAD_LEFT);
            } else {
                $newNumber = '0001';
            }

            $kodeOrder = "ODR-$today-$newNumber";


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

            // =====================
            // Ambil produk
            // =====================
            $produk = Tproduk::where('id_produk',$request->produk_id)->firstOrFail();

            if ($request->jumlah > $produk->sisa_stok) {
                throw new \Exception("Stok produk {$produk->nama_produk} tidak cukup");
            }
            

            // =====================
            // Simpan order
            // =====================
            $order = Torder::create([
                'kode_order'     => $kodeOrder,
                'pelanggan' => $request->pelanggan,
                'metode_bayar' => $request->metode_bayar,
                'produk_id' => $request->produk_id,
                'jumlah_pesanan' => $request->jumlah,
                'keluar_pesanan' => 0,
                'catatan' => $request->catatan,
                'sisa_pesanan' => $request->jumlah,
                'status' => $request->status ?? 'Belum Bayar',
                'tanggal' => now()
            ]);

            $qty = $request->jumlah;
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


            Tkeranjang::where('pelanggan', $request->pelanggan)
                ->where('produk_id', $request->produk_id)
                ->delete();

            // =====================
            // Update stok produk
            // =====================
            /* $produk->update([
                'sisa_stok' => $produk->sisa_stok - $request->jumlah
            ]); */

            DB::commit();

            return response()->json([
                'success'=>true,
                'message'=>'Order berhasil dibuat',
                'data'=>$order
            ]);

        } catch (\Exception $e){

            DB::rollBack();

            return response()->json([
                'success'=>false,
                'message'=>$e->getMessage()
            ],500);
        }
    }

    public function storeuser(Request $request)
    {
        $request->validate([
            'pelanggan' => 'required|integer',
            'produk_id' => 'required|integer'
        ]);

        DB::beginTransaction();

        try {

            $today = Carbon::now()->format('Ymd');

            // =====================
            // Ambil produk
            // =====================
            $produk = Tproduk::where('id_produk',$request->produk_id)->firstOrFail();

            if ($request->jumlah > $produk->sisa_stok) {
                throw new \Exception("Stok produk {$produk->nama_produk} tidak cukup");
            }

            // =====================
            // Simpan order
            // =====================
            $order = Tkeranjang::create([
                'pelanggan' => $request->pelanggan,
                'produk_id' => $request->produk_id,
                'produk_id' => $request->produk_id,
                'qty' => 1,
                'tanggal' => now()
            ]);

             

            // =====================
            // Update stok produk
            // =====================
            /* $produk->update([
                'sisa_stok' => $produk->sisa_stok - $request->jumlah
            ]); */

            DB::commit();

            return response()->json([
                'success'=>true,
                'message'=>'Berhasil masuk keranjang',
                'data'=>$order
            ]);

        } catch (\Exception $e){

            DB::rollBack();

            return response()->json([
                'success'=>false,
                'message'=>$e->getMessage()
            ],500);
        }
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
         $orderku = Tkeranjang::findOrFail($id);
            
        
        

        if (!$orderku) {
            return response()->json([
                'success' => false,
                'message' => 'Keranjang tidak ditemukan'
            ], 404);
        }

        $request->validate([
            "qty" => 'required'
        ]);

       
        // ubah data sesuai inputan
       
        

        DB::transaction(function() use ($request, $orderku, $id) {

            $orderku->update([
                'qty' => $request->qty
            ]);
           
        });

        return response()->json([
            'success' => true,
            'message' => 'Keranjang berhasil diupdate',
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