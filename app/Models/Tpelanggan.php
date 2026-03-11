<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tpelanggan extends Model
{
    use HasFactory;
    protected $table = 'tpelanggans'; // optional kalau tabel kamu bukan plural otomatis

    protected $primaryKey = 'id_pelanggan'; // 🟢 ini penting!

    public $incrementing = true; // kalau id_barang auto increment
    protected $keyType = 'int';  // atau 'string' kalau bukan integer

    protected $fillable = [
        
        'nama_pelanggan',
        'alamat',
        'telpon',
        'wilayah'
    ];
}
