@extends("layouts.app")
 
@section("content")
<div class="card mt-10 mb-5 bg-body-tertiary">
    <div class="card-header  bg-white">
        <h5>Form Tambah Stok</h5>
    </div>
    <div class="card-body">
        @if ($roleuserlogin == "Super Admin" )
        <a href="/SuperAdmin/Stok" class="btn btn-info btn-l mb-2 text-light"><i class="fa fa-arrow-left"></i> Kembali</a>
    
        @elseif ($roleuserlogin == "Admin" )
        <a href="/Admin/Stok" class="btn btn-info btn-l mb-2 text-light"><i class="fa fa-arrow-left"></i> Kembali</a>
        @endif
       
 
        <form action="{{ route('folder_stok.store') }}" method="post" enctype="multipart/form-data" class="row border  border-2 border-success bg-success-subtle rounded p-2">
            @csrf
            <div class="col-md-6">
                <div class="row">
                    <div class="form-group mb-2  col-md-12">
                        <label class="font-weight-bold">Produk</label>
                        <select class="form-select form-select-lg m-1 @error('produk_id') is-invalid @enderror" aria-label="Small select example"  name="produk_id" id="">
                            <option  value="">Pilih Produk</option>
                            @foreach($produkku as $produk)
                                <option value="{{ $produk->id_produk }}">{{ $produk->nama_produk }}</option>
                            @endforeach
                           
                           
                        </select>
                        <!-- tampilkan pesan error -->
                        @error('produk_id')
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
                        <label class="font-weight-bold">Tipe</label>
                        <select class="form-select form-select-lg m-1 @error('tipe') is-invalid @enderror" aria-label="Small select example"  name="tipe" id="" disabled>
                            <option value="Masuk">Masuk</option>
                           
                           
                        </select>
                        <!-- tampilkan pesan error -->
                        @error('tipe')
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
                        <label class="font-weight-bold">Qty</label>
                        <input type="number" class="form-control form-control-lg m-1 @error('qty') is-invalid @enderror"  placeholder="Qty"
                            name="qty" id="">
                        <!-- tampilkan pesan error -->
                        @error('qty')
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