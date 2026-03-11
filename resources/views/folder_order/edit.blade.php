
@extends("layouts.app")
 
@section("content")
<div class="card mb-5 bg-body-tertiary">
    <div class="card-header  bg-white">
        <h4>Form Edit Order Pelanggan</h4>
    </div>
    <div class="card-body">
        @if ($roleuserlogin == "Super Admin" )
        <a href="/SuperAdmin/Order" class="btn btn-info btn-l mb-3 text-white"><i class="fa fa-arrow-left"></i> Kembali</a>
        
        <form action="/SuperAdmin/Order/Update/{{$orderku->id_order}}" method="POST"  enctype="multipart/form-data" class="row border  border-2 border-success bg-success-subtle rounded p-2"
            enctype="multipart/form-data">
    
        @elseif ($roleuserlogin == "Admin" )
        <a href="/Admin/Order" class="btn btn-info btn-l mb-3 text-white"><i class="fa fa-arrow-left"></i> Kembali</a>
        
        <form action="/Admin/Order/Update/{{$orderku->id_order}}" method="POST"  enctype="multipart/form-data" class="row border  border-2 border-success bg-success-subtle rounded p-2"
            enctype="multipart/form-data">
        @endif
        
            @csrf
            @method('PUT')

            <div class="col-md-5">
                <div class="row">
                    <div class="form-group mb-2  col-md-12">
                        <label class="font-weight-bold">Pelanggan</label>
                        <select class="form-select form-select-lg m-1 @error('pelanggan') is-invalid @enderror" aria-label="Small select example"  name="pelanggan" id="">
                            <option  value="{{ old('pelanggan', $orderku->pelanggan) }}">{{ old('pelanggan', $orderku->nama_pelanggan) }}</option>
                            @foreach($pelangganku as $pelanggan)
                                <option value="{{ $pelanggan->id_pelanggan }}">{{ $pelanggan->nama_pelanggan }}</option>
                            @endforeach
                           
                           
                        </select>
                        <!-- tampilkan pesan error -->
                        @error('pelanggan')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    
                </div>
            </div>
            <div class="col-md-5">
                <div class="row">
                    <div class="form-group mb-2  col-md-12">
                        <label class="font-weight-bold">metode_bayar</label>
                        <select class="form-select form-select-lg m-1 @error('metode_bayar') is-invalid @enderror" aria-label="Small select example"  name="metode_bayar" id="">
                            <option  value="{{ old('metode_bayar', $orderku->metode_bayar) }}">{{ old('metode_bayar', $orderku->metode_bayar) }}</option>
                           
                           <option value="Cash">Cash</option>
                           <option value="Debet">TF</option>
                           
                           
                        </select>
                        <!-- tampilkan pesan error -->
                        @error('metode_bayar')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    
                </div>
            </div>
            <div class="col-md-5">
                <div class="row">
                    <div class="form-group mb-2  col-md-12">
                        <label class="font-weight-bold">Produk</label>
                        <select class="form-select form-select-lg m-1 @error('produk_id') is-invalid @enderror" aria-label="Small select example"  name="produk_id" id="">
                             <option  value="{{ old('produk_id', $orderku->produk_id) }}">{{ old('produk_id', $orderku->nama_produk) }}</option>
                            @foreach($produkku as $produk)
                                <option value="{{ $produk->id_produk }}">{{ $produk->nama_produk }}</option>
                            @endforeach
                           
                           
                        </select>
                        <!-- tampilkan pesan error -->
                        @error('produk_id')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    
                </div>
            </div>
            <div class="col-md-5">
                <div class="row">
                    <div class="form-group mb-2  col-md-12">
                        <label class="font-weight-bold">Jumlah Pesanan</label>
                        <input type="number" class="form-control form-control-lg m-1 @error('jumlah_pesanan') is-invalid @enderror"  placeholder="Jumlah Pesanan"
                            name="jumlah_pesanan" value="{{ old('jumlah_pesanan', $orderku->jumlah_pesanan) }}" id="jumlah_pesanan">
                        <!-- tampilkan pesan error -->
                        @error('jumlah_pesanan')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    
                </div>
            </div>
            <div class="col-md-5">
                <div class="row">
                    <div class="form-group mb-2  col-md-12">
                        <label class="font-weight-bold">Keluar Pesanan</label>
                        <input type="number" class="form-control form-control-lg m-1 @error('keluar_pesanan') is-invalid @enderror"  placeholder="Jumlah Keluar"
                            name="keluar_pesanan" value="{{ old('keluar_pesanan', $orderku->keluar_pesanan) }}" id="keluar_pesanan" readonly>
                        <!-- tampilkan pesan error -->
                        @error('keluar_pesanan')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    
                </div>
            </div>
            <div class="col-md-5">
                <div class="row">
                    <div class="form-group mb-2  col-md-12">
                        <label class="font-weight-bold">Sisa Pesanan</label>
                        <input type="number" class="form-control form-control-lg m-1 @error('sisa_pesanan') is-invalid @enderror"  placeholder="Sisa Pesanan"
                            name="sisa_pesanan" value="{{ old('sisa_pesanan', $orderku->sisa_pesanan) }}" id="sisa_pesanan" readonly>
                        <!-- tampilkan pesan error -->
                        @error('sisa_pesanan')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    
                </div>
            </div>
            
            <div class="col-md-12 d-flex flex-row-reverse">
                <button type="submit" class="btn btn-l btn-success me-3">Update</button>
                <button type="reset" class="btn btn-l btn-secondary me-3">Reset</button>
             </div>
        </form>
        <script>
document.addEventListener("DOMContentLoaded", function () {

    const jumlahInput = document.getElementById("jumlah_pesanan");
    const keluarInput = document.getElementById("keluar_pesanan");
    const sisaInput   = document.getElementById("sisa_pesanan");

    function hitungSisa() {

        let jumlah = parseInt(jumlahInput.value) || 0;
        let keluar = parseInt(keluarInput.value) || 0;

        // Jumlah tidak boleh kurang dari keluar
        if (jumlah < keluar) {
            jumlah = keluar;
            jumlahInput.value = jumlah;
        }

        // Hitung sisa
        let sisa = jumlah - keluar;
        sisaInput.value = sisa;
    }

    // Event
    jumlahInput.addEventListener("input", hitungSisa);
    keluarInput.addEventListener("input", hitungSisa);

    // Hitung awal
    hitungSisa();

});
</script>



    </div>
</div>
@endsection