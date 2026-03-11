<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Torder extends Model
{
    use HasFactory;
    protected $table = 'torders'; // optional kalau tabel kamu bukan plural otomatis

    protected $primaryKey = 'id_order'; // 🟢 ini penting!

    public $incrementing = true; // kalau id_barang auto increment
    protected $keyType = 'int';  // atau 'string' kalau bukan integer

    protected $fillable = [
        'kode_order',
        'pelanggan',
        'metode_bayar',
        'jumlah_pesanan',
        'keluar_pesanan',
        'sisa_pesanan',
        'produk_id',
        'jumlah_bayar',
        'catatan',
        'status',
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

    public function details()
    {
        return $this->hasMany(TorderDetail::class,'order_id','id_order');
    }

    public function pelanggan()
    {
        return $this->belongsTo(Tpelanggan::class,'pelanggan','id_pelanggan');
    }
}
