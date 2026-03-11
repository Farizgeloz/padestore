@extends("layouts.app")
 
@section("content")
<div class="card mt-10 mb-5 bg-body-tertiary">
    <div class="card-header  bg-white">
        <h5>Form Tambah Pelanggan</h5>
    </div>
    <div class="card-body">
        @if ($roleuserlogin == "Super Admin" )
        <a href="/SuperAdmin/Order" class="btn btn-info btn-l mb-2 text-light"><i class="fa fa-arrow-left"></i> Kembali</a>
    
        @elseif ($roleuserlogin == "Admin" )
        <a href="/Admin/Order" class="btn btn-info btn-l mb-2 text-light"><i class="fa fa-arrow-left"></i> Kembali</a>
        @endif
       
 
        <form action="{{ route('folder_order.store') }}" method="post" enctype="multipart/form-data" class="row border  border-2 border-success bg-success-subtle rounded p-2">
            @csrf
            <div class="col-md-5">
                <div class="row">
                    <div class="form-group mb-2  col-md-12">
                        <label class="font-weight-bold">Pelanggan</label>
                        <select class="form-select form-select-lg m-1 @error('pelanggan') is-invalid @enderror" aria-label="Small select example"  name="pelanggan" id="">
                            <option  value="">Pilih Pelanggan</option>
                            @foreach($pelangganku as $pelanggan)
                                <option value="{{ $pelanggan->id_pelanggan }}">{{ $pelanggan->nama_pelanggan }}</option>
                            @endforeach
                           
                           
                        </select>
                        <!-- tampilkan pesan error -->
                        @error('pelanggan')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    
                </div>
            </div>
            <div class="col-md-5">
                <div class="row">
                    <div class="form-group mb-2  col-md-12">
                        <label class="font-weight-bold">metode_bayar</label>
                        <select class="form-select form-select-lg m-1 @error('metode_bayar') is-invalid @enderror" aria-label="Small select example"  name="metode_bayar" id="">
                            <option  value="">Pilih metode_bayar</option>
                           <option value="Cash">Cash</option>
                           <option value="Debet">TF</option>
                           
                           
                        </select>
                        <!-- tampilkan pesan error -->
                        @error('metode_bayar')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    
                </div>
            </div>
            <div class="col-md-5">
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
            <div class="col-md-5">
                <div class="row">
                    <div class="form-group mb-2  col-md-12">
                        <label class="font-weight-bold">Jumlah Pesanan</label>
                        <input type="number" class="form-control form-control-lg m-1 @error('jumlah_pesanan') is-invalid @enderror"  placeholder="Jumlah Pesanan"
                            name="jumlah_pesanan" value="{{ old('jumlah_pesanan') }}" id="">
                        <!-- tampilkan pesan error -->
                        @error('jumlah_pesanan')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    
                </div>
            </div>
            
            
            
                   
            <div class="col-md-12 d-flex flex-row-reverse">
             <button type="submit" class="btn btn-l btn-success me-3">SIMPAN</button>
                <button type="reset" class="btn btn-l btn-secondary me-3">CLEAR</button>
            </div>
            
           
        </form>
    </div>
</div>
@endsection