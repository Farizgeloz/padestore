
@extends("layouts.app")
 
@section("content")
<div class="card mb-5 bg-body-tertiary">
    <div class="card-header  bg-white">
        <h4>Form Edit Data Pengguna</h4>
    </div>
    <div class="card-body">
        @if ($roleuserlogin == "Super Admin")
        <a href="/SuperAdmin/User" class="btn btn-info btn-sm mb-3"><i class="fa fa-arrow-left"></i> Kembali</a>
        <form action="/SuperAdmin/User/{{$userku->id}}/Update" method="POST"  enctype="multipart/form-data" class=""
            enctype="multipart/form-data">
        @elseif ($roleuserlogin == "Admin" )
        <a href="/Admin/User" class="btn btn-info btn-sm mb-3"><i class="fa fa-arrow-left"></i> Kembali</a>
        <form action="/Admin/User/{{$userku->id}}/Update" method="POST"  enctype="multipart/form-data" class=""
            enctype="multipart/form-data">
                
        @endif
            @csrf
            @method('PUT')
            <div class="row justify-content-center align-items-center">
                <div class="col-md-5 border  border-2 border-success rounded p-4">
                    <div class="row">
                        <div class="form-group mb-2  col-md-12">
                            <label class="font-weight-bold text-success">Nama Lengkap</label>
                            <input type="text" class="form-control form-control-lg m-1 @error('name') is-invalid @enderror"  placeholder="Nama Lengkap"
                                name="name" value="{{ old('name', $userku->name) }}" id="">
                            <!-- tampilkan pesan error -->
                            @error('name')
                                <div class="alert alert-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group mb-2  col-md-12">
                            <label class="font-weight-bold text-success">Akun</label>
                            <input type="text" class="form-control form-control-lg m-1 @error('akun') is-invalid @enderror"  placeholder="Akun"
                                name="akun" value="{{ old('akun', $userku->akun) }}" id="">
                            <!-- tampilkan pesan error -->
                            @error('akun')
                                <div class="alert alert-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group mb-2  col-md-12">
                            <label class="font-weight-bold text-success">Email</label>
                            <input type="email" class="form-control form-control-lg m-1 @error('email') is-invalid @enderror"  placeholder="Email"
                                name="email" value="{{ old('email', $userku->email) }}" id="">
                            <!-- tampilkan pesan error -->
                            @error('email')
                                <div class="alert alert-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group mb-2  col-md-12">
                            <label class="font-weight-bold text-success">Password</label>
                            <input type="password" class="form-control form-control-lg m-1 @error('password') is-invalid @enderror"  placeholder="Password"
                                name="password" value="{{ old('password', $userku->password) }}" id="">
                            <!-- tampilkan pesan error -->
                            @error('password')
                                <div class="alert alert-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group mb-2  col-md-12">
                            <label class="font-weight-bold text-success">Wilayah</label>
                            <input type="text" class="form-control form-control-lg m-1 @error('wilayah') is-invalid @enderror"  placeholder="Wilayah"
                                name="wilayah" value="{{ old('wilayah', $userku->wilayah) }}">
                            <!-- tampilkan pesan error -->
                            @error('wilayah')
                                <div class="alert alert-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group mb-2  col-md-12">
                            <label class="font-weight-bold text-success">Akses</label>
                            <select class="form-select form-select-lg m-1 @error('role') is-invalid @enderror" aria-label="Small select example"  name="role" id="">
                                <option  value="{{ old('role', $userku->role) }}">{{ old('role', $userku->role) }}</option>
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
                    <button type="reset" class="btn btn-md btn-secondary me-3 mt-2" style="height: 50px">Reset</button>
                    <button type="submit" class="btn btn-md btn-success me-3 mt-2" style="height: 50px">Update</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection