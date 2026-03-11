<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tproduk extends Model
{
    use HasFactory;

    protected $table = 'tproduks'; // optional kalau tabel kamu bukan plural otomatis

    protected $primaryKey = 'id_produk'; // 🟢 ini penting!

    public $incrementing = true; // kalau id_produk auto increment
    protected $keyType = 'int';  // atau 'string' kalau bukan integer

    protected $fillable = [
        'barcode',
        'nama_produk',
        //'stok_awal',
        //'produk_masuk',
        //'produk_keluar',
        'harga_retail',
        'sisa_stok',
        'gambar',
        'deskripsi',
        'status',
        'tanggal'
    ];

    public function orders()
    {
        return $this->hasMany(Torder::class, 'produk_id', 'id_produk');
    }

    public function pesanans()
    {
        return $this->hasMany(Tpesanan::class, 'produk', 'id_produk');
    }

    public function getHargaRupiahAttribute()
    {
        return 'Rp ' . number_format($this->harga_retail, 0, ',', '.');
    }

    /* public function getHargaAkumulasiRupiahAttribute()
    {
        return 'Rp ' . number_format($this->harga_akumulasi, 0, ',', '.');
    } */
}
