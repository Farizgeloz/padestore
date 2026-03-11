@extends("layouts.app")
 
@section("content")
<div class="mt-1 mb-5 card bg-body-tertiary">
   
    <div class="bg-white card-header">
        <h4><i class="fa fa-database"></i> Daftar Pengeluaran</h4>
    </div>
    
    <div class="card-body">
 
        @session("success")
        <div class="alert alert-success">{{ $value }}</div>
        @endsession
        @if ($roleuserlogin == "Super Admin" )
            <a href="/SuperAdmin/Pengeluaran/Tambah" class="mb-3 btn btn-success btn-sm"> <i class="fa fa-plus"></i> Tambah Pengeluaran</a>
        
        @elseif ($roleuserlogin == "Admin" )
            <a href="/Admin/Pengeluaran/Tambah" class="mb-3 btn btn-success btn-sm"> <i class="fa fa-plus"></i> Tambah Pengeluaran</a>
        @endif

        @if ($roleuserlogin == "Super Admin" )
        <form method="GET" action="/SuperAdmin/Pengeluaran/Search" class="mb-2 row">
        @elseif ($roleuserlogin == "Admin" )
        <form method="GET" action="/Admin/Pengeluaran/Search" class="mb-2 row">
        @else
        <form method="GET" action="/Pengeluaran/Search" class="mb-2 row">
        @endif
        
            <div class="input-group row" style="margin-right:5px;">
                <div class="form-outline col-md-10 col-9" data-mdb-input-init>
                    <input class="border border-2 form-control" name="search" placeholder="Pencarian Data..." value="{{ request()->input('search') ? request()->input('search') : '' }}">
                </div>
                <button type="submit" class="rounded btn btn-primary col-md-2 col-3">Cari</button>
            </div>
        </form>
        <div class="table-responsive">
            <table class="table table-striped table-bordered"  style="width:100%">
                <thead class="text-white bg-success textsize9">
                    <tr>
                        <th scope="col" width="50px">No</th>
                        <th scope="col">Pengeluaran</th>
                        <th scope="col">Nominal</th>
                        <th scope="col">Tanggal</th>
                        <th scope="col">Validasi</th>
                        <th scope="col" style="width: 20%"  class="text-center">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pengeluaranku as $pengeluaran)
                    <tr>
                        <td class="textsize9">{{ $pengeluaranku->firstItem() + $loop->index }}</td>
                       
                        <td class=" textsize9">{{ $pengeluaran->nama_pengeluaran }}</td>
                        <td class="textsize9">
                            Rp {{ number_format($pengeluaran->nominal, 0, ',', '.') }}
                        </td>
                        <td class=" textsize9">{{ \Carbon\Carbon::parse($pengeluaran->tanggal)->translatedFormat('d F Y') }}</td>
                        <td style="
                            color: {{ 
                                $pengeluaran->validasi === 'Belum Valid' ? '#c97204' : '#0ea314'
                            }};
                        ">
                            {{ $pengeluaran->validasi }}
                        </td>
                        
                        <td class="text-center align-items-center">
                            <!-- dari middleware UserAkses-->
                               
                                @if ($roleuserlogin == "Super Admin" )
                                    @if ($pengeluaran->status !== "Habis")
                                        <a href="/SuperAdmin/Pengeluaran/Edit/{{$pengeluaran->id_pengeluaran}}"
                                            class="btn btn-sm btn-warning"><i class="fa fa-pen"></i></a>
                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModalDelete{{ $pengeluaran->id_pengeluaran }}">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    @endif
                                @elseif ($roleuserlogin == "Admin" )
                                    @if ($pengeluaran->status !== "Habis")
                                        <a href="/Admin/Pengeluaran/{{ $pengeluaran->id_pengeluaran }}/Edit"
                                            class="btn btn-sm btn-warning">
                                            <i class="fa fa-pen"></i>
                                        </a>
                                        <button type="button" class="btn btn-danger btn-sm"
                                            data-bs-toggle="modal"
                                            data-bs-target="#exampleModalDelete{{ $pengeluaran->id_pengeluaran }}">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    @endif
                                @endif
                                
                               
                                
                            </form>
                        </td>
                    </tr>

<!------------------------ Modal Delete----------------------------->
                    <div class="modal fade" id="exampleModalDelete{{ $pengeluaran->id_pengeluaran }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-l">
                            <form action="{{ route('folder_pengeluaran.destroy', $pengeluaran->id_pengeluaran) }}" method="POST" class="p-2 border border-2 rounded border-success">
                                @csrf
                                @method('DELETE')
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus Data ({{$pengeluaran->nama_pengeluaran}})</h1>
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
            {{ $pengeluaranku->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection