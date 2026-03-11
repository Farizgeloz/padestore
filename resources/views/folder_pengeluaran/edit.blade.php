
@extends("layouts.app")
 
@section("content")
<div class="card mb-5 bg-body-tertiary">
    <div class="card-header  bg-white">
        <h4>Form Edit Pengeluaran</h4>
    </div>
    <div class="card-body">
        @if ($roleuserlogin == "Super Admin" )
        <a href="/SuperAdmin/Pengeluaran" class="btn btn-info btn-sm mb-3"><i class="fa fa-arrow-left"></i> Back</a>
        
        <form action="/SuperAdmin/Pengeluaran/Update/{{$pengeluaranku->id_pengeluaran}}" method="POST"  enctype="multipart/form-data" class="row border  border-2 border-success rounded p-2"
            enctype="multipart/form-data">
    
        @elseif ($roleuserlogin == "Admin" )
        <a href="/Admin/Pengeluaran" class="btn btn-info btn-sm mb-3"><i class="fa fa-arrow-left"></i> Back</a>
        
        <form action="/Admin/Pengeluaran/Update/{{$pengeluaranku->id_pengeluaran}}" method="POST"  enctype="multipart/form-data" class="row border  border-2 border-success rounded p-2"
            enctype="multipart/form-data">
        @endif
        
            @csrf
            @method('PUT')

            <div class="col-md-4">
                <div class="row">
                    <div class="form-group mb-2  col-md-12">
                        <label class="font-weight-bold text-success">Nama Pengeluaran</label>
                        <input type="text" class="form-control m-1 @error('nama_pengeluaran') is-invalid @enderror"  placeholder="Nama Pengeluaran"
                            name="nama_pengeluaran" value="{{ old('nama_pengeluaran', $pengeluaranku->nama_pengeluaran) }}" id="">
                        <!-- tampilkan pesan error -->
                        @error('nama_pengeluaran')
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
                        <label class="font-weight-bold text-success">Nominal</label>
                        <div class="position-relative m-1">
                            <span style="position:absolute; left:10px; top:50%; transform:translateY(-50%); color:gray;">Rp</span>
                            <input 
                                type="text" 
                                inputmode="numeric"
                                class="form-control ps-5 @error('nominal') is-invalid @enderror"  
                                placeholder="Nominal"
                                name="nominal" 
                                id="nominal"
                                value="{{ old('nominal', number_format($pengeluaranku->nominal ?? 0, 0, ',', '.')) }}">
                        </div>
                        <!-- tampilkan pesan error -->
                        @error('nominal')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                </div>
            </div>
            
            <div class="col-md-2">
                <div class="row">
                    <div class="form-group mb-2  col-md-12">
                        <label class="font-weight-bold text-success">Validasi</label>
                        <select class="form-select form-select-l m-1 @error('status') is-invalid @enderror" aria-label="Small select example"  name="validasi" id="">
                            <option  value="{{ old('validasi', $pengeluaranku->validasi) }}">{{ old('validasi', $pengeluaranku->validasi) }}</option>
                            
                                <option value="Belum Valid">Belum Valid</option>
                                <option value="Valid">Valid</option>
                           
                           
                        </select>
                        <!-- tampilkan pesan error -->
                        @error('validasi')
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
                        <label class="font-weight-bold text-success">Tanggal</label>
                        <input type="date" class="form-control m-1 @error('tanggal') is-invalid @enderror"  placeholder="Tanggal"
                            name="tanggal" value="{{ old('tanggal', $pengeluaranku->tanggal) }}" id="">
                        <!-- tampilkan pesan error -->
                        @error('tanggal')
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
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const nominalInput = document.getElementById('nominal');

    nominalInput.addEventListener('input', function (e) {
        // Hilangkan semua karakter non-digit
        let value = this.value.replace(/\D/g, '');

        // Format pakai titik ribuan (locale Indonesia)
        value = new Intl.NumberFormat('id-ID').format(value);

        // Set ulang ke input
        this.value = value;
    });

    // Sebelum form disubmit, hapus titik supaya dikirim sebagai angka murni
    const form = nominalInput.closest('form');
    if (form) {
        form.addEventListener('submit', function() {
            nominalInput.value = nominalInput.value.replace(/\D/g, '');
        });
    }
});
</script>

@endsection