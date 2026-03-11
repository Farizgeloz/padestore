
@extends("layouts.app")
 
@section("content")
<div class="card mb-5 bg-body-tertiary">
    <div class="card-header  bg-white">
        <h4>Form Edit Order Pelanggan</h4>
    </div>
    <div class="card-body">
        @if ($roleuserlogin == "Super Admin" )
        <a href="/SuperAdmin/Kotak" class="btn btn-info btn-sm mb-3"><i class="fa fa-arrow-left"></i> Back</a>
        
        <form action="/SuperAdmin/Order/Update/{{$orderku->id_order}}" method="POST"  enctype="multipart/form-data" class="row border  border-2 border-success rounded p-2"
            enctype="multipart/form-data">
    
        @elseif ($roleuserlogin == "Admin" )
        <a href="/Admin/Kotak" class="btn btn-info btn-sm mb-3"><i class="fa fa-arrow-left"></i> Back</a>
        
        <form action="/Admin/Order/Update/{{$orderku->id_order}}" method="POST"  enctype="multipart/form-data" class="row border  border-2 border-success rounded p-2"
            enctype="multipart/form-data">
        @endif
        
            @csrf
            @method('PUT')

            <div class="col-md-6">
                <div class="row">
                    <div class="form-group mb-2  col-md-12">
                        <label class="font-weight-bold text-success">Pelanggan</label>
                        <select class="form-select form-select-l m-1 @error('pelanggan') is-invalid @enderror" aria-label="Small select example"  name="pelanggan" id="">
                            <option  value="{{ old('pelanggan', $orderku->pelanggan) }}">{{ old('pelanggan', $orderku->nama_pelanggan) }}</option>
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
            <div class="col-md-6">
                <div class="row">
                    <div class="form-group mb-2  col-md-12">
                        <label class="font-weight-bold text-success">Nominal</label>
                        <input type="text" class="form-control m-1 @error('nominal') is-invalid @enderror"  placeholder="Nominal"
                            name="nominal" value="{{ old('nominal', $orderku->nominal) }}" id="">
                        <!-- tampilkan pesan error -->
                        @error('nominal')
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
                        <label class="font-weight-bold text-success">Jumlah Pesanan</label>
                        <input type="number" class="form-control m-1 @error('jumlah_pesanan') is-invalid @enderror"  placeholder="Jumlah Pesanan"
                            name="jumlah_pesanan" value="{{ old('jumlah_pesanan', $orderku->jumlah_pesanan) }}" id="">
                        <!-- tampilkan pesan error -->
                        @error('jumlah_pesanan')
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
                        <label class="font-weight-bold text-success">Sisa Pesanan</label>
                        <input type="number" class="form-control m-1 @error('sisa_pesanan') is-invalid @enderror"  placeholder="Sisa Pesanan"
                            name="sisa_pesanan" value="{{ old('sisa_pesanan', $orderku->sisa_pesanan) }}" id="">
                        <!-- tampilkan pesan error -->
                        @error('sisa_pesanan')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    
                </div>
            </div>
            
            <div class="col-md-12 d-flex flex-row-reverse">
                <button type="submit" class="btn btn-md btn-success me-3">Update</button>
                <button type="reset" class="btn btn-md btn-secondary me-3">Reset</button>
             </div>
        </form>
    </div>
</div>
@endsection