<?php

namespace App\Http\Controllers;

use App\Models\Tpesanan;
use App\Models\Torder;
use App\Models\Tkotak;
use App\Models\Tpelanggan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class Controller_Pesanan_Dropsit extends Controller
{
    // 

    

    public function index(): View
    {
        $namauserlogin = Auth::user()->name;
        $akunuserlogin = Auth::user()->akun;  
        $roleuserlogin = Auth::user()->role;
        $userku = User::select('wilayah','id')->where('akun', $akunuserlogin)->firstOrFail();
        $pesananku = Tpesanan::leftJoin('tpelanggans', 'tpesanans.pelanggan', '=', 'tpelanggans.id_pelanggan')
            ->leftJoin('tkotaks', 'tpesanans.kotak', '=', 'tkotaks.id_kotak')
            ->leftJoin('users', 'tpesanans.pengantar', '=', 'users.id')
            ->select('tpesanans.*', 'tpelanggans.nama_pelanggan as nama_pelanggan','tkotaks.nomor_kotak','users.akun')
            ->where('tpesanans.status', 'Deliver') // ✅ benar
            ->where('tpesanans.pengantar', $userku->id) // ✅ benar
            ->orderBy('tpesanans.tanggal', 'DESC')
            ->orderBy('tpesanans.status', 'ASC')   // 🔹 urutan pertama
            ->paginate(10);
       
       
        return view('folder_pesanan_dropsit.page_pesanan_dropsit', 
            compact('pesananku','namauserlogin','akunuserlogin','roleuserlogin'));
    }

    public function search(Request $request)
    {
        if (!empty($request)) {
            $search = $request->input('search');
            
            $namauserlogin = Auth::user()->name;
            $akunuserlogin = Auth::user()->akun;  
            $roleuserlogin = Auth::user()->role;   
            $userku = User::select('wilayah','id')->where('akun', $akunuserlogin)->firstOrFail();

            $pesananku = Tpesanan::leftJoin('tpelanggans', 'tpesanans.pelanggan', '=', 'tpelanggans.id_pelanggan')
                ->leftJoin('tkotaks', 'tpesanans.kotak', '=', 'tkotaks.id_kotak')
                ->leftJoin('users', 'tpesanans.pengantar', '=', 'users.id')
                ->select('tpesanans.*', 'tpelanggans.nama_pelanggan as nama_pelanggan','tkotaks.nomor_kotak','users.akun')
                ->where('tpesanans.status', 'Deliver') // ✅ benar
                ->where('tpesanans.pengantar', $userku->id) // ✅ benar
                ->where(function ($query) use ($request) {
                    $query->where('tpesanans.status', 'like', '%' . $request->search . '%')
                        ->orWhere('tpesanans.jenis', 'like', '%' . $request->search . '%')
                        ->orWhere('tpelanggans.nama_pelanggan', 'like', '%' . $request->search . '%');// cari juga di nama pelanggan
                        
                })
                ->orderBy('tpesanans.tanggal', 'DESC')
                ->orderBy('tpesanans.status', 'ASC')   // 🔹 urutan pertama
                ->paginate(10);
            
            
           
            return view('folder_pesanan_dropsit.page_pesanan_dropsit', 
                compact('pesananku','namauserlogin','akunuserlogin','roleuserlogin'));
        }
        else{
             $pesananku = Tpesanan::orderBy('id_order', 'DESC')->paginate(10);
            
             return view('folder_pesanan_dropsit.page_pesanan_dropsit', 
                compact('pesananku','namauserlogin','akunuserlogin','roleuserlogin'));
        }
       
        
       
    }

    // buat method create
    public function create(): View
    {
        
        $namauserlogin = Auth::user()->name;
        $akunuserlogin = Auth::user()->akun;  
        $roleuserlogin = Auth::user()->role;

        $userku = User::select('wilayah','id')->where('akun', $akunuserlogin)->firstOrFail();
        $pelangganku = Tpelanggan::select('id_pelanggan','nama_pelanggan')->where('wilayah', $userku->wilayah)->orderBy('nama_pelanggan', 'ASC')->get();
        $kotakku = Tpesanan::join('tkotaks', 'tpesanans.kotak', '=', 'tkotaks.id_kotak')
            ->select('tpesanans.*','tkotaks.nomor_kotak')
            ->whereNull('tpesanans.pelanggan') // ✅ hanya ambil yang kolom pelanggan masih kosong (NULL)
            ->where('tpesanans.pengantar', $userku->id)
            ->orderBy('tkotaks.nomor_kotak', 'ASC')
            ->get();
        $pengantarku = User::select('id','akun')
            //->where('akun', $akunuserlogin)
            ->orderBy('akun', 'ASC')->get();



        return view('folder_pesanan_dropsit.create', 
            compact('namauserlogin','akunuserlogin','roleuserlogin','pelangganku','kotakku','pengantarku'));
    }

    public function storeku(Request $request): RedirectResponse
    {
        $request->validate([
            "pelanggan" => 'nullable|integer|exists:tpelanggans,id_pelanggan',
            "kotak" => 'required|array|min:1',
            "kotak.*" => 'integer|exists:tkotaks,id_kotak',
        ]);

        $pelanggan = $request->pelanggan;
        $status = $request->status ?? 'Deliver';

        // ✅ Cek dulu status order pelanggan
        // ✅ Cek order pelanggan yang masih aktif
        $orderku = Torder::where('pelanggan', $pelanggan)
            ->join('thargas', 'torders.jenis_harga', '=', 'thargas.id_harga')
            ->where('status', 'Aktif')
            ->select('torders.*','thargas.nominal as harga', 'thargas.jenis_harga')
            ->first();
         

        if (!$orderku) {
            return redirect()->back()->with('error', 'Tidak ada order aktif untuk pelanggan ini.');
        }

        // ✅ Jika sisa pesanan sudah habis, jangan lanjut
        if ($orderku->sisa_pesanan <= 0) {
            return redirect()->back()->with('error', 'Sisa Order Sudah Habis, tidak bisa menambah pesanan baru.');
        }

        $jumlahDisimpan = 0;
        $jumlahDuplikat = 0;
        $idKotakBerhasil = []; // untuk menyimpan id kotak yang berhasil disimpan

        foreach ($request->kotak as $idKotak) {
            // ✅ Tambahkan log di sini
            Log::info('Menyimpan pesanan baru', [
                'pelanggan' => $pelanggan,
                'kotak' => $idKotak,
            ]);
            // ✅ Jika sisa pesanan sudah habis di tengah loop, hentikan simpan
            if ($orderku->sisa_pesanan - $jumlahDisimpan <= 0) {
                break;
            }

            // ✅ Cek apakah kotak sudah digunakan pada pesanan aktif
            $sudahAda = Tpesanan::where('kotak', $idKotak)
                ->where('status', 'Dropsit')
                ->exists();

            if ($sudahAda) {
                $jumlahDuplikat++;
                continue;
            }

            // ✅ Simpan hanya jika masih ada sisa pesanan
            $pesanan = Tpesanan::where('kotak', $idKotak)
                    ->whereNotIn('status', ['Selesai'])
                    ->first();
            //$kotak = Tkotak::where('id_kotak', $idKotak)->first();

            if ($pesanan) {
                $pesanan->update([
                    'pelanggan' => $pelanggan,
                    'harga_satuan' => $orderku->harga,
                    'status' => 'Dropsit',
                    'tanggal' => date('Y-m-d'),
                ]);

                
               $jumlahDisimpan++;
               $idKotakBerhasil[] = $idKotak;

            } else {
                Log::warning('Kotak tidak ditemukan di tabel tpesanan', [
                    'kotak' => $idKotak
                ]);
            }


            
        }

        // ✅ Hitung total harga akumulatif setelah semua loop selesai
        $hargaAkumulatif = $orderku->harga * $jumlahDisimpan;

        // ✅ Update semua tpesanan yang berhasil disimpan dengan total harga akumulatif
        if (!empty($idKotakBerhasil)) {
            Tpesanan::whereIn('kotak', $idKotakBerhasil)
                ->update(['harga_akumulasi' => $hargaAkumulatif]);
        }

        

        // ✅ Hitung ulang sisa pesanan setelah penyimpanan
        $sisaBaru = max(0, $orderku->sisa_pesanan - $jumlahDisimpan);
        $statusBaru = $sisaBaru === 0 ? 'Selesai' : $orderku->status;
        //$jumlah_bayar=$orderku->harga * $jumlahDisimpan;

        $orderku->update([
            'sisa_pesanan' => $sisaBaru,
            'status' => $statusBaru,
            //'jumlah_bayar' => $jumlah_bayar
        ]);

        // ✅ Buat pesan hasil
        if ($jumlahDisimpan === 0) {
            return redirect()->back()->with('error', 'Tidak ada pesanan yang disimpan karena kotak sudah terpakai atau sisa pesanan sudah habis.');
        }

        $pesan = "Pesanan berhasil disimpan ($jumlahDisimpan kotak). Status order: $statusBaru";
        if ($jumlahDuplikat > 0) {
            $pesan .= " $jumlahDuplikat kotak dilewati karena sudah digunakan.";
        }

        /* return redirect()->route('folder_pesanan_dropsit.page_pesanan_dropsit')
            ->with('success', $pesan); */
        return redirect()->route('folder_pesanan_dropsit.page_pesanan_dropsit')
            ->with('success', "Berhasil Disimpan");
    }






    // method untuk detail produk
    public function show(string $id): View
    {
        // ambil id produk
        $pesananku = Tpesanan::findOrFail($id);
        // render view
        return view('folder_pesanan_dropsit.show', compact('pesananku'));
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


        $pesananku = Tpesanan::join('tpelanggans', 'tpesanans.pelanggan', '=', 'tpelanggans.id_pelanggan')
            ->select('tpesanans.*', 'tpelanggans.nama_pelanggan')
            ->where('tpesanans.id_order', $id)
            ->firstOrFail();
       
        return view('folder_pesanan_dropsit.edit', 
            compact('pesananku','pelangganku','namauserlogin','akunuserlogin','roleuserlogin',
            'tingkatuserlogin','kecamatanuserlogin','desauserlogin','dusunuserlogin'));
    }
    // method untuk ubah data di database
    public function update(Request $request, $id): RedirectResponse
    {
        // kode untuk validasi inputan
        $request->validate([
            "pelanggan" => 'required|min:1',
            "nominal" => 'required|min:1',
            "jumlah_pesanan" => 'required|min:1',
            "sisa_pesanan" => 'required|min:1',
            "status" => 'required|min:1'
        ]);

         // get data by id produk
         $pesananku = Tpesanan::findOrFail($id);
            
        $status = $request->sisa_pesanan == 0 ? 'Selesai' : 'Aktif';
        // ubah data sesuai inputan
        $pesananku->update([
            'pelanggan' => $request->pelanggan,
            'nominal' => $request->nominal,
            'jumlah_pesanan' => $request->jumlah_pesanan,
            'sisa_pesanan' => $request->sisa_pesanan,
            'status' => $status,
            'tanggal' => date('Y-m-d'),
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
        return redirect()->route('folder_pesanan_dropsit.page_pesanan_dropsit')->with(['success' => 'Data Berhasil Diubah']);
    }

    // method hapus data
    public function destroy($id): RedirectResponse
    {

        // get data by id produk
        $pesananku = Tpesanan::findOrFail($id);
        // hapus data produk
        $pesananku->delete();

        return redirect()->route('folder_pesanan_dropsit.page_pesanan_dropsit')->with(['success' => 'Data Berhasil Dihapus']);
    }
}
