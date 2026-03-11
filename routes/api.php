<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DashboardApiController;
use App\Http\Controllers\Api\PelangganApiController;
use App\Http\Controllers\Api\ProdukApiController;
use App\Http\Controllers\Api\StokApiController;
use App\Http\Controllers\Api\OrderApiController;
use App\Http\Controllers\Api\KeranjangApiController;
use App\Http\Controllers\Api\PesananApiController;
use App\Http\Controllers\Api\LaporanApiController;
use App\Http\Controllers\Api\MetodeBayarApiController;
use App\Http\Controllers\Api\OtherApiController;
use App\Http\Controllers\Api\AuthController;

Route::prefix('v1')->group(function () {

    // 🔓 PUBLIC (tidak pakai sanctum)
    Route::post('/login', [AuthController::class, 'login']);
     Route::get('/dashboard/produk', [DashboardApiController::class, 'dashboardproduk']);
     Route::get('/dashboard/iklan', [DashboardApiController::class, 'dashboardiklan']);

    Route::get('/user/aktif', [PelangganApiController::class, 'indexuseraktif']);
    // 🔐 PROTECTED
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);

        Route::get('/pelanggan', [PelangganApiController::class, 'index']);
        Route::get('/pelanggan/paging', [PelangganApiController::class, 'indexPaging']);
        Route::get('/pelanggan/{id}', [PelangganApiController::class, 'show']);
        Route::post('/pelanggan', [PelangganApiController::class, 'store']);
        Route::put('/pelanggan/{id}', [PelangganApiController::class, 'update']);
        Route::delete('/pelanggan/{id}', [PelangganApiController::class, 'destroy']);
        
        Route::get('/produk', [ProdukApiController::class, 'index']);
         Route::get('/produk/paging', [ProdukApiController::class, 'indexPaging']);
        Route::get('/produk/{id}', [ProdukApiController::class, 'show']);
        Route::post('/produk', [ProdukApiController::class, 'store']);
        Route::put('/produk/{id}', [ProdukApiController::class, 'update']);
        Route::post('/produk/multipart', [ProdukApiController::class, 'storemultipart']);
        Route::post('/produk/multipart/{id}', [ProdukApiController::class, 'updatemultipart']);
        Route::delete('/produk/{id}', [ProdukApiController::class, 'destroy']);

        Route::get('/stok', [StokApiController::class, 'index']);
        Route::get('/stok/{id}', [StokApiController::class, 'show']);
        Route::post('/stok', [StokApiController::class, 'store']);
        Route::put('/stok/{id}', [StokApiController::class, 'update']);
        Route::delete('/stok/{id}', [StokApiController::class, 'destroy']);
        Route::get('stok/produk/{id}', [StokApiController::class, 'indexByProduk']);

        Route::get('/order', [OrderApiController::class, 'index']);
        Route::get('/order/paging', [OrderApiController::class, 'indexPaging']);
        Route::get('/order/aktif', [OrderApiController::class, 'indexaktif']);
        Route::get('/order/{id}', [OrderApiController::class, 'show']);
        Route::post('/order', [OrderApiController::class, 'store']);
        Route::post('/order/user', [OrderApiController::class, 'storeuser']);
        Route::put('/order/{id}', [OrderApiController::class, 'update']);
        Route::delete('/order/{id}', [OrderApiController::class, 'destroy']);

        Route::get('/keranjang', [KeranjangApiController::class, 'index']);
        Route::get('/keranjang/paging', [KeranjangApiController::class, 'indexPaging']);
        Route::get('/keranjang/aktif', [KeranjangApiController::class, 'indexaktif']);
        Route::get('/keranjang/{id}', [KeranjangApiController::class, 'show']);
        Route::post('/keranjang', [KeranjangApiController::class, 'storeuser']);
        Route::post('/order/checkout', [KeranjangApiController::class, 'store']);
        Route::put('/keranjang/{id}', [KeranjangApiController::class, 'update']);
        Route::delete('/keranjang/{id}', [KeranjangApiController::class, 'destroy']);


        Route::get('/pesanan', [PesananApiController::class, 'index']);
        Route::get('/pesanan/paging', [PesananApiController::class, 'indexPaging']);
        Route::get('/pesanan/paging/selesai', [PesananApiController::class, 'indexPagingSelesai']);
        Route::get('/pesanan/{id}', [PesananApiController::class, 'show']);
        Route::post('/pesanan', [PesananApiController::class, 'store']);
        Route::put('/pesanan/{id}', [PesananApiController::class, 'update']);
        Route::delete('/pesanan/{id}', [PesananApiController::class, 'destroy']);

        Route::get('/laporan', [LaporanApiController::class, 'index']);
        Route::get('/laporan/paging', [LaporanApiController::class, 'indexPaging']);
        Route::get('/laporan/{id}', [LaporanApiController::class, 'show']);
        Route::post('/laporan', [LaporanApiController::class, 'store']);
        Route::put('/laporan/{id}', [LaporanApiController::class, 'update']);
        Route::delete('/laporan/{id}', [LaporanApiController::class, 'destroy']);

        Route::get('/metodebayar', [MetodeBayarApiController::class, 'index']);
        Route::get('/metodebayar/{id}', [MetodeBayarApiController::class, 'show']);
        Route::post('/metodebayar', [MetodeBayarApiController::class, 'store']);
        Route::put('/metodebayar/{id}', [MetodeBayarApiController::class, 'update']);
        Route::delete('/metodebayar/{id}', [MetodeBayarApiController::class, 'destroy']);

        Route::get('/other/ringkasan-keuangan', [OtherApiController::class, 'ringkasanKeuangan']);
       

    });

});

