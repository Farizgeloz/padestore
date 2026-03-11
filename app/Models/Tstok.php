<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tstok extends Model
{
    use HasFactory;

    protected $table = 'tstoks'; // optional kalau tabel kamu bukan plural otomatis

    protected $primaryKey = 'id_stok'; // 🟢 ini penting!

    public $incrementing = true; // kalau id_produk auto increment
    protected $keyType = 'int';  // atau 'string' kalau bukan integer

    protected $fillable = [
        'produk_id',
        'tipe',
        'qty',
        'referensi',
        'keterangan',
        'admin',
        'tanggal',
    ];

    

    /* public function getHargaAkumulasiRupiahAttribute()
    {
        return 'Rp ' . number_format($this->harga_akumulasi, 0, ',', '.');
    } */
}
