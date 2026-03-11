<?php

namespace App\Http\Controllers;

use App\Models\Tproduk;
use App\Models\Torder;
use App\Models\Tpelanggan;
use App\Models\Tpesanan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class Controller_Order extends Controller
{
    // 

    

    public function index(): View
    {
        $namauserlogin = Auth::user()->name;
        $roleuserlogin = Auth::user()->role;
        $akunuserlogin = Auth::user()->akun;  
        $orderku = Torder::join('tpelanggans', 'torders.pelanggan', '=', 'tpelanggans.id_pelanggan')
            ->join('tproduks', 'torders.produk_id', '=', 'tproduks.id_produk')
            ->select('torders.*', 'tpelanggans.nama_pelanggan', 'tproduks.nama_produk as nama_produk', 'tproduks.harga_retail as harga_satuan')
            ->orderBy('torders.updated_at', 'DESC')
            ->paginate(10);
       
       
        return view('folder_order.page_order', 
            compact('orderku','namauserlogin','akunuserlogin','roleuserlogin'));
    }

    public function search(Request $request)
    {
        if (!empty($request)) {
            $search = $request->input('search');
            
            $namauserlogin = Auth::user()->name;
            $roleuserlogin = Auth::user()->role;   
            $akunuserlogin = Auth::user()->akun;  

            
            $orderku = Torder::leftJoin('tpelanggans', 'torders.pelanggan', '=', 'tpelanggans.id_pelanggan')
                ->leftJoin('tproduks', 'torders.produk_id', '=', 'tproduks.id_produk')
                ->where(function ($query) use ($request) {
                    $query->where('torders.status', 'like', '%' . $request->search . '%')
                        ->orWhere('tpelanggans.nama_pelanggan', 'like', '%' . $request->search . '%')
                        ->orWhere('tproduks.nama_produk', 'like', '%' . $request->search . '%');
                })
                ->select('torders.*', 'tpelanggans.nama_pelanggan', 'tproduks.nama_produk as nama_produk', 'tproduks.harga_retail as harga_satuan')
                ->orderBy('torders.updated_at', 'DESC')
                ->paginate(10);
            
           
            return view('folder_order.page_order', 
                compact('orderku','namauserlogin','akunuserlogin','roleuserlogin'));
        }
        else{
             $orderku = Torder::orderBy('id_order', 'DESC')->paginate(10);
            
             return view('folder_order.page_order', 
                compact('orderku','namauserlogin','akunuserlogin','roleuserlogin'));
        }
       
        
       
    }

    // buat method create
    public function create(): View
    {
        
        $namauserlogin = Auth::user()->name;
        $akunuserlogin = Auth::user()->akun;  
        $roleuserlogin = Auth::user()->role;
        $tingkatuserlogin = Auth::user()->tingkat;
        $kecamatanuserlogin = Auth::user()->kecamatan;
        $desauserlogin = Auth::user()->desa;
        $dusunuserlogin = Auth::user()->dusun;

        $pelangganku = Tpelanggan::select('id_pelanggan','nama_pelanggan')->orderBy('nama_pelanggan', 'ASC')->get();
        $produkku = Tproduk::select('id_produk','nama_produk','harga_retail')->orderBy('nama_produk', 'ASC')->get();



        return view('folder_order.create', 
            compact('namauserlogin','akunuserlogin','roleuserlogin','pelangganku','produkku'));
    }

    

    public function store(Request $request): RedirectResponse
    {
        // kode untuk validasi inputan
        $request->validate([
            "pelanggan" => 'required|min:1',
            "metode_bayar" => 'required|min:1',
            "produk_id" => 'required|min:1',
            "jumlah_pesanan" => 'required|min:1'
            //'image_ktp' => 'required|image|mimes:jpeg,jpg,png|max:2048',
            //'image_kk' => 'required|image|mimes:jpeg,jpg,png|max:2048',
            //'image_sk' => 'required|image|mimes:jpeg,jpg,png|max:2048'
        ]);

       // Generate kode_order random 6 digit unik
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

        Torder::create([
            'kode_order'     => $kodeOrder,
            'pelanggan' => $request->pelanggan,
            'metode_bayar' => $request->metode_bayar,
            'jumlah_pesanan' => $request->jumlah_pesanan,
            'sisa_pesanan' => $request->jumlah_pesanan,
            'produk_id' => $request->produk_id,
            'status' => 'Aktif'
            //'image_ktp' => $image_ktp->hashName(),
            //'image_kk' => $image_kk->hashName(),
            //'image_sk' => $image_sk->hashName()
        ]);

        return redirect()->route('folder_order.page_order')->with(['success' => 'Data Berhasil Disimpan']);
    }

    // method untuk detail produk
    public function show(string $id): View
    {
        // ambil id produk
        $orderku = Torder::findOrFail($id);
        // render view
        return view('folder_order.show', compact('orderku'));
    }

    // buat method untuk view data yang mau diubah
    public function edit(string $id): View
    {
        $namauserlogin = Auth::user()->name;
        $akunuserlogin = Auth::user()->akun;  
        $roleuserlogin = Auth::user()->role;
        $tingkatuserlogin = Auth::user()->tingkat;
        $kecamatanuserlogin = Auth::user()->kecamatan;
        $desauserlogin = Auth::user()->desa;
        $dusunuserlogin = Auth::user()->dusun;  

        $pelangganku = Tpelanggan::select('id_pelanggan','nama_pelanggan')->orderBy('nama_pelanggan', 'ASC')->get();
        $produkku = Tproduk::select('id_produk','nama_produk','harga_retail')->orderBy('nama_produk', 'ASC')->get();

        $orderku = Torder::leftJoin('tpelanggans', 'torders.pelanggan', '=', 'tpelanggans.id_pelanggan')
            ->leftJoin('tproduks', 'torders.produk_id', '=', 'tproduks.id_produk')
            ->select('torders.*', 'tpelanggans.nama_pelanggan', 'tproduks.nama_produk')
            ->where('torders.id_order', $id)
            ->firstOrFail();
       
        return view('folder_order.edit', 
            compact('orderku','pelangganku','produkku','namauserlogin','akunuserlogin','roleuserlogin',
            'tingkatuserlogin','kecamatanuserlogin','desauserlogin','dusunuserlogin'));
    }
    // method untuk ubah data di database
    public function update(Request $request, $id): RedirectResponse
    {
        // kode untuk validasi inputan
        $request->validate([
            "pelanggan" => 'required',
            "metode_bayar" => 'required',
            "produk_id" => 'required',
            "jumlah_pesanan" => 'required|numeric|min:1',
            "keluar_pesanan" => 'required|numeric|min:0'
        ]);

         // get data by id produk
         $orderku = Torder::findOrFail($id);
            
        $status = $request->sisa_pesanan == 0 ? 'Selesai' : 'Aktif';
        // ubah data sesuai inputan
        $pesananku = Tpesanan::where('tpesanans.order_id', $id);

        $produkku = Tproduk::where('id_produk', $request->produk_id);
        $harga_retail = $produkku->value('harga_retail');
        $total_akumulasi = $harga_retail * $pesananku->value('qty');
        $orderku->update([
            'pelanggan' => $request->pelanggan,
            'metode_bayar' => $request->metode_bayar,
            'produk_id' => $request->produk_id,
            'jumlah_pesanan' => $request->jumlah_pesanan,
            'keluar_pesanan' => $request->keluar_pesanan,
            'sisa_pesanan' => $request->sisa_pesanan,
            'status' => $status,
        ]);
        $pesananku->update([
            'pelanggan' => $request->pelanggan,
            'produk' => $request->produk_id,
            'harga' => $harga_retail,
            'harga_akumulasi' => $total_akumulasi
        ]);

        /*} else {
            // ubah data sesuai inputan
            $biodataku->update([
                'nama_lengkap' => $request->nama_lengkap,
                'ktp' => $request->ktp,
                'tgl_lahir' => $request->tgl_lahir,
                'tempat_lahir' => $request->tempat_lahir,
                'tingkat' => $request->tingkat,
                'divisi' => $request->divisi,
                'posisi' => $request->posisi,
                'deskripsi' => $request->deskripsi
            ]);
        }*/
        return redirect()->route('folder_order.page_order')->with(['success' => 'Data Berhasil Diubah']);
    }

    // method hapus data
    public function destroy($id): RedirectResponse
    {

        // get data by id produk
        $orderku = Torder::findOrFail($id);
        // hapus data produk
        $orderku->delete();

        return redirect()->route('folder_order.page_order')->with(['success' => 'Data Berhasil Dihapus']);
    }
}
