<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tbarang extends Model
{
    use HasFactory;

    protected $table = 'tbarangs'; // optional kalau tabel kamu bukan plural otomatis

    protected $primaryKey = 'id_barang'; // 🟢 ini penting!

    public $incrementing = true; // kalau id_barang auto increment
    protected $keyType = 'int';  // atau 'string' kalau bukan integer

    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'stok_awal',
        'barang_masuk',
        'barang_keluar',
        'sisa_stok',
        'nilai_akhir',
        'tanggal',
        'status'
    ];
}
