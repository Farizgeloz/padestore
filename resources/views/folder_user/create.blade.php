@extends("layouts.app")
 
@section("content")
<div class="card mt-10 mb-5 bg-body-tertiary">
    <div class="card-header  bg-white">
        <h5>Form Tambah Data Pengguna</h5>
    </div>
    <div class="card-body">
        <a href="{{ route('folder_user.page_user') }}" class="btn btn-info btn-sm mb-2 text-light"><i class="fa fa-arrow-left"></i> Kembali</a>
 
        <form action="/SuperAdmin/User/Create" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row justify-content-center align-items-center">
                <div class="col-md-5  border  border-2 border-success  bg-success-subtle rounded p-4">
                    <div class="row">
                        <div class="form-group mb-2  col-md-12">
                            <label class="font-weight-bold">Nama Lengkap</label>
                            <input type="text" class="form-control form-control-lg m-1 @error('name') is-invalid @enderror"  placeholder="Nama Lengkap"
                                name="name" value="{{ old('name') }}">
                            <!-- tampilkan pesan error -->
                            @error('name')
                                <div class="alert alert-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group mb-2  col-md-12">
                            <label class="font-weight-bold">Akun</label>
                            <input type="text" class="form-control form-control-lg m-1 @error('akun') is-invalid @enderror"  placeholder="Akun"
                                name="akun" value="{{ old('akun') }}">
                            <!-- tampilkan pesan error -->
                            @error('akun')
                                <div class="alert alert-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group mb-2  col-md-12">
                            <label class="font-weight-bold">Email</label>
                            <input type="text" class="form-control form-control-lg m-1 @error('emaill') is-invalid @enderror"  placeholder="Email"
                                name="emaill" value="{{ old('emaill') }}" id="">
                            <!-- tampilkan pesan error -->
                            @error('emaill')
                                <div class="alert alert-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group mb-2  col-md-12">
                            <label class="font-weight-bold">Password</label>
                            <input type="text" class="form-control form-control-lg m-1 @error('passwordd') is-invalid @enderror"  placeholder="Password"
                                name="passwordd" value="{{ old('passwordd') }}" id="">
                            <!-- tampilkan pesan error -->
                            @error('passwordd')
                                <div class="alert alert-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group mb-2  col-md-12">
                            <label class="font-weight-bold">Wilayah</label>
                            <input type="text" class="form-control form-control-lg m-1 @error('wilayah') is-invalid @enderror"  placeholder="Wilayah"
                                name="wilayah" value="{{ old('wilayah') }}">
                            <!-- tampilkan pesan error -->
                            @error('wilayah')
                                <div class="alert alert-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="form-group mb-3  col-md-12">
                            <label class="font-weight-bold">Akses</label>
                            <select class="form-select form-select-lg m-1 @error('role') is-invalid @enderror" aria-label="Small select example"  name="role">
                                <option value="">Pilih Akses</option>
                                @if ($roleuserlogin == "Super Admin" )
                                    <option value="Driver">Driver</option>
                                    <option value="Admin">Admin</option>
                                    <option value="Super Admin">Super Admin</option>
                                @else
                                    <option value="Driver">Driver</option>
                                    <option value="Admin">Admin</option>
                                @endif
                            
                            </select>
                            <!-- tampilkan pesan error -->
                            @error('role')
                                <div class="alert alert-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>      
                <div class="col-md-5 d-flex">
                    <button type="reset" class="btn btn-md btn-secondary me-3 mt-2" style="height: 50px">CLEAR</button>
                    <button type="submit" class="btn btn-md btn-success me-3 mt-2" style="height: 50px">SIMPAN</button>
                </div>
            </div>
           
        </form>
    </div>
</div>
@endsection