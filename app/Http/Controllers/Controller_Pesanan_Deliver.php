<?php

namespace App\Http\Controllers;

use App\Models\Tpesanan;
use App\Models\Torder;
use App\Models\Tkotak;
use App\Models\Tpelanggan;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class Controller_Pesanan_Deliver extends Controller
{
    // 

    

    public function index(): View
    {
        $namauserlogin = Auth::user()->name;
        $akunuserlogin = Auth::user()->akun;  
        $roleuserlogin = Auth::user()->role;
        $pesananku = Tpesanan::leftJoin('tpelanggans', 'tpesanans.pelanggan', '=', 'tpelanggans.id_pelanggan')
            ->leftJoin('tkotaks', 'tpesanans.kotak', '=', 'tkotaks.id_kotak')
            ->leftJoin('users', 'tpesanans.pengantar', '=', 'users.id')
            ->select('tpesanans.*', 'tpelanggans.nama_pelanggan','tkotaks.nomor_kotak','users.akun')
            ->whereNotIn('tpesanans.status', ['PickedUp','Selesai']) // ✅ benar
            ->orderBy('tpesanans.tanggal', 'DESC')
            ->orderBy('tpesanans.status', 'ASC')   // 🔹 urutan pertama
            ->paginate(10);
       
       
        return view('folder_pesanan_deliver.page_pesanan_deliver', 
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
                ->leftJoin('tkotaks', 'tpesanans.kotak', '=', 'tkotaks.id_kotak')
                ->leftJoin('users', 'tpesanans.pengantar', '=', 'users.id')
                ->select('tpesanans.*', 'tpelanggans.nama_pelanggan','tkotaks.nomor_kotak','users.akun')
                ->whereNotIn('tpesanans.status', ['PickedUp','Selesai']) // ✅ benar
                ->where(function ($query) use ($request) {
                    $query->where('tpesanans.status', 'like', '%' . $request->search . '%')
                        ->orWhere('tpesanans.jenis', 'like', '%' . $request->search . '%')
                        ->orWhere('tpelanggans.nama_pelanggan', 'like', '%' . $request->search . '%');// cari juga di nama pelanggan
                })
                ->orderBy('tpesanans.tanggal', 'DESC')
                ->orderBy('tpesanans.status', 'ASC')   // 🔹 urutan pertama
                ->paginate(10);
           
            
           
            return view('folder_pesanan_deliver.page_pesanan_deliver', 
                compact('pesananku','namauserlogin','akunuserlogin','roleuserlogin'));
        }
        else{
             $pesananku = Tpesanan::orderBy('id_order', 'DESC')->paginate(10);
            
             return view('folder_pesanan_deliver.page_pesanan_deliver', 
                compact('pesananku','namauserlogin','akunuserlogin','roleuserlogin'));
        }
       
        
       
    }

    // buat method create
    public function create(): View
    {
        
        $namauserlogin = Auth::user()->name;
        $akunuserlogin = Auth::user()->akun;  
        $roleuserlogin = Auth::user()->role;

        $pelangganku = Tpelanggan::select('id_pelanggan','nama_pelanggan')->orderBy('nama_pelanggan', 'ASC')->get();
        $kotakku = Tkotak::select('id_kotak','nomor_kotak','status')->orderBy('nomor_kotak', 'ASC')->get();
        $pengantarku = User::select('id','akun')->where('role', 'Driver')->orderBy('akun', 'ASC')->get();



        return view('folder_pesanan_deliver.create', 
            compact('namauserlogin','akunuserlogin','roleuserlogin','pelangganku','kotakku','pengantarku'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            //"pelanggan" => 'required|integer|exists:tpelanggans,id_pelanggan',
            "jenis" => 'required|string|min:1',
            "kotak" => 'required|array|min:1',
            "kotak.*" => 'integer|exists:tkotaks,id_kotak',
            "pengantar" => 'required|integer|min:1',
        ]);

        //$pelanggan = $request->pelanggan;
        $jenis = $request->jenis;
        $pengantar = $request->pengantar;
        $status = $request->status ?? 'Deliver';

        // ✅ Cek dulu status order pelanggan
        // ✅ Cek order pelanggan yang masih aktif
        /* $orderku = Torder::where('pelanggan', $pelanggan)
            ->where('status', 'Aktif')
            ->first();

        if (!$orderku) {
            return redirect()->back()->with('error', 'Tidak ada order aktif untuk pelanggan ini.');
        }

        // ✅ Jika sisa pesanan sudah habis, jangan lanjut
        if ($orderku->sisa_pesanan <= 0) {
            return redirect()->back()->with('error', 'Sisa Order Sudah Habis, tidak bisa menambah pesanan baru.');
        } */

        $jumlahDisimpan = 0;
        $jumlahDuplikat = 0;

        foreach ($request->kotak as $idKotak) {
            // ✅ Jika sisa pesanan sudah habis di tengah loop, hentikan simpan
            /* if ($orderku->sisa_pesanan - $jumlahDisimpan <= 0) {
                break;
            } */

            // ✅ Cek apakah kotak sudah digunakan pada pesanan aktif
            $sudahAda = Tpesanan::where('kotak', $idKotak)
                ->whereIn('status', ['Deliver', 'Dropsit'])
                ->exists();

            if ($sudahAda) {
                $jumlahDuplikat++;
                continue;
            }

            // ✅ Simpan hanya jika masih ada sisa pesanan
            Tpesanan::create([
                //'pelanggan' => $pelanggan,
                'jenis' => $jenis,
                'kotak' => $idKotak,
                'pengantar' => $pengantar,
                'status' => $status,
                'tanggal' => date('Y-m-d')
            ]);
            $updatekotakku = Tkotak::findOrFail($idKotak);
            $updatekotakku->update([
                'status' => 'Keluar'
            ]);

            $jumlahDisimpan++;
        }

        // ✅ Hitung ulang sisa pesanan setelah penyimpanan
        /* $sisaBaru = max(0, $orderku->sisa_pesanan - $jumlahDisimpan);
        $statusBaru = $sisaBaru === 0 ? 'Selesai' : $orderku->status;

        $orderku->update([
            'sisa_pesanan' => $sisaBaru,
            'status' => $statusBaru,
        ]); */

        // ✅ Buat pesan hasil
        if ($jumlahDisimpan === 0) {
            return redirect()->back()->with('error', 'Tidak ada pesanan yang disimpan karena kotak sudah terpakai atau sisa pesanan sudah habis.');
        }

        //$pesan = "Pesanan berhasil disimpan ($jumlahDisimpan kotak). Status order: $statusBaru";
        $pesan = "Pesanan berhasil disimpan ($jumlahDisimpan kotak).";
        if ($jumlahDuplikat > 0) {
            $pesan .= " $jumlahDuplikat kotak dilewati karena sudah digunakan.";
        }

        return redirect()->route('folder_pesanan_deliver.page_pesanan_deliver')
            ->with('success', $pesan); 
        /* return redirect()->route('folder_pesanan_deliver.page_pesanan_deliver')
            ->with('success', "Berhasil Disimpan"); */
    }






    // method untuk detail produk
    public function show(string $id): View
    {
        // ambil id produk
        $pesananku = Tpesanan::findOrFail($id);
        // render view
        return view('folder_pesanan_deliver.show', compact('pesananku'));
    }

    // buat method untuk view data yang mau diubah
    public function edit(string $id_pesanan): View
    {
        $namauserlogin = Auth::user()->name;
        $akunuserlogin = Auth::user()->akun;  
        $roleuserlogin = Auth::user()->role;
        $tingkatuserlogin = Auth::user()->tingkat;
        $kecamatanuserlogin = Auth::user()->kecamatan;
        $desauserlogin = Auth::user()->desa;
        $dusunuserlogin = Auth::user()->dusun;  

        $pelangganku = Tpelanggan::select('id_pelanggan','nama_pelanggan')->orderBy('nama_pelanggan', 'ASC')->get();


        $pesananku = Tpesanan::join('tpelanggans', 'tpesanans.pelanggan', '=', 'tpelanggans.id_pelanggan')
            ->join('tkotaks', 'tpesanans.kotak', '=', 'tkotaks.id_kotak')
            ->select('tpesanans.*', 'tpelanggans.nama_pelanggan', 'tkotaks.nomor_kotak')
            ->where('tpesanans.id_pesanan', $id_pesanan)
            ->firstOrFail();
        $kotakku = Tkotak::where('status', 'Ada')->orderBy('nomor_kotak','Asc')->get();
       
        return view('folder_pesanan_deliver.edit', 
            compact('pesananku','pelangganku','kotakku','namauserlogin','akunuserlogin','roleuserlogin',
            'tingkatuserlogin','kecamatanuserlogin','desauserlogin','dusunuserlogin'));
    }
    // method untuk ubah data di database
    public function update(Request $request, $id_pesanan): RedirectResponse
    {
        // kode untuk validasi inputan
        $request->validate([
            "pelanggan" => 'required|integer',
            "jenis" => 'required|string',
            "kotak" => 'required|integer',
            "status" => 'required|string'
        ]);

         // get data by id produk
         $pesananku = Tpesanan::findOrFail($id_pesanan);
            
        // ubah data sesuai inputan
        if ($request->status === "Deliver") {
            $pelanggan = null; // pelanggan dikosongkan jika status Deliver
            $tanggal = date('Y-m-d'); // tanggal diupdate ke hari ini
        } else {
            $pelanggan = $request->pelanggan;
            $tanggal = $pesananku->tanggal; // tetap gunakan tanggal lama
        }

        $pesananku->update([
            'pelanggan' => $pelanggan,
            'jenis' => $request->jenis,
            'kotak' => $request->kotak,
            'status' => $request->status,
            'tanggal' => $tanggal,
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
        return redirect()->route('folder_pesanan_deliver.page_pesanan_deliver')->with(['success' => 'Data Berhasil Diubah']);
    }

    // method hapus data
    public function destroy($id): RedirectResponse
    {

        // get data by id produk
        $pesananku = Tpesanan::findOrFail($id);
        // hapus data produk
        $pesananku->delete();

        return redirect()->route('folder_pesanan_deliver.page_pesanan_deliver')->with(['success' => 'Data Berhasil Dihapus']);
    }
}
