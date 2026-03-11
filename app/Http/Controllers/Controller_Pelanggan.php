<?php

namespace App\Http\Controllers;

use App\Models\Tpelanggan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class Controller_Pelanggan extends Controller
{
    // 

    

    public function index(): View
    {
        $namauserlogin = Auth::user()->name;
        $roleuserlogin = Auth::user()->role;
        $akunuserlogin = Auth::user()->akun;  
        $pelangganku = Tpelanggan::orderBy('id_pelanggan', 'DESC')->Paginate(10);
        
       
       
        return view('folder_pelanggan.page_pelanggan', 
            compact('pelangganku','namauserlogin','akunuserlogin','roleuserlogin'));
    }

    public function search(Request $request)
    {
        if (!empty($request)) {
            $search = $request->input('search');
            
            $namauserlogin = Auth::user()->name;
        $akunuserlogin = Auth::user()->akun;  
            $roleuserlogin = Auth::user()->role;   

            
            $pelangganku = Tpelanggan::where(function ($query) use ($request) {
                    $query->where('nomor_kotak', "like", "%" . $request->search . "%");
                    $query->orWhere('deskripsi', "like", "%" . $request->search . "%");
                })
                ->orderBy('id_pelanggan', 'DESC')
                ->paginate(10);
            
           
            return view('folder_pelanggan.page_pelanggan', 
                compact('pelangganku','namauserlogin','akunuserlogin','roleuserlogin'));
        }
        else{
             $pelangganku = Tpelanggan::orderBy('id_pelanggan', 'DESC')->paginate(10);
            
             return view('folder_pelanggan.page_pelanggan', 
                compact('pelangganku','namauserlogin','akunuserlogin','roleuserlogin'));
        }
       
        
       
    }

    // buat method create
    public function create(): View
    {
        
        $namauserlogin = Auth::user()->name;
        $akunuserlogin = Auth::user()->akun;  
        $roleuserlogin = Auth::user()->role;
        



        return view('folder_pelanggan.create', 
            compact('namauserlogin','akunuserlogin','roleuserlogin'));
    }

    

    public function store(Request $request): RedirectResponse
    {
        // kode untuk validasi inputan
        $request->validate([
            "nama_pelanggan" => 'required|min:1',
            "alamat" => 'required|min:1',
            "telpon" => 'required|min:1',
            "wilayah" => 'required|min:1'
        ]);

        

        Tpelanggan::create([
            'nama_pelanggan' => $request->nama_pelanggan,
            'alamat' => $request->alamat,
            'telpon' => $request->telpon,
            'wilayah' => $request->wilayah
            //'image_ktp' => $image_ktp->hashName(),
            //'image_kk' => $image_kk->hashName(),
            //'image_sk' => $image_sk->hashName()
        ]);

        return redirect()->route('folder_pelanggan.page_pelanggan')->with(['success' => 'Data Berhasil Disimpan']);
    }

    // method untuk detail produk
    public function show(string $id): View
    {
        // ambil id produk
        $biodataku = Tpelanggan::findOrFail($id);
        // render view
        return view('folder_pelanggan.show', compact('biodataku'));
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

        


        $pelangganku = Tpelanggan::findOrFail($id);
       
        return view('folder_pelanggan.edit', 
            compact('pelangganku','namauserlogin','akunuserlogin','roleuserlogin',
            'tingkatuserlogin','kecamatanuserlogin','desauserlogin','dusunuserlogin'));
    }
    // method untuk ubah data di database
    public function update(Request $request, $id): RedirectResponse
    {
        // kode untuk validasi inputan
        $request->validate([
            "nama_pelanggan" => 'required|min:1',
            "alamat" => 'required|min:1',
            "telpon" => 'required|min:1',
            "wilayah" => 'required|min:1'
        ]);

         // get data by id produk
         $pelangganku = Tpelanggan::findOrFail($id);
 
        
            $pelangganku->update([
                'nama_pelanggan' => $request->nama_pelanggan,
                'alamat' => $request->alamat,
                'telpon' => $request->telpon,
                'wilayah' => $request->wilayah
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
        return redirect()->route('folder_pelanggan.page_pelanggan')->with(['success' => 'Data Berhasil Diubah']);
    }

    // method hapus data
    public function destroy($id): RedirectResponse
    {

        // get data by id produk
        $pelangganku = Tpelanggan::findOrFail($id);
        // hapus data produk
        $pelangganku->delete();

        return redirect()->route('folder_pelanggan.page_pelanggan')->with(['success' => 'Data Berhasil Dihapus']);
    }
}
