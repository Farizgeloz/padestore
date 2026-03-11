
@extends("layouts.app")
 
@section("content")
<div class="card mb-5 bg-body-tertiary">
    <div class="card-header  bg-white">
        <h4>Form Edit Data Pelanggan</h4>
    </div>
    <div class="card-body">
        @if ($roleuserlogin == "Super Admin" )
        <a href="/SuperAdmin/Pelanggan" class="btn btn-info btn-l mb-3 text-white"><i class="fa fa-arrow-left"></i> Kembali</a>
        
        <form action="/SuperAdmin/Pelanggan/Update/{{$pelangganku->id_pelanggan}}" method="POST"  enctype="multipart/form-data" class="row border  border-2 border-success bg-success-subtle rounded p-2"
            enctype="multipart/form-data">
    
        @elseif ($roleuserlogin == "Admin" )
        <a href="/Admin/Pelanggan" class="btn btn-info btn-l mb-3 text-white"><i class="fa fa-arrow-left"></i> Kembali</a>
        
        <form action="/Admin/Pelanggan/Update/{{$pelangganku->id_pelanggan}}" method="POST"  enctype="multipart/form-data" class="row border  border-2 border-success bg-success-subtle rounded p-2"
            enctype="multipart/form-data">
        @endif
        
            @csrf
            @method('PUT')

            <div class="col-md-5">
                <div class="row">
                    <div class="form-group mb-2  col-md-12">
                        <label class="font-weight-bold">Nama Pelanggan</label>
                        <input type="text" class="form-control form-control-lg m-1 @error('nama_pelanggan') is-invalid @enderror"  placeholder="Nama Pelanggan"
                            name="nama_pelanggan" value="{{ old('nama_pelanggan', $pelangganku->nama_pelanggan) }}" id="">
                        <!-- tampilkan pesan error -->
                        @error('nama_pelanggan')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                </div>
            </div>
            <div class="col-md-10">
                <div class="row">
                    <div class="form-group mb-2  col-md-12">
                        <label class="font-weight-bold">Alamat</label>
                        <textarea name="alamat"
                            class="form-control form-control-lg m-1 @error('alamat') is-invalid @enderror" rows="3"
                            placeholder="masukkan alamat">{{ old('alamat', $pelangganku->alamat) }}</textarea>
                        <!-- tampilkan pesan error -->
                        @error('alamat')
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
                        <label class="font-weight-bold">Telpon</label>
                        <input type="text" class="form-control form-control-lg m-1 @error('telpon') is-invalid @enderror"  placeholder="Telpon"
                            name="telpon" value="{{ old('telpon', $pelangganku->telpon) }}" id="">
                        <!-- tampilkan pesan error -->
                        @error('telpon')
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
                        <label class="font-weight-bold">Wilayah</label>
                        <input type="text" class="form-control form-control-lg m-1 @error('wilayah') is-invalid @enderror"  placeholder="Wilayah"
                            name="wilayah" value="{{ old('wilayah', $pelangganku->wilayah) }}" id="wilayah">
                        <!-- tampilkan pesan error -->
                        @error('wilayah')
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