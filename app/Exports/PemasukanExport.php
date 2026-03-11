<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PemasukanExport implements FromView
{
    protected $pemasukanku;

    public function __construct($pemasukanku)
    {
        $this->pemasukanku = $pemasukanku;
    }

    public function view(): View
    {
        return view('exports.pemasukan', [
            'pemasukanku' => $this->pemasukanku
        ]);
    }
}
