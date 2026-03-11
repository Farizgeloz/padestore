@extends("layouts.app")
 
@section("content")
<div class="mt-1 mb-5 card bg-body-tertiary">
   
    <div class="bg-white card-header">
        <h4><i class="fa fa-database"></i> Daftar Stok Barang</h4>
    </div>
    
    <div class="card-body">
 
        @session("success")
        <div class="alert alert-success">{{ $value }}</div>
        @endsession
        @if ($roleuserlogin == "Super Admin" )
            <a href="/SuperAdmin/StokBarang/Tambah" class="mb-3 btn btn-success btn-l"> <i class="fa fa-plus"></i> Tambah Stok Barang</a>
        
        @elseif ($roleuserlogin == "Admin" )
            <a href="/Admin/StokBarang/Tambah" class="mb-3 btn btn-success btn-l"> <i class="fa fa-plus"></i> Tambah Stok Barang</a>
        @endif

        @if ($roleuserlogin == "Super Admin" )
        <form method="GET" action="/SuperAdmin/StokBarang/Search" class="mb-2 row">
        @elseif ($roleuserlogin == "Admin" )
        <form method="GET" action="/Admin/StokBarang/Search" class="mb-2 row">
        @else
        <form method="GET" action="/StokBarang/Search" class="mb-2 row">
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
                        <th scope="col">Kode Barang</th>
                        <th scope="col">Nama Barang</th>
                        <th scope="col">Stok Awal</th>
                        <th scope="col">Barang Masuk</th>
                        <th scope="col">Barang Keluar</th>
                        <th scope="col">Sisa Stok</th>
                        <th scope="col">Nilai Akhir</th>
                        <th scope="col">Tanggal</th>
                        <th scope="col">Status</th>
                        <th scope="col" style="width: 20%"  class="text-center">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($stokbarangku as $stokbarang)
                    <tr>
                        <td class="textsize9">{{ $stokbarangku->firstItem() + $loop->index }}</td>
                       
                        <td class=" textsize9">{{ $stokbarang->kode_barang }}</td>
                        <td class=" textsize9">{{ $stokbarang->nama_barang }}</td>
                        <td class=" textsize9">{{ $stokbarang->stok_awal }}</td>
                        <td>{{$stokbarang->barang_masuk}}</td>
                        <td>{{$stokbarang->barang_keluar}}</td>
                        <td>{{($stokbarang->barang_masuk + $stokbarang->barang_masuk) - $stokbarang->barang_keluar}}</td>
                        <td>{{$stokbarang->nilai_akhir}}</td>
                         <td class=" textsize9">{{ \Carbon\Carbon::parse($stokbarang->tanggal)->translatedFormat('d F Y') }}</td>
                        <td style="background-color: {{ $stokbarang->status === 'Habis' ? '#ffb3b3' : 'transparent' }}">
                            {{ $stokbarang->status }}
                        </td>
                        
                        <td class="text-center align-items-center">
                            <!-- dari middleware UserAkses-->
                                @if($errors->any())
                                    <p class="textsize6 text-danger mb-1">{{$errors->first()}}</p>
                                @endif
                                <button type="button" class="btn btn-primary btn-l" data-bs-toggle="modal" data-bs-target="#exampleModalDetail{{ $stokbarang->id_barang }}">
                                   <i class="fa fa-eye"></i>
                                </button>
                                @if ($roleuserlogin == "Super Admin" )
                                    @if ($stokbarang->status !== "Habis")
                                        <a href="/SuperAdmin/StokBarang/Edit/{{$stokbarang->id_barang}}"
                                            class="btn btn-l btn-warning"><i class="fa fa-pen"></i></a>
                                        <button type="button" class="btn btn-danger btn-l" data-bs-toggle="modal" data-bs-target="#exampleModalDelete{{ $stokbarang->id_barang }}">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    @endif
                                @elseif ($roleuserlogin == "Admin" )
                                    @if ($stokbarang->status !== "Habis")
                                        <a href="/Admin/StokBarang/{{ $stokbarang->id_barang }}/Edit"
                                            class="btn btn-l btn-warning">
                                            <i class="fa fa-pen"></i>
                                        </a>
                                        <button type="button" class="btn btn-danger btn-l"
                                            data-bs-toggle="modal"
                                            data-bs-target="#exampleModalDelete{{ $stokbarang->id_barang }}">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    @endif
                                @endif
                                
                               
                                
                            </form>
                        </td>
                    </tr>

<!------------------------ Modal Detail----------------------------->
                    <div class="modal fade" id="exampleModalDetail{{ $stokbarang->id_barang }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-xl w-100" style="">
                            <div class="p-2 modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Detail ({{$stokbarang->nama_barang}})</h1>
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
                                                        <p>{!! $stokbarang->alamat !!}</p>
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
                    <div class="modal fade" id="exampleModalDelete{{ $stokbarang->id_barang }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-l">
                            <form action="{{ route('folder_stokbarang.destroy', $stokbarang->id_barang) }}" method="POST" class="p-2 border border-2 rounded border-success">
                                @csrf
                                @method('DELETE')
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus Data ({{$stokbarang->nama_stokbarang}})</h1>
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
            {{ $stokbarangku->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection