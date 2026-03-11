<?php

namespace App\Http\Controllers;

use App\Models\Tpesanan;
use App\Models\Torder;
use App\Models\Tpelanggan;
use App\Models\Tproduk;
use App\Models\Tstok;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Controller_Pesanan extends Controller
{
    // 

    

    public function index(): View
    {
        $namauserlogin = Auth::user()->name;
        $akunuserlogin = Auth::user()->akun;  
        $roleuserlogin = Auth::user()->role;
        $pesananku = Tpesanan::leftJoin('tpelanggans', 'tpesanans.pelanggan', '=', 'tpelanggans.id_pelanggan')
            ->leftJoin('tproduks', 'tpesanans.produk', '=', 'tproduks.id_produk')
            ->leftJoin('users', 'tpesanans.pengantar', '=', 'users.id')
            ->select('tpesanans.*', 'tpelanggans.nama_pelanggan','tproduks.nama_produk','users.akun')
            ->whereNot('tpesanans.status', 'Selesai')
            ->orderBy('tpesanans.tanggal', 'DESC')
            ->orderBy('tpesanans.status', 'ASC')   // 🔹 urutan pertama
            ->paginate(10);
       
       
        return view('folder_pesanan.page_pesanan', 
            compact('pesananku','namauserlogin','akunuserlogin','roleuserlogin'));
    }
    

    public function search(Request $request)
    {
        if (!empty($request)) {
            $search = $request->input('search');
            
            $namauserlogin = Auth::user()->name;
        $akunuserlogin = Auth::user()->akun;  
            $roleuserlogin = Auth::user()->role;   

            $pesananku = Tpesanan::leftJoin('tpelanggans', 'tpesanans.pelanggan', '=', 'tpelanggans.id_pelanggan')
                ->leftJoin('tproduks', 'tpesanans.produk', '=', 'tproduks.id_produk')
                ->leftJoin('users', 'tpesanans.pengantar', '=', 'users.id')
                ->select('tpesanans.*', 'tpelanggans.nama_pelanggan','tproduks.nama_produk','users.akun')
                ->where(function ($query) use ($request) {
                    $query->where('tpesanans.status', 'like', '%' . $request->search . '%')
                        ->orWhere('tproduks.nama_produk', 'like', '%' . $request->search . '%')
                        ->orWhere('tpelanggans.nama_pelanggan', 'like', '%' . $request->search . '%');// cari juga di nama pelanggan
                })
                ->whereNot('tpesanans.status', 'Selesai')
                ->orderBy('tpesanans.tanggal', 'DESC')
                ->orderBy('tpesanans.status', 'ASC')   // 🔹 urutan pertama
                ->paginate(10);
           
            
           
            return view('folder_pesanan.page_pesanan', 
                compact('pesananku','namauserlogin','akunuserlogin','roleuserlogin'));
        }
        else{
             $pesananku = Tpesanan::orderBy('id_pesanan', 'DESC')->paginate(10);
            
             return view('folder_pesanan.page_pesanan', 
                compact('pesananku','namauserlogin','akunuserlogin','roleuserlogin'));
        }
       
        
       
    }

    // buat method create
    public function create(): View
    {
        
        $namauserlogin = Auth::user()->name;
        $akunuserlogin = Auth::user()->akun;  
        $roleuserlogin = Auth::user()->role;

         // Ambil order berdasarkan order_id dari URL
        //$orderku = Torder::findOrFail($request->order_id);

        // Ambil sisa pesanan
        //$sisaAwal = $orderku->sisa_pesanan;
        $orderku = Torder::leftJoin('tpelanggans', 'torders.pelanggan', '=', 'tpelanggans.id_pelanggan')
            ->leftJoin('tproduks', 'torders.produk_id', '=', 'tproduks.id_produk')
            ->select('torders.*', 'tpelanggans.nama_pelanggan', 'tproduks.nama_produk', 'tproduks.harga_retail')
            ->where('torders.status', 'Aktif')
            ->orderBy('tpelanggans.nama_pelanggan', 'ASC')
            ->get();

        // ✅ Ambil pesanan
       
        $pelangganku = Tpelanggan::select('id_pelanggan','nama_pelanggan')->orderBy('nama_pelanggan', 'ASC')->get();
        $produkku = Tproduk::select('id_produk','barcode','nama_produk','status')->orderBy('nama_produk', 'ASC')->get();
    


        return view('folder_pesanan.create', 
            compact('namauserlogin','akunuserlogin','roleuserlogin','pelangganku','produkku','orderku'));
    }

    public function store(Request $request): RedirectResponse
    {
        // ✅ Validasi awal
        $request->validate([
            "order" => "required|exists:torders,id_order",
            "qty"   => "required|integer|min:1",
        ], [
            "order.required" => "Orderan wajib dipilih.",
            "order.exists"   => "Orderan tidak ditemukan di database.",
            "qty.required"   => "Qty wajib diisi.",
            "qty.integer"    => "Qty harus berupa angka.",
            "qty.min"        => "Qty minimal 1.",
        ]);

        // Kode pesanan
        $storeCode = "PS"; // kode toko
        $cityCode  = "PR"; // kode kota / lokasi
        $today     = Carbon::now()->format('ymd');

        // Ambil pesanan terakhir hari ini
        $lastOrder = Tpesanan::whereDate('created_at', Carbon::today())
            ->orderBy('id_pesanan', 'desc')
            ->first();

        $newNumber = $lastOrder
            ? str_pad((int) substr($lastOrder->kode_pesanan, strrpos($lastOrder->kode_pesanan, '-') + 1) + 1, 4, '0', STR_PAD_LEFT)
            : '0001';

        $kodePesanan = "{$storeCode}-{$cityCode}-{$today}-{$newNumber}";

        // Cek unik kode pesanan
        while (Tpesanan::where('kode_pesanan', $kodePesanan)->exists()) {
            $newNumber = str_pad((int)$newNumber + 1, 4, '0', STR_PAD_LEFT);
            $kodePesanan = "{$storeCode}-{$cityCode}-{$today}-{$newNumber}";
        }

        try {
            DB::transaction(function () use ($request, $kodePesanan) {
                $getorder = Torder::with('produk')
                            ->lockForUpdate()
                            ->findOrFail($request->order);

                $getproduk = Tproduk::lockForUpdate()
                            ->findOrFail($getorder->produk->id_produk);

                $qty = $request->qty;

                // ❌ Validasi runtime
                if ($getproduk->sisa_stok <= 0) {
                    throw new \Exception('Stok produk sudah habis.');
                }

                if ($getorder->status !== 'Aktif') {
                    throw new \Exception('Order sudah selesai.');
                }

                if ($qty > $getorder->sisa_pesanan) {
                    throw new \Exception('Qty melebihi sisa pesanan.');
                }

                if ($qty > $getproduk->sisa_stok) {
                    throw new \Exception('Qty melebihi sisa stok produk.');
                }

                // 🔥 Kurangi stok produk
                $getproduk->update([
                    'sisa_stok' => $getproduk->sisa_stok - $qty
                ]);

                // 🔥 Simpan pesanan baru
                $getorder->pesanans()->create([
                    'kode_pesanan'    => $kodePesanan,
                    'pelanggan'       => $getorder->pelanggan,
                    'produk'          => $getproduk->id_produk,
                    'qty'             => $qty,
                    'harga'           => $getproduk->harga_retail,
                    'harga_akumulasi' => $getproduk->harga_retail * $qty,
                    'status'          => 'Deliver',
                    'tanggal'         => now()
                ]);

                // 🔥 Update order
                $keluarBaru = $getorder->keluar_pesanan + $qty;
                $sisaBaru   = $getorder->jumlah_pesanan - $keluarBaru;

                $getorder->update([
                    'keluar_pesanan' => $keluarBaru,
                    'sisa_pesanan'   => $sisaBaru,
                    'status'         => $sisaBaru == 0 ? 'Selesai' : 'Aktif'
                ]);

                // 🔥 Catat stok keluar
                Tstok::create([
                    'produk_id' => $getproduk->id_produk,
                    'tipe'      => 'Keluar',
                    'qty'       => $qty,
                    'referensi' => $getorder->kode_order.' - Order',
                    'tanggal'   => now(),
                ]);
            });

            // ✅ Jika semua sukses
            return redirect()
                ->route('folder_pesanan.page_pesanan')
                ->with('success', "Pesanan berhasil disimpan.");

        } catch (\Exception $e) {
            // ❌ Tangani error runtime
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => $e->getMessage()]);
        }
    }








    // method untuk detail produk
    public function show(string $id): View
    {
        // ambil id produk
        $pesananku = Tpesanan::findOrFail($id);
        // render view
        return view('folder_pesanan.show', compact('pesananku'));
    }

    // buat method untuk view data yang mau diubah
    public function edit(string $id): View
    {
        $namauserlogin   = Auth::user()->name;
        $akunuserlogin   = Auth::user()->akun;  
        $roleuserlogin   = Auth::user()->role;
        $tingkatuserlogin= Auth::user()->tingkat;
        $kecamatanuserlogin = Auth::user()->kecamatan;
        $desauserlogin   = Auth::user()->desa;
        $dusunuserlogin  = Auth::user()->dusun;  

        $orderku = Torder::leftJoin('tpelanggans', 'torders.pelanggan', '=', 'tpelanggans.id_pelanggan')
            ->leftJoin('tproduks', 'torders.produk_id', '=', 'tproduks.id_produk')
            ->select('torders.*', 'tpelanggans.nama_pelanggan', 'tproduks.nama_produk')
            ->where('torders.status', 'Aktif')
            ->orderBy('tpelanggans.nama_pelanggan', 'ASC')
            ->get();

        // ✅ Ambil pesanan
        $pesananku = Tpesanan::leftJoin('tpelanggans', 'tpesanans.pelanggan', '=', 'tpelanggans.id_pelanggan')
                ->leftJoin('torders', 'tpesanans.order_id', '=', 'torders.id_order')
                ->leftJoin('tproduks', 'tpesanans.produk', '=', 'tproduks.id_produk')
                ->select('tpesanans.*', 'tpelanggans.nama_pelanggan', 'torders.sisa_pesanan', 'tproduks.nama_produk')
                ->findOrFail($id);
        //$orderku = $pesananku->order;

        return view(
            'folder_pesanan.edit', 
            compact(
                'pesananku',
                /* 'pelangganku', */
                'orderku',
                'namauserlogin',
                'akunuserlogin',
                'roleuserlogin',
                'tingkatuserlogin',
                'kecamatanuserlogin',
                'desauserlogin',
                'dusunuserlogin'
            )
        );
    }

    // method untuk ubah data di database
    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'qty'       => 'required|integer|min:0',
            //"catatan"   => 'required|string|min:1',
            "status"   => 'required|string|min:1',
        ]);

        $pesananku = Tpesanan::findOrFail($id);
        $order     = Torder::findOrFail($pesananku->order_id);
        $produk     = Tproduk::findOrFail($order->produk_id);

        $qtyLama = $pesananku->qty;
        $qtyBaru = $request->qty;
        $harga   = $pesananku->harga;

        // 🔥 Hitung keluar baru
        $keluarBaru = ($order->keluar_pesanan - $qtyLama) + $qtyBaru;

        // 🚫 Tolak jika melebihi jumlah pesanan
        if ($keluarBaru > $order->jumlah_pesanan) {
            return back()->with('error', 'Qty melebihi jumlah pesanan.');
        }

        if ($keluarBaru < 0) {
            return back()->with('error', 'Qty tidak valid.');
        }

        $sisaBaru = $order->jumlah_pesanan - $keluarBaru;
        $hargaAkumulasi = $harga * $qtyBaru;

        // 🔥 Update Tpesanan
        $pesananku->update([
            'qty'             => $qtyBaru,
            'harga'           => $harga,
            'harga_akumulasi' => $hargaAkumulasi,
            //'catatan'         => $request->catatan,
            'status'          => $request->status,
            'tanggal'         => now()
        ]);
        

        // 🔥 Update Torder
        $order->update([
            'keluar_pesanan' => $keluarBaru,
            'sisa_pesanan'   => $sisaBaru,
            'status'         => $sisaBaru == 0 ? 'Selesai' : 'Aktif'
        ]);

        // 🔥 Update Tproduk
        $order->update([
            'keluar_pesanan' => $keluarBaru,
            'sisa_pesanan'   => $sisaBaru,
            'status'         => $sisaBaru == 0 ? 'Selesai' : 'Aktif'
        ]);

        return redirect()
            ->route('folder_pesanan.page_pesanan')
            ->with('success', 'Data Berhasil Diubah');
    }

    /* public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'qty'    => 'required|integer|min:0',
            'status' => 'required|string|min:1',
        ]);

        DB::transaction(function () use ($request, $id) {

            $pesananku = Tpesanan::lockForUpdate()->findOrFail($id);
            $order     = Torder::lockForUpdate()->findOrFail($pesananku->order_id);
            $produk    = Tproduk::lockForUpdate()
                            ->findOrFail($order->nama_produk); // kalau sudah pakai produk_id lebih bagus

            $qtyLama = $pesananku->qty;
            $qtyBaru = $request->qty;
            $harga   = $pesananku->harga;

            // 🔥 Hitung selisih qty
            $selisih = $qtyBaru - $qtyLama;

            // 🔥 Hitung keluar baru order
            $keluarBaru = $order->keluar_pesanan + $selisih;

            if ($keluarBaru > $order->jumlah_pesanan) {
                throw new \Exception('Qty melebihi jumlah pesanan.');
            }

            if ($keluarBaru < 0) {
                throw new \Exception('Qty tidak valid.');
            }

            // 🔥 CEK STOK jika qty naik
            if ($selisih > 0 && $produk->sisa_stok < $selisih) {
                throw new \Exception('Stok tidak mencukupi.');
            }

            // =============================
            // UPDATE STOK PRODUK
            // =============================
            $produk->update([
                'produk_keluar' => $produk->produk_keluar + $selisih,
                'sisa_stok'     => $produk->sisa_stok - $selisih
            ]);

            // =============================
            // UPDATE PESANAN
            // =============================
            $hargaAkumulasi = $harga * $qtyBaru;

            $pesananku->update([
                'qty'             => $qtyBaru,
                'harga'           => $harga,
                'harga_akumulasi' => $hargaAkumulasi,
                'status'          => $request->status,
                'tanggal'         => now()
            ]);

            // =============================
            // UPDATE ORDER
            // =============================
            $sisaBaru = $order->jumlah_pesanan - $keluarBaru;

            $order->update([
                'keluar_pesanan' => $keluarBaru,
                'sisa_pesanan'   => $sisaBaru,
                'status'         => $sisaBaru == 0 ? 'Selesai' : 'Aktif'
            ]);
        });

        return redirect()
            ->route('folder_pesanan.page_pesanan')
            ->with('success', 'Data Berhasil Diubah');
    } */





    // method hapus data
    // method hapus data
    public function destroy($id): RedirectResponse
    {
        $pesananku = Tpesanan::findOrFail($id);
        $order     = Torder::findOrFail($pesananku->order_id);

        // 🚫 Cegah hapus jika sudah selesai
        if ($order->status == 'Selesai') {
            return back()->with('error', 'Pesanan sudah selesai, tidak bisa dihapus.');
        }

        $qtyHapus = $pesananku->qty;

        // 🔥 Hitung keluar baru setelah dikurangi
        $keluarBaru = $order->keluar_pesanan - $qtyHapus;

        if ($keluarBaru < 0) {
            return back()->with('error', 'Terjadi kesalahan perhitungan qty.');
        }

        $sisaBaru = $order->jumlah_pesanan - $keluarBaru;

        // 🔥 Update Torder dulu
        $order->update([
            'keluar_pesanan' => $keluarBaru,
            'sisa_pesanan'   => $sisaBaru,
            'status'         => $sisaBaru == 0 ? 'Selesai' : 'Aktif'
        ]);

        // 🔥 Baru hapus detail pesanan
        $pesananku->delete();

        return redirect()
            ->route('folder_pesanan.page_pesanan')
            ->with(['success' => 'Data Berhasil Dihapus']);
    }

}
