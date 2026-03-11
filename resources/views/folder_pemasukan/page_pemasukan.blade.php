@extends("layouts.app")
 
@section("content")
<div class="mt-1 mb-5 card bg-body-tertiary">
   
    <div class="bg-white card-header">
        <h4><i class="fa fa-database"></i> Daftar Pemasukan</h4>
    </div>
    
    <div class="card-body">
 
        @session("success")
        <div class="alert alert-success">{{ $value }}</div>
        @endsession
        @if ($roleuserlogin == "Super Admin" )
            <a href="/SuperAdmin/Pemasukan/Tambah" class="mb-3 btn btn-success btn-sm"> <i class="fa fa-plus"></i> Tambah Pemasukan</a>
        
        @elseif ($roleuserlogin == "Admin" )
            <a href="/Admin/Pemasukan/Tambah" class="mb-3 btn btn-success btn-sm"> <i class="fa fa-plus"></i> Tambah Pemasukan</a>
        @endif

        @if ($roleuserlogin == "Super Admin" )
        <form method="GET" action="/SuperAdmin/Pemasukan/Search" class="mb-2 row">
        @elseif ($roleuserlogin == "Admin" )
        <form method="GET" action="/Admin/Pemasukan/Search" class="mb-2 row">
        @else
        <form method="GET" action="/Pemasukan/Search" class="mb-2 row">
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
                        <th scope="col">Pelanggan</th>
                        <th scope="col">Produk</th>
                        <th scope="col">Total Order</th>
                        <th scope="col">Total Qty</th>
                        <th scope="col">Total Harga</th>
                        <th scope="col">Tanggal</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pemasukanku as $pemasukan)
                    <tr>
                        <td class="textsize9">{{ $pemasukanku->firstItem() + $loop->index }}</td>
                       
                        <td class=" textsize9">{{ $pemasukan->nama_pelanggan }}</td>
                        <td class=" textsize9">{{ $pemasukan->nama_produk }}</td>
                        <td class=" textsize9">{{ $pemasukan->total_order }}</td>
                        <td class=" textsize9">{{ $pemasukan->total_qty }}</td>
                        <td class="textsize9">
                            Rp {{ number_format($pemasukan->total_harga, 0, ',', '.') }}
                        </td>
                        <td class=" textsize9">{{ \Carbon\Carbon::parse($pemasukan->tanggal)->translatedFormat('d F Y') }}</td>
                        <td style="
                            color: {{ 
                                $pemasukan->status === 'Dropsit' ? '#c97204' : '#0ea314'
                            }};
                        ">
                            {{ $pemasukan->status }}
                        </td>
                        
                    </tr>

                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="d-flex custom-pagination justify-content-end">
            {{ $pemasukanku->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection