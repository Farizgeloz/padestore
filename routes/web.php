<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\SesiController;
use App\Http\Controllers\Controller_Biolist;
use App\Http\Controllers\Controller_Dashboard;
use App\Http\Controllers\Controller_Kotak;
use App\Http\Controllers\Controller_Pelanggan;
use App\Http\Controllers\Controller_Stokbarang;
use App\Http\Controllers\Controller_Produk;
use App\Http\Controllers\Controller_Stok;
use App\Http\Controllers\Controller_Order;
use App\Http\Controllers\Controller_Pesanan;
use App\Http\Controllers\Controller_Pesanan_Deliver;
use App\Http\Controllers\Controller_Pesanan_Dropsit;
use App\Http\Controllers\Controller_KotakPengembalian;
use App\Http\Controllers\Controller_KotakVerifikasi;
use App\Http\Controllers\Controller_Pemasukan;
use App\Http\Controllers\Controller_Pengeluaran;
use App\Http\Controllers\Controller_Pesanan_Selesai;
use App\Http\Controllers\Controller_PesananDeliver;
use App\Http\Controllers\Controller_Rekapitulasi;
use App\Http\Controllers\Controller_User;
use App\Http\Controllers\LabaPdfController;
use Illuminate\Support\Facades\Route;

Route::get('/',[SesiController::class, 'index']);

Route::middleware(['guest'])->group(function(){
    
    Route::get('/Login',[SesiController::class, 'viewlogin'])->name('login');
    Route::post('/Login',[SesiController::class, 'login']);

});

Route::get('/home', [Controller_Dashboard::class, 'index'])
    ->name('folder_dashboard.page_dashboard');

Route::middleware(['auth'])->group(function(){
    Route::get('/admin', [AdminController::class, 'index']);
    Route::get('/admin/superadminku', [AdminController::class, 'ambilsuperadmin'])->middleware('UserAkses:Super Admin');
    Route::get('/admin/adminku', [AdminController::class, 'ambiladmin'])->middleware('UserAkses:Admin');
    Route::get('/admin/userku', [AdminController::class, 'ambiluser'])->middleware('UserAkses:User');

    

Route::get('/logout',[SesiController::class, 'logout']);

});

