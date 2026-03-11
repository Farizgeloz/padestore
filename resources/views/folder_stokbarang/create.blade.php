@extends("layouts.app")
 
@section("content")
<div class="card mt-10 mb-5 bg-body-tertiary">
    <div class="card-header  bg-white">
        <h5>Form Tambah Stok Barang</h5>
    </div>
    <div class="card-body">
        @if ($roleuserlogin == "Super Admin" )
        <a href="/SuperAdmin/StokBarang" class="btn btn-info btn-l mb-2 text-light"><i class="fa fa-arrow-left"></i> Kembali</a>
    
        @elseif ($roleuserlogin == "Admin" )
        <a href="/Admin/StokBarang" class="btn btn-info btn-l mb-2 text-light"><i class="fa fa-arrow-left"></i> Kembali</a>
        @endif
       
 
        <form action="{{ route('folder_stokbarang.store') }}" method="post" enctype="multipart/form-data" class="row border  border-2 border-success bg-success-subtle rounded p-2">
            @csrf
            <div class="col-md-3">
                <div class="row">
                    <div class="form-group mb-2  col-md-12">
                        <label class="font-weight-bold">Kode Barang</label>
                        <input type="text" class="form-control form-control-lg m-1 @error('kode_barang') is-invalid @enderror"  placeholder="Kode Barang"
                            name="kode_barang" value="{{ old('kode_barang') }}" id="">
                        <!-- tampilkan pesan error -->
                        @error('kode_barang')
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
                        <label class="font-weight-bold">Nama Barang</label>
                        <input type="text" class="form-control form-control-lg m-1 @error('nama_barang') is-invalid @enderror"  placeholder="Nama Barang"
                            name="nama_barang" value="{{ old('nama_barang') }}" id="">
                        <!-- tampilkan pesan error -->
                        @error('nama_barang')
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
                        <label class="font-weight-bold">Barang Masuk</label>
                        <input type="number" class="form-control form-control-lg m-1 @error('barang_masuk') is-invalid @enderror"  placeholder="Barang Masuk"
                            name="barang_masuk" value="{{ old('barang_masuk') }}" id="">
                        <!-- tampilkan pesan error -->
                        @error('barang_masuk')
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
                        <label class="font-weight-bold">Barang Keluar</label>
                        <input type="number" class="form-control form-control-lg m-1 @error('barang_keluar') is-invalid @enderror"  placeholder="Barang Keluar"
                            name="barang_keluar" value="{{ old('barang_keluar') }}" id="">
                        <!-- tampilkan pesan error -->
                        @error('barang_keluar')
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