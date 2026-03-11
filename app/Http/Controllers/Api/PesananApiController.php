<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tproduk;
use App\Models\Torder;
use App\Models\Tpesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class PesananApiController extends Controller
{
    // ambil semua produk
    public function index()
    {
        $order = Tpesanan::leftJoin('tpelanggans', 'tpesanans.pelanggan', '=', 'tpelanggans.id_pelanggan')
            ->leftJoin('torders', 'tpesanans.order_id', '=', 'torders.id_order')
            ->leftJoin('tproduks', 'tpesanans.produk', '=', 'tproduks.id_produk')
            ->leftJoin('users', 'tpesanans.pengantar', '=', 'users.id')
            ->select('tpesanans.*', 'tpelanggans.nama_pelanggan','tproduks.nama_produk','users.akun','torders.kode_order')
            ->orderBy('tpesanans.status', 'ASC')
            ->orderBy('tpesanans.tanggal', 'DESC')->get();   // 🔹 urutan pertama

        return response()->json([
            'success' => true,
            'message' => 'Daftar Pesanan',
            'data' => $order
        ]);
    }

    public function indexPaging(Request $request)
    {
        $search = $request->search;
        
        $filter = (int) $request->get('filter', 0);

        $pesanan = Tpesanan::leftJoin('tpelanggans', 'tpesanans.pelanggan', '=', 'tpelanggans.id_pelanggan')
            //->leftJoin('torders', 'tpesanans.order_id', '=', 'torders.kode_order')
            ->leftJoin('tproduks', 'tpesanans.produk', '=', 'tproduks.id_produk')
            ->leftJoin('users', 'tpesanans.pengantar', '=', 'users.id')
            ->select(
                'tpesanans.*',
                'tpelanggans.nama_pelanggan',
                'tproduks.nama_produk',
                'users.akun'
                //'torders.kode_order'
            )
            ->orderBy('tpesanans.tanggal', 'DESC');

        // ===== FILTER BERDASARKAN PERIODE =====
        /* if ($periode && $tanggal) {
            if ($periode == 'Periode Harian') {
                $pesanan->whereDate('tpesanans.tanggal', $tanggal);

            } elseif ($periode == 'Periode Bulanan') {
                [$tahun, $bulan] = explode('-', $tanggal);
                $bulan = ltrim($bulan, '0'); // pastikan bulan int
                $pesanan->whereYear('tpesanans.tanggal', (int)$tahun)
                        ->whereMonth('tpesanans.tanggal', (int)$bulan);

            } elseif ($periode == 'Periode Tahunan') {
                $pesanan->whereYear('tpesanans.tanggal', (int)$tanggal);

            } elseif ($periode == 'Range Tanggal') {
                // Tangani format "2026-01-01 s/d 2026-02-28" atau "2026-01-01|2026-02-28"
                if (str_contains($tanggal, '|')) {
                    [$start, $end] = explode('|', $tanggal);
                } elseif (str_contains($tanggal, ' s/d ')) {
                    [$start, $end] = explode(' s/d ', $tanggal);
                } else {
                    $start = $tanggal;
                    $end = $tanggal;
                }

                $startDate = Carbon::parse($start)->startOfDay();
                $endDate   = Carbon::parse($end)->endOfDay();

                Log::debug("Filter Range: $startDate -> $endDate");

                $pesanan->whereBetween('tpesanans.tanggal', [$startDate, $endDate]);
            }
        } */

        

        // ===== FILTER SEARCH =====
        if ($search) {
            $pesanan->where(function($q) use ($search) {
                $q->where('tproduks.nama_produk', 'like', "%$search%")
                  ->orWhere('tpelanggans.nama_pelanggan', 'like', "%$search%");
                  //->orWhere('torders.kode_order', 'like', "%$search%");
            });
        }

        switch ($filter) {

            case 0: // Belum Bayar
                $pesanan->where('tpesanans.status', 'Belum Bayar');
                break;

            case 1: // Dikemas
                $pesanan->where('tpesanans.status', 'Dikemas');
                break;

            case 2: // Dikirim
                $pesanan->where('tpesanans.status', 'Dikirim');
                break;

            case 3: // Selesai
                $pesanan->where('tpesanans.status', 'Selesai');
                break;

            default: // Semua / Terbaru
                break;
        }

        $pesanan = $pesanan->paginate(10);

        return response()->json($pesanan);
    }

    public function indexPagingSelesai(Request $request)
    {
        $search = $request->search;
        $periode = $request->periode;
        $tanggal = $request->tanggal;

        $pesanan = Tpesanan::leftJoin('tpelanggans', 'tpesanans.pelanggan', '=', 'tpelanggans.id_pelanggan')
            ->leftJoin('torders', 'tpesanans.order_id', '=', 'torders.kode_order')
            ->leftJoin('tproduks', 'tpesanans.produk', '=', 'tproduks.id_produk')
            ->leftJoin('users', 'tpesanans.pengantar', '=', 'users.id')
            ->select(
                'tpesanans.*',
                'tpelanggans.nama_pelanggan',
                'tproduks.nama_produk',
                'users.akun',
                'torders.kode_order'
            )
            ->where('tpesanans.status', 'Selesai')
            ->orderBy('tpesanans.tanggal', 'DESC');

        // ===== FILTER BERDASARKAN PERIODE =====
        if ($periode && $tanggal) {
            if ($periode == 'Periode Harian') {
                $pesanan->whereDate('tpesanans.tanggal', $tanggal);

            } elseif ($periode == 'Periode Bulanan') {
                [$tahun, $bulan] = explode('-', $tanggal);
                $bulan = ltrim($bulan, '0'); // pastikan bulan int
                $pesanan->whereYear('tpesanans.tanggal', (int)$tahun)
                        ->whereMonth('tpesanans.tanggal', (int)$bulan);

            } elseif ($periode == 'Periode Tahunan') {
                $pesanan->whereYear('tpesanans.tanggal', (int)$tanggal);

            } elseif ($periode == 'Range Tanggal') {
                // Tangani format "2026-01-01 s/d 2026-02-28" atau "2026-01-01|2026-02-28"
                if (str_contains($tanggal, '|')) {
                    [$start, $end] = explode('|', $tanggal);
                } elseif (str_contains($tanggal, ' s/d ')) {
                    [$start, $end] = explode(' s/d ', $tanggal);
                } else {
                    $start = $tanggal;
                    $end = $tanggal;
                }

                $startDate = Carbon::parse($start)->startOfDay();
                $endDate   = Carbon::parse($end)->endOfDay();

                Log::debug("Filter Range: $startDate -> $endDate");

                $pesanan->whereBetween('tpesanans.tanggal', [$startDate, $endDate]);
            }
        }

        // ===== FILTER SEARCH =====
        if ($search) {
            $pesanan->where(function($q) use ($search) {
                $q->where('tproduks.nama_produk', 'like', "%$search%")
                  ->orWhere('tpelanggans.nama_pelanggan', 'like', "%$search%")
                  ->orWhere('torders.kode_order', 'like', "%$search%");
            });
        }

        $pesanan = $pesanan->paginate(10);

        return response()->json($pesanan);
    }

    // detail produk
    public function show($id)
    {
        $order = Tpesanan::leftJoin('tpelanggans', 'tpesanans.pelanggan', '=', 'tpelanggans.id_pelanggan')
            ->leftJoin('tproduks', 'tpesanans.produk', '=', 'tproduks.id_produk')
            ->leftJoin('users', 'tpesanans.pengantar', '=', 'users.id')
            ->select('tpesanans.*', 'tpelanggans.nama_pelanggan','tproduks.nama_produk','users.akun')
            ->where('tpesanans.id_pesanan', $id)
            ->orderBy('tpesanans.tanggal', 'DESC')
            ->orderBy('tpesanans.status', 'ASC')->first();   // 🔹 urutan pertama

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Pesanan tidak ditemukan'
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
            "qty" => 'required',
            "sisa_pesanan" => 'required',
            "order_id" => 'required|exists:torders,id_order',
            
        ]);

        $storeCode = "PS"; // kode toko
        $cityCode  = "PR"; // kode kota / lokasi
        $today = Carbon::now()->format('ymd'); // format tanggal: YYMMDD

        // Ambil pesanan terakhir hari ini
        $lastOrder = Tpesanan::whereDate('created_at', Carbon::today())
            ->orderBy('id_pesanan', 'desc')
            ->first();

        if ($lastOrder) {
            // Ambil nomor urut terakhir dari bagian setelah tanggal
            $lastNumber = (int) substr($lastOrder->kode_pesanan, strrpos($lastOrder->kode_pesanan, '-') + 1);
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT); // otomatis 4 digit
        } else {
            $newNumber = '0001';
        }

        $kodePesanan = "{$storeCode}-{$cityCode}-{$today}-{$newNumber}";

        // Cek apakah kode sudah ada (jika sistem berjalan paralel)
        while (Tpesanan::where('kode_pesanan', $kodePesanan)->exists()) {
            $newNumber = str_pad((int)$newNumber + 1, 4, '0', STR_PAD_LEFT);
            $kodePesanan = "{$storeCode}-{$cityCode}-{$today}-{$newNumber}";
        }
      

        DB::transaction(function() use ($request, &$order, $kodePesanan) {
            $qty = $request->qty;
            $harga_retail = $request->harga;
            $harga_akumulasi = $harga_retail * $qty;
            $sisa_pesanan = $request->sisa_pesanan;
            $status_order = $request->sisa_pesanan == 0 ? 'Selesai' : 'Aktif';
            $order = Torder::where('id_order', $request->order_id)->firstOrFail();
            $pelanggan = $order->pelanggan;
            $produk = $order->produk_id;
            $jumlah_pesanan = $order->jumlah_pesanan;
            $keluar_pesanan_order = $jumlah_pesanan - $sisa_pesanan;

            $pesanan = Tpesanan::create([
                'order_id' => $request->order_id,
                'kode_pesanan' => $kodePesanan,
                'pelanggan' => $pelanggan,
                'produk' => $produk,
                'qty' => $qty,
                'harga' => $harga_retail,
                'harga_akumulasi' => $harga_akumulasi,
                'status' => 'Deliver',
                'tanggal' => now()
            ]);

            $order->update([
                'sisa_pesanan' => $sisa_pesanan,  
                'keluar_pesanan' => $keluar_pesanan_order,
                'status' => $status_order
            ]);
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
       

         // get data by id produk
         $pesanan = Tpesanan::findOrFail($id);
            
        
        

        if (!$pesanan) {
            return response()->json([
                'success' => false,
                'message' => 'Order tidak ditemukan'
            ], 404);
        }

        $request->validate([
            "qty" => 'required',
            "harga" => 'required',
        ]);

       
        // ubah data sesuai inputan
       
        

        DB::transaction(function() use ($request, $pesanan, $id) {
            $pesanan = Tpesanan::where('id_pesanan', $id)->firstOrFail();

            $order = Torder::where('kode_order', $pesanan->order_id)->firstOrFail();

            $status_order = $request->status;

            if($status_order == 'Selesai') {
                $keluar_pesanan_order = $order->jumlah_pesanan;
                $sisa_pesanan_order = 0;
            } else{
                $keluar_pesanan_order = 0;
                $sisa_pesanan_order = $order->jumlah_pesanan;
            }

            $keluar_pesanan_order = $order->jumlah_pesanan - $request->sisa_pesanan;

            $qty = $request->qty;
            $harga_retail = $request->harga;
            $harga_akumulasi = $harga_retail * $qty;


            $pesanan->update([
                'qty' => $qty,
                'harga' => $harga_retail,
                'harga_akumulasi' => $harga_akumulasi,
                'status' => $status_order
            ]);

            

            $order->update([
                'sisa_pesanan' => $sisa_pesanan_order,  
                'keluar_pesanan' => $keluar_pesanan_order,
                'status' => $status_order
            ]);
        });

        return response()->json([
            'success' => true,
            'message' => 'Order berhasil diupdate',
            'data' => $pesanan
        ]);
    }

    // hapus produk
    public function destroy($id)
    {
        $produk = Tproduk::findOrFail($id);

        if (!$produk) {
            return response()->json([
                'success' => false,
                'message' => 'Order tidak ditemukan'
            ], 404);
        }

        // Cek apakah produk terkait dengan pesanan
        if ($produk->pesanans()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Order tidak bisa dihapus karena ada pesanan terkait'
            ], 400);
        }

        DB::transaction(function() use ($produk) {
            $produk->delete();
        });

        return response()->json([
            'success' => true,
            'message' => 'Order berhasil dihapus'
        ]);
    }
}