<?php

namespace App\Http\Controllers;

use App\Models\Tpengeluaran;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class Controller_Pengeluaran extends Controller
{
    // 
    public $timestamps = false;
    

    public function index(): View
    {
        $namauserlogin = Auth::user()->name;
        $akunuserlogin = Auth::user()->akun;  
        $akunuserlogin = Auth::user()->akun;  
        $roleuserlogin = Auth::user()->role;
        $pengeluaranku = Tpengeluaran::orderBy('id_pengeluaran', 'DESC')->Paginate(10);
        
       
       
        return view('folder_pengeluaran.page_pengeluaran', 
            compact('pengeluaranku','namauserlogin','akunuserlogin','roleuserlogin'));
    }

    public function search(Request $request)
    {
        if (!empty($request)) {
            $search = $request->input('search');
            
            $namauserlogin = Auth::user()->name;
            $akunuserlogin = Auth::user()->akun;  
            $akunuserlogin = Auth::user()->akun;  
            $roleuserlogin = Auth::user()->role;   

            
            $pengeluaranku = Tpengeluaran::where(function ($query) use ($request) {
                    $query->where('nama_pengeluaran', "like", "%" . $request->search . "%");
                })
                ->orderBy('tanggal', 'DESC')
                ->paginate(10);
            
           
            return view('folder_pengeluaran.page_pengeluaran', 
                compact('pengeluaranku','namauserlogin','akunuserlogin','roleuserlogin'));
        }
        else{
             $pengeluaranku = Tpengeluaran::orderBy('tanggal', 'DESC')->paginate(10);
            
             return view('folder_pengeluaran.page_pengeluaran', 
                compact('pengeluaranku','namauserlogin','akunuserlogin','roleuserlogin'));
        }
       
        
       
    }

    // buat method create
    public function create(): View
    {
        
        $namauserlogin = Auth::user()->name;
        $akunuserlogin = Auth::user()->akun;  
        $roleuserlogin = Auth::user()->role;
        



        return view('folder_pengeluaran.create', 
            compact('namauserlogin','akunuserlogin','roleuserlogin'));
    }

    

    public function store(Request $request): RedirectResponse
    {
        // kode untuk validasi inputan
        $request->validate([
            "nama_pengeluaran" => 'required|min:1',
            "nominal" => 'required|min:1',
            "tanggal" => 'required|min:1'
        ]);

        

        Tpengeluaran::create([
            'nama_pengeluaran' => $request->nama_pengeluaran,
            'nominal' => $request->nominal,
            'tanggal' => $request->tanggal,
            'updated_at' => $request->tanggal,
            'created_at' => $request->tanggal,
            'validasi' => 'Belum Valid'
            //'image_ktp' => $image_ktp->hashName(),
            //'image_kk' => $image_kk->hashName(),
            //'image_sk' => $image_sk->hashName()
        ]);

        return redirect()->route('folder_pengeluaran.page_pengeluaran')->with(['success' => 'Data Berhasil Disimpan']);
    }

    // method untuk detail produk
    public function show(string $id): View
    {
        // ambil id produk
        $biodataku = Tpengeluaran::findOrFail($id);
        // render view
        return view('folder_pengeluaran.show', compact('biodataku'));
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

        


        $pengeluaranku = Tpengeluaran::findOrFail($id);
       
        return view('folder_pengeluaran.edit', 
            compact('pengeluaranku','namauserlogin','akunuserlogin','roleuserlogin'));
    }
    // method untuk ubah data di database
    public function update(Request $request, $id): RedirectResponse
    {
        // kode untuk validasi inputan
        $request->validate([
            "nama_pengeluaran" => 'required|min:1',
            "nominal" => 'required|min:1',
            "tanggal" => 'required|min:1',
            "validasi" => 'required|min:1'
        ]);
        
       
         // get data by id produk
         $stokbarangku = Tpengeluaran::findOrFail($id);
 
        
            $stokbarangku->timestamps = false; // ✅ Matikan sementara
            $stokbarangku->update([
                'nama_pengeluaran' => $request->nama_pengeluaran,
                'nominal' => $request->nominal,
                'tanggal' => date('Y-m-d H:i:s', strtotime($request->tanggal)),
                'validasi' => $request->validasi
            ]);
            $stokbarangku->timestamps = true; // ✅ Hidupkan kembali kalau perlu

        return redirect()->route('folder_pengeluaran.page_pengeluaran')->with(['success' => 'Data Berhasil Diubah']);
    }

    // method hapus data
    public function destroy($id): RedirectResponse
    {

        // get data by id produk
        $stokbarangku = Tpengeluaran::findOrFail($id);
        // hapus data produk
        $stokbarangku->delete();

        return redirect()->route('folder_pengeluaran.page_pengeluaran')->with(['success' => 'Data Berhasil Dihapus']);
    }
}
