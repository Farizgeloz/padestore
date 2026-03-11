<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tbiolists', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lengkap');
            $table->bigInteger('ktp');
            $table->date('tgl_lahir');
            $table->string('tempat_lahir');
            $table->string('pekerjaan');
            $table->string('telpon');
            $table->string('lokasi');
            $table->string('divisi');
            $table->string('posisi');
            $table->string('kecamatan');
            $table->string('desa');
            $table->string('dusun');
            $table->text('deskripsi');
            $table->string('image');
            $table->string('image_ktp');
            $table->string('image_kk');
            $table->string('image_sk');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbiolists');
    }
};
