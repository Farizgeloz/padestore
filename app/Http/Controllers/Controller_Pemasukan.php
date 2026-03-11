<?php

namespace App\Http\Controllers;

use App\Models\Tpemasukan;
use App\Models\Tpesanan;
use App\Models\Tpelanggan;
use App\Models\Tharga;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Controller_Pemasukan extends Controller
{
    // 

    

    public function index(): View
    {
        $namauserlogin = Auth::user()->name;
        $akunuserlogin = Auth::user()->akun;  
        $roleuserlogin = Auth::user()->role;
        $pemasukanku = Tpesanan::leftJoin('tpelanggans', 'tpesanans.pelanggan', '=', 'tpelanggans.id_pelanggan')
        ->leftJoin('tproduks', 'tpesanans.produk', '=', 'tproduks.id_produk')
        ->select(
            'tpelanggans.nama_pelanggan',
            'tproduks.nama_produk',
            DB::raw('DATE(tpesanans.tanggal) as tanggal'),
            DB::raw('SUM(tpesanans.harga_akumulasi) as total_harga'),
            DB::raw('COUNT(tpesanans.order_id) as total_order'),
            DB::raw('SUM(tpesanans.qty) as total_qty'),
            DB::raw('MAX(tpesanans.status) as status')
        )
        ->groupBy(
            'tpelanggans.nama_pelanggan',
            'tproduks.nama_produk',
            DB::raw('DATE(tpesanans.tanggal)')
        )
        ->whereIn('tpesanans.status', ['Selesai'])
        ->orderByDesc('tpesanans.tanggal')
        ->orderBy('tpelanggans.nama_pelanggan', 'ASC')
        ->paginate(10);
        
       
       
        return view('folder_pemasukan.page_pemasukan', 
            compact('pemasukanku','namauserlogin','akunuserlogin','roleuserlogin'));
    }

    public function search(Request $request)
    {
        if (!empty($request)) {
            $search = $request->input('search');
            
            $namauserlogin = Auth::user()->name;
            $akunuserlogin = Auth::user()->akun;  
            $akunuserlogin = Auth::user()->akun;  
            $roleuserlogin = Auth::user()->role;   

            
            $pemasukanku = Tpemasukan::where(function ($query) use ($request) {
                    $query->where('nama_pemasukan', "like", "%" . $request->search . "%");
                })
                ->orderBy('tanggal', 'DESC')
                ->paginate(10);
            
           
            return view('folder_pemasukan.page_pemasukan', 
                compact('pemasukanku','namauserlogin','akunuserlogin','roleuserlogin'));
        }
        else{
             $pemasukanku = Tpemasukan::orderBy('tanggal', 'DESC')->paginate(10);
            
             return view('folder_pemasukan.page_pemasukan', 
                compact('pemasukanku','namauserlogin','akunuserlogin','roleuserlogin'));
        }
       
        
       
    }

    // buat method create
    public function create(): View
    {
        
        $namauserlogin = Auth::user()->name;
        $akunuserlogin = Auth::user()->akun;  
        $roleuserlogin = Auth::user()->role;
        



        return view('folder_pemasukan.create', 
            compact('namauserlogin','akunuserlogin','roleuserlogin'));
    }

    

    public function store(Request $request): RedirectResponse
    {
        // kode untuk validasi inputan
        $request->validate([
            "nama_pemasukan" => 'required|min:1',
            "nominal" => 'required|min:1',
            "tanggal" => 'required|min:1'
        ]);

        

        Tpemasukan::create([
            'nama_pemasukan' => $request->nama_pemasukan,
            'nominal' => $request->nominal,
            'tanggal' => $request->tanggal,
            'validasi' => 'Belum Valid'
            //'image_ktp' => $image_ktp->hashName(),
            //'image_kk' => $image_kk->hashName(),
            //'image_sk' => $image_sk->hashName()
        ]);

        return redirect()->route('folder_pemasukan.page_pemasukan')->with(['success' => 'Data Berhasil Disimpan']);
    }

    // method untuk detail produk
    public function show(string $id): View
    {
        // ambil id produk
        $biodataku = Tpemasukan::findOrFail($id);
        // render view
        return view('folder_pemasukan.show', compact('biodataku'));
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

        


        $pemasukanku = Tpemasukan::findOrFail($id);
       
        return view('folder_pemasukan.edit', 
            compact('pemasukanku','namauserlogin','akunuserlogin','roleuserlogin'));
    }
    // method untuk ubah data di database
    public function update(Request $request, $id): RedirectResponse
    {
        // kode untuk validasi inputan
        $request->validate([
            "nama_pemasukan" => 'required|min:1',
            "nominal" => 'required|min:1',
            "tanggal" => 'required|min:1',
            "validasi" => 'required|min:1'
        ]);
        
       
         // get data by id produk
         $stokbarangku = Tpemasukan::findOrFail($id);
 
        
            $stokbarangku->update([
                'nama_pemasukan' => $request->nama_pemasukan,
                'nominal' => $request->nominal,
                'tanggal' => $request->tanggal,
                'validasi' => $request->validasi
            ]);

        return redirect()->route('folder_pemasukan.page_pemasukan')->with(['success' => 'Data Berhasil Diubah']);
    }

    // method hapus data
    public function destroy($id): RedirectResponse
    {

        // get data by id produk
        $stokbarangku = Tpemasukan::findOrFail($id);
        // hapus data produk
        $stokbarangku->delete();

        return redirect()->route('folder_pemasukan.page_pemasukan')->with(['success' => 'Data Berhasil Dihapus']);
    }
}
