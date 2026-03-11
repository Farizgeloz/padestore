<?php

namespace App\Exports;
use Carbon\Carbon;
use App\Models\Tpengeluaran;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PengeluaranSheet implements FromCollection, WithHeadings, WithTitle, ShouldAutoSize, WithColumnWidths, WithStyles
{
    protected $tanggal;

    public function __construct($tanggal = null)
    {
        $this->tanggal = $tanggal;
    }

    public function collection()
    {
        $query = Tpengeluaran::select('nama_pengeluaran', 'nominal', 'tanggal', 'validasi')
            ->where('validasi', 'Valid')
            ->orderBy('tanggal', 'ASC');

        // ✅ Filter fleksibel: tahun, bulan, tanggal
        if ($this->tanggal) {
            $parts = explode('-', $this->tanggal);
            if (count($parts) === 1) {
                $query->whereYear('tanggal', $parts[0]);
            } elseif (count($parts) === 2) {
                $query->whereYear('tanggal', $parts[0])
                    ->whereMonth('tanggal', $parts[1]);
            } elseif (count($parts) === 3) {
                $query->whereDate('tanggal', $this->tanggal);
            }
        }

        $data = $query->get();

        // ✅ Format kolom tanggal
        $data->transform(function ($row) {
            if ($row->tanggal) {
                $date = Carbon::parse($row->tanggal);
                if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $row->tanggal)) {
                    $row->tanggal = $date->translatedFormat('d F Y'); // tanggal lengkap
                } elseif (preg_match('/^\d{4}-\d{2}$/', $this->tanggal)) {
                    $row->tanggal = $date->translatedFormat('F Y'); // bulan & tahun
                } elseif (preg_match('/^\d{4}$/', $this->tanggal)) {
                    $row->tanggal = $date->translatedFormat('Y'); // tahun saja
                }
            }
            return $row;
        });

        // ✅ Hitung total nominal
        $total = $data->sum('nominal');

        // ✅ Tambahkan baris total di paling bawah
        $data->push([
            'nama_pengeluaran' => 'TOTAL KESELURUHAN',
            'nominal' => $total,
            'tanggal' => '',
            'validasi' => '',
        ]);

        return $data;
    }

    public function headings(): array
    {
        return ['Nama Pengeluaran', 'Nominal', 'Tanggal', 'Validasi'];
    }

    public function title(): string
    {
        return 'Pengeluaran';
    }

    public function columnWidths(): array
    {
        return [
            'A' => 40,
            'B' => 20,
            'C' => 18,
            'D' => 15,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $highestRow = $sheet->getHighestRow();

        // ✅ Style header
        $sheet->getStyle('A1:D1')->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => [
                'fillType' => 'solid',
                'startColor' => ['rgb' => '4CAF50'],
            ],
            'alignment' => ['horizontal' => 'center', 'vertical' => 'center'],
        ]);

        // ✅ Border semua sel
        $sheet->getStyle("A1:D{$highestRow}")
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        // ✅ Rata kanan untuk kolom nominal
        $sheet->getStyle("B2:B{$highestRow}")
            ->getAlignment()
            ->setHorizontal('right');

        // ✅ Format angka ribuan
        $sheet->getStyle("B2:B{$highestRow}")
            ->getNumberFormat()
            ->setFormatCode('#,##0');

        // ✅ Rata tengah tanggal & validasi
        $sheet->getStyle("C2:D{$highestRow}")
            ->getAlignment()
            ->setHorizontal('center');

        // ✅ Style baris total (tebal + background warna lembut)
        $sheet->getStyle("A{$highestRow}:D{$highestRow}")->applyFromArray([
            'font' => ['bold' => true],
            'fill' => [
                'fillType' => 'solid',
                'startColor' => ['rgb' => 'FFF2CC'], // kuning lembut
            ],
        ]);

        return [];
    }
}
