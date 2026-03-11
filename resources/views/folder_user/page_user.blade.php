@extends("layouts.app")
 
@section("content")
<div class="mt-1 mb-5 card bg-body-tertiary">
   
    <div class="bg-white card-header">
        <h4><i class="fa fa-database"></i> Daftar Akun / Pengguna</h4>
    </div>
    
    <div class="card-body">
 
        @session("success")
        <div class="alert alert-success">{{ $value }}</div>
        @endsession

        @if ($roleuserlogin == "Super Admin")
        <a href="/SuperAdmin/User/Create" class="mb-3 btn btn-success btn-l"> <i class="fa fa-plus"></i> Tambah Pengguna</a>
        <form method="GET" action="/SuperAdmin/User/Search" class="mb-2 row">
        @elseif ($roleuserlogin == "Admin" )
        <a href="/Admin/User/Create" class="mb-3 btn btn-success btn-l"> <i class="fa fa-plus"></i> Tambah Pengguna</a>
        <form method="GET" action="/Admin/User/Search" class="mb-2 row">        
        @endif
      
            <div class="input-group row" style="margin-right:5px;">
                <div class="form-outline col-md-10 col-9" data-mdb-input-init>
                    <input class="border border-2 form-control form-control-lg" name="search" placeholder="Pencarian Data..." value="{{ request()->input('search') ? request()->input('search') : '' }}">
                </div>
                <button type="submit" class="rounded btn btn-primary col-md-2 col-3">Cari</button>
            </div>
        </form>
        <div class="table-responsive">
            <table class="table table-striped table-bordered"  style="width:100%">
                <thead class="text-white bg-success textsize9">
                    <tr>
                        <th scope="col-1" width="50px">No</th>
                        <th scope="col-2">Nama</th>
                        <th scope="col-2">Email</th>
                        <th scope="col-1">Role</th>
                        <th scope="col-2">Wilayah</th>
                        <th scope="col-1" style=""  class="text-center">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($userku as $myuser)
                    <tr>
                        <td scope="col-1" class="textsize9">{{ $userku->firstItem() + $loop->index }}</td>
                        <td scope="col-2" class=" textsize9">{{ $myuser->name }}</td>
                        <td scope="col-2">{{$myuser->email}}</td>
                        <td scope="col-1">{{ $myuser->role }}</td>
                        <td scope="col-1">{{ $myuser->wilayah }}</td>
                        <td scope="col-1" class="text-center align-items-center">
                            <!-- dari middleware UserAkses-->
                                @if($errors->any())
                                    <p class="textsize6 text-danger mb-1">{{$errors->first()}}</p>
                                @endif
                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModalDetail{{ $myuser->id }}">
                                   <i class="fa fa-eye"></i>
                                </button>
                                @if ($roleuserlogin == "Super Admin")
                                <a href="/SuperAdmin/User/{{$myuser->id}}/Edit"
                                    class="btn btn-sm btn-warning"><i class="fa fa-pen"></i></a>
                                @elseif ($roleuserlogin == "Admin" )
                                <a href="/Admin/User/{{$myuser->id}}/Edit"
                                    class="btn btn-sm btn-warning"><i class="fa fa-pen"></i></a>
                                        
                                @endif
                               
                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModalDelete{{ $myuser->id }}">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>

<!------------------------ Modal Detail----------------------------->
                    <div class="modal fade" id="exampleModalDetail{{ $myuser->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-xl w-100" style="">
                            <div class="p-2 modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Detail ({{$myuser->name}})</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="p-2 border border-2 rounded modal-body border-success">
                                    <div class="p-2 row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <p>Name</p>
                                                </div>
                                                <div class="col-md-8">
                                                    <p>: <strong>{{ $myuser->name }}</strong></p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <p>Email</p>
                                                </div>
                                                <div class="col-md-8">
                                                    <p>: <strong>{{ $myuser->email }}</strong></p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <p>Password</p>
                                                </div>
                                                <div class="col-md-8">
                                                    <p>: <strong>{{ $myuser->password }}</strong></p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <p>Tingkat</p>
                                                </div>
                                                <div class="col-md-8">
                                                    <p>: <strong>{{ $myuser->tingkat }}</strong></p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <p>Kecamatan</p>
                                                </div>
                                                <div class="col-md-8">
                                                    <p>: <strong>{{ $myuser->kecamatan }}</strong></p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <p>Desa</p>
                                                </div>
                                                <div class="col-md-8">
                                                    <p>: <strong>{{ $myuser->desa }}</strong></p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <p>Dusun</p>
                                                </div>
                                                <div class="col-md-8">
                                                    <p>: <strong>{{ $myuser->dusun }}</strong></p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <p>Role</p>
                                                </div>
                                                <div class="col-md-8">
                                                    <p>: <strong>{{ $myuser->role }}</strong></p>
                                                </div>
                                            </div>
                                            
                                            
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Keluar</button>
                                </div>
                            </div>
                        </div>
                    </div>

<!------------------------ Modal Delete----------------------------->
                    <div class="modal fade" id="exampleModalDelete{{ $myuser->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-l">
                            <form action="{{ route('folder_user.destroy', $myuser->id) }}" method="POST" class="p-2 border border-2 rounded border-success">
                                @csrf
                                @method('DELETE')
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus Data ({{$myuser->name}})</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                            <div class="row">
                                                <p>Anda Yakin Akan Menghapus Data Ini?</p>
                                               
                                            </div>
                                        
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                         <button type="submit" class="btn btn-md btn-danger me-3">Hapus</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="d-flex custom-pagination justify-content-end">
            {{ $userku->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection