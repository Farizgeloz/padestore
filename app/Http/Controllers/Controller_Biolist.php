<?php

namespace App\Http\Controllers;

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

class Controller_Biolist extends Controller
{
    // 

    

    public function index(): View
    {
        $namauserlogin = Auth::user()->name;
        $roleuserlogin = Auth::user()->role;
        $tingkatuserlogin = Auth::user()->tingkat;
        $kecamatanuserlogin = Auth::user()->kecamatan;
        $desauserlogin = Auth::user()->desa;
        $dusunuserlogin = Auth::user()->dusun;
        if($roleuserlogin=="Super Admin"){
            $biodataku = Tbiolist::orderBy('id', 'DESC')->Paginate(10);
        }else{
            if($tingkatuserlogin=="DPC"){
                $biodataku = Tbiolist::orderBy('id', 'DESC')->Paginate(10);
            }else if(($roleuserlogin=="Admin")&&($tingkatuserlogin=="DPAC")){
                $biodataku = Tbiolist::where('kecamatan',$kecamatanuserlogin)
                    ->orderBy('id', 'DESC')->Paginate(10);
            }else if($tingkatuserlogin=="DPRt"){
                $biodataku = Tbiolist::where('kecamatan',$kecamatanuserlogin)
                    ->where('desa',$desauserlogin)
                    ->orderBy('id', 'DESC')->Paginate(10);
            }else if($tingkatuserlogin=="DPARt;"){
                $biodataku = Tbiolist::where('kecamatan',$kecamatanuserlogin)
                    ->where('desa',$desauserlogin)
                    ->where('dusun',$dusunuserlogin)
                    ->orderBy('id', 'DESC')->Paginate(10);
            }else{
                $biodataku ="";
            }
            
        }
       
        $tingkatku = Ttingkat::get();
        $divisiku = Tdivisi::get();
        $posisiku = Tposisi::get();
        
        return view('folder_biolist.page_biolist', 
            compact('biodataku','tingkatku','divisiku','posisiku',
            'namauserlogin','roleuserlogin','tingkatuserlogin',
            'kecamatanuserlogin','desauserlogin','dusunuserlogin'));
    }

