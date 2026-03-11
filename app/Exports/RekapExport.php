<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class RekapExport implements WithMultipleSheets
{
    protected $tanggal;

    public function __construct($tanggal)
    {
        $this->tanggal = $tanggal;
    }

    public function sheets(): array
    {
        return [
            new PemasukanSheet($this->tanggal),
            new PengeluaranSheet($this->tanggal),
            new LabaSheet($this->tanggal),
        ];
    }
}
