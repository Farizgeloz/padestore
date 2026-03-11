<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tpendapatan extends Model
{
    use HasFactory;
    protected $table = 'tpendapatans'; // optional kalau tabel kamu bukan plural otomatis

    protected $primaryKey = 'id_pendapatan'; // 🟢 ini penting!

    public $incrementing = true; // kalau id_barang auto increment
    protected $keyType = 'int';  // atau 'string' kalau bukan integer

    protected $fillable = [
        
        'harga_satuan',
        'jumlah_kotak',
        'bahan_baku',
        'laba_kotor',
        'laba_bersih',
        'tanggal'
    ];
}
