<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tpesanan;
use App\Models\Tpengeluaran;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class LabaPdfController extends Controller
{
    // ==========================
    // Fungsi helper filter tanggal
    // ==========================
    private function filterTanggal($query, $kolom='tanggal', $tanggal=null)
    {
        if (!$tanggal) return $query;

        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $tanggal)) {
            return $query->whereDate($kolom, $tanggal);
        }
        if (preg_match('/^\d{4}-\d{2}$/', $tanggal)) {
            [$tahun, $bulan] = explode('-', $tanggal);
            return $query->whereYear($kolom, $tahun)->whereMonth($kolom, $bulan);
        }
        if (preg_match('/^\d{4}$/', $tanggal)) {
            return $query->whereYear($kolom, $tanggal);
        }

        return $query;
    }

    // ==========================
    // Fungsi utama export PDF
    // ==========================
    public function export(Request $request)
    {
        $tanggal = $request->tanggal ?? null;

        // 🔹 Detect mode
        if ($tanggal && preg_match('/^\d{4}-\d{2}-\d{2}$/', $tanggal)) $mode = 'harian';
        elseif ($tanggal && preg_match('/^\d{4}-\d{2}$/', $tanggal)) $mode = 'bulanan';
        elseif ($tanggal && preg_match('/^\d{4}$/', $tanggal)) $mode = 'tahunan';
        else $mode = 'semua';

        // =======================
        // DATA PER HARI
        // =======================
        $harianPemasukan = $this->filterTanggal(
            DB::table('tpesanans as p')
                ->select(DB::raw('DATE(p.tanggal) as periode'),
                         DB::raw('SUM(p.harga_akumulasi) as total_pemasukan'),
                         DB::raw('0 as total_pengeluaran'))
                ->whereIn('p.status',['Selesai']),
            'p.tanggal',
            $tanggal
        )->groupBy(DB::raw('DATE(p.tanggal)'));

        $harianPengeluaran = $this->filterTanggal(
            DB::table('tpengeluarans as e')
                ->select(DB::raw('DATE(e.tanggal) as periode'),
                         DB::raw('0 as total_pemasukan'),
                         DB::raw('SUM(CASE WHEN e.validasi="Valid" THEN e.nominal ELSE 0 END) as total_pengeluaran')),
            'e.tanggal',
            $tanggal
        )->groupBy(DB::raw('DATE(e.tanggal)'));

        $harian = DB::query()
            ->fromSub($harianPemasukan->unionAll($harianPengeluaran), 'u')
            ->select('u.periode',
                     DB::raw('SUM(u.total_pemasukan) as total_pemasukan'),
                     DB::raw('SUM(u.total_pengeluaran) as total_pengeluaran'))
            ->groupBy('u.periode')
            ->orderBy('u.periode')
            ->get()
            ->map(fn($row) => [
                'periode' => Carbon::parse($row->periode)->translatedFormat('d F Y'),
                'total_pemasukan' => $row->total_pemasukan,
                'total_pengeluaran' => $row->total_pengeluaran,
                'laba' => $row->total_pemasukan - $row->total_pengeluaran,
            ]);

        // =======================
        // DATA PER BULAN
        // =======================
        $bulananPemasukan = $this->filterTanggal(
            DB::table('tpesanans as p')
                ->select(DB::raw('YEAR(p.tanggal) as tahun'),
                         DB::raw('MONTH(p.tanggal) as bulan'),
                         DB::raw('SUM(p.harga_akumulasi) as total_pemasukan'),
                         DB::raw('0 as total_pengeluaran'))
                ->whereIn('p.status',['Selesai']),
            'p.tanggal',
            $tanggal
        )->groupBy(DB::raw('YEAR(p.tanggal), MONTH(p.tanggal)'));

        $bulananPengeluaran = $this->filterTanggal(
            DB::table('tpengeluarans as e')
                ->select(DB::raw('YEAR(e.tanggal) as tahun'),
                         DB::raw('MONTH(e.tanggal) as bulan'),
                         DB::raw('0 as total_pemasukan'),
                         DB::raw('SUM(CASE WHEN e.validasi="Valid" THEN e.nominal ELSE 0 END) as total_pengeluaran')),
            'e.tanggal',
            $tanggal
        )->groupBy(DB::raw('YEAR(e.tanggal), MONTH(e.tanggal)'));

        $bulanan = DB::query()
            ->fromSub($bulananPemasukan->unionAll($bulananPengeluaran), 'u')
            ->select('u.tahun','u.bulan',
                     DB::raw('SUM(u.total_pemasukan) as total_pemasukan'),
                     DB::raw('SUM(u.total_pengeluaran) as total_pengeluaran'))
            ->groupBy('u.tahun','u.bulan')
            ->orderBy('u.tahun')
            ->orderBy('u.bulan')
            ->get()
            ->map(fn($row) => [
                'periode' => Carbon::create($row->tahun,$row->bulan,1)->translatedFormat('F Y'),
                'total_pemasukan' => $row->total_pemasukan,
                'total_pengeluaran' => $row->total_pengeluaran,
                'laba' => $row->total_pemasukan - $row->total_pengeluaran,
            ]);

        // =======================
        // DATA PER TAHUN
        // =======================
        $tahunanPemasukan = $this->filterTanggal(
            DB::table('tpesanans as p')
                ->select(DB::raw('YEAR(p.tanggal) as periode'),
                         DB::raw('SUM(p.harga_akumulasi) as total_pemasukan'),
                         DB::raw('0 as total_pengeluaran'))
                ->whereIn('p.status',['Selesai']),
            'p.tanggal',
            $tanggal
        )->groupBy(DB::raw('YEAR(p.tanggal)'));

        $tahunanPengeluaran = $this->filterTanggal(
            DB::table('tpengeluarans as e')
                ->select(DB::raw('YEAR(e.tanggal) as periode'),
                         DB::raw('0 as total_pemasukan'),
                         DB::raw('SUM(CASE WHEN e.validasi="Valid" THEN e.nominal ELSE 0 END) as total_pengeluaran')),
            'e.tanggal',
            $tanggal
        )->groupBy(DB::raw('YEAR(e.tanggal)'));

        $tahunan = DB::query()
            ->fromSub($tahunanPemasukan->unionAll($tahunanPengeluaran), 'u')
            ->select('u.periode',
                     DB::raw('SUM(u.total_pemasukan) as total_pemasukan'),
                     DB::raw('SUM(u.total_pengeluaran) as total_pengeluaran'))
            ->groupBy('u.periode')
            ->orderBy('u.periode')
            ->get()
            ->map(fn($row) => [
                'periode' => $row->periode,
                'total_pemasukan' => $row->total_pemasukan,
                'total_pengeluaran' => $row->total_pengeluaran,
                'laba' => $row->total_pemasukan - $row->total_pengeluaran,
            ]);

        // =======================
        // TOTAL KESELURUHAN
        // =======================
        $totalPemasukan = $this->filterTanggal(Tpesanan::whereIn('status',['Selesai']),'tanggal',$tanggal)->sum('harga_akumulasi');
        $totalPengeluaran = $this->filterTanggal(Tpengeluaran::where('validasi','Valid'),'tanggal',$tanggal)->sum('nominal');
        $totalLaba = $totalPemasukan - $totalPengeluaran;

        // 🔹 Judul PDF sesuai filter
        if ($mode=='harian') $judul = "Rekapitulasi Laba Per Hari" . ($tanggal ? " ({$tanggal})" : '');
        elseif ($mode=='bulanan') $judul = "Rekapitulasi Laba Per Bulan" . ($tanggal ? " ({$tanggal})" : '');
        elseif ($mode=='tahunan') $judul = "Rekapitulasi Laba Per Tahun" . ($tanggal ? " ({$tanggal})" : '');
        else $judul = "Rekapitulasi Laba Semua Periode";

        // 🔹 Generate PDF
        return Pdf::loadView('pdf.laba_full', [
            'judul' => $judul,
            'harian' => $harian,
            'bulanan' => $bulanan,
            'tahunan' => $tahunan,
            'totalPemasukan' => $totalPemasukan,
            'totalPengeluaran' => $totalPengeluaran,
            'totalLaba' => $totalLaba,
        ])->setPaper('a4', 'landscape')
          ->download('rekap_laba.pdf');
    }
}
