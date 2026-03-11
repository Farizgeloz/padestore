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
use Illuminate\Support\Facades\Log;

class Controller_KotakVerifikasi extends Controller
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
            ->whereIn('tpesanans.status', ['PickedUp']) // ✅ benar
            ->orderBy('tpesanans.updated_at', 'DESC')
            ->orderBy('tpesanans.status', 'ASC')   // 🔹 urutan pertama
            ->paginate(10);
       
       
        return view('folder_kotakverifikasi.page_kotakverifikasi', 
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
                ->whereIn('tpesanans.status', ['PickedUp']) // ✅ benar
                ->where(function ($query) use ($request) {
                    $query->where('tpesanans.jenis', 'like', '%' . $request->search . '%')
                        ->orWhere('tpelanggans.nama_pelanggan', 'like', '%' . $request->search . '%');// cari juga di nama pelanggan
                })
                ->orderBy('tpesanans.updated_at', 'DESC')
                ->orderBy('tpesanans.status', 'ASC')   // 🔹 urutan pertama
                ->paginate(10);
           
            
           
            return view('folder_kotakverifikasi.page_kotakverifikasi', 
                compact('pesananku','namauserlogin','akunuserlogin','roleuserlogin'));
        }
        else{
             $pesananku = Tpesanan::orderBy('id_order', 'DESC')->paginate(10);
            
             return view('folder_kotakverifikasi.page_kotakverifikasi', 
                compact('pesananku','namauserlogin','akunuserlogin','roleuserlogin'));
        }
       
        
       
    }

    // buat method create
    public function create(): View
    {
        $namauserlogin = Auth::user()->name;
        $akunuserlogin = Auth::user()->akun;  
        $roleuserlogin = Auth::user()->role;

        $userku = User::select('wilayah','id')
            ->where('akun', $akunuserlogin)
            ->firstOrFail();

        $pelangganku = Tpelanggan::select('id_pelanggan','nama_pelanggan')
            ->where('wilayah', $userku->wilayah)
            ->orderBy('nama_pelanggan', 'ASC')
            ->get();

        $pengantarku = User::select('id','akun')
            ->orderBy('akun', 'ASC')
            ->get();
        $kotakku = collect([]);

        return view('folder_kotakverifikasi.create', compact(
            'namauserlogin','akunuserlogin','roleuserlogin','pelangganku','pengantarku','kotakku'
        ));
    }

    public function getKotakByPelanggan($id)
    {
        $namauserlogin = Auth::user()->name;
        $akunuserlogin = Auth::user()->akun;  
        $roleuserlogin = Auth::user()->role;
        $userku = User::select('wilayah','id')
            ->where('akun', $akunuserlogin)
            ->firstOrFail();

        // Jika pelanggan dipilih (bukan kosong)
        if ($id != 'kosong') {
            $kotakku = Tpesanan::join('tkotaks', 'tpesanans.kotak', '=', 'tkotaks.id_kotak')
                ->select('tpesanans.*', 'tkotaks.nomor_kotak')
                ->where('tpesanans.pengantar', $userku->id)
                ->where('tpesanans.pelanggan', $id)
                ->where('tpesanans.status', 'Dropsit')
                ->orderBy('tkotaks.nomor_kotak', 'ASC')
                ->get();
        } else {
            // Kalau pelanggan belum dipilih, tampilkan kotak tanpa pelanggan (NULL)
            $kotakku = Tpesanan::join('tkotaks', 'tpesanans.kotak', '=', 'tkotaks.id_kotak')
                ->select('tpesanans.*', 'tkotaks.nomor_kotak')
                ->whereNull('tpesanans.pelanggan')
                ->where('tpesanans.pengantar', $userku->id)
                ->where('tpesanans.status', 'Dropsit')
                ->orderBy('tkotaks.nomor_kotak', 'ASC')
                ->get();
        }

        return response()->json($kotakku);
    }




    public function storeku(Request $request): RedirectResponse
    {
        $request->validate([
            "pelanggan" => 'nullable|integer|exists:tpelanggans,id_pelanggan',
            //"jenis" => 'required|string|min:1',
            "kotak" => 'required|array|min:1',
            "kotak.*" => 'integer|exists:tkotaks,id_kotak',
            //"pengantar" => 'nullable|integer|min:1',
        ]);

        $pelanggan = $request->pelanggan;
        $jenis = $request->jenis;
        //$pengantar = $request->pengantar;
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
           

            // ✅ Cek apakah kotak sudah digunakan pada pesanan aktif
            $sudahAda = Tpesanan::where('kotak', $idKotak)
                ->where('status', 'PickedUp')
                ->exists();

            if ($sudahAda) {
                $jumlahDuplikat++;
                continue;
            }

            // ✅ Simpan hanya jika masih ada sisa pesanan
            $pesanan = Tpesanan::where('kotak', $idKotak)->first();
            //$kotak = Tkotak::where('id_kotak', $idKotak)->first();

            if ($pesanan) {
                $pesanan->update([
                    //'pelanggan' => $pelanggan,
                    //'jenis' => $jenis,
                    'status' => 'PickedUp',
                    //'pengantar' => $pengantar,
                ]);
                /* $kotak->update([
                    'status' => 'Keluar'
                ]); */
            } else {
                Log::warning('Kotak tidak ditemukan di tabel tpesanan', [
                    'kotak' => $idKotak
                ]);
            }


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

        $pesan = "Pesanan berhasil disimpan ($jumlahDisimpan kotak).";
        if ($jumlahDuplikat > 0) {
            $pesan .= " $jumlahDuplikat kotak dilewati karena sudah digunakan.";
        }

        /* return redirect()->route('folder_kotakverifikasi.page_kotakverifikasi')
            ->with('success', $pesan); */
        return redirect()->route('folder_kotakverifikasi.page_kotakverifikasi')
            ->with('success', "Berhasil Disimpan");
    }






    // method untuk detail produk
    public function show(string $id): View
    {
        // ambil id produk
        $pesananku = Tpesanan::findOrFail($id);
        // render view
        return view('folder_kotakverifikasi.show', compact('pesananku'));
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
       
        return view('folder_kotakverifikasi.edit', 
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
            'status' => $status
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
        return redirect()->route('folder_kotakverifikasi.page_kotakverifikasi')->with(['success' => 'Data Berhasil Diubah']);
    }

    public function updateMultiple(Request $request)
    {
        $ids = $request->input('selected_id', []);
        $status = $request->input('status_update');

        if (empty($ids) || !$status) {
            return back()->with('error', 'Pilih minimal satu pesanan dan status tujuan.');
        }

        // Update status pesanan
        Tpesanan::whereIn('id_pesanan', $ids)->update(['status' => $status]);

        // Jika status diubah menjadi "Selesai", update juga tabel kotak
        if ($status === "Selesai") {
            $kotakku = Tpesanan::whereIn('id_pesanan', $ids)
                ->pluck('kotak')   // ambil kolom kotak saja
                ->toArray();       // ubah ke array biasa

            if (!empty($kotakku)) {
                Tkotak::whereIn('id_kotak', $kotakku)->update(['status' => 'Ada']);
            }
        }else{
            $kotakku = Tpesanan::whereIn('id_pesanan', $ids)
                ->pluck('kotak')   // ambil kolom kotak saja
                ->toArray();       // ubah ke array biasa

            if (!empty($kotakku)) {
                Tkotak::whereIn('id_kotak', $kotakku)->update(['status' => 'Keluar']);
            }

        }

        return back()->with('success', 'Status pesanan berhasil diperbarui.');
    }


    // method hapus data
    public function destroy($id): RedirectResponse
    {

        // get data by id produk
        $pesananku = Tpesanan::findOrFail($id);
        // hapus data produk
        $pesananku->delete();

        return redirect()->route('folder_kotakverifikasi.page_kotakverifikasi')->with(['success' => 'Data Berhasil Dihapus']);
    }
}
