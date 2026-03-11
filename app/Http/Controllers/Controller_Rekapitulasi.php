<?php

namespace App\Http\Controllers;

use App\Models\Tpemasukan;
use App\Models\Tpesanan;
use App\Models\Tpelanggan;
use App\Models\Tharga;
use App\Models\Tpengeluaran;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Exports\PemasukanExport;
use App\Exports\RekapExport;
use App\Exports\downloadLabaPdf;
use Maatwebsite\Excel\Facades\Excel;

class Controller_Rekapitulasi extends Controller
{
    // 

    

    public function index(): View
{
    $namauserlogin = Auth::user()->name;
    $akunuserlogin = Auth::user()->akun;
    $roleuserlogin = Auth::user()->role;

    /*
    |--------------------------------------------------------------------------
    | SUBQUERY PEMASUKAN
    |--------------------------------------------------------------------------
    */
    $pemasukan = DB::table('tpesanans')
        ->selectRaw('DATE(tanggal) as tanggal, SUM(harga_akumulasi) as total_pemasukan')
        ->where('status', 'Selesai')
        ->groupByRaw('DATE(tanggal)');

    /*
    |--------------------------------------------------------------------------
    | SUBQUERY PENGELUARAN
    |--------------------------------------------------------------------------
    */
    $pengeluaran = DB::table('tpengeluarans')
        ->selectRaw('DATE(tanggal) as tanggal, SUM(nominal) as total_pengeluaran')
        ->where('validasi', 'Valid')
        ->groupByRaw('DATE(tanggal)');

    /*
    |--------------------------------------------------------------------------
    | AMBIL SEMUA TANGGAL UNIK (STABIL TANPA DUPLIKAT)
    |--------------------------------------------------------------------------
    */
    $semuaTanggal = DB::query()->fromSub(
        DB::table('tpesanans')
            ->selectRaw('DATE(tanggal) as tanggal')
            ->where('status', 'Selesai')
            ->union(
                DB::table('tpengeluarans')
                    ->selectRaw('DATE(tanggal) as tanggal')
                    ->where('validasi', 'Valid')
            ),
        'tanggal_union'
    );

    /*
    |--------------------------------------------------------------------------
    | REKAP HARIAN
    |--------------------------------------------------------------------------
    */
    $rekapitulasiku = DB::query()
        ->fromSub($semuaTanggal, 't')
        ->leftJoinSub($pemasukan, 'masuk', 't.tanggal', '=', 'masuk.tanggal')
        ->leftJoinSub($pengeluaran, 'keluar', 't.tanggal', '=', 'keluar.tanggal')
        ->selectRaw('
            t.tanggal,
            IFNULL(masuk.total_pemasukan,0) as total_pemasukan,
            IFNULL(keluar.total_pengeluaran,0) as total_pengeluaran,
            (IFNULL(masuk.total_pemasukan,0) - IFNULL(keluar.total_pengeluaran,0)) as laba_harian
        ')
        ->orderBy('t.tanggal', 'desc')
        ->paginate(10);

    /*
    |--------------------------------------------------------------------------
    | TOTAL KESELURUHAN (DIHITUNG LANGSUNG AGAR TIDAK SALAH)
    |--------------------------------------------------------------------------
    */
    $totalPemasukan = DB::table('tpesanans')
        ->where('status', 'Selesai')
        ->sum('harga_akumulasi');

    $totalPengeluaran = DB::table('tpengeluarans')
        ->where('validasi', 'Valid')
        ->sum('nominal');

    $totalKeseluruhan = (object)[
        'total_pemasukan'   => $totalPemasukan,
        'total_pengeluaran' => $totalPengeluaran,
        'total_laba'        => $totalPemasukan - $totalPengeluaran
    ];

    return view('folder_rekapitulasi.page_rekapitulasi', [
        'jenis_pencarian'   => '',
        'value_pencarian'   => '',
        'rekapitulasiku'    => $rekapitulasiku,
        'totalKeseluruhan'  => $totalKeseluruhan,
        'namauserlogin'     => $namauserlogin,
        'akunuserlogin'     => $akunuserlogin,
        'roleuserlogin'     => $roleuserlogin
    ]);
}





    public function search(Request $request): View
    {
        $namauserlogin = Auth::user()->name;
        $akunuserlogin = Auth::user()->akun;
        $roleuserlogin = Auth::user()->role;

        /*
        |--------------------------------------------------------------------------
        | SUBQUERY PEMASUKAN
        |--------------------------------------------------------------------------
        */
        $pemasukan = DB::table('tpesanans')
            ->selectRaw('DATE(tanggal) as tanggal, SUM(harga_akumulasi) as total_pemasukan')
            ->where('status', 'Selesai')
            ->groupByRaw('DATE(tanggal)');

        /*
        |--------------------------------------------------------------------------
        | SUBQUERY PENGELUARAN
        |--------------------------------------------------------------------------
        */
        $pengeluaran = DB::table('tpengeluarans')
            ->selectRaw('DATE(tanggal) as tanggal, SUM(nominal) as total_pengeluaran')
            ->where('validasi', 'Valid')
            ->groupByRaw('DATE(tanggal)');

        /*
        |--------------------------------------------------------------------------
        | AMBIL SEMUA TANGGAL UNIK (HANYA TANGGAL SAJA!)
        |--------------------------------------------------------------------------
        */
        $semuaTanggal = DB::query()->fromSub(
            DB::table('tpesanans')
                ->selectRaw('DATE(tanggal) as tanggal')
                ->where('status', 'Selesai')
                ->union(
                    DB::table('tpengeluarans')
                        ->selectRaw('DATE(tanggal) as tanggal')
                        ->where('validasi', 'Valid')
                ),
            'tanggal_union'
        );

        /*
        |--------------------------------------------------------------------------
        | REKAP QUERY
        |--------------------------------------------------------------------------
        */
        $rekapitulasiku = DB::query()
            ->fromSub($semuaTanggal, 't')
            ->leftJoinSub($pemasukan, 'masuk', 't.tanggal', '=', 'masuk.tanggal')
            ->leftJoinSub($pengeluaran, 'keluar', 't.tanggal', '=', 'keluar.tanggal')
            ->selectRaw('
                t.tanggal,
                IFNULL(masuk.total_pemasukan,0) as total_pemasukan,
                IFNULL(keluar.total_pengeluaran,0) as total_pengeluaran,
                (IFNULL(masuk.total_pemasukan,0) - IFNULL(keluar.total_pengeluaran,0)) as laba_harian
            ')
            ->orderBy('t.tanggal', 'desc');

        /*
        |--------------------------------------------------------------------------
        | FILTER SEARCH
        |--------------------------------------------------------------------------
        */
        if ($request->filled('search') && $request->filled('search_jenis')) {

            $search = $request->search;
            $jenis  = $request->search_jenis;

            if ($jenis === 'Harian') {
                $rekapitulasiku->whereDate('t.tanggal', $search);
            }

            elseif ($jenis === 'Bulanan') {
                $rekapitulasiku->whereRaw("DATE_FORMAT(t.tanggal, '%Y-%m') = ?", [$search]);
            }

            elseif ($jenis === 'Tahunan') {
                $rekapitulasiku->whereYear('t.tanggal', $search);
            }
        }

        $rekapitulasiku = $rekapitulasiku->paginate(10);

        /*
        |--------------------------------------------------------------------------
        | TOTAL KESELURUHAN (DIHITUNG TERPISAH AGAR AKURAT)
        |--------------------------------------------------------------------------
        */
        $totalPemasukan = DB::table('tpesanans')
            ->where('status', 'Selesai');

        $totalPengeluaran = DB::table('tpengeluarans')
            ->where('validasi', 'Valid');

        if ($request->filled('search') && $request->filled('search_jenis')) {

            $search = $request->search;
            $jenis  = $request->search_jenis;

            if ($jenis === 'Harian') {
                $totalPemasukan->whereDate('tanggal', $search);
                $totalPengeluaran->whereDate('tanggal', $search);
            }

            elseif ($jenis === 'Bulanan') {
                $totalPemasukan->whereRaw("DATE_FORMAT(tanggal, '%Y-%m') = ?", [$search]);
                $totalPengeluaran->whereRaw("DATE_FORMAT(tanggal, '%Y-%m') = ?", [$search]);
            }

            elseif ($jenis === 'Tahunan') {
                $totalPemasukan->whereYear('tanggal', $search);
                $totalPengeluaran->whereYear('tanggal', $search);
            }
        }

        $totalMasuk = $totalPemasukan->sum('harga_akumulasi');
        $totalKeluar = $totalPengeluaran->sum('nominal');

        $totalKeseluruhan = (object)[
            'total_pemasukan'   => $totalMasuk,
            'total_pengeluaran' => $totalKeluar,
            'total_laba'        => $totalMasuk - $totalKeluar
        ];

        $jenis_pencarian = $request->search_jenis;
        $value_pencarian = $request->search;

        return view('folder_rekapitulasi.page_rekapitulasi', compact(
            'jenis_pencarian',
            'value_pencarian',
            'rekapitulasiku',
            'totalKeseluruhan',
            'namauserlogin',
            'akunuserlogin',
            'roleuserlogin'
        ));
    }



    public function detail(string $id): View
    {
        $tanggal = $id;
        $namauserlogin = Auth::user()->name;
        $akunuserlogin = Auth::user()->akun;  
        $roleuserlogin = Auth::user()->role;

        // ===============================
        // 🔹 1. PEMASUKAN DETAIL (per pelanggan)
        // ===============================
        $pemasukanku = Tpesanan::leftJoin('tpelanggans', 'tpesanans.pelanggan', '=', 'tpelanggans.id_pelanggan')
            ->leftJoin('tproduks', 'tpesanans.produk', '=', 'tproduks.id_produk')
            ->select(
                'tpesanans.pelanggan',
                'tpelanggans.nama_pelanggan',
                'tproduks.nama_produk',
                DB::raw('SUM(tpesanans.harga_akumulasi) as total_harga'),
                DB::raw('MAX(tpesanans.tanggal) as tanggal'),
                DB::raw('MAX(tpesanans.status) as status')
            )
            ->whereIn('tpesanans.status', ['Selesai'])
            ->whereRaw("tpesanans.tanggal LIKE ?", ["%$id%"])
            ->groupBy('tpesanans.pelanggan', 'tpelanggans.nama_pelanggan', 'tproduks.nama_produk', DB::raw('DATE(tpesanans.tanggal)'))
            ->orderByDesc('tanggal')
            ->paginate(10);

        // ===============================
        // 🔹 2. PENGELUARAN DETAIL
        // ===============================
        $pengeluaranku = Tpengeluaran::orderBy('tanggal', 'DESC')
            ->where('validasi', 'Valid')
            ->whereRaw("tanggal LIKE ?", ["%$id%"])
            ->paginate(10);

        // ===============================
        // 🔹 3. SUBQUERY PEMASUKAN
        // ===============================
        $pemasukan = DB::table('tpesanans')
            ->select(
                DB::raw('DATE(tanggal) as tanggal'),
                DB::raw('SUM(harga_akumulasi) as total_pemasukan')
            )
            ->whereIn('status', ['Selesai'])
            ->groupBy(DB::raw('DATE(tanggal)'));

        // ===============================
        // 🔹 4. SUBQUERY PENGELUARAN
        // ===============================
        $pengeluaran = DB::table('tpengeluarans')
            ->select(
                DB::raw('DATE(tanggal) as tanggal'),
                DB::raw('SUM(nominal) as total_pengeluaran')
            )
            ->where('validasi', 'Valid')
            ->groupBy(DB::raw('DATE(tanggal)'));

        // ===============================
        // 🔹 5. FULL JOIN (tiruan)
        // ===============================
        $sql = "
            SELECT 
                COALESCE(masuk.tanggal, keluar.tanggal) AS tanggal,
                IFNULL(masuk.total_pemasukan, 0) AS total_pemasukan,
                IFNULL(keluar.total_pengeluaran, 0) AS total_pengeluaran
            FROM ({$pemasukan->toSql()}) AS masuk
            LEFT JOIN ({$pengeluaran->toSql()}) AS keluar 
                ON masuk.tanggal = keluar.tanggal

            UNION ALL

            SELECT 
                COALESCE(masuk.tanggal, keluar.tanggal) AS tanggal,
                IFNULL(masuk.total_pemasukan, 0) AS total_pemasukan,
                IFNULL(keluar.total_pengeluaran, 0) AS total_pengeluaran
            FROM ({$pengeluaran->toSql()}) AS keluar
            LEFT JOIN ({$pemasukan->toSql()}) AS masuk 
                ON masuk.tanggal = keluar.tanggal
            WHERE masuk.tanggal IS NULL
        ";

        // ===============================
        // 🔹 6. Hitung Total Keseluruhan
        // ===============================
        $bindings = array_merge(
            $pemasukan->getBindings(),
            $pengeluaran->getBindings(),
            $pengeluaran->getBindings(),
            $pemasukan->getBindings()
        );

        $totalKeseluruhan = DB::table(DB::raw("({$sql}) as full_data"))
            ->setBindings($bindings)
            ->whereRaw("tanggal LIKE ?", ["%$tanggal%"])
            //->whereIn('status', ['Selesai'])
            ->selectRaw('
                SUM(total_pemasukan) as total_pemasukan,
                SUM(total_pengeluaran) as total_pengeluaran,
                SUM(total_pemasukan - total_pengeluaran) as total_laba
            ')
            ->first();

        // ===============================
        // 🔹 7. RETURN VIEW
        // ===============================
        return view('folder_rekapitulasi.page_detail', [
            'pemasukanku' => $pemasukanku,
            'pengeluaranku' => $pengeluaranku,
            'totalKeseluruhan' => $totalKeseluruhan,
            'tanggal' => $tanggal,
            'namauserlogin' => $namauserlogin,
            'akunuserlogin' => $akunuserlogin,
            'roleuserlogin' => $roleuserlogin,
        ]);
    }



    public function exportPemasukan(string $id)
    {
        $pemasukanku = Tpesanan::leftJoin('tpelanggans', 'tpesanans.pelanggan', '=', 'tpelanggans.id_pelanggan')
        ->select(
            'tpesanans.pelanggan',
            'tpelanggans.nama_pelanggan',
            DB::raw('SUM(tpesanans.harga_akumulasi) as total_harga'),
            DB::raw('MAX(tpesanans.tanggal) as tanggal'),
            DB::raw('MAX(tpesanans.status) as status')
        )
        ->whereIn('tpesanans.status', ['Selesai'])
        ->whereRaw("tpesanans.tanggal LIKE ?", ["%$id%"])// cari juga di nama pelanggan
        ->groupBy('tpesanans.pelanggan', 'tpelanggans.nama_pelanggan', DB::raw('DATE(tpesanans.tanggal)'))
        ->orderByDesc('tanggal')
        ->paginate(10);
        return Excel::download(new PemasukanExport($pemasukanku), 'pemasukan.xlsx');
    }

    public function export(string $id)
    {
        return Excel::download(new RekapExport($id), 'Rekap_' . $id . '.xlsx');
    }

    public function downloadLabaPdf(string $id)
    {
        $labaController = new LabaPdfController();
        return $labaController->export(new \Illuminate\Http\Request(['tanggal' => $id]));
    }


    // buat method create
    public function create(): View
    {
        
        $namauserlogin = Auth::user()->name;
        $akunuserlogin = Auth::user()->akun;  
        $roleuserlogin = Auth::user()->role;
        



        return view('folder_rekapitulasi.create', 
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

        return redirect()->route('folder_rekapitulasi.page_rekapitulasi')->with(['success' => 'Data Berhasil Disimpan']);
    }

    // method untuk detail produk
    public function show(string $id): View
    {
        // ambil id produk
        $biodataku = Tpemasukan::findOrFail($id);
        // render view
        return view('folder_rekapitulasi.show', compact('biodataku'));
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

        


        $rekapitulasiku = Tpemasukan::findOrFail($id);
       
        return view('folder_rekapitulasi.edit', 
            compact('rekapitulasiku','namauserlogin','akunuserlogin','roleuserlogin'));
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

        return redirect()->route('folder_rekapitulasi.page_rekapitulasi')->with(['success' => 'Data Berhasil Diubah']);
    }

    // method hapus data
    public function destroy($id): RedirectResponse
    {

        // get data by id produk
        $stokbarangku = Tpemasukan::findOrFail($id);
        // hapus data produk
        $stokbarangku->delete();

        return redirect()->route('folder_rekapitulasi.page_rekapitulasi')->with(['success' => 'Data Berhasil Dihapus']);
    }
}