    public function search(Request $request)
    {
        if (!empty($request)) {
            $search = $request->input('search');
            $tingkatku = Ttingkat::get();
            $divisiku = Tdivisi::get();
            $posisiku = Tposisi::get();
            $namauserlogin = Auth::user()->name;
            $akunuserlogin = Auth::user()->akun;
            $roleuserlogin = Auth::user()->role;   
            $tingkatuserlogin = Auth::user()->tingkat;
            $kecamatanuserlogin = Auth::user()->kecamatan;
            $desauserlogin = Auth::user()->desa;
            $dusunuserlogin = Auth::user()->dusun;

            if($roleuserlogin=="Super Admin"){
                $biodataku = Tbiolist::where('nama_lengkap','like',"%$search%")
                    ->orWhere('ktp', 'like', "%$search%")
                    ->orWhere('tingkat', 'like', "%$search%")
                    ->orWhere('divisi', 'like', "%$search%")
                    ->orWhere('posisi', 'like', "%$search%")
                    ->orWhere('deskripsi', 'like', "%$search%")
                    ->orderBy('id', 'DESC')
                    ->paginate(10);
            }else if($tingkatuserlogin=="DPC"){
                $biodataku = Tbiolist::where('nama_lengkap','like',"%$search%")
                    ->orWhere('ktp', 'like', "%$search%")
                    ->orWhere('tingkat', 'like', "%$search%")
                    ->orWhere('divisi', 'like', "%$search%")
                    ->orWhere('posisi', 'like', "%$search%")
                    ->orWhere('deskripsi', 'like', "%$search%")
                    ->orderBy('id', 'DESC')
                    ->paginate(10);
            }else if($tingkatuserlogin=="DPAC"){
                $biodataku = Tbiolist::where('kecamatan',$kecamatanuserlogin)
                    ->where(function ($query) use ($request) {
                        $query->where('nama_lengkap', "like", "%" . $request->search . "%");
                        $query->orWhere('ktp', "like", "%" . $request->search . "%");
                        $query->orWhere('tingkat', "like", "%" . $request->search . "%");
                        $query->orWhere('divisi', "like", "%" . $request->search . "%");
                        $query->orWhere('posisi', "like", "%" . $request->search . "%");
                        $query->orWhere('deskripsi', "like", "%" . $request->search . "%");
                    })
                    ->orderBy('id', 'DESC')
                    ->paginate(10);
            }else if($tingkatuserlogin=="DPRt"){

                $biodataku = Tbiolist::where('kecamatan',$kecamatanuserlogin)
                    ->where('desa',$desauserlogin)
                    ->where(function ($query) use ($request) {
                        $query->where('nama_lengkap', "like", "%" . $request->search . "%");
                        $query->orWhere('ktp', "like", "%" . $request->search . "%");
                        $query->orWhere('tingkat', "like", "%" . $request->search . "%");
                        $query->orWhere('divisi', "like", "%" . $request->search . "%");
                        $query->orWhere('posisi', "like", "%" . $request->search . "%");
                        $query->orWhere('deskripsi', "like", "%" . $request->search . "%");
                    })
                    ->orderBy('id', 'DESC')
                    ->paginate(10);
            
            }else if($tingkatuserlogin=="DPARt"){
                $biodataku = Tbiolist::where('kecamatan',$kecamatanuserlogin)
                    ->where('desa',$desauserlogin)
                    ->where('dusun',$dusunuserlogin)
                    ->where(function ($query) use ($request) {
                        $query->where('nama_lengkap', "like", "%" . $request->search . "%");
                        $query->orWhere('ktp', "like", "%" . $request->search . "%");
                        $query->orWhere('tingkat', "like", "%" . $request->search . "%");
                        $query->orWhere('divisi', "like", "%" . $request->search . "%");
                        $query->orWhere('posisi', "like", "%" . $request->search . "%");
                        $query->orWhere('deskripsi', "like", "%" . $request->search . "%");
                    })
                    ->orderBy('id', 'DESC')
                    ->paginate(10);
            }else{
                $biodataku = "";
            }
           
            return view('folder_biolist.page_biolist', 
                compact('biodataku','tingkatku','divisiku','posisiku',
                'namauserlogin','akunuserlogin','roleuserlogin','tingkatuserlogin',
                'kecamatanuserlogin','desauserlogin','dusunuserlogin'));
        }
 
        $biodataku = Tbiolist::orderBy('id', 'DESC')->paginate(10);
        $tingkatku = Ttingkat::get();
        $divisiku = Tdivisi::get();
        $posisiku = Tposisi::get();
        $tingkatuserlogin = Auth::user()->tingkat;
        $kecamatanuserlogin = Auth::user()->kecamatan;
        $desauserlogin = Auth::user()->desa;
        $dusunuserlogin = Auth::user()->dusun;
        $roleuserlogin = Auth::user()->role;   
        $namauserlogin = Auth::user()->name;
            $akunuserlogin = Auth::user()->akun;
        return view('folder_biolist.page_biolist', 
            compact('biodataku','tingkatku','divisiku','posisiku',
            'namauserlogin','roleuserlogin','tingkatuserlogin',
            'kecamatanuserlogin','desauserlogin','dusunuserlogin'));
    }

