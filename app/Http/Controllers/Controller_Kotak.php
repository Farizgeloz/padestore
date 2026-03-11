<?php

namespace App\Http\Controllers;

use App\Models\Tkotak;
use App\Models\Tbiolist;
use App\Models\Ttingkat;
use App\Models\Tdivisi;
use App\Models\Tposisi;
use App\Models\Twilayah;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class Controller_Kotak extends Controller
{
    // 

    

    public function index(): View
    {
        $namauserlogin = Auth::user()->name;
        $roleuserlogin = Auth::user()->role;
        $akunuserlogin = Auth::user()->akun;   
        $kotakku = Tkotak::orderBy('id_kotak', 'DESC')->Paginate(10);
        
       
       
        return view('folder_kotak.page_kotak', 
            compact('kotakku','namauserlogin','akunuserlogin','roleuserlogin'));
    }

    public function search(Request $request)
    {
        if (!empty($request)) {
            $search = $request->input('search');
            
            $namauserlogin = Auth::user()->name;
            $roleuserlogin = Auth::user()->role;
            $akunuserlogin = Auth::user()->akun;   

            
            $kotakku = Tkotak::where(function ($query) use ($request) {
                    $query->where('nomor_kotak', "like", "%" . $request->search . "%");
                    $query->orWhere('deskripsi', "like", "%" . $request->search . "%");
                })
                ->orderBy('id_kotak', 'DESC')
                ->paginate(10);
            
           
            return view('folder_kotak.page_kotak', 
                compact('kotakku','namauserlogin','akunuserlogin','roleuserlogin'));
        }
        else{
             $kotakku = Tkotak::orderBy('id_kotak', 'DESC')->paginate(10);
            
             return view('folder_kotak.page_kotak', 
                compact('kotakku','namauserlogin','akunuserlogin','roleuserlogin'));
        }
       
        
       
    }

    // buat method create
    public function create(): View
    {
        
        $namauserlogin = Auth::user()->name;
        $roleuserlogin = Auth::user()->role;
        $akunuserlogin = Auth::user()->akun;  

        



        return view('folder_kotak.create', 
            compact('namauserlogin','akunuserlogin','roleuserlogin'));
    }

    

    public function store(Request $request): RedirectResponse
    {
        // kode untuk validasi inputan
        $request->validate([
            "nomor_kotak" => 'required|min:1',
            "deskripsi" => 'required|min:1'
            //'foto' => 'image|mimes:jpeg,jpg,png|max:2048',
            //'image_ktp' => 'required|image|mimes:jpeg,jpg,png|max:2048',
            //'image_kk' => 'required|image|mimes:jpeg,jpg,png|max:2048',
            //'image_sk' => 'required|image|mimes:jpeg,jpg,png|max:2048'
        ]);

        // upload image
        //$image = $request->file('foto');
        //$image->storeAs('kotaks', $image->hashName());
        //$image_ktp = $request->file('image');
        //$image_ktp->storeAs('anggotalists_ktp', $image_ktp->hashName());
        //$image_kk = $request->file('image');
        //$image_kk->storeAs('anggotalists_kk', $image_kk->hashName());
        //$image_sk = $request->file('image');
        //$image_sk->storeAs('anggotalists_sk', $image_sk->hashName());

        // kirimkan data input ke tabel database3

       

        Tkotak::create([
            'nomor_kotak' => $request->nomor_kotak,
            'deskripsi' => $request->deskripsi,
            'status' => 'Ada'
            //'foto' => $image->hashName(),
            //'image_ktp' => $image_ktp->hashName(),
            //'image_kk' => $image_kk->hashName(),
            //'image_sk' => $image_sk->hashName()
        ]);

        return redirect()->route('folder_kotak.page_kotak')->with(['success' => 'Data Berhasil Disimpan']);
    }

    // method untuk detail produk
    public function show(string $id): View
    {
        // ambil id produk
        $biodataku = Tkotak::findOrFail($id);
        // render view
        return view('folder_kotak.show', compact('biodataku'));
    }

    // buat method untuk view data yang mau diubah
    public function edit(string $id): View
    {
        $namauserlogin = Auth::user()->name;
        $roleuserlogin = Auth::user()->role;
        $akunuserlogin = Auth::user()->akun;  
        $tingkatuserlogin = Auth::user()->tingkat;
        $kecamatanuserlogin = Auth::user()->kecamatan;
        $desauserlogin = Auth::user()->desa;
        $dusunuserlogin = Auth::user()->dusun;  

        


        $kotakku = Tkotak::findOrFail($id);
       
        return view('folder_kotak.edit', 
            compact('kotakku','namauserlogin','akunuserlogin','roleuserlogin',
            'tingkatuserlogin','kecamatanuserlogin','desauserlogin','dusunuserlogin'));
    }
    // method untuk ubah data di database
    public function update(Request $request, $id): RedirectResponse
    {
        // kode untuk validasi inputan
        $request->validate([
            "nomor_kotak" => 'required|min:1',
            "deskripsi" => 'required|min:1',
            'foto' => 'image|mimes:jpeg,jpg,png|max:2048'
        ]);

         // get data by id produk
         $kotakku = Tkotak::findOrFail($id);
 
        //if ($request->hasFile('image')) {
            // hapus gambar yang lama
           // if ($request->hasFile('image')) {
                //Storage::delete('anggotalists/' . $biodataku->image);
                // gantikan dengan gambar yang baru
                /*
                $image = $request->file('image');
                $image->storeAs('anggotalists1', $image->hashName());*/
                $imagepath=null;
                $foto =null;
               
                if ($request->hasFile('foto')) {
                    Storage::delete('kotaks/' . $kotakku->foto);
                    $foto = $request->file('foto');
                    $photoPath=$request->file('foto')->store('kotaks','public');

                    $kotakku->update([
                        'foto' => $foto->hashName()
                    ]);
                  
                }

            
            
            // ubah data sesuai inputan
            $kotakku->update([
                'nomor_kotak' => $request->nomor_kotak,
                'deskripsi' => $request->deskripsi
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
        return redirect()->route('folder_kotak.page_kotak')->with(['success' => 'Data Berhasil Diubah']);
    }

    // method hapus data
    public function destroy($id): RedirectResponse
    {

        // get data by id produk
        $kotakku = Tkotak::findOrFail($id);
        // hapus gambar
        Storage::delete('kotaks/' . $kotakku->foto);

        // hapus data produk
        $kotakku->delete();

        return redirect()->route('folder_kotak.page_kotak')->with(['success' => 'Data Berhasil Dihapus']);
    }
}
