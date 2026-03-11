@extends("layouts.app")
 
@section("content")
<div class="card mt-10 mb-5 bg-body-tertiary">
    <div class="card-header  bg-white">
        <h5>Form Tambah Stok Produk</h5>
    </div>
    <div class="card-body">
        @if ($roleuserlogin == "Super Admin" )
        <a href="/SuperAdmin/StokProduk" class="btn btn-info btn-l mb-2 text-light"><i class="fa fa-arrow-left"></i> Kembali</a>
    
        @elseif ($roleuserlogin == "Admin" )
        <a href="/Admin/StokProduk" class="btn btn-info btn-l mb-2 text-light"><i class="fa fa-arrow-left"></i> Kembali</a>
        @endif
       
 
        <form action="{{ route('folder_produk.store') }}" method="post" enctype="multipart/form-data" class="row border  border-2 border-success bg-success-subtle rounded p-2">
            @csrf
            <div class="col-md-3">
                <div class="row">
                    <div class="form-group mb-2  col-md-12">
                        <label class="font-weight-bold">Kode Produk</label>
                        <input type="text" class="form-control form-control-lg m-1 @error('kode_produk') is-invalid @enderror"  placeholder="Kode Produk"
                            name="kode_produk" value="{{ old('kode_produk') }}" id="">
                        <!-- tampilkan pesan error -->
                        @error('kode_produk')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="form-group mb-2  col-md-12">
                        <label class="font-weight-bold">Nama Produk</label>
                        <input type="text" class="form-control form-control-lg m-1 @error('nama_produk') is-invalid @enderror"  placeholder="Nama Produk"
                            name="nama_produk" value="{{ old('nama_produk') }}" id="">
                        <!-- tampilkan pesan error -->
                        @error('nama_produk')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    
                </div>
            </div>
            <div class="col-md-4">
                <div class="row">
                    <div class="form-group mb-2  col-md-12">
                        <label class="font-weight-bold">Stok awal</label>
                        <input type="number" class="form-control form-control-lg m-1 @error('stok_awal') is-invalid @enderror"  placeholder="Stok Awal"
                            name="stok_awal" value="{{ old('stok_awal') }}" id="">
                        <!-- tampilkan pesan error -->
                        @error('stok_awal')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    
                </div>
            </div>
            <div class="col-md-4">
                <div class="row">
                    <div class="form-group mb-2  col-md-12">
                        <label class="font-weight-bold">Produk Masuk</label>
                        <input type="number" class="form-control form-control-lg m-1 @error('produk_masuk') is-invalid @enderror"  placeholder="Produk Masuk"
                            name="produk_masuk" value="{{ old('produk_masuk') }}" id="">
                        <!-- tampilkan pesan error -->
                        @error('produk_masuk')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    
                </div>
            </div>
            <div class="col-md-4">
                <div class="row">
                    <div class="form-group mb-2  col-md-12">
                        <label class="font-weight-bold">Produk Keluar</label>
                        <input type="number" class="form-control form-control-lg m-1 @error('produk_keluar') is-invalid @enderror"  placeholder="Produk Keluar"
                            name="produk_keluar" value="{{ old('produk_keluar') }}" id="">
                        <!-- tampilkan pesan error -->
                        @error('produk_keluar')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    
                </div>
            </div>
            <div class="col-md-4">
                <div class="row">
                    <div class="form-group mb-2  col-md-12">
                        <label class="font-weight-bold">Sisa Stok</label>
                        <input type="number" class="form-control form-control-lg m-1 @error('sisa_stok') is-invalid @enderror"  placeholder="Sisa Stok"
                            name="sisa_stok" value="{{ old('sisa_stok') }}" id="">
                        <!-- tampilkan pesan error -->
                        @error('sisa_stok')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    
                </div>
            </div>
            <div class="col-md-4">
                <div class="row">
                    <div class="form-group mb-2  col-md-12">
                        <label class="font-weight-bold">Nilai Akhir</label>
                        <input type="number" class="form-control form-control-lg m-1 @error('nilai_akhir') is-invalid @enderror"  placeholder="Nilai Akhir"
                            name="nilai_akhir" value="{{ old('nilai_akhir') }}" id="">
                        <!-- tampilkan pesan error -->
                        @error('nilai_akhir')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    
                </div>
            </div>
            <div class="col-md-4">
                <div class="row">
                    <div class="form-group mb-2  col-md-12">
                        <label class="font-weight-bold">Tanggal Input</label>
                        <input type="date" class="form-control form-control-lg m-1 @error('tanggal') is-invalid @enderror"  placeholder="Tanggal Input"
                            name="tanggal" value="{{ old('tanggal') }}" id="">
                        <!-- tampilkan pesan error -->
                        @error('tanggal')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    
                </div>
            </div>
            
            
            
              
            <div class="col-md-12 d-flex flex-row-reverse">
             <button type="submit" class="btn btn-l btn-success me-3 mt-3">SIMPAN</button>
                <button type="reset" class="btn btn-l btn-secondary me-3 mt-3">CLEAR</button>
            </div>
            
           
        </form>
    </div>
</div>
@endsection