
@extends("layouts.app")
 
@section("content")
<div class="card mb-5 bg-body-tertiary">
    <div class="card-header  bg-white">
        <h4>Form Edit Pesanan</h4>
    </div>
    <div class="card-body">
        @if ($roleuserlogin == "Super Admin" )
        <a href="/SuperAdmin/DropPesanan" class="btn btn-info btn-sm mb-3"><i class="fa fa-arrow-left"></i> Back</a>
        
        <form action="/SuperAdmin/DropPesanan/Update/{{$pesananku->id_pesanan}}" method="POST"  enctype="multipart/form-data" class="row border  border-2 border-success rounded p-2">
    
        @elseif ($roleuserlogin == "Admin" )
        <a href="/Admin/Kotak" class="btn btn-info btn-sm mb-3"><i class="fa fa-arrow-left"></i> Back</a>
        
        <form action="/Admin/DropPesanan/Update/{{$pesananku->id_pesanan}}" method="POST"  enctype="multipart/form-data" class="row border  border-2 border-success rounded p-2">
        @endif
        
            @csrf
            @method('PUT')

            <div class="col-md-6">
                <div class="row">
                    
                    <div class="form-group mb-2  col-md-12">
                        <label class="font-weight-bold text-success">Pelanggan</label>
                        <select class="form-select form-select-l m-1 @error('order') is-invalid @enderror" aria-label="Small select example"  name="order" id="">
                            <option  value="{{ old('order', $pesananku->order_id) }}">{{ old('order', $pesananku->nama_pelanggan . ' - ' . $pesananku->nama_produk) }}</option>
                            @foreach($orderku as $order)
                                <option value="{{ $order->id_order }}">{{ $order->nama_pelanggan }} - {{ $order->nama_produk }}</option>
                            @endforeach
                           
                           
                        </select>
                        <!-- tampilkan pesan error -->
                        @error('order')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="form-group mb-2  col-md-12">
                        <label class="font-weight-bold text-success">Harga Satuan</label>
                        <input type="text" class="form-control m-1 @error('harga') is-invalid @enderror"  placeholder="Harga Satuan"
                            name="harga" value="{{ old('harga', $pesananku->harga) }}" id="harga">
                        <!-- tampilkan pesan error -->
                        @error('harga')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="form-group mb-2 col-md-12">
                        <label class="font-weight-bold text-success">Harga Akumulasi</label>

                        <!-- Tampilan Rupiah -->
                        <input type="text"
                            class="form-control m-1"
                            id="harga_akumulasi_display"
                            readonly>

                        <!-- Nilai asli angka -->
                        <input type="hidden"
                            name="harga_akumulasi"
                            id="harga_akumulasi">
                    </div>
                    
                    
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="form-group mb-2  col-md-12">
                        <label class="font-weight-bold text-success">Qty</label>
                        <input type="number" class="form-control m-1 @error('qty') is-invalid @enderror"  placeholder="Qty"
                            name="qty" value="{{ old('qty', $pesananku->qty) }}"  id="qty" min="1">
                        <!-- tampilkan pesan error -->
                        @error('qty')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="form-group mb-2  col-md-12">
                        <label class="font-weight-bold text-success">Sisa Pesanan</label>
                        <input type="number" class="form-control m-1 @error('sisa_pesanan') is-invalid @enderror"  placeholder="Sisa Pesanan"
                            name="sisa_pesanan" value="{{ old('sisa_pesanan', $pesananku->sisa_pesanan) }}" id="sisa_pesanan" min="0">
                        <!-- tampilkan pesan error -->
                        @error('sisa_pesanan')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    
                </div>
            </div>
            <div class="col-md-3">
                <div class="row">
                    <div class="form-group mb-2  col-md-12">
                        <label class="font-weight-bold">Status</label>
                        
                        <select 
                            class="form-select form-select-lg @error('status') is-invalid @enderror" 
                            aria-label="Small select example"  
                            name="status" 
                            id="">
                            
                            <option  value="{{ old('status', $pesananku->status) }}">{{ old('status', $pesananku->status) }}</option>
                            <option value="Deliver">Deliver</option>
                            <option value="Selesai">Selesai</option>
                        </select>
                        <!-- tampilkan pesan error -->
                        @error('status')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    
                </div>
            </div>
            
            <div class="col-md-12 d-flex flex-row-reverse">
                <button type="submit" class="btn btn-md btn-success me-3">Update</button>
                <button type="reset" class="btn btn-md btn-secondary me-3">Reset</button>
             </div>
        </form>
       <script>
            document.addEventListener("DOMContentLoaded", function () {

                let totalAwal = {{ $pesananku->sisa_pesanan + $pesananku->qty }};

                const hargaInput = document.getElementById("harga");
                const qtyInput = document.getElementById("qty");
                const akumulasiDisplay = document.getElementById("harga_akumulasi_display");
                const akumulasiHidden = document.getElementById("harga_akumulasi");
                const sisaInput = document.getElementById("sisa_pesanan");

                function formatRupiah(angka) {
                    return new Intl.NumberFormat("id-ID", {
                        style: "currency",
                        currency: "IDR",
                        minimumFractionDigits: 0
                    }).format(angka);
                }

                function getAngka(value) {
                    return parseInt(value.replace(/[^0-9]/g, "")) || 0;
                }

                function hitungSemua() {
                    let harga = getAngka(hargaInput.value);
                    let qty = parseInt(qtyInput.value) || 0;

                    if (qty < 0) qty = 0;
                    if (qty > totalAwal) qty = totalAwal;

                    qtyInput.value = qty;

                    let totalHarga = harga * qty;
                    let sisa = totalAwal - qty;

                    if (sisa < 0) sisa = 0;

                    // Tampilkan rupiah
                    akumulasiDisplay.value = formatRupiah(totalHarga);

                    // Simpan angka asli
                    akumulasiHidden.value = totalHarga;

                    sisaInput.value = sisa;
                }

                // Format harga saat diketik
                hargaInput.addEventListener("input", function () {
                    let angka = getAngka(this.value);
                    this.value = formatRupiah(angka);
                    hitungSemua();
                });

                qtyInput.addEventListener("input", hitungSemua);

                document.querySelector("form").addEventListener("submit", function () {
                    hargaInput.value = getAngka(hargaInput.value);
                });

                // Format saat load pertama
                let hargaAwal = getAngka(hargaInput.value);
                hargaInput.value = formatRupiah(hargaAwal);

                hitungSemua();
            });
        </script>

    </div>
</div>
@endsection