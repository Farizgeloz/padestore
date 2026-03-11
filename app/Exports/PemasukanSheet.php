<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Tpesanan;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;

class PemasukanSheet implements FromCollection, WithHeadings, WithTitle, ShouldAutoSize, WithColumnWidths, WithStyles
{
    protected $tanggal;

    public function __construct($tanggal = null)
    {
        $this->tanggal = $tanggal;
    }

    public function collection()
    {
        $query = Tpesanan::leftJoin('tpelanggans', 'tpesanans.pelanggan', '=', 'tpelanggans.id_pelanggan')
            ->select(
                'tpelanggans.nama_pelanggan',
                DB::raw('SUM(tpesanans.harga_akumulasi) as total_harga'),
                DB::raw('DATE(tpesanans.tanggal) as tanggal'),
                DB::raw('MAX(tpesanans.status) as status')
            )
            ->where('tpesanans.status', 'Selesai')
            ->groupBy(
                'tpelanggans.nama_pelanggan',
                DB::raw('DATE(tpesanans.tanggal)')
            )
            ->orderBy('tanggal', 'ASC');

        // ✅ Filter fleksibel (tahun / bulan / tanggal)
        if ($this->tanggal) {
            $parts = explode('-', $this->tanggal);

            if (count($parts) === 1) {
                $query->whereYear('tpesanans.tanggal', $parts[0]);
            } elseif (count($parts) === 2) {
                $query->whereYear('tpesanans.tanggal', $parts[0])
                      ->whereMonth('tpesanans.tanggal', $parts[1]);
            } elseif (count($parts) === 3) {
                $query->whereDate('tpesanans.tanggal', $this->tanggal);
            }
        }

        $data = $query->get();

        // ✅ Format tanggal dengan aman
        $data->transform(function ($row) {
            if ($row->tanggal) {
                $row->tanggal = Carbon::parse($row->tanggal)
                    ->translatedFormat('d F Y');
            }
            return $row;
        });

        // ✅ Hitung total keseluruhan
        $totalHarga = $data->sum('total_harga');

        // ✅ Tambahkan baris total (object agar konsisten)
        $data->push((object)[
            'nama_pelanggan' => 'TOTAL KESELURUHAN',
            'total_harga'    => $totalHarga,
            'tanggal'        => '',
            'status'         => '',
        ]);

        return $data;
    }

    public function headings(): array
    {
        return ['Pelanggan', 'Total Harga', 'Tanggal', 'Status'];
    }

    public function title(): string
    {
        return 'Pemasukan';
    }

    public function columnWidths(): array
    {
        return [
            'A' => 30,
            'B' => 18,
            'C' => 20,
            'D' => 15,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $highestRow = $sheet->getHighestRow();

        // ✅ Style Header
        $sheet->getStyle('A1:D1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF']
            ],
            'fill' => [
                'fillType' => 'solid',
                'startColor' => ['rgb' => '4CAF50']
            ],
            'alignment' => [
                'horizontal' => 'center',
                'vertical'   => 'center'
            ],
        ]);

        // ✅ Border semua cell
        $sheet->getStyle("A1:D{$highestRow}")
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN);

        // ✅ Format angka ribuan (kolom B = Total Harga)
        $sheet->getStyle("B2:B{$highestRow}")
            ->getNumberFormat()
            ->setFormatCode('#,##0');

        // ✅ Rata tengah kolom tertentu
        $sheet->getStyle("B2:B{$highestRow}")
            ->getAlignment()
            ->setHorizontal('center');

        $sheet->getStyle("C2:C{$highestRow}")
            ->getAlignment()
            ->setHorizontal('center');

        $sheet->getStyle("D2:D{$highestRow}")
            ->getAlignment()
            ->setHorizontal('center');

        // ✅ Style baris TOTAL
        $sheet->getStyle("A{$highestRow}:D{$highestRow}")
            ->applyFromArray([
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => 'solid',
                    'startColor' => ['rgb' => 'FFF2CC']
                ],
            ]);

        return [];
    }
}
