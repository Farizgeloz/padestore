@extends("layouts.app")
 
@section("content")
<div class="mt-1 mb-5 card bg-body-tertiary">
   
    <div class="bg-white card-header">
        <h4><i class="fa fa-database"></i> Pesanan Pengiriman</h4>
    </div>
    
    <div class="card-body">
 
        @session("success")
        <div class="alert alert-success">{{ $value }}</div>
        @endsession
        @if ($roleuserlogin == "Super Admin" )
            <a href="/SuperAdmin/Pesanan/Deliver/Tambah" class="mb-3 btn btn-success btn-l"> <i class="fa fa-plus"></i> Tambah Pengiriman</a>
        
        @elseif ($roleuserlogin == "Admin" )
            <a href="/Admin/Pesanan/Deliver/Tambah" class="mb-3 btn btn-success btn-l"> <i class="fa fa-plus"></i> Tambah Pengiriman</a>
        @endif

        @if ($roleuserlogin == "Super Admin" )
        <form method="GET" action="/SuperAdmin/Pesanan/Deliver/Search" class="mb-2 row">
        @elseif ($roleuserlogin == "Admin" )
        <form method="GET" action="/Admin/Pesanan/Deliver/Search" class="mb-2 row">
        @else
        <form method="GET" action="/Pesanan/Deliver/Search" class="mb-2 row">
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
                        <th scope="col" width="50px">ID</th>
                        <th scope="col">Pelanggan</th>
                        <th scope="col">Jenis</th>
                        <th scope="col">No Kotak</th>
                        <th scope="col">Harga Satuan</th>
                        <th scope="col">Pengantar</th>
                        <th scope="col">Status</th>
                        <th scope="col">Tanggal</th>
                        <th scope="col" style="width: 20%"  class="text-center">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pesananku as $pesanan)
                    <tr>
                        <td class="textsize9">{{ $pesananku->firstItem() + $loop->index }}</td>
                       
                        <td class=" textsize9">{{ $pesanan->nama_pelanggan }}</td>
                        <td class=" textsize9">{{ $pesanan->jenis }}</td>
                        <td class=" textsize9">{{ $pesanan->nomor_kotak }}</td>
                         <td class="textsize9">
                            Rp {{ number_format($pesanan->harga_satuan, 0, ',', '.') }}
                        </td>
                        <td class=" textsize9">{{ $pesanan->akun }}</td>
                        <td style="
                            background-color: {{ 
                                $pesanan->status === 'Deliver' ? '#ffc107' : 
                                ($pesanan->status === 'Dropsit' ? '#0ea314' : 'transparent') 
                            }};
                            color: {{ 
                                $pesanan->status === 'Deliver' ? '#fff' : 
                                ($pesanan->status === 'Dropsit' ? '#fff' : '#999') 
                            }};
                        ">
                            {{ $pesanan->status }}
                        </td>
                        <td class=" textsize9">{{ \Carbon\Carbon::parse($pesanan->tanggal)->translatedFormat('d F Y') }}</td>
                        <td class="text-center align-items-center">
                            <!-- dari middleware UserAkses-->
                               
                                @if ($roleuserlogin == "Super Admin" )
                                <a href="/SuperAdmin/Pesanan/Deliver/Edit/{{$pesanan->id_pesanan}}"
                                    class="btn btn-sm btn-warning"><i class="fa fa-pen"></i></a>
                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModalDelete{{ $pesanan->id_pesanan }}">
                                    <i class="fa fa-trash"></i>
                                </button>
                            
                                @elseif ($roleuserlogin == "Admin" )
                                <a href="/Admin/Pesanan/Deliver/Edit/{{$pesanan->id_pesanan}}"
                                    class="btn btn-sm btn-warning"><i class="fa fa-pen"></i></a>
                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModalDelete{{ $pesanan->id_pesanan }}">
                                    <i class="fa fa-trash"></i>
                                </button>
                                @endif
                                
                               
                                
                            </form>
                        </td>
                    </tr>


<!------------------------ Modal Delete----------------------------->
                    <div class="modal fade" id="exampleModalDelete{{ $pesanan->id_pesanan }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-l">
                            <form action="{{ route('folder_pesanandeliver.destroy', $pesanan->id_pesanan) }}" method="POST" class="p-2 border border-2 rounded border-success">
                                @csrf
                                @method('DELETE')
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus Data ({{$pesanan->nama_pelanggan}})</h1>
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
            {{ $pesananku->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection