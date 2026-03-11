<?php

namespace App\Http\Controllers;

use App\Models\Tproduk;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use illuminate\View\View;
use Illuminate\Support\Facades\Auth;


class Controller_Produk extends Controller
{
    // 

    

    public function index(): View
    {
        $namauserlogin = Auth::user()->name;
        $akunuserlogin = Auth::user()->akun;  
        $akunuserlogin = Auth::user()->akun;  
        $roleuserlogin = Auth::user()->role;
        $produkku = Tproduk::orderBy('id_produk', 'DESC')->Paginate(10);
        
       
       
        return view('folder_produk.page_produk', 
            compact('produkku','namauserlogin','akunuserlogin','roleuserlogin'));
    }

    public function search(Request $request)
    {
        if (!empty($request)) {
            $search = $request->input('search');
            
            $namauserlogin = Auth::user()->name;
        $akunuserlogin = Auth::user()->akun;  
            $akunuserlogin = Auth::user()->akun;  
            $roleuserlogin = Auth::user()->role;   

            
            $produkku = Tproduk::where(function ($query) use ($request) {
                    $query->where('nama_produk', "like", "%" . $request->search . "%");
                    $query->orWhere('barcode', "like", "%" . $request->search . "%");
                })
                ->orderBy('id_produk', 'DESC')
                ->paginate(10);
            
           
            return view('folder_produk.page_produk', 
                compact('produkku','namauserlogin','akunuserlogin','roleuserlogin'));
        }
        else{
             $produkku = Tproduk::orderBy('id_produk', 'DESC')->paginate(10);
            
             return view('folder_produk.page_produk', 
                compact('produkku','namauserlogin','akunuserlogin','roleuserlogin'));
        }
       
        
       
    }

    // buat method create
    public function create(): View
    {
        
        $namauserlogin = Auth::user()->name;
        $akunuserlogin = Auth::user()->akun;  
        $roleuserlogin = Auth::user()->role;
        



        return view('folder_produk.create', 
            compact('namauserlogin','akunuserlogin','roleuserlogin'));
    }

    

    public function store(Request $request): RedirectResponse
    {
        // kode untuk validasi inputan
        $request->validate([
            "barcode" => 'required|min:1',
            "nama_produk" => 'required|min:1',
            "stok_awal" => 'required|min:1',
            "produk_masuk" => 'required|min:1',
            "produk_keluar" => 'required|min:1',
            "harga_retail" => 'required|min:1',
            "harga_grosir" => 'required|min:1',
            "minimal_grosir" => 'required|min:1',
            "sisa_stok" => 'required|min:1',
            "minimal_grosir" => 'required|min:1',
            "tanggal" => 'required|min:1'
           
        ]);

        

        Tproduk::create([
            'barcode' => $request->barcode,
            'nama_produk' => $request->nama_produk,
            'stok_awal' => $request->stok_awal,
            'produk_masuk' => $request->produk_masuk,
            'produk_keluar' => $request->produk_keluar,
            'harga_retail' => $request->harga_retail,
            'harga_grosir' => $request->harga_grosir,
            'minimal_grosir' => $request->minimal_grosir,
            'sisa_stok' => $request->sisa_stok,
            'gambar' => $request->gambar,
            'deskripsi' => $request->deskripsi,
            'tanggal' => $request->tanggal,
            'status' => 'Ada'
            //'image_ktp' => $image_ktp->hashName(),
            //'image_kk' => $image_kk->hashName(),
            //'image_sk' => $image_sk->hashName()
        ]);

        return redirect()->route('folder_produk.page_produk')->with(['success' => 'Data Berhasil Disimpan']);
    }

    // method untuk detail produk
    public function show(string $id): View
    {
        // ambil id produk
        $biodataku = Tproduk::findOrFail($id);
        // render view
        return view('folder_produk.show', compact('biodataku'));
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

        


        $produkku = Tproduk::findOrFail($id);
       
        return view('folder_produk.edit', 
            compact('produkku','namauserlogin','akunuserlogin','roleuserlogin',
            'tingkatuserlogin','kecamatanuserlogin','desauserlogin','dusunuserlogin'));
    }
    // method untuk ubah data di database
    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            "barcode" => 'required|min:1',
            "nama_produk" => 'required|min:1',
            "harga_retail" => 'required|min:1',
            "sisa_stok" => 'required|min:1',
            "tanggal" => 'required',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $produkku = Tproduk::findOrFail($id);

        // Validasi logika aman
        if ($request->filled('produk_masuk') && $request->filled('produk_keluar')) {
            if ($request->produk_masuk < $request->produk_keluar) {
                return back()
                    ->withErrors(['produk_masuk' => 'Jumlah produk masuk tidak boleh lebih kecil dari produk keluar.'])
                    ->withInput();
            }
        }

        // Handle upload gambar (opsional)
        if ($request->hasFile('gambar')) {

            if ($produkku->gambar && Storage::exists('produk/' . $produkku->gambar)) {
                Storage::delete('produk/' . $produkku->gambar);
            }

            $file = $request->file('gambar');
            $file->storeAs('produk', $file->hashName());

            $produkku->gambar = $file->hashName();
        }

        // Update data
        $produkku->update([
            'barcode' => $request->barcode,
            'nama_produk' => $request->nama_produk,
            'harga_retail' => $request->harga_retail,
            'sisa_stok' => $request->sisa_stok,
            'gambar' => $produkku->gambar,
            'tanggal' => $request->tanggal,
        ]);

        return redirect()
            ->route('folder_produk.page_produk')
            ->with('success', 'Data Berhasil Diubah');
    }

    // method hapus data
    public function destroy($id): RedirectResponse
    {

        // get data by id produk
        $produkku = Tproduk::findOrFail($id);
        // hapus data produk
        $produkku->delete();

        return redirect()->route('folder_produk.page_produk')->with(['success' => 'Data Berhasil Dihapus']);
    }
}
