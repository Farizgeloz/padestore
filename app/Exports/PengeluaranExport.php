<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PengeluaranExport implements FromView
{
    protected $pengeluaranku;

    public function __construct($pengeluaranku)
    {
        $this->pengeluaranku = $pengeluaranku;
    }

    public function view(): View
    {
        return view('exports.pengeluaran', [
            'pengeluaranku' => $this->pengeluaranku
        ]);
    }
}
