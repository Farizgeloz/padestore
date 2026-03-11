<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tpemasukan extends Model
{
    use HasFactory;
    protected $table = 'tpemasukans'; // optional kalau tabel kamu bukan plural otomatis

    protected $primaryKey = 'id_pemasukan'; // 🟢 ini penting!

    public $incrementing = true; // kalau id_barang auto increment
    protected $keyType = 'int';  // atau 'string' kalau bukan integer

    protected $fillable = [
        
        'nama_pemasukan',
        'nominal',
        'tanggal',
        'validasi'
    ];
}
