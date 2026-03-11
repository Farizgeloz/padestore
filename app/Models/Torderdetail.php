<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Torderdetail extends Model
{
    use HasFactory;
    protected $table = 'torderdetails'; // optional kalau tabel kamu bukan plural otomatis

    protected $primaryKey = 'id_detail'; // 🟢 ini penting!

    public $incrementing = true; // kalau id_barang auto increment
    protected $keyType = 'int';  // atau 'string' kalau bukan integer

    protected $fillable = [
        'order_id',
        'produk_id',
        'jumlah',
        'keluar',
        'sisa'
    ];

    public function produk()
    {
        return $this->belongsTo(Tproduk::class, 'produk_id', 'id_produk');
    }

    
}
