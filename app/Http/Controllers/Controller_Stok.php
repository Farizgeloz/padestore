<?php

namespace App\Http\Controllers;

use App\Models\Tstok;
use App\Models\Tproduk;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Controller_Stok extends Controller
{
    // 

    

    public function index(): View
    {
        $namauserlogin = Auth::user()->name;
        $akunuserlogin = Auth::user()->akun;  
        $akunuserlogin = Auth::user()->akun;  
        $roleuserlogin = Auth::user()->role;
        $stokku = Tstok::leftJoin('tproduks', 'tstoks.produk_id', '=', 'tproduks.id_produk')
                ->select('tstoks.*', 'tproduks.nama_produk')
                ->orderBy('id_stok', 'DESC')->Paginate(10);
        
       
       
        return view('folder_stok.page_stok', 
            compact('stokku','namauserlogin','akunuserlogin','roleuserlogin'));
    }

    public function search(Request $request)
    {
        if (!empty($request)) {
            $search = $request->input('search');
            
            $namauserlogin = Auth::user()->name;
        $akunuserlogin = Auth::user()->akun;  
            $akunuserlogin = Auth::user()->akun;  
            $roleuserlogin = Auth::user()->role;   

            
            $stokku = Tstok::leftJoin('tproduks', 'tstoks.produk_id', '=', 'tproduks.id_produk')
                ->select('tstoks.*', 'tproduks.nama_produk')
                ->where(function ($query) use ($request) {
                        $query->where('tproduks.nama_stok', "like", "%" . $request->search . "%");
                        $query->orWhere('tstoks.tipe', "like", "%" . $request->search . "%");
                    })
                
                ->orderBy('id_stok', 'DESC')
                ->paginate(10);
            
           
            return view('folder_stok.page_stok', 
                compact('stokku','namauserlogin','akunuserlogin','roleuserlogin'));
        }
        else{
             $stokku = Tstok::orderBy('id_stok', 'DESC')->paginate(10);
            
             return view('folder_stok.page_stok', 
                compact('stokku','namauserlogin','akunuserlogin','roleuserlogin'));
        }
       
        
       
    }

    // buat method create
    public function create(): View
    {
        
        $namauserlogin = Auth::user()->name;
        $akunuserlogin = Auth::user()->akun;  
        $roleuserlogin = Auth::user()->role;
        
        $produkku = Tproduk::select('id_produk','nama_produk','harga_retail')->orderBy('nama_produk', 'ASC')->get();


        return view('folder_stok.create', 
            compact('namauserlogin','akunuserlogin','roleuserlogin','produkku'));
    }

    

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            "produk_id" => 'required|exists:tproduks,id_produk',
            "qty"       => 'required|integer|min:1',
            "tanggal"   => 'required|date',
        ]);

        DB::transaction(function () use ($request) {

            $produk = Tproduk::lockForUpdate()
                        ->findOrFail($request->produk_id);

            $qty = $request->qty;

            $sisa_stok = $produk->sisa_stok;


            // =============================
            // STOK MASUK
            // =============================
          
            $stok_akhir= $sisa_stok + $qty;

            $produk->update(['sisa_stok' => $stok_akhir]);

            
            

            // =============================
            // SIMPAN LOG STOK
            // =============================
            Tstok::create([
                'produk_id' => $request->produk_id,
                'tipe'      => "Masuk",
                'qty'       => $qty,
                'tanggal'   => $request->tanggal
            ]);
        });

        return redirect()
            ->route('folder_stok.page_stok')
            ->with(['success' => 'Data Berhasil Disimpan']);
    }


    // method untuk detail stok
    public function show(string $id): View
    {
        // ambil id stok
        $biodataku = Tstok::findOrFail($id);
        // render view
        return view('folder_stok.show', compact('biodataku'));
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

        


        $stokku = Tstok::findOrFail($id);
       
        return view('folder_stok.edit', 
            compact('stokku','namauserlogin','akunuserlogin','roleuserlogin',
            'tingkatuserlogin','kecamatanuserlogin','desauserlogin','dusunuserlogin'));
    }
    // method untuk ubah data di database
    public function update(Request $request, $id): RedirectResponse
    {
        // kode untuk validasi inputan
        $request->validate([
            "barcode" => 'required|min:1',
            "nama_stok" => 'required|min:1',
            "stok_awal" => 'required|min:1',
            "stok_masuk" => 'required|min:1',
            "stok_keluar" => 'required|min:1',
            "harga_retail" => 'required|min:1',
            "harga_grosir" => 'required|min:1',
            "minimal_grosir" => 'required|min:1',
            "sisa_stok" => 'required|min:1',
            "minimal_grosir" => 'required|min:1',
            "tanggal" => 'required|min:1'
        ]);
        
        // 🧩 Validasi tambahan: logika khusus
        if ($request->stok_masuk < $request->stok_keluar) {
            return back()
                ->withErrors(['stok_masuk' => 'Jumlah stok masuk tidak boleh lebih kecil dari stok keluar.'])
                ->withInput();
        }

         // get data by id stok
         $stokku = Tstok::findOrFail($id);
 
        
            $stokku->update([
                'barcode' => $request->barcode,
                'nama_stok' => $request->nama_stok,
                'stok_awal' => $request->stok_awal,
                'stok_masuk' => $request->stok_masuk,
                'stok_keluar' => $request->stok_keluar,
                'harga_retail' => $request->harga_retail,
                'harga_grosir' => $request->harga_grosir,
                'minimal_grosir' => $request->minimal_grosir,
                'sisa_stok' => $request->sisa_stok,
                'gambar' => $request->gambar,
                'deskripsi' => $request->deskripsi,
                'tanggal' => $request->tanggal,
                'status' => $request->status
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
        return redirect()->route('folder_stok.page_stok')->with(['success' => 'Data Berhasil Diubah']);
    }

    // method hapus data
    public function destroy($id): RedirectResponse
    {

        // get data by id stok
        $stokku = Tstok::findOrFail($id);
        // hapus data stok
        $stokku->delete();

        return redirect()->route('folder_stok.page_stok')->with(['success' => 'Data Berhasil Dihapus']);
    }
}
