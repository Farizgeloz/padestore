<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tharga extends Model
{
    use HasFactory;
    protected $table = 'thargas'; // optional kalau tabel kamu bukan plural otomatis

    protected $primaryKey = 'id_harga'; // 🟢 ini penting!

    public $incrementing = true; // kalau id_barang auto increment
    protected $keyType = 'int';  // atau 'string' kalau bukan integer

    protected $fillable = [
        
        'jenis_harga',
        'nominal'
    ];
}