Route::middleware(['auth'])->group(function(){
    
    Route::middleware(['UserAkses:Super Admin'])->group(function(){
        Route::controller(Controller_Biolist::class)->group(function () {
            Route::get('/SuperAdmin/Biodata', 'index')->name('folder_biolist.page_biolist');
            Route::get('/SuperAdmin/Biodata/search', 'search')->name('search');
            Route::get('/SuperAdmin/Biodata/Tambah', 'create')->name('folder_biolist.create');
            Route::post('/SuperAdmin/Biodata', 'store')->name('folder_biolist.store');
            Route::get('/SuperAdmin/Biodata/{anggotalist}/Edit', 'edit')->name('folder_biolist.edit');
            Route::put('/SuperAdmin/Biodata/{anggotalist}/Update', 'update')->name('folder_biolist.update');
            Route::delete('/SuperAdmin/Biodata/{anggotalist}', 'destroy')->name('folder_biolist.destroy');

            
        });

        Route::controller(Controller_User::class)->group(function () {
            Route::get('/SuperAdmin/User', 'indexuser')->name('folder_user.page_user');
            Route::get('/SuperAdmin/User/Search', 'searchuser')->name('folder_user.search');
            Route::get('/SuperAdmin/User/Create', 'createuser')->name('folder_user.create');
            Route::post('/SuperAdmin/User/Create', 'storeuser')->name('folder_user.storeuser');
            Route::get('/SuperAdmin/User/{anggotalist}/Edit', 'edituser')->name('folder_user.edit');
            Route::put('/SuperAdmin/User/{anggotalist}/Update', 'updateuser')->name('folder_user.update');
            Route::delete('/SuperAdmin/User/{anggotalist}', 'destroyuser')->name('folder_user.destroy');
        });
       

        Route::controller(Controller_Pelanggan::class)->group(function () {
            Route::get('/SuperAdmin/Pelanggan', 'index')->name('folder_pelanggan.page_pelanggan');
            Route::get('/SuperAdmin/Pelanggan/Search', 'search')->name('folder_pelanggan.search');
            Route::get('/SuperAdmin/Pelanggan/Tambah', 'create')->name('folder_pelanggan.create');
            Route::post('/SuperAdmin/Pelanggan', 'store')->name('folder_pelanggan.store');
            Route::get('/SuperAdmin/Pelanggan/Edit/{anggotalist}', 'edit')->name('folder_pelanggan.edit');
            Route::put('/SuperAdmin/Pelanggan/Update/{anggotalist}', 'update')->name('folder_pelanggan.update');
            Route::delete('/SuperAdmin/Pelanggan/{anggotalist}', 'destroy')->name('folder_pelanggan.destroy');
        });

        Route::controller(Controller_Stokbarang::class)->group(function () {
            Route::get('/SuperAdmin/StokBarang', 'index')->name('folder_stokbarang.page_stokbarang');
            Route::get('/SuperAdmin/StokBarang/Search', 'search')->name('folder_stokbarang.search');
            Route::get('/SuperAdmin/StokBarang/Tambah', 'create')->name('folder_stokbarang.create');
            Route::post('/SuperAdmin/StokBarang', 'store')->name('folder_stokbarang.store');
            Route::get('/SuperAdmin/StokBarang/Edit/{anggotalist}', 'edit')->name('folder_stokbarang.edit');
            Route::put('/SuperAdmin/StokBarang/Update/{anggotalist}', 'update')->name('folder_stokbarang.update');
            Route::delete('/SuperAdmin/StokBarang/{anggotalist}', 'destroy')->name('folder_stokbarang.destroy');
        });

        Route::controller(Controller_Produk::class)->group(function () {
            Route::get('/SuperAdmin/Produk', 'index')->name('folder_produk.page_produk');
            Route::get('/SuperAdmin/Produk/Search', 'search')->name('folder_produk.search');
            Route::get('/SuperAdmin/Produk/Tambah', 'create')->name('folder_produk.create');
            Route::post('/SuperAdmin/Produk', 'store')->name('folder_produk.store');
            Route::get('/SuperAdmin/Produk/Edit/{anggotalist}', 'edit')->name('folder_produk.edit');
            Route::put('/SuperAdmin/Produk/Update/{anggotalist}', 'update')->name('folder_produk.update');
            Route::delete('/SuperAdmin/Produk/{anggotalist}', 'destroy')->name('folder_produk.destroy');
        });

        Route::controller(Controller_Stok::class)->group(function () {
            Route::get('/SuperAdmin/Stok', 'index')->name('folder_stok.page_stok');
            Route::get('/SuperAdmin/Stok/Search', 'search')->name('folder_stok.search');
            Route::get('/SuperAdmin/Stok/Tambah', 'create')->name('folder_stok.create');
            Route::post('/SuperAdmin/Stok', 'store')->name('folder_stok.store');
            Route::get('/SuperAdmin/Stok/Edit/{anggotalist}', 'edit')->name('folder_stok.edit');
            Route::put('/SuperAdmin/Stok/Update/{anggotalist}', 'update')->name('folder_stok.update');
            Route::delete('/SuperAdmin/Stok/{anggotalist}', 'destroy')->name('folder_stok.destroy');
        });

        Route::controller(Controller_Order::class)->group(function () {
            Route::get('/SuperAdmin/Order', 'index')->name('folder_order.page_order');
            Route::get('/SuperAdmin/Order/Search', 'search')->name('folder_order.search');
            Route::get('/SuperAdmin/Order/Tambah', 'create')->name('folder_order.create');
            Route::post('/SuperAdmin/Order', 'store')->name('folder_order.store');
            Route::get('/SuperAdmin/Order/Edit/{anggotalist}', 'edit')->name('folder_order.edit');
            Route::put('/SuperAdmin/Order/Update/{anggotalist}', 'update')->name('folder_order.update');
            Route::delete('/SuperAdmin/Order/{anggotalist}', 'destroy')->name('folder_order.destroy');
        });

        Route::controller(Controller_Pesanan::class)->group(function () {
            Route::get('/SuperAdmin/DropPesanan', 'index')->name('folder_pesanan.page_pesanan');
            Route::get('/SuperAdmin/DropPesanan/Search', 'search')->name('folder_pesanan.search');
            Route::get('/SuperAdmin/DropPesanan/Tambah', 'create')->name('folder_pesanan.create');
            Route::post('/SuperAdmin/DropPesanan', 'store')->name('folder_pesanan.store');
            Route::get('/SuperAdmin/DropPesanan/Edit/{anggotalist}', 'edit')->name('folder_pesanan.edit');
            Route::put('/SuperAdmin/DropPesanan/Update/{anggotalist}', 'update')->name('folder_pesanan.update');
            Route::delete('/SuperAdmin/DropPesanan/{anggotalist}', 'destroy')->name('folder_pesanan.destroy');
        });
         Route::controller(Controller_PesananDeliver::class)->group(function () {
            Route::get('/SuperAdmin/Pesanan/Deliver', 'index')->name('folder_pesanandeliver.page_pesanandeliver');
            Route::get('/SuperAdmin/Pesanan/Deliver/Search', 'search')->name('folder_pesanandeliver.search');
            Route::get('/SuperAdmin/Pesanan/Deliver/Tambah', 'create')->name('folder_pesanandeliver.create');
            Route::post('/SuperAdmin/Pesanan/Deliver', 'store')->name('folder_pesanandeliver.store');
            Route::get('/SuperAdmin/Pesanan/Deliver/Edit/{anggotalist}', 'edit')->name('folder_pesanandeliver.edit');
            Route::put('/SuperAdmin/Pesanan/Deliver/Update/{anggotalist}', 'update')->name('folder_pesanandeliver.update');
            Route::delete('/SuperAdmin/Pesanan/Deliver/{anggotalist}', 'destroy')->name('folder_pesanandeliver.destroy');
        });
        Route::controller(Controller_Pesanan_Deliver::class)->group(function () {
            Route::get('/SuperAdmin/Deliver', 'index')->name('folder_pesanan_deliver.page_pesanan_deliver');
            Route::get('/SuperAdmin/Deliver/Search', 'search')->name('folder_pesanan_deliver.search');
            Route::get('/SuperAdmin/Deliver/Tambah', 'create')->name('folder_pesanan_deliver.create');
            Route::post('/SuperAdmin/Deliver', 'store')->name('folder_pesanan_deliver.store');
            Route::get('/SuperAdmin/Deliver/Edit/{id_pesanan}', 'edit')->name('folder_pesanan_deliver.edit');
            Route::put('/SuperAdmin/Deliver/Update/{id_pesanan}', 'update')->name('folder_pesanan_deliver.update');
            Route::delete('/SuperAdmin/Deliver/{id_pesanan}', 'destroy')->name('folder_pesanan_deliver.destroy');
        });
        

        Route::controller(Controller_Pesanan_Selesai::class)->group(function () {
            Route::get('/SuperAdmin/Pesanan/Selesai', 'index')->name('folder_pesanan_selesai.page_pesanan_selesai');
            Route::get('/SuperAdmin/Pesanan/Selesai/Search', 'search')->name('folder_pesanan_selesai.search');
            Route::get('/SuperAdmin/Pesanan/Selesai/Tambah', 'create')->name('folder_pesanan_selesai.create');
            Route::post('/SuperAdmin/Pesanan/Selesai', 'store')->name('folder_pesanan_selesai.store');
            Route::get('/SuperAdmin/Pesanan/Selesai/Edit/{anggotalist}', 'edit')->name('folder_pesanan_selesai.edit');
            Route::put('/SuperAdmin/Pesanan/Selesai/Update/{anggotalist}', 'update')->name('folder_pesanan_selesai.update');
            Route::delete('/SuperAdmin/Pesanan/Selesai/{anggotalist}', 'destroy')->name('folder_pesanan_selesai.destroy');
            Route::put('/SuperAdmin/Pesanan/Selesai/Update-Multiple', 'updateMultiple')->name('folder_pesanan_selesai.update_multiple');
        });

        Route::controller(Controller_Pengeluaran::class)->group(function () {
            Route::get('/SuperAdmin/Pengeluaran', 'index')->name('folder_pengeluaran.page_pengeluaran');
            Route::get('/SuperAdmin/Pengeluaran/Search', 'search')->name('folder_pengeluaran.search');
            Route::get('/SuperAdmin/Pengeluaran/Tambah', 'create')->name('folder_pengeluaran.create');
            Route::post('/SuperAdmin/Pengeluaran', 'store')->name('folder_pengeluaran.store');
            Route::get('/SuperAdmin/Pengeluaran/Edit/{anggotalist}', 'edit')->name('folder_pengeluaran.edit');
            Route::put('/SuperAdmin/Pengeluaran/Update/{anggotalist}', 'update')->name('folder_pengeluaran.update');
            Route::delete('/SuperAdmin/Pengeluaran/{anggotalist}', 'destroy')->name('folder_pengeluaran.destroy');
        });
        Route::controller(Controller_Pemasukan::class)->group(function () {
            Route::get('/SuperAdmin/Pemasukan', 'index')->name('folder_pemasukan.page_pemasukan');
            Route::get('/SuperAdmin/Pemasukan/Search', 'search')->name('folder_pemasukan.search');
            Route::get('/SuperAdmin/Pemasukan/Tambah', 'create')->name('folder_pemasukan.create');
            Route::post('/SuperAdmin/Pemasukan', 'store')->name('folder_pemasukan.store');
            Route::get('/SuperAdmin/Pemasukan/Edit/{anggotalist}', 'edit')->name('folder_pemasukan.edit');
            Route::put('/SuperAdmin/Pemasukan/Update/{anggotalist}', 'update')->name('folder_pemasukan.update');
            Route::delete('/SuperAdmin/Pemasukan/{anggotalist}', 'destroy')->name('folder_pemasukan.destroy');
        });
        Route::controller(Controller_Rekapitulasi::class)->group(function () {
            Route::get('/SuperAdmin/Rekapitulasi', 'index')->name('folder_rekapitulasi.page_rekapitulasi');
            Route::get('/SuperAdmin/Rekapitulasi/Search', 'search')->name('folder_rekapitulasi.search');
            Route::get('/SuperAdmin/Rekapitulasi/Tambah', 'create')->name('folder_rekapitulasi.create');
            Route::post('/SuperAdmin/Rekapitulasi', 'store')->name('folder_rekapitulasi.store');
            Route::get('/SuperAdmin/Rekapitulasi/Edit/{anggotalist}', 'edit')->name('folder_rekapitulasi.edit');
            Route::put('/SuperAdmin/Rekapitulasi/Update/{anggotalist}', 'update')->name('folder_rekapitulasi.update');
            Route::delete('/SuperAdmin/Rekapitulasi/{anggotalist}', 'destroy')->name('folder_rekapitulasi.destroy');
            Route::get('/SuperAdmin/Rekapitulasi/Detail/{anggotalist}', 'detail')->name('folder_rekapitulasi.page_detail');
            Route::get('/SuperAdmin/Rekapitulasi/export-pemasukan/{anggotalist}', 'exportPemasukan')->name('folder_rekapitulasi.export-pemasukan');
            Route::get('/SuperAdmin/Rekapitulasi/export/{anggotalist}', 'export')->name('folder_rekapitulasi.export');
            Route::get('/SuperAdmin/Rekapitulasi/pdf/{anggotalist}', 'downloadLabaPdf')->name('folder_rekapitulasi.pdf');
            
        });
        
        
    });

    /* Route::middleware(['UserAkses:Admin'])->group(function(){
        Route::controller(Controller_Biolist::class)->group(function () {
            Route::get('/Admin/Biodata', 'index')->name('folder_biolist.page_biolist');
            Route::get('/Admin/Biodata/Search', 'search')->name('search');
            Route::get('/Admin/Biodata/Tambah', 'create')->name('folder_biolist.create');
            Route::post('/Admin/Biodata', 'store')->name('folder_biolist.store');
            Route::get('/Admin/Biodata/{anggotalist}/Edit', 'edit')->name('folder_biolist.edit');
            Route::put('/Admin/Biodata/{anggotalist}/Update', 'update')->name('folder_biolist.update');
            Route::delete('/Admin/Biodata/{anggotalist}', 'destroy')->name('folder_biolist.destroy');
        });

        Route::controller(Controller_User::class)->group(function () {
            Route::get('/Admin/User', 'indexuser')->name('folder_user.page_user');
            Route::get('/Admin/User/Search', 'searchuser')->name('folder_user.search');
            Route::get('/Admin/User/Create', 'createuser')->name('folder_user.create');
            Route::post('/Admin/User/Create', 'storeuser')->name('folder_user.storeuser');
            Route::get('/Admin/User/{anggotalist}/Edit', 'edituser')->name('folder_user.edit');
            Route::put('/Admin/User/{anggotalist}/Update', 'updateuser')->name('folder_user.update');
            Route::delete('/Admin/User/{anggotalist}', 'destroyuser')->name('folder_user.destroy');
        });
        
        
    }); */

   

   /*  Route::controller(Controller_Biolist::class)->group(function () {
        
        Route::get('/Biodata', 'index')->name('folder_biolist.page_biolist');
        Route::get('/Biodata/Search', 'search')->name('search');
        
        
    }); */

    Route::controller(Controller_Pesanan_Dropsit::class)->group(function () {
        Route::get('/Driver/Pesanan/Dropsit', 'index')->name('folder_pesanan_dropsit.page_pesanan_dropsit');
        Route::get('/Driver/Pesanan/Dropsit/Search', 'search')->name('folder_pesanan_dropsit.search');
        Route::get('/Driver/Pesanan/Dropsit/Tambah', 'create')->name('folder_pesanan_dropsit.create');
        Route::post('/Driver/Pesanan/Dropsit', 'storeku')->name('folder_pesanan_dropsit.storeku');
        Route::get('/Driver/Pesanan/Dropsit/Edit/{anggotalist}', 'edit')->name('folder_pesanan_dropsit.edit');
        Route::put('/Driver/Pesanan/Dropsit/Update/{anggotalist}', 'update')->name('folder_pesanan_dropsit.update');
        Route::delete('/Driver/Pesanan/Dropsit/{anggotalist}', 'destroy')->name('folder_pesanan_dropsit.destroy');
    });
    

    
    
    /*Route::middleware(['UserAkses:Admin'])->group(function(){
        Route::controller(Controller_Biolist::class)->group(function () {
            Route::get('/Biodata', 'index')->name('folder_biolist.page_biolist');
            Route::get('/Biodata/search', 'search')->name('search');
            Route::get('/Biodata/create', 'create')->name('folder_biolist.create');
            Route::post('/Biodata', 'store')->name('folder_biolist.store');
            Route::put('/Biodata/{anggotalist}', 'update')->name('folder_biolist.update');
            Route::delete('/Biodata/{anggotalist}', 'destroy')->name('folder_biolist.destroy');
        });
    });*/
    
    

});


