@extends("layouts.app")
 
@section("content")
<div class="mt-1 mb-5 card bg-body-tertiary">
   
    <div class="bg-white card-header">
        <h4><i class="fa fa-database"></i> Daftar Stok Produk</h4>
    </div>
    
    <div class="card-body">
 
        @session("success")
        <div class="alert alert-success">{{ $value }}</div>
        @endsession
        @if ($roleuserlogin == "Super Admin" )
            <a href="/SuperAdmin/Stok/Tambah" class="mb-3 btn btn-success btn-l"> <i class="fa fa-plus"></i> Tambah Stok Produk</a>
        
        @elseif ($roleuserlogin == "Admin" )
            <a href="/Admin/Stok/Tambah" class="mb-3 btn btn-success btn-l"> <i class="fa fa-plus"></i> Tambah Stok Produk</a>
        @endif

        @if ($roleuserlogin == "Super Admin" )
        <form method="GET" action="/SuperAdmin/Stok/Search" class="mb-2 row">
        @elseif ($roleuserlogin == "Admin" )
        <form method="GET" action="/Admin/Stok/Search" class="mb-2 row">
        @else
        <form method="GET" action="/Stok/Search" class="mb-2 row">
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
                        <th scope="col" width="50px">No</th>
                        <th scope="col">Nama Produk</th>
                        <th scope="col">Tipe</th>
                        <th scope="col">Qty</th>
                        <th scope="col">Referensi</th>
                        <th scope="col">Keterangan</th>
                        <th scope="col" style="width: 20%"  class="text-center">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($stokku as $stok)
                    <tr>
                        <td class="textsize9">{{ $stokku->firstItem() + $loop->index }}</td>
                       
                        <td class=" textsize9">{{ $stok->nama_produk }}</td>
                        <td>{{$stok->tipe}}</td>
                        <td>{{$stok->qty}}</td>
                        <td>{{$stok->referensi}}</td>
                        <td>{{$stok->keterangan}}</td>
                         {{-- <td class=" textsize9">{{ \Carbon\Carbon::parse($stok->tanggal)->translatedFormat('d F Y') }}</td> --}}
                        
                        <td class="text-center align-items-center">
                            <!-- dari middleware UserAkses-->
                                @if($errors->any())
                                    <p class="textsize6 text-danger mb-1">{{$errors->first()}}</p>
                                @endif
                                <button type="button" class="btn btn-primary btn-l" data-bs-toggle="modal" data-bs-target="#exampleModalDetail{{ $stok->id_stok }}">
                                   <i class="fa fa-eye"></i>
                                </button>
                                @if ($roleuserlogin == "Super Admin" )
                                    @if ($stok->status !== "Habis")
                                        <a href="/SuperAdmin/Stok/Edit/{{$stok->id_stok}}"
                                            class="btn btn-l btn-warning"><i class="fa fa-pen"></i></a>
                                        <button type="button" class="btn btn-danger btn-l" data-bs-toggle="modal" data-bs-target="#exampleModalDelete{{ $stok->id_stok }}">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    @endif
                                @elseif ($roleuserlogin == "Admin" )
                                    @if ($stok->status !== "Habis")
                                        <a href="/Admin/Stok/{{ $stok->id_stok }}/Edit"
                                            class="btn btn-l btn-warning">
                                            <i class="fa fa-pen"></i>
                                        </a>
                                        <button type="button" class="btn btn-danger btn-l"
                                            data-bs-toggle="modal"
                                            data-bs-target="#exampleModalDelete{{ $stok->id_stok }}">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    @endif
                                @endif
                                
                               
                                
                            </form>
                        </td>
                    </tr>

<!------------------------ Modal Detail----------------------------->
                    <div class="modal fade" id="exampleModalDetail{{ $stok->id_stok }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-xl w-100" style="">
                            <div class="p-2 modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Detail ({{$stok->nama_produk}})</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="p-2 border border-2 rounded modal-body border-success">
                                    <div class="p-2 row">
                                        
                                        <div class="col-md-6">
                                            <div class="border rounded row border-1 m-2">
                                                <div class="col-md-12">
                                                        <p>Deskripsi Riwayat :</p>
                                                </div>
                                                <div class="col-md-12">
                                                    <code class="text-secondary">
                                                        <p>{!! $stok->alamat !!}</p>
                                                    </code>
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
                    <div class="modal fade" id="exampleModalDelete{{ $stok->id_stok }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-l">
                            <form action="{{ route('folder_produk.destroy', $stok->id_stok) }}" method="POST" class="p-2 border border-2 rounded border-success">
                                @csrf
                                @method('DELETE')
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus Data ({{$stok->nama_stok}})</h1>
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
            {{ $stokku->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection