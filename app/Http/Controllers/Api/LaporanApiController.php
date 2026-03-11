<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tpelanggan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanApiController extends Controller
{
    // ambil semua pelanggan
    public function index()
    {
        $pelanggan = Tpelanggan::orderBy('id_pelanggan', 'DESC')->get();

        return response()->json([
            'success' => true,
            'message' => 'Daftar Pelanggan',
            'data' => $pelanggan
        ]);
    }

    /*public function indexPaging(Request $request)
    {
        $search  = $request->search;
        $tanggal = $request->tanggal;  // bisa harian, bulanan, tahunan, atau range
        $periode = $request->periode;

        // ===== SUBQUERY PEMASUKAN =====
        $pemasukan = DB::table('tpesanans')
            ->selectRaw('DATE(tanggal) as tanggal')
            ->selectRaw('SUM(harga_akumulasi) as total_pemasukan')
            ->where('status', 'Selesai');

        // ===== SUBQUERY PENGELUARAN =====
        $pengeluaran = DB::table('tpengeluarans')
            ->selectRaw('DATE(tanggal) as tanggal')
            ->selectRaw('SUM(nominal) as total_pengeluaran')
            ->where('validasi', 'Valid');

        // ===== FILTER BERDASARKAN PERIODE =====
        if ($periode == 'Harian' && $tanggal) {
            $pemasukan->whereDate('tanggal', $tanggal);
            $pengeluaran->whereDate('tanggal', $tanggal);

        } elseif ($periode == 'Bulanan' && $tanggal) {
            [$bulan, $tahun] = explode('-', $tanggal);
            $pemasukan->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun);
            $pengeluaran->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun);

        } elseif ($periode == 'Tahunan' && $tanggal) {
            $tahun = $tanggal;
            $pemasukan->whereYear('tanggal', $tahun);
            $pengeluaran->whereYear('tanggal', $tahun);

        } elseif ($periode == 'Range Tanggal' && $tanggal) {
            [$start, $end] = explode(' s/d ', $tanggal);
            $pemasukan->whereBetween('tanggal', [$start, $end]);
            $pengeluaran->whereBetween('tanggal', [$start, $end]);
        }

        // ===== GROUP BY =====
        $pemasukan->groupBy(DB::raw('DATE(tanggal)'));
        $pengeluaran->groupBy(DB::raw('DATE(tanggal)'));

        // ===== UNION TANGGAL =====
        $tanggalUnion = DB::query()->fromSub(
            DB::table('tpesanans')
                ->selectRaw('DATE(tanggal) as tanggal')
                ->where('status', 'Selesai')
                ->when($periode == 'Harian' && $tanggal, function($q) use ($tanggal) {
                    $q->whereDate('tanggal', $tanggal);
                })
                ->when($periode == 'Bulanan' && $tanggal, function($q) use ($tanggal) {
                    [$bulan, $tahun] = explode('-', $tanggal);
                    $q->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun);
                })
                ->when($periode == 'Tahunan' && $tanggal, function($q) use ($tanggal) {
                    $q->whereYear('tanggal', $tanggal);
                })
                ->when($periode == 'Range Tanggal' && $tanggal, function($q) use ($tanggal) {
                    [$start, $end] = explode(' s/d ', $tanggal);
                    $q->whereBetween('tanggal', [$start, $end]);
                })
                ->union(
                    DB::table('tpengeluarans')
                        ->selectRaw('DATE(tanggal) as tanggal')
                        ->where('validasi', 'Valid')
                        ->when($periode == 'Harian' && $tanggal, function($q) use ($tanggal) {
                            $q->whereDate('tanggal', $tanggal);
                        })
                        ->when($periode == 'Bulanan' && $tanggal, function($q) use ($tanggal) {
                            [$bulan, $tahun] = explode('-', $tanggal);
                            $q->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun);
                        })
                        ->when($periode == 'Tahunan' && $tanggal, function($q) use ($tanggal) {
                            $q->whereYear('tanggal', $tanggal);
                        })
                        ->when($periode == 'Range Tanggal' && $tanggal, function($q) use ($tanggal) {
                            [$start, $end] = explode(' s/d ', $tanggal);
                            $q->whereBetween('tanggal', [$start, $end]);
                        })
                ),
            'tanggal_union'
        );
        // ===== REKAP =====
        $rekapitulasiku = DB::query()
            ->fromSub($tanggalUnion, 't')
            ->leftJoinSub($pemasukan, 'masuk', 't.tanggal', '=', 'masuk.tanggal')
            ->leftJoinSub($pengeluaran, 'keluar', 't.tanggal', '=', 'keluar.tanggal')
            ->selectRaw('
                t.tanggal,
                IFNULL(masuk.total_pemasukan,0) as total_pemasukan,
                IFNULL(keluar.total_pengeluaran,0) as total_pengeluaran,
                (IFNULL(masuk.total_pemasukan,0) - IFNULL(keluar.total_pengeluaran,0)) as laba_harian
            ')
            ->orderBy('t.tanggal', 'desc');

        if ($search) {
            $rekapitulasiku->where('t.tanggal', 'like', "%$search%");
        }

        return response()->json($rekapitulasiku->paginate(10));
    }*/

    private function applyPeriodeFilter($query, $periode, $tanggal)
    {
        if (!$tanggal) return $query;

        // ===== HARIAN =====
        if ($periode == 'Periode Harian') {
            return $query->whereDate('tanggal', $tanggal);
        }

        // ===== TAHUNAN =====
        if ($periode == 'Periode Tahunan') {
            return $query->whereYear('tanggal', $tanggal);
        }

        // ===== BULANAN (FORMAT: YYYY-MM) =====
        if ($periode == 'Periode Bulanan' && str_contains($tanggal, '-')) {

            $parts = explode('-', $tanggal);

            if (count($parts) === 2) {

                $tahun = $parts[0];
                $bulan = $parts[1];

                return $query->whereMonth('tanggal', $bulan)
                            ->whereYear('tanggal', $tahun);
            }
        }

        // ===== RANGE (FORMAT: start|end) =====
        if ($periode == 'Range Tanggal' && str_contains($tanggal, '|')) {

            $parts = explode('|', $tanggal);

            if (count($parts) === 2) {

                $start = $parts[0];
                $end   = $parts[1];

                return $query->whereBetween('tanggal', [$start, $end]);
            }
        }

        return $query;
    }
        
    public function indexPaging(Request $request)
    {
        $search  = $request->search;
        $tanggal = $request->tanggal;
        $periode = $request->periode;

        // ===== SUBQUERY PEMASUKAN =====
        $pemasukan = DB::table('tpesanans')
            ->selectRaw('DATE(tanggal) as tanggal')
            ->selectRaw('SUM(harga_akumulasi) as total_pemasukan')
            ->where('status', 'Selesai');

        // ===== SUBQUERY PENGELUARAN =====
        $pengeluaran = DB::table('tpengeluarans')
            ->selectRaw('DATE(tanggal) as tanggal')
            ->selectRaw('SUM(nominal) as total_pengeluaran')
            ->where('validasi', 'Valid');

        // Terapkan filter periode
        $pemasukan   = $this->applyPeriodeFilter($pemasukan, $periode, $tanggal);
        $pengeluaran = $this->applyPeriodeFilter($pengeluaran, $periode, $tanggal);

        // ===== GROUP BY =====
        $pemasukan->groupBy(DB::raw('DATE(tanggal)'));
        $pengeluaran->groupBy(DB::raw('DATE(tanggal)'));

        // ===== UNION TANGGAL =====
        $tanggalUnion = DB::query()->fromSub(
            DB::table('tpesanans')
                ->selectRaw('DATE(tanggal) as tanggal')
                ->where('status', 'Selesai')
                ->tap(fn($q) => $this->applyPeriodeFilter($q, $periode, $tanggal))
                ->union(
                    DB::table('tpengeluarans')
                        ->selectRaw('DATE(tanggal) as tanggal')
                        ->where('validasi', 'Valid')
                        ->tap(fn($q) => $this->applyPeriodeFilter($q, $periode, $tanggal))
                ),
            'tanggal_union'
        );

        // ===== REKAP =====
        $rekapitulasiku = DB::query()
            ->fromSub($tanggalUnion, 't')
            ->leftJoinSub($pemasukan, 'masuk', 't.tanggal', '=', 'masuk.tanggal')
            ->leftJoinSub($pengeluaran, 'keluar', 't.tanggal', '=', 'keluar.tanggal')
            ->selectRaw('
                t.tanggal,
                IFNULL(masuk.total_pemasukan,0) as total_pemasukan,
                IFNULL(keluar.total_pengeluaran,0) as total_pengeluaran,
                (IFNULL(masuk.total_pemasukan,0) - IFNULL(keluar.total_pengeluaran,0)) as laba_harian
            ')
            ->orderBy('t.tanggal', 'desc');

        if ($search) {
            $rekapitulasiku->where('t.tanggal', 'like', "%$search%");
        }

        $paginated = $rekapitulasiku->paginate(10);

        // ===== TOTAL NOMINAL =====
        $collection = $rekapitulasiku->get();

        $totalKeseluruhanPemasukan = $collection->sum('total_pemasukan');
        $totalKeseluruhanPengeluaran = $collection->sum('total_pengeluaran');

        // ===== TOTAL COUNT DATA =====
        $totalKeseluruhanDataPemasukan = $this->applyPeriodeFilter(
            DB::table('tpesanans')->where('status', 'Selesai'),
            $periode,
            $tanggal
        )->count();

        $totalKeseluruhanDataPengeluaran = $this->applyPeriodeFilter(
            DB::table('tpengeluarans')->where('validasi', 'Valid'),
            $periode,
            $tanggal
        )->count();

        $response = $paginated->toArray();

        $response['total_keseluruhan_pemasukan'] = $totalKeseluruhanPemasukan;
        $response['total_keseluruhan_pengeluaran'] = $totalKeseluruhanPengeluaran;
        $response['total_keseluruhan_data_pemasukan'] = $totalKeseluruhanDataPemasukan;
        $response['total_keseluruhan_data_pengeluaran'] = $totalKeseluruhanDataPengeluaran;
        $response['total_keseluruhan_laba'] =
            $totalKeseluruhanPemasukan - $totalKeseluruhanPengeluaran;

        return response()->json($response);
    }
        

    public function indexuseraktif()
    {
        $akun = User::leftJoin('tpelanggans', 'users.id', '=', 'tpelanggans.akun')
                ->select('users.*', 'tpelanggans.nama_pelanggan')
                ->where('users.status', 'Aktif')
                ->where('users.role', 'Pelanggan')
        ->orderBy('users.created_at', 'DESC')->get();

        return response()->json([
            'success' => true,
            'message' => 'Daftar Akun Aktif',
            'data' => $akun
        ]);
    }

    // detail pelanggan
    public function show($id)
    {
        $pelanggan = Tpelanggan::find($id);

        if (!$pelanggan) {
            return response()->json([
                'success' => false,
                'message' => 'Pelanggan tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $pelanggan
        ]);
    }

    // tambah produk
    public function store(Request $request)
    {
        $request->validate([
            "nama_pelanggan" => 'required',
            "alamat" => 'required',
            "telpon" => 'required'
        ]);

        DB::transaction(function() use ($request, &$pelanggan) {

            $data = [
                'nama_pelanggan' => $request->nama_pelanggan,
                'alamat'         => $request->alamat,
                'telpon'         => $request->telpon,
                'wilayah'        => $request->wilayah,
                'status'         => $request->status
            ];

            // ✅ Jika akun dikirim, tambahkan ke data
            if ($request->filled('akun')) {
                $data['akun'] = $request->akun;
            }

            $pelanggan = Tpelanggan::create($data);
        });

        return response()->json([
            'success' => true,
            'message' => 'Pelanggan berhasil ditambahkan',
            'data'    => $pelanggan
        ]);
    }

    // update pelanggan
    public function update(Request $request, $id)
    {
        $pelanggan = Tpelanggan::find($id);

        if (!$pelanggan) {
            return response()->json([
                'success' => false,
                'message' => 'Pelanggan tidak ditemukan'
            ], 404);
        }

        $request->validate([
            "nama_pelanggan" => 'required',
            "alamat" => 'required',
            "telpon" => 'required',
            "status" => 'required',
        ]);

        DB::transaction(function() use ($request, $pelanggan) {
            $pelanggan->update([
                'nama_pelanggan' => $request->nama_pelanggan,
                'akun' => $request->akun,
                'alamat' => $request->alamat,
                'telpon' => $request->telpon,
                'wilayah' => $request->wilayah,
                'status' => $request->status
            ]);
        });

        return response()->json([
            'success' => true,
            'message' => 'Pelanggan berhasil diupdate',
            'data' => $pelanggan
        ]);
    }

    // hapus pelanggan
    public function destroy($id)
    {
        $pelanggan = Tpelanggan::findOrFail($id);

        if (!$pelanggan) {
            return response()->json([
                'success' => false,
                'message' => 'Pelanggan tidak ditemukan'
            ], 404);
        }

        // Cek apakah pelanggan terkait dengan pesanan
        if ($pelanggan->pesanans()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Pelanggan tidak bisa dihapus karena ada pesanan terkait'
            ], 400);
        }

        DB::transaction(function() use ($pelanggan) {
            $pelanggan->delete();
        });

        return response()->json([
            'success' => true,
            'message' => 'Pelanggan berhasil dihapus'
        ]);
    }
}