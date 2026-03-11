@extends("layouts.app")
 
@section("content")
<div class="card mt-10 mb-5 bg-body-tertiary">
    <div class="card-header  bg-white">
        <h5>Form Tambah Pengeluaran</h5>
    </div>
    <div class="card-body">
        @if ($roleuserlogin == "Super Admin" )
        <a href="/SuperAdmin/Pengeluaran" class="btn btn-info btn-sm mb-2 text-light"><i class="fa fa-arrow-left"></i> Kembali</a>
    
        @elseif ($roleuserlogin == "Admin" )
        <a href="/Admin/Pengeluaran" class="btn btn-info btn-sm mb-2 text-light"><i class="fa fa-arrow-left"></i> Kembali</a>
        @endif
       
 
        <form action="{{ route('folder_pengeluaran.store') }}" method="post" enctype="multipart/form-data" class="row border  border-2 border-success rounded p-2">
            @csrf
            <div class="col-md-6">
                <div class="row">
                    <div class="form-group mb-2  col-md-12">
                        <label class="font-weight-bold text-success">Nama Pengeluaran</label>
                        <input type="text" class="form-control m-1 @error('nama_pengeluaran') is-invalid @enderror"  placeholder="Nama Pengeluaran"
                            name="nama_pengeluaran" value="{{ old('nama_pengeluaran') }}" id="">
                        <!-- tampilkan pesan error -->
                        @error('nama_pengeluaran')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    
                </div>
            </div>
            <div class="col-md-3">
                <div class="row">
                    <div class="form-group mb-2  col-md-12">
                        <label class="font-weight-bold text-success">Nominal</label>
                        <input type="number" class="form-control m-1 @error('nominal') is-invalid @enderror"  placeholder="Nominal"
                            name="nominal" value="{{ old('nominal') }}" id="">
                        <!-- tampilkan pesan error -->
                        @error('nominal')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="row">
                    <div class="form-group mb-2  col-md-12">
                        <label class="font-weight-bold text-success">Tanggal Input</label>
                        <input type="date" class="form-control m-1 @error('tanggal') is-invalid @enderror"  placeholder="Tanggal Input"
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
             <button type="submit" class="btn btn-md btn-success me-3">SIMPAN</button>
                <button type="reset" class="btn btn-md btn-secondary me-3">CLEAR</button>
            </div>
            
           
        </form>
    </div>
</div>
@endsection