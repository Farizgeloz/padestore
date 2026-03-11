
@extends("layouts.app")
 
@section("content")
<div class="card mb-5 bg-body-tertiary">
    <div class="card-header  bg-white">
        <h4>Form Edit Stok Barang</h4>
    </div>
    <div class="card-body">
        @if ($roleuserlogin == "Super Admin" )
        <a href="/SuperAdmin/StokBarang" class="btn btn-info btn-l mb-3 text-white"><i class="fa fa-arrow-left"></i> Kembali</a>
        
        <form action="/SuperAdmin/StokBarang/Update/{{$stokbarangku->id_barang}}" method="POST"  enctype="multipart/form-data" class="row border  border-2 border-success bg-success-subtle rounded p-2"
            enctype="multipart/form-data">
    
        @elseif ($roleuserlogin == "Admin" )
        <a href="/Admin/StokBarang" class="btn btn-info btn-l mb-3 text-white"><i class="fa fa-arrow-left"></i> Kembali</a>
        
        <form action="/Admin/StokBarang/Update/{{$stokbarangku->id_barang}}" method="POST"  enctype="multipart/form-data" class="row border  border-2 border-success bg-success-subtle rounded p-2"
            enctype="multipart/form-data">
        @endif
        
            @csrf
            @method('PUT')

            <div class="col-md-3">
                <div class="row">
                    <div class="form-group mb-2  col-md-12">
                        <label class="font-weight-bold">Kode Barang</label>
                        <input type="text" class="form-control form-control-lg m-1 @error('kode_barang') is-invalid @enderror"  placeholder="Kode Barang"
                            name="kode_barang" value="{{ old('kode_barang', $stokbarangku->kode_barang) }}" id="">
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
                            name="nama_barang" value="{{ old('nama_barang', $stokbarangku->nama_barang) }}" id="">
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
                        <label class="font-weight-bold">Stok Awal</label>
                        <input type="number" class="form-control form-control-lg m-1 @error('stok_awal') is-invalid @enderror"  placeholder="Stok Awal"
                            name="stok_awal" value="{{ old('stok_awal', $stokbarangku->stok_awal) }}" id="">
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
                            name="barang_masuk" value="{{ old('barang_masuk', $stokbarangku->barang_masuk) }}" id="">
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
                            name="barang_keluar" value="{{ old('barang_keluar', $stokbarangku->barang_keluar) }}" id="">
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
                            name="sisa_stok" value="{{ old('sisa_stok', $stokbarangku->sisa_stok) }}" id="">
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
                            name="nilai_akhir" value="{{ old('nilai_akhir', $stokbarangku->nilai_akhir) }}" id="">
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
                            name="tanggal" value="{{ old('tanggal', $stokbarangku->tanggal) }}" id="">
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
                            <option  value="{{ old('status', $stokbarangku->status) }}">{{ old('status', $stokbarangku->status) }}</option>
                            
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