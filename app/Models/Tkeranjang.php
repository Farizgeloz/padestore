<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tkeranjang extends Model
{
    use HasFactory;
    protected $table = 'tkeranjangs'; // optional kalau tabel kamu bukan plural otomatis

    protected $primaryKey = 'id_keranjang'; // 🟢 ini penting!

    public $incrementing = true; // kalau id_barang auto increment
    protected $keyType = 'int';  // atau 'string' kalau bukan integer

    protected $fillable = [
        'kode_order',
        'pelanggan',
        'produk_id',
        'qty',
        'tanggal'
    ];

    public function produk()
    {
        return $this->belongsTo(Tproduk::class, 'produk_id', 'id_produk');
    }

    public function pesanans()
    {
        return $this->hasMany(Tpesanan::class, 'order_id', 'id_order');
    }
}
