<?php

namespace App\Http\Controllers;

use App\Models\Tbarang;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class Controller_Stokbarang extends Controller
{
    // 

    

    public function index(): View
    {
        $namauserlogin = Auth::user()->name;
        $akunuserlogin = Auth::user()->akun;  
        $akunuserlogin = Auth::user()->akun;  
        $roleuserlogin = Auth::user()->role;
        $stokbarangku = Tbarang::orderBy('id_barang', 'DESC')->Paginate(10);
        
       
       
        return view('folder_stokbarang.page_stokbarang', 
            compact('stokbarangku','namauserlogin','akunuserlogin','roleuserlogin'));
    }

    public function search(Request $request)
    {
        if (!empty($request)) {
            $search = $request->input('search');
            
            $namauserlogin = Auth::user()->name;
        $akunuserlogin = Auth::user()->akun;  
            $akunuserlogin = Auth::user()->akun;  
            $roleuserlogin = Auth::user()->role;   

            
            $stokbarangku = Tbarang::where(function ($query) use ($request) {
                    $query->where('nomor_kotak', "like", "%" . $request->search . "%");
                    $query->orWhere('deskripsi', "like", "%" . $request->search . "%");
                })
                ->orderBy('id_barang', 'DESC')
                ->paginate(10);
            
           
            return view('folder_stokbarang.page_stokbarang', 
                compact('stokbarangku','namauserlogin','akunuserlogin','roleuserlogin'));
        }
        else{
             $stokbarangku = Tbarang::orderBy('id_barang', 'DESC')->paginate(10);
            
             return view('folder_stokbarang.page_stokbarang', 
                compact('stokbarangku','namauserlogin','akunuserlogin','roleuserlogin'));
        }
       
        
       
    }

    // buat method create
    public function create(): View
    {
        
        $namauserlogin = Auth::user()->name;
        $akunuserlogin = Auth::user()->akun;  
        $roleuserlogin = Auth::user()->role;
        



        return view('folder_stokbarang.create', 
            compact('namauserlogin','akunuserlogin','roleuserlogin'));
    }

    

    public function store(Request $request): RedirectResponse
    {
        // kode untuk validasi inputan
        $request->validate([
            "kode_barang" => 'required|min:1',
            "nama_barang" => 'required|min:1',
            "stok_awal" => 'required|min:1',
            "barang_masuk" => 'required|min:1',
            "barang_keluar" => 'required|min:1',
            "sisa_stok" => 'required|min:1',
            "nilai_akhir" => 'required|min:1',
            "tanggal" => 'required|min:1'
        ]);

        

        Tbarang::create([
            'kode_barang' => $request->kode_barang,
            'nama_barang' => $request->nama_barang,
            'stok_awal' => $request->stok_awal,
            'barang_masuk' => $request->barang_masuk,
            'barang_keluar' => $request->barang_keluar,
            'sisa_stok' => $request->sisa_stok,
            'nilai_akhir' => $request->nilai_akhir,
            'tanggal' => $request->tanggal,
            'status' => 'Ada'
            //'image_ktp' => $image_ktp->hashName(),
            //'image_kk' => $image_kk->hashName(),
            //'image_sk' => $image_sk->hashName()
        ]);

        return redirect()->route('folder_stokbarang.page_stokbarang')->with(['success' => 'Data Berhasil Disimpan']);
    }

    // method untuk detail produk
    public function show(string $id): View
    {
        // ambil id produk
        $biodataku = Tbarang::findOrFail($id);
        // render view
        return view('folder_stokbarang.show', compact('biodataku'));
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

        


        $stokbarangku = Tbarang::findOrFail($id);
       
        return view('folder_stokbarang.edit', 
            compact('stokbarangku','namauserlogin','akunuserlogin','roleuserlogin',
            'tingkatuserlogin','kecamatanuserlogin','desauserlogin','dusunuserlogin'));
    }
    // method untuk ubah data di database
    public function update(Request $request, $id): RedirectResponse
    {
        // kode untuk validasi inputan
        $request->validate([
            "kode_barang" => 'required|min:1',
            "nama_barang" => 'required|min:1',
            "stok_awal" => 'required|min:1',
            "barang_masuk" => 'required|min:1',
            "barang_keluar" => 'required|min:1',
            "sisa_stok" => 'required|min:1',
            "nilai_akhir" => 'required|min:1',
            "tanggal" => 'required|min:1',
            "status" => 'required|min:1'
        ]);
        
        // 🧩 Validasi tambahan: logika khusus
        if ($request->barang_masuk < $request->barang_keluar) {
            return back()
                ->withErrors(['barang_masuk' => 'Jumlah barang masuk tidak boleh lebih kecil dari barang keluar.'])
                ->withInput();
        }

         // get data by id produk
         $stokbarangku = Tbarang::findOrFail($id);
 
        
            $stokbarangku->update([
                'kode_barang' => $request->kode_barang,
                'nama_barang' => $request->nama_barang,
                'stok_awal' => $request->stok_awal,
                'barang_masuk' => $request->barang_masuk,
                'barang_keluar' => $request->barang_keluar,
                'sisa_stok' => $request->sisa_stok,
                'nilai_akhir' => $request->nilai_akhir,
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
        return redirect()->route('folder_stokbarang.page_stokbarang')->with(['success' => 'Data Berhasil Diubah']);
    }

    // method hapus data
    public function destroy($id): RedirectResponse
    {

        // get data by id produk
        $stokbarangku = Tbarang::findOrFail($id);
        // hapus data produk
        $stokbarangku->delete();

        return redirect()->route('folder_stokbarang.page_stokbarang')->with(['success' => 'Data Berhasil Dihapus']);
    }
}