    // buat method create
    public function create(): View
    {
        $tingkatku = Ttingkat::get();
        $divisiku = Tdivisi::get();
        $posisiku = Tposisi::get();
        $namauserlogin = Auth::user()->name;
        $roleuserlogin = Auth::user()->role;
        $tingkatuserlogin = Auth::user()->tingkat;
        $kecamatanuserlogin = Auth::user()->kecamatan;
        $desauserlogin = Auth::user()->desa;
        $dusunuserlogin = Auth::user()->dusun;

        if($roleuserlogin=="Super Admin"){
            $wilayahkecku = Twilayah::select('kecamatan')->groupBy('kecamatan')->orderBy('kecamatan', 'ASC')->get();
            $wilayahdesku = Twilayah::get();
        }else{
            if(($roleuserlogin=="Admin")&&($tingkatuserlogin=="DPC")){
                $wilayahkecku = Twilayah::select('kecamatan')->groupBy('kecamatan')->orderBy('kecamatan', 'ASC')->get();
                $wilayahdesku = Twilayah::get();
            }else if(($roleuserlogin=="Admin")&&($tingkatuserlogin=="DPAC")){
                $wilayahkecku = Twilayah::select('kecamatan')
                    ->where('kecamatan',$kecamatanuserlogin)
                    ->groupBy('kecamatan')
                    ->orderBy('kecamatan', 'ASC')
                    ->get();
                $wilayahdesku = Twilayah::select('desa')
                    ->where('kecamatan',$kecamatanuserlogin)
                    ->orderBy('desa', 'ASC')
                    ->get();
            }else if(($roleuserlogin=="Admin")&&($tingkatuserlogin=="DPRt")){
                $wilayahkecku = Twilayah::select('kecamatan')
                    ->where('kecamatan',$kecamatanuserlogin)
                    ->where('desa',$desauserlogin)
                    ->groupBy('kecamatan')
                    ->orderBy('kecamatan', 'ASC')
                    ->get();
                $wilayahdesku = Twilayah::select('desa')
                    ->where('kecamatan',$kecamatanuserlogin)
                    ->where('desa',$desauserlogin)
                    ->orderBy('desa', 'ASC')
                    ->get();
            }else if(($roleuserlogin=="Admin")&&($tingkatuserlogin=="DPARt;")){
                $wilayahkecku = Twilayah::select('kecamatan')
                    ->where('kecamatan',$kecamatanuserlogin)
                    ->where('desa',$desauserlogin)
                    ->groupBy('kecamatan')
                    ->orderBy('kecamatan', 'ASC')
                    ->get();
                $wilayahdesku = Twilayah::select('desa')
                    ->where('kecamatan',$kecamatanuserlogin)
                    ->where('desa',$desauserlogin)
                    ->orderBy('desa', 'ASC')
                    ->get();
            }else{
                $wilayahkecku ="";
                $wilayahdesku ="";
            }
            
        }



        return view('folder_biolist.create', 
            compact('tingkatku','divisiku','posisiku',
            'wilayahkecku','wilayahdesku',
            'namauserlogin','roleuserlogin','tingkatuserlogin',
            'kecamatanuserlogin','desauserlogin','dusunuserlogin'));
    }

    

    public function store(Request $request): RedirectResponse
    {
        // kode untuk validasi inputan
        $request->validate([
            "nama_lengkap" => 'required|min:3',
            'ktp' => 'required|numeric|16',
            'tgl_lahir' => 'required',
            'tempat_lahir' => 'required|min:3',
            "telpon" => 'numeric|min:11',
            "deskripsi" => 'required|min:1',
            'tingkat' => 'required|min:1',
            'divisi' => 'required|min:1',
            'posisi' => 'required|min:1',
            "deskripsi" => 'required|min:1',
            'image' => 'image|mimes:jpeg,jpg,png|max:2048',
            //'image_ktp' => 'required|image|mimes:jpeg,jpg,png|max:2048',
            //'image_kk' => 'required|image|mimes:jpeg,jpg,png|max:2048',
            //'image_sk' => 'required|image|mimes:jpeg,jpg,png|max:2048'
        ]);

        // upload image
        $image = $request->file('image');
        $image->storeAs('anggotalists', $image->hashName());
        //$image_ktp = $request->file('image');
        //$image_ktp->storeAs('anggotalists_ktp', $image_ktp->hashName());
        //$image_kk = $request->file('image');
        //$image_kk->storeAs('anggotalists_kk', $image_kk->hashName());
        //$image_sk = $request->file('image');
        //$image_sk->storeAs('anggotalists_sk', $image_sk->hashName());

        // kirimkan data input ke tabel database3

        //Terlebih dahulu kita trim dl
        $nomorhp = trim($request->telpon);
        //bersihkan dari karakter yang tidak perlu
        $nomorhp = strip_tags($nomorhp);     
        // Berishkan dari spasi
        $nomorhp= str_replace(" ","",$nomorhp);
        // bersihkan dari bentuk seperti  (022) 66677788
        $nomorhp= str_replace("(","",$nomorhp);
        // bersihkan dari format yang ada titik seperti 0811.222.333.4
        $nomorhp= str_replace(".","",$nomorhp); 
    
        //cek apakah mengandung karakter + dan 0-9
        if(!preg_match('/[^+0-9]/',trim($nomorhp))){
            // cek apakah no hp karakter 1-3 adalah +62
            if(substr(trim($nomorhp), 0, 3)=='+62'){
                $nomorhp= trim($nomorhp);
            }
            // cek apakah no hp karakter 1 adalah 0
            elseif(substr($nomorhp, 0, 1)=='0'){
                $nomorhp= '+62'.substr($nomorhp, 1);
            }
        }   

        Tbiolist::create([
            'nama_lengkap' => $request->nama_lengkap,
            'ktp' => $request->ktp,
            'tgl_lahir' => $request->tgl_lahir,
            'tempat_lahir' => $request->tempat_lahir,
            'pekerjaan' => $request->pekerjaan,
            'telpon' => $nomorhp,
            'tingkat' => $request->tingkat,
            'divisi' => $request->divisi,
            'posisi' => $request->posisi,
            'deskripsi' => $request->deskripsi,
            'image' => $image->hashName(),
            //'image_ktp' => $image_ktp->hashName(),
            //'image_kk' => $image_kk->hashName(),
            //'image_sk' => $image_sk->hashName()
        ]);

        return redirect()->route('folder_biolist.page_biolist')->with(['success' => 'Data Berhasil Disimpan']);
    }

    // method untuk detail produk
    public function show(string $id): View
    {
        // ambil id produk
        $biodataku = Tbiolist::findOrFail($id);
        // render view
        return view('folder_biolist.show', compact('biodataku'));
    }

