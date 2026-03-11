@extends("layouts.app")
 
@section("content")
<div class="mt-1 mb-5 card bg-body-tertiary">
   
    <div class="bg-white card-header">
        <h4><i class="fa fa-database"></i> Pesanan Selesai</h4>
    </div>
    
    <div class="card-body">
 
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
       
        @if ($roleuserlogin == "Super Admin" )
        <form method="GET" action="/SuperAdmin/Pesanan/Selesai/Search" class="mb-2 row">
        @elseif ($roleuserlogin == "Admin" )
        <form method="GET" action="/Admin/Pesanan/Selesai/Search" class="mb-2 row">
        @else
        <form method="GET" action="/Pesanan/Selesai/Search" class="mb-2 row">
        @endif
        
            <div class="input-group row" style="margin-right:5px;">
                <div class="form-outline col-md-10 col-9" data-mdb-input-init>
                    <input class="border border-2 form-control" name="search" placeholder="Pencarian Data..." value="{{ request()->input('search') ? request()->input('search') : '' }}">
                </div>
                <button type="submit" class="rounded btn btn-primary col-md-2 col-3">Cari</button>
            </div>
        </form>
        <div class="table-responsive">
            <form action="{{ route('folder_pesanan_selesai.update_multiple') }}" method="POST">
                @csrf
                @method('PUT')

                <table class="table table-striped table-bordered" style="width:100%">
                    <thead class="text-white bg-success textsize9">
                        <tr>
                            <th width="30px" class="text-center">
                                <input type="checkbox" id="select-all" />
                            </th>
                            <th scope="col" width="50px">No</th>
                            <th scope="col">Pelanggan</th>
                            <th scope="col">Produk</th>
                            <th scope="col">Qty</th>
                            <th scope="col">Harga Satuan</th>
                            <th scope="col">Jumlah Bayar</th>
                            <th scope="col">Status</th>
                            <th scope="col">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pesananku as $pesanan)
                        <tr>
                            <td class="text-center">
                                <input type="checkbox" name="selected_id[]" value="{{ $pesanan->id_pesanan }}" class="row-checkbox" />
                            </td>
                            <td class=" textsize9">{{ $loop->iteration }}</td>
                            <td class=" textsize9">{{ $pesanan->nama_pelanggan }}</td>
                            <td class=" textsize9">{{ $pesanan->nama_produk }}</td>
                            <td class=" textsize9">{{ $pesanan->qty }}</td>
                            <td>{{ $pesanan->harga_rupiah }}</td>
                            <td>{{ $pesanan->harga_akumulasi_rupiah }}</td>
                            <td style="
                                background-color: {{ 
                                    $pesanan->status === 'PickedUp' ? '#a3730e' :'transparent'
                                }};
                                color: {{ 
                                    $pesanan->status === 'PickedUp' ? '#fff' : '#999'
                                }};
                            ">
                                {{ $pesanan->status }}
                            </td>
                            <td class=" textsize9">{{ \Carbon\Carbon::parse($pesanan->tanggal)->translatedFormat('d F Y') }}</td>
                            
                        </tr>

                        @endforeach
                    </tbody>
                </table>

                <div class="mt-3">
                    <select name="status_update" class="form-select w-auto d-inline-block">
                        <option value="">-- Ubah Status ke --</option>
                        <option value="Deliver">Deliver</option>
                        <option value="Selesai">Selesai</option>
                    </select>
                    <button type="submit" class="btn btn-success btn-sm">
                        <i class="fa fa-save"></i> Update Terpilih
                    </button>
                </div>
            </form>
            {{-- Checkbox select all script --}}
            <script>
                document.getElementById('select-all').addEventListener('change', function() {
                    const checkboxes = document.querySelectorAll('.row-checkbox');
                    checkboxes.forEach(cb => cb.checked = this.checked);
                });
            </script>
        </div>
        <div class="d-flex custom-pagination justify-content-end">
            {{ $pesananku->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection