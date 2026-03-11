
@extends("layouts.app")
 
@section("content")
<div class="card mb-5 bg-body-tertiary">
    <div class="card-header  bg-white">
        <h4>Form Edit Stok Produk</h4>
    </div>
    <div class="card-body">
        @if ($roleuserlogin == "Super Admin" )
        <a href="/SuperAdmin/Produk" class="btn btn-info btn-l mb-3 text-white"><i class="fa fa-arrow-left"></i> Kembali</a>
        
        <form action="/SuperAdmin/Produk/Update/{{$produkku->id_produk}}" method="POST"  enctype="multipart/form-data" class="row border  border-2 border-success bg-success-subtle rounded p-2"
            enctype="multipart/form-data">
    
        @elseif ($roleuserlogin == "Admin" )
        <a href="/Admin/Produk" class="btn btn-info btn-l mb-3 text-white"><i class="fa fa-arrow-left"></i> Kembali</a>
        
        <form action="/Admin/Produk/Update/{{$produkku->id_produk}}" method="POST"  enctype="multipart/form-data" class="row border  border-2 border-success bg-success-subtle rounded p-2"
            enctype="multipart/form-data">
        @endif
        
            @csrf
            @method('PUT')

            <div class="col-md-3">
                <div class="row">
                    <div class="form-group mb-2  col-md-12">
                        <label class="font-weight-bold">Kode Produk</label>
                        <input type="text" class="form-control form-control-lg m-1 @error('barcode') is-invalid @enderror"  placeholder="Kode Produk"
                            name="barcode" value="{{ old('barcode', $produkku->barcode) }}" id="">
                        <!-- tampilkan pesan error -->
                        @error('barcode')
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
                        <input type="text" class="form-control form-control-lg m-1 @error('id_produk') is-invalid @enderror"  placeholder="id_produk"
                            name="id_produk" value="{{ old('id_produk', $produkku->id_produk) }}" id="">
                        <input type="text" class="form-control form-control-lg m-1 @error('nama_produk') is-invalid @enderror"  placeholder="Nama Produk"
                            name="nama_produk" value="{{ old('nama_produk', $produkku->nama_produk) }}" id="">
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
                            name="stok_awal" value="{{ old('stok_awal', $produkku->stok_awal) }}" id="">
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
                            name="produk_masuk" value="{{ old('produk_masuk', $produkku->produk_masuk) }}" id="">
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
                            name="produk_keluar" value="{{ old('produk_keluar', $produkku->produk_keluar) }}" id="">
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
                            name="sisa_stok" value="{{ old('sisa_stok', $produkku->sisa_stok) }}" id="">
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
                        <label class="font-weight-bold">Harga Retail</label>
                        <input type="number" class="form-control form-control-lg m-1 @error('harga_retail') is-invalid @enderror"  placeholder="Harga Retail"
                            name="harga_retail" value="{{ old('harga_retail', $produkku->harga_retail) }}" id="">
                        <!-- tampilkan pesan error -->
                        @error('harga_retail')
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
                            name="tanggal" value="{{ old('tanggal', $produkku->tanggal) }}" id="">
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
                            <option  value="{{ old('status', $produkku->status) }}">{{ old('status', $produkku->status) }}</option>
                            
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
            <div class="col-md-6">
                <div class="form-group mb-2">
                    <label class="font-weight-bold">Gambar Produk (Opsional)</label>

                    {{-- tampilkan gambar lama --}}
                    @if($produkku->gambar)
                        <div class="mb-2">
                            <img src="{{ asset('storage/produk/'.$produkku->gambar) }}"
                                width="150"
                                class="img-thumbnail">
                        </div>
                    @endif

                    <input type="file"
                        name="gambar"
                        class="form-control @error('gambar') is-invalid @enderror">

                    @error('gambar')
                        <div class="alert alert-danger mt-2">
                            {{ $message }}
                        </div>
                    @enderror
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