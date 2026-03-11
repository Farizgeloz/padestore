<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tmetodebayar extends Model
{
    use HasFactory;

    protected $table = 'tmetodebayars'; // optional kalau tabel kamu bukan plural otomatis

    protected $primaryKey = 'id_metode_bayar'; // 🟢 ini penting!

    public $incrementing = true; // kalau id_metode_bayar auto increment
    protected $keyType = 'int';  // atau 'string' kalau bukan integer

    protected $fillable = [
        'nama_metode_bayar'
    ];
}
