<?php

namespace App\Http\Controllers;

use App\Models\Tharga;
use App\Models\Tkotak;
use App\Models\Torder;
use App\Models\Tpelanggan;
use App\Models\Tpesanan;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class Controller_PesananDeliver extends Controller
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
       
       
        return view('folder_pesanandeliver.page_pesanandeliver', 
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
           
            
           
            return view('folder_pesanandeliver.page_pesanandeliver', 
                compact('pesananku','namauserlogin','akunuserlogin','roleuserlogin'));
        }
        else{
             $pesananku = Tpesanan::orderBy('id_order', 'DESC')->paginate(10);
            
             return view('folder_pesanandeliver.page_pesanandeliver', 
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



        return view('folder_pesanandeliver.create', 
            compact('namauserlogin','akunuserlogin','roleuserlogin','pelangganku','kotakku','pengantarku'));
    }

    

    public function store(Request $request): RedirectResponse
    {
        // kode untuk validasi inputan
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

        return redirect()->route('folder_pesanandeliver.page_pesanandeliver')
            ->with('success', $pesan); 
        /* return redirect()->route('folder_pesanan_deliver.page_pesanan_deliver')
            ->with('success', "Berhasil Disimpan"); */
    }

    // method untuk detail produk
    public function show(string $id): View
    {
        // ambil id produk
        $orderku = Torder::findOrFail($id);
        // render view
        return view('folder_pesanandeliver.show', compact('orderku'));
    }

    // buat method untuk view data yang mau diubah
    public function edit(string $id): View
    {
        $namauserlogin = Auth::user()->name;
        $akunuserlogin = Auth::user()->akun;  
        $roleuserlogin = Auth::user()->role;

        $pelangganku = Tpelanggan::select('id_pelanggan','nama_pelanggan')->orderBy('nama_pelanggan', 'ASC')->get();


        $pesananku = Tpesanan::leftjoin('tpelanggans', 'tpesanans.pelanggan', '=', 'tpelanggans.id_pelanggan')
            ->leftjoin('tkotaks', 'tpesanans.kotak', '=', 'tkotaks.id_kotak')
            ->select('tpesanans.*', 'tpelanggans.nama_pelanggan', 'tkotaks.nomor_kotak')
            ->where('tpesanans.id_pesanan', $id)
            ->firstOrFail();
        $kotakku = Tkotak::orderBy('nomor_kotak','Asc')->get();
       
        return view('folder_pesanandeliver.edit', 
            compact('pesananku','pelangganku','kotakku','namauserlogin','akunuserlogin','roleuserlogin'));
    }
    // method untuk ubah data di database
    public function update(Request $request, $id): RedirectResponse
    {
        // kode untuk validasi inputan
        $request->validate([
            "pelanggan" => 'nullable|min:1',
            "jenis" => 'required|min:1',
            "kotak" => 'required|min:1',
            "status" => 'required|min:1'
        ]);

        $pelangganold=$request->pelangganold;
        $statusold=$request->statusold;
        $kotakold=$request->kotakold;

         // get data by id produk
         $pesananku = Tpesanan::findOrFail($id);
          // ubah data sesuai inputan
        if ($request->status === "Deliver") {
            $pelanggan = null; // pelanggan dikosongkan jika status Deliver
            $tanggal = date('Y-m-d'); // tanggal diupdate ke hari ini
            $orderku = Torder::where('pelanggan', $pelangganold)
                ->join('thargas', 'torders.jenis_harga', '=', 'thargas.id_harga')
                ->select('torders.*','thargas.nominal as harga', 'thargas.jenis_harga')
                ->first();
            if ($orderku) {
                $sisapesanan = $orderku->sisa_pesanan + 1;
                $orderku->update([
                    'sisa_pesanan' => $sisapesanan,
                    'status' => 'Aktif',
                    // 'jumlah_bayar' => $jumlah_bayar
                ]);
            }
        } else {
            $pelanggan = $request->pelanggan;
            $tanggal = $pesananku->tanggal; // tetap gunakan tanggal lama
            
            if($statusold==="Deliver"){
                $orderku = Torder::where('pelanggan', $pelanggan)
                    ->join('thargas', 'torders.jenis_harga', '=', 'thargas.id_harga')
                    ->select('torders.*','thargas.nominal as harga', 'thargas.jenis_harga')
                    ->first();
               
                if ($orderku) {
                    // ✅ Hitung ulang sisa pesanan setelah penyimpanan
                    $sisaBaru = max(0, $orderku->sisa_pesanan - 1);
                    $statusBaru = $sisaBaru === 0 ? 'Selesai' : $orderku->status;
                    //$jumlah_bayar=$orderku->harga * $jumlahDisimpan;

                    $orderku->update([
                        'sisa_pesanan' => $sisaBaru,
                        'status' => $statusBaru,
                        //'jumlah_bayar' => $jumlah_bayar
                    ]);
                }
            }
        }

        
        if($kotakold === $request->kotak){
            $kotakku = Tkotak::where('id_kotak', $request->kotak)
                ->first();
            $kotakku->update([
                'status' => 'Keluar',
                //'jumlah_bayar' => $jumlah_bayar
            ]);
        }else{
            $kotakku = Tkotak::where('id_kotak', $kotakold)
                ->first();
            $kotakku->update([
                'status' => 'Ada',
                //'jumlah_bayar' => $jumlah_bayar
            ]);
            $kotakku2 = Tkotak::where('id_kotak', $request->kotak)
                ->first();
            $kotakku2->update([
                'status' => 'Keluar',
                //'jumlah_bayar' => $jumlah_bayar
            ]);
        }

            
       // $status = $request->sisa_pesanan == 0 ? 'Selesai' : 'Aktif';
        // ubah data sesuai inputan
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
        return redirect()->route('folder_pesanandeliver.page_pesanandeliver')->with(['success' => 'Data Berhasil Diubah']);
    }

    // method hapus data
    public function destroy($id): RedirectResponse
    {

        // get data by id produk
        $orderku = Torder::findOrFail($id);
        // hapus data produk
        $orderku->delete();

        return redirect()->route('folder_pesanandeliver.page_pesanandeliver')->with(['success' => 'Data Berhasil Dihapus']);
    }
}