    // buat method untuk view data yang mau diubah
    public function edit(string $id): View
    {
        $namauserlogin = Auth::user()->name;
        $roleuserlogin = Auth::user()->role;
        $tingkatuserlogin = Auth::user()->tingkat;
        $kecamatanuserlogin = Auth::user()->kecamatan;
        $desauserlogin = Auth::user()->desa;
        $dusunuserlogin = Auth::user()->dusun;  
        $namauserlogin = Auth::user()->name;

        $tingkatku = Ttingkat::get();
        $divisiku = Tdivisi::get();
        $posisiku = Tposisi::get();

        if($roleuserlogin=="Super Admin"){
            $wilayahkecku = Twilayah::select('kecamatan')->groupBy('kecamatan')->orderBy('kecamatan', 'ASC')->get();
            $wilayahdesku = Twilayah::get();
        }else{
            if(($roleuserlogin=="Admin")&&($tingkatuserlogin=="DPC")){
                $wilayahkecku = Twilayah::select('kecamatan')->groupBy('kecamatan')->orderBy('kecamatan', 'ASC')->get();
                $wilayahdesku = Twilayah::get();
            }else if(($roleuserlogin=="Admin")&&($tingkatuserlogin=="DPAC")){
                $wilayahkecku = Twilayah::select('kecamatan')
                    ->where('kecamatan',$kecamatanuserlogin)
                    ->groupBy('kecamatan')
                    ->orderBy('kecamatan', 'ASC')
                    ->get();
                $wilayahdesku = Twilayah::select('desa')
                    ->where('kecamatan',$kecamatanuserlogin)
                    ->orderBy('desa', 'ASC')
                    ->get();
            }else if(($roleuserlogin=="Admin")&&($tingkatuserlogin=="DPRt")){
                $wilayahkecku = Twilayah::select('kecamatan')
                    ->where('kecamatan',$kecamatanuserlogin)
                    ->where('desa',$desauserlogin)
                    ->groupBy('kecamatan')
                    ->orderBy('kecamatan', 'ASC')
                    ->get();
                $wilayahdesku = Twilayah::select('desa')
                    ->where('kecamatan',$kecamatanuserlogin)
                    ->where('desa',$desauserlogin)
                    ->orderBy('desa', 'ASC')
                    ->get();
            }else if(($roleuserlogin=="Admin")&&($tingkatuserlogin=="DPARt;")){
                $wilayahkecku = Twilayah::select('kecamatan')
                    ->where('kecamatan',$kecamatanuserlogin)
                    ->where('desa',$desauserlogin)
                    ->groupBy('kecamatan')
                    ->orderBy('kecamatan', 'ASC')
                    ->get();
                $wilayahdesku = Twilayah::select('desa')
                    ->where('kecamatan',$kecamatanuserlogin)
                    ->where('desa',$desauserlogin)
                    ->orderBy('desa', 'ASC')
                    ->get();
            }else{
                $wilayahkecku ="";
                $wilayahdesku ="";
            }
            
        }

        


        $biodataku = Tbiolist::findOrFail($id);
       
        return view('folder_biolist.edit', 
            compact('biodataku','tingkatku','divisiku','posisiku',
            'wilayahkecku','wilayahdesku','namauserlogin','roleuserlogin',
            'tingkatuserlogin','kecamatanuserlogin','desauserlogin','dusunuserlogin'));
    }
    // method untuk ubah data di database
    public function update(Request $request, $id): RedirectResponse
    {
        // kode untuk validasi inputan
        $request->validate([
            "nama_lengkap" => 'required|min:5',
            'ktp' => 'required|numeric',
            'tgl_lahir' => 'required',
            'tempat_lahir' => 'required|min:1',
            "telpon" => 'numeric|min:11',
            'tingkat' => 'required|min:1',
            'divisi' => 'required|min:1',
            'posisi' => 'required|min:1',
            "deskripsi" => 'required|min:1',
            'image' => 'image|mimes:jpeg,jpg,png|max:2048',
            'image_ktp' => 'image|mimes:jpeg,jpg,png|max:2048',
            'image_kk' => 'image|mimes:jpeg,jpg,png|max:2048',
            'image_sk' => 'image|mimes:jpeg,jpg,png|max:2048'
        ]);

         // get data by id produk
         $biodataku = Tbiolist::findOrFail($id);
 
        //if ($request->hasFile('image')) {
            // hapus gambar yang lama
           // if ($request->hasFile('image')) {
                //Storage::delete('anggotalists/' . $biodataku->image);
                // gantikan dengan gambar yang baru
                /*
                $image = $request->file('image');
                $image->storeAs('anggotalists1', $image->hashName());*/
                $imagepath=null;
                $image =null;
                $image_ktp =null;
                $image_kk =null;
                $image_sk =null;
                if ($request->hasFile('image')) {
                    Storage::delete('anggotalists/' . $biodataku->image);
                    $image = $request->file('image');
                    $photoPath=$request->file('image')->store('anggotalists','public');

                    $biodataku->update([
                        'image' => $image->hashName()
                    ]);
                  
                }
                if ($request->hasFile('image_ktp')) {
                    Storage::delete('anggotalists_ktp/' . $biodataku->image_ktp);
                    $image_ktp = $request->file('image_ktp');
                    $photoPath=$request->file('image_ktp')->store('anggotalists_ktp','public');

                    $biodataku->update([
                        'image_ktp' => $image_ktp->hashName()
                    ]);
                  
                }
                if ($request->hasFile('image_kk')) {
                    Storage::delete('anggotalists_kk/' . $biodataku->image_kk);
                    $image_kk = $request->file('image_kk');
                    $photoPath=$request->file('image_kk')->store('anggotalists_kk','public');

                    $biodataku->update([
                        'image_kk' => $image_kk->hashName()
                    ]);
                  
                }
                if ($request->hasFile('image_sk')) {
                    Storage::delete('anggotalists_sk/' . $biodataku->image_sk);
                    $image_sk = $request->file('image_sk');
                    $photoPath=$request->file('image_sk')->store('anggotalists_sk','public');

                    $biodataku->update([
                        'image_sk' => $image_sk->hashName()
                    ]);
                  
                }

                /*$biodataku->update([
                    'image' => $image->hashName()
                ]);*/
            //}
           
            /*if ($request->hasFile('image_ktp')) {
                //Storage::delete('anggotalists_ktp/' . $biodataku->image_ktp);
                $image_ktp = $request->file('image_ktp');
                $image_ktp->storeAs('anggotalists_ktp', $image_ktp->hashName());
                $biodataku->update([
                    'image_ktp' => $image_ktp->hashName()
                ]);
            }
            if ($request->hasFile('image_kk')) {
                //Storage::delete('anggotalists_kk/' . $biodataku->image_kk);
                $image_kk = $request->file('image_kk');
                $image_kk->storeAs('anggotalists_kk', $image_kk->hashName());
                $biodataku->update([
                    'image_kk' => $image_kk->hashName()
                ]);
            }
            if ($request->hasFile('image_sk')) {
                //Storage::delete('anggotalists_sk/' . $biodataku->image_sk);
                $image_sk = $request->file('image_sk');
                $image_sk->storeAs('anggotalists_sk', $image_sk->hashName());
                $biodataku->update([
                    'image_sk' => $image_sk->hashName()
                ]);
            }*/
            //Terlebih dahulu kita trim dl
            $nomorhp = trim($request->telpon);
            //bersihkan dari karakter yang tidak perlu
            $nomorhp = strip_tags($nomorhp);     
            // Berishkan dari spasi
            $nomorhp= str_replace(" ","",$nomorhp);
            // bersihkan dari bentuk seperti  (022) 66677788
            $nomorhp= str_replace("(","",$nomorhp);
            // bersihkan dari format yang ada titik seperti 0811.222.333.4
            $nomorhp= str_replace(".","",$nomorhp); 
        
            //cek apakah mengandung karakter + dan 0-9
            if(!preg_match('/[^+0-9]/',trim($nomorhp))){
                // cek apakah no hp karakter 1-3 adalah +62
                if(substr(trim($nomorhp), 0, 3)=='+62'){
                    $nomorhp= trim($nomorhp);
                }
                // cek apakah no hp karakter 1 adalah 0
                elseif(substr($nomorhp, 0, 1)=='0'){
                    $nomorhp= '+62'.substr($nomorhp, 1);
                }
            }    
            
            // ubah data sesuai inputan
            $biodataku->update([
                'nama_lengkap' => $request->nama_lengkap,
                'ktp' => $request->ktp,
                'tgl_lahir' => $request->tgl_lahir,
                'tempat_lahir' => $request->tempat_lahir,
                'pekerjaan' => $request->pekerjaan,
                'telpon' => $nomorhp,
                'tingkat' => $request->tingkat,
                'divisi' => $request->divisi,
                'posisi' => $request->posisi,
                'kecamatan' => $request->kecamatan,
                'desa' => $request->desa,
                'dusun' => $request->dusun,
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
        return redirect()->route('folder_biolist.page_biolist')->with(['success' => 'Data Berhasil Diubah']);
    }

    // method hapus data
    public function destroy($id): RedirectResponse
    {

        // get data by id produk
        $biodataku = Tbiolist::findOrFail($id);
        // hapus gambar
        Storage::delete('anggotalists/' . $biodataku->image);
        Storage::delete('anggotalists_ktp/' . $biodataku->image_ktp);
        Storage::delete('anggotalists_kk/' . $biodataku->image_kk);
        Storage::delete('anggotalists_sk/' . $biodataku->image_sk);

        // hapus data produk
        $biodataku->delete();

        return redirect()->route('folder_biolist.page_biolist')->with(['success' => 'Data Berhasil Dihapus']);
    }
}
