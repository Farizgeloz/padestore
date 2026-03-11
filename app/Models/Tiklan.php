<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tiklan extends Model
{
    use HasFactory;

    protected $table = 'tiklans'; // optional kalau tabel kamu bukan plural otomatis

    protected $primaryKey = 'id_iklan'; // 🟢 ini penting!

    public $incrementing = true; // kalau id_banner auto increment
    protected $keyType = 'int';  // atau 'string' kalau bukan integer

    protected $fillable = [
        'judul',
        'gambar',
        'tautan',
        'tanggal',
    ];

   

}
