<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Tpesanan;
use App\Models\Tpengeluaran;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class LabaSheet implements FromCollection, WithHeadings, WithTitle, ShouldAutoSize, WithStyles, WithCustomStartCell
{
    protected $tanggal;
    protected $mode;

    public function __construct($tanggal = null)
    {
        $this->tanggal = $tanggal;
        $this->mode = $this->detectMode($tanggal);
    }

    private function detectMode($tanggal)
    {
        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $tanggal)) return 'harian';
        if (preg_match('/^\d{4}-\d{2}$/', $tanggal)) return 'bulanan';
        if (preg_match('/^\d{4}$/', $tanggal)) return 'tahunan';
        return 'semua';
    }

    private function filterTanggal($query, $kolom = 'tanggal')
    {
        if (!$this->tanggal) return $query;

        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $this->tanggal)) return $query->whereDate($kolom, $this->tanggal);
        if (preg_match('/^\d{4}-\d{2}$/', $this->tanggal)) {
            [$tahun, $bulan] = explode('-', $this->tanggal);
            return $query->whereYear($kolom, $tahun)->whereMonth($kolom, $bulan);
        }
        if (preg_match('/^\d{4}$/', $this->tanggal)) return $query->whereYear($kolom, $this->tanggal);

        return $query;
    }

    public function collection()
    {
        $dataGabung = collect();

        // ============================
        // DATA PER HARI
        // ============================
        $harianPemasukan = $this->filterTanggal(
            DB::table('tpesanans as p')
                ->select(
                    DB::raw('DATE(p.tanggal) as periode'),
                    DB::raw('SUM(p.harga_akumulasi) as total_pemasukan'),
                    DB::raw('0 as total_pengeluaran')
                )
                ->whereIn('p.status', ['Selesai']),
            'p.tanggal'
        )->groupBy(DB::raw('DATE(p.tanggal)'));

        $harianPengeluaran = $this->filterTanggal(
            DB::table('tpengeluarans as e')
                ->select(
                    DB::raw('DATE(e.tanggal) as periode'),
                    DB::raw('0 as total_pemasukan'),
                    DB::raw('SUM(CASE WHEN e.validasi="Valid" THEN e.nominal ELSE 0 END) as total_pengeluaran')
                ),
            'e.tanggal'
        )->groupBy(DB::raw('DATE(e.tanggal)'));

        $harian = DB::query()
            ->fromSub($harianPemasukan->unionAll($harianPengeluaran), 'u')
            ->select(
                'u.periode',
                DB::raw('SUM(u.total_pemasukan) as total_pemasukan'),
                DB::raw('SUM(u.total_pengeluaran) as total_pengeluaran')
            )
            ->groupBy('u.periode')
            ->orderBy('u.periode')
            ->get()
            ->map(fn($row) => [
                'Periode' => Carbon::parse($row->periode)->translatedFormat('d F Y'),
                'Total Pemasukan' => $row->total_pemasukan,
                'Total Pengeluaran' => $row->total_pengeluaran,
                'Laba (Pemasukan - Pengeluaran)' => $row->total_pemasukan - $row->total_pengeluaran,
            ]);

        // ============================
        // DATA PER BULAN
        // ============================
        $bulananPemasukan = $this->filterTanggal(
            DB::table('tpesanans as p')
                ->select(
                    DB::raw('YEAR(p.tanggal) as tahun'),
                    DB::raw('MONTH(p.tanggal) as bulan'),
                    DB::raw('SUM(p.harga_akumulasi) as total_pemasukan'),
                    DB::raw('0 as total_pengeluaran')
                )
                ->whereIn('p.status', ['Selesai']),
            'p.tanggal'
        )->groupBy(DB::raw('YEAR(p.tanggal), MONTH(p.tanggal)'));

        $bulananPengeluaran = $this->filterTanggal(
            DB::table('tpengeluarans as e')
                ->select(
                    DB::raw('YEAR(e.tanggal) as tahun'),
                    DB::raw('MONTH(e.tanggal) as bulan'),
                    DB::raw('0 as total_pemasukan'),
                    DB::raw('SUM(CASE WHEN e.validasi="Valid" THEN e.nominal ELSE 0 END) as total_pengeluaran')
                ),
            'e.tanggal'
        )->groupBy(DB::raw('YEAR(e.tanggal), MONTH(e.tanggal)'));

        $bulanan = DB::query()
            ->fromSub($bulananPemasukan->unionAll($bulananPengeluaran), 'u')
            ->select(
                'u.tahun','u.bulan',
                DB::raw('SUM(u.total_pemasukan) as total_pemasukan'),
                DB::raw('SUM(u.total_pengeluaran) as total_pengeluaran')
            )
            ->groupBy('u.tahun','u.bulan')
            ->orderBy('u.tahun')
            ->orderBy('u.bulan')
            ->get()
            ->map(fn($row) => [
                'Periode'=>Carbon::create($row->tahun,$row->bulan,1)->translatedFormat('F Y'),
                'Total Pemasukan'=>$row->total_pemasukan,
                'Total Pengeluaran'=>$row->total_pengeluaran,
                'Laba (Pemasukan - Pengeluaran)'=>$row->total_pemasukan-$row->total_pengeluaran,
            ]);

        // ============================
        // DATA PER TAHUN
        // ============================
        $tahunanPemasukan = $this->filterTanggal(
            DB::table('tpesanans as p')
                ->select(DB::raw('YEAR(p.tanggal) as periode'), DB::raw('SUM(p.harga_akumulasi) as total_pemasukan'), DB::raw('0 as total_pengeluaran'))
                ->whereIn('p.status',['Selesai']),
            'p.tanggal'
        )->groupBy(DB::raw('YEAR(p.tanggal)'));

        $tahunanPengeluaran = $this->filterTanggal(
            DB::table('tpengeluarans as e')
                ->select(DB::raw('YEAR(e.tanggal) as periode'), DB::raw('0 as total_pemasukan'), DB::raw('SUM(CASE WHEN e.validasi="Valid" THEN e.nominal ELSE 0 END) as total_pengeluaran')),
            'e.tanggal'
        )->groupBy(DB::raw('YEAR(e.tanggal)'));

        $tahunan = DB::query()
            ->fromSub($tahunanPemasukan->unionAll($tahunanPengeluaran),'u')
            ->select('u.periode', DB::raw('SUM(u.total_pemasukan) as total_pemasukan'), DB::raw('SUM(u.total_pengeluaran) as total_pengeluaran'))
            ->groupBy('u.periode')
            ->orderBy('u.periode')
            ->get()
            ->map(fn($row)=>[
                'Periode'=>$row->periode,
                'Total Pemasukan'=>$row->total_pemasukan,
                'Total Pengeluaran'=>$row->total_pengeluaran,
                'Laba (Pemasukan - Pengeluaran)'=>$row->total_pemasukan-$row->total_pengeluaran,
            ]);

        // ============================
        // TOTAL KESELURUHAN
        // ============================
        $totalPemasukan = $this->filterTanggal(Tpesanan::whereIn('status',['Selesai']),'tanggal')->sum('harga_akumulasi');
        $totalPengeluaran = $this->filterTanggal(Tpengeluaran::where('validasi','Valid'),'tanggal')->sum('nominal');
        $totalLaba = $totalPemasukan - $totalPengeluaran;

        // ============================
        // GABUNG DATA
        // ============================
        if(in_array($this->mode,['harian','bulanan','tahunan','semua'])){
            $dataGabung->push(['Periode'=>'--- PER HARI ---']);
            foreach($harian as $row) $dataGabung->push($row);
        }

        if(in_array($this->mode,['bulanan','tahunan','semua'])){
            $dataGabung->push(['Periode'=>'','Total Pemasukan'=>'','Total Pengeluaran'=>'','Laba (Pemasukan - Pengeluaran)'=>'']);
            $dataGabung->push(['Periode'=>'--- PER BULAN ---','Total Pemasukan'=>'','Total Pengeluaran'=>'','Laba (Pemasukan - Pengeluaran)'=>'']);
            foreach($bulanan as $row) $dataGabung->push($row);
        }

        if(in_array($this->mode,['tahunan','semua'])){
            $dataGabung->push(['Periode'=>'','Total Pemasukan'=>'','Total Pengeluaran'=>'','Laba (Pemasukan - Pengeluaran)'=>'']);
            $dataGabung->push(['Periode'=>'--- PER TAHUN ---','Total Pemasukan'=>'','Total Pengeluaran'=>'','Laba (Pemasukan - Pengeluaran)'=>'']);
            foreach($tahunan as $row) $dataGabung->push($row);
        }

        $dataGabung->push(['Periode'=>'','Total Pemasukan'=>'','Total Pengeluaran'=>'','Laba (Pemasukan - Pengeluaran)'=>'']);
        $dataGabung->push([
            'Periode'=>'TOTAL KESELURUHAN',
            'Total Pemasukan'=>$totalPemasukan,
            'Total Pengeluaran'=>$totalPengeluaran,
            'Laba (Pemasukan - Pengeluaran)'=>$totalLaba
        ]);

        return $dataGabung;
    }

    public function startCell(): string
    {
        return 'A2'; // header tabel mulai di baris 2
    }

    public function headings(): array
    {
        return ['Periode','Total Pemasukan','Total Pengeluaran','Laba (Pemasukan - Pengeluaran)'];
    }

    public function title(): string
    {
        return 'Laba';
    }

    public function styles(Worksheet $sheet)
    {
        $highestRow = $sheet->getHighestRow();

        // 🔹 Judul di baris 1
        $judul = "Rekapitulasi Data ";
        switch ($this->mode) {
            case 'harian': 
                $judul .= "Per Hari"; 
                if($this->tanggal) $judul .= " (" . Carbon::parse($this->tanggal)->translatedFormat('d F Y') . ")";
                break;
            case 'bulanan': 
                $judul .= "Per Bulan"; 
                if($this->tanggal) $judul .= " (" . Carbon::createFromFormat('Y-m',$this->tanggal)->translatedFormat('F Y') . ")";
                break;
            case 'tahunan': 
                $judul .= "Per Tahun"; 
                if($this->tanggal) $judul .= " (" . Carbon::createFromFormat('Y',$this->tanggal)->translatedFormat('Y') . ")";
                break;
            default: $judul .= "Semua Periode"; break;
        }

        $sheet->setCellValue('A1', $judul);
        $sheet->mergeCells('A1:D1');
        $sheet->getStyle('A1:D1')->applyFromArray([
            'font'=>['bold'=>true],
            'fill'=>['fillType'=>Fill::FILL_SOLID,'startColor'=>['rgb'=>'E6EE9C']],
            'alignment'=>['horizontal'=>'center','vertical'=>'center']
        ]);

        // Header tabel di baris 2
        $sheet->getStyle('A2:D2')->applyFromArray([
            'font'=>['bold'=>true,'color'=>['rgb'=>'FFFFFF']],
            'fill'=>['fillType'=>Fill::FILL_SOLID,'startColor'=>['rgb'=>'4CAF50']],
            'alignment'=>['horizontal'=>'center','vertical'=>'center']
        ]);

        // Baris PER HARI / BULAN / TAHUN / TOTAL warna berbeda
        for($row=3;$row<=$highestRow;$row++){
            $val = $sheet->getCell("A$row")->getValue();
            switch($val){
                case '--- PER HARI ---': $color='BBDEFB'; break;
                case '--- PER BULAN ---': $color='FFF9C4'; break;
                case '--- PER TAHUN ---': $color='FFE0B2'; break;
                case 'TOTAL KESELURUHAN': $color='C8E6C9'; break;
                default: $color=null;
            }
            if($color){
                $sheet->getStyle("A$row:D$row")->applyFromArray([
                    'fill'=>['fillType'=>Fill::FILL_SOLID,'startColor'=>['rgb'=>$color]],
                    'font'=>['bold'=>true],
                ]);
            }
        }

        return [];
    }
}
