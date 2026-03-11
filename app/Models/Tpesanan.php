<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tpesanan extends Model
{
    use HasFactory;
    protected $table = 'tpesanans'; // optional kalau tabel kamu bukan plural otomatis

    protected $primaryKey = 'id_pesanan'; // 🟢 ini penting!

    public $incrementing = true; // kalau id_barang auto increment
    protected $keyType = 'int';  // atau 'string' kalau bukan integer

    protected $fillable = [
        'pelanggan',
        'order_id',
        'kode_pesanan',
        'produk',
        'pengantar',
        'harga',
        'qty',
        'harga_akumulasi',
        'catatan',
        'status',
        'tanggal'
    ];

   /*  public function order()
    {
        return $this->belongsTo(Torder::class, 'order_id');
    } */

    public function order()
    {
        return $this->belongsTo(Torder::class, 'order_id', 'id_order');
    }

    public function getHargaRupiahAttribute()
    {
        return 'Rp ' . number_format($this->harga, 0, ',', '.');
    }

    public function getHargaAkumulasiRupiahAttribute()
    {
        return 'Rp ' . number_format($this->harga_akumulasi, 0, ',', '.');
    }
}
