
@extends("layouts.app")
 
@section("content")
<div class="card mb-5 bg-body-tertiary">
    <div class="card-header  bg-white">
        <h4>Form Edit Stok Produk</h4>
    </div>
    <div class="card-body">
        @if ($roleuserlogin == "Super Admin" )
        <a href="/SuperAdmin/Stok" class="btn btn-info btn-l mb-3 text-white"><i class="fa fa-arrow-left"></i> Kembali</a>
        
        <form action="/SuperAdmin/Stok/Update/{{$stokku->id_produk}}" method="POST"  enctype="multipart/form-data" class="row border  border-2 border-success bg-success-subtle rounded p-2"
            enctype="multipart/form-data">
    
        @elseif ($roleuserlogin == "Admin" )
        <a href="/Admin/Stok" class="btn btn-info btn-l mb-3 text-white"><i class="fa fa-arrow-left"></i> Kembali</a>
        
        <form action="/Admin/Stok/Update/{{$stokku->id_produk}}" method="POST"  enctype="multipart/form-data" class="row border  border-2 border-success bg-success-subtle rounded p-2"
            enctype="multipart/form-data">
        @endif
        
            @csrf
            @method('PUT')

            <div class="col-md-3">
                <div class="row">
                    <div class="form-group mb-2  col-md-12">
                        <label class="font-weight-bold">Kode Produk</label>
                        <input type="text" class="form-control form-control-lg m-1 @error('kode_produk') is-invalid @enderror"  placeholder="Kode Produk"
                            name="kode_produk" value="{{ old('kode_produk', $stokku->kode_produk) }}" id="">
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
                            name="nama_produk" value="{{ old('nama_produk', $stokku->nama_produk) }}" id="">
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
                        <label class="font-weight-bold">Stok Awal</label>
                        <input type="number" class="form-control form-control-lg m-1 @error('stok_awal') is-invalid @enderror"  placeholder="Stok Awal"
                            name="stok_awal" value="{{ old('stok_awal', $stokku->stok_awal) }}" id="">
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
                            name="produk_masuk" value="{{ old('produk_masuk', $stokku->produk_masuk) }}" id="">
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
                            name="produk_keluar" value="{{ old('produk_keluar', $stokku->produk_keluar) }}" id="">
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
                            name="sisa_stok" value="{{ old('sisa_stok', $stokku->sisa_stok) }}" id="">
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
                            name="nilai_akhir" value="{{ old('nilai_akhir', $stokku->nilai_akhir) }}" id="">
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
                        <label class="font-weight-bold">Tanggal</label>
                        <input type="date" class="form-control form-control-lg m-1 @error('tanggal') is-invalid @enderror"  placeholder="Tanggal"
                            name="tanggal" value="{{ old('tanggal', $stokku->tanggal) }}" id="">
                        <!-- tampilkan pesan error -->
                        @error('tanggal')
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
                        <label class="font-weight-bold">Status</label>
                        <select class="form-select form-select-lg m-1 @error('status') is-invalid @enderror" aria-label="Small select example"  name="status" id="">
                            <option  value="{{ old('status', $stokku->status) }}">{{ old('status', $stokku->status) }}</option>
                            
                                <option value="Ada">Ada</option>
                                <option value="Habis">Habis</option>
                           
                           
                        </select>
                        <!-- tampilkan pesan error -->
                        @error('status')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                </div>
            </div>
            
            <div class="col-md-12 d-flex flex-row-reverse">
                <button type="submit" class="btn btn-l btn-success me-3 mt-3">Update</button>
                <button type="reset" class="btn btn-l btn-secondary me-3 mt-3">Reset</button>
             </div>
        </form>
    </div>
</div>
@endsection