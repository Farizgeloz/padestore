
@extends("layouts.app")
 
@section("content")
<div class="card mb-5 bg-body-tertiary">
    <div class="card-header  bg-white">
        <h4>Form Edit Pengiriman Pesanan Pelanggan</h4>
    </div>
    <div class="card-body">
        @if ($roleuserlogin == "Super Admin" )
        <a href="/SuperAdmin/PesananDeliver" class="btn btn-info btn-sm mb-3"><i class="fa fa-arrow-left"></i> Back</a>
        
        <form action="/SuperAdmin/PesananDeliver/Update/{{$pesananku->id_pesanan}}" method="POST" class="row border  border-2 border-success rounded p-2"
            enctype="multipart/form-data">
    
        @elseif ($roleuserlogin == "Admin" )
        <a href="/Admin/PesananDeliver" class="btn btn-info btn-sm mb-3"><i class="fa fa-arrow-left"></i> Back</a>
        
        <form action="/Admin/PesananDeliver/Update/{{$pesananku->id_pesanan}}" method="POST" class="row border  border-2 border-success rounded p-2"
            enctype="multipart/form-data">
        @endif
        
            @csrf
            @method('PUT')

            <div class="col-md-6">
                <div class="row">
                    <div class="form-group mb-2  col-md-12">
                        <label class="font-weight-bold text-success">Pelanggan</label>
                        <select class="form-select form-select-l m-1 @error('pelanggan') is-invalid @enderror" aria-label="Small select example"  name="pelanggan" id="">
                            <option  value="{{ old('pelanggan', $pesananku->pelanggan) }}">{{ old('pelanggan', $pesananku->nama_pelanggan) }}</option>
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
                        <label class="font-weight-bold text-success">Jenis</label>
                        <select class="form-select form-select-l m-1 @error('jenis') is-invalid @enderror" aria-label="Small select example"  name="jenis" id="">
                            
                            <option  value="{{ old('jenis', $pesananku->jenis) }}">{{ old('jenis', $pesananku->jenis) }}</option>
                            <option value="Tahu Besar">Tahu Besar</option>
                            <option value="Tahu Kecil">Tahu Kecil</option>
                            <option value="Tahu Timur">Tahu Timur</option>
                        </select>
                        <!-- tampilkan pesan error -->
                        @error('jenis')
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
                        <label class="font-weight-bold text-success">Nomor Kotak</label>
                        <select class="form-select form-select-l m-1 @error('kotak') is-invalid @enderror" aria-label="Small select example"  name="kotak" id="">
                            
                            <option  value="{{ old('kotak', $pesananku->kotak) }}">{{ old('kotak', $pesananku->nomor_kotak) }}</option>
                            @foreach($kotakku as $kotak)
                                <option value="{{ $kotak->id_kotak }}">{{ $kotak->nomor_kotak }}</option>
                            @endforeach
                        </select>
                        <!-- tampilkan pesan error -->
                        @error('kotak')
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
                        <label class="font-weight-bold text-success">Status</label>
                        <select class="form-select form-select-l m-1 @error('status') is-invalid @enderror" aria-label="Small select example"  name="status" id="">
                            
                            <option  value="{{ old('status', $pesananku->status) }}">{{ old('status', $pesananku->status) }}</option>
                            <option value="Dropsit">Dropsit</option>
                            <option value="Deliver">Deliver</option>
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
                <button type="submit" class="btn btn-md btn-success me-3">Update</button>
                <button type="reset" class="btn btn-md btn-secondary me-3">Reset</button>
             </div>
        </form>
    </div>
</div>
@endsection