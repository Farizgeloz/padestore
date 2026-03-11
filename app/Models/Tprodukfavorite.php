<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tprodukfavorite extends Model
{
    use HasFactory;

    protected $table = 'tprodukfavorites'; // optional kalau tabel kamu bukan plural otomatis

    protected $primaryKey = 'id_produk'; // 🟢 ini penting!

    public $incrementing = true; // kalau id_produk auto increment
    protected $keyType = 'int';  // atau 'string' kalau bukan integer

    protected $fillable = [
        'produk_id',
        'tanggal'
    ];

    
}
