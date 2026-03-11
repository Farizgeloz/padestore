@extends("layouts.app")
 
@section("content")
<div class="card mt-10 mb-5 bg-body-tertiary">
    <div class="card-header  bg-white">
        <h5>Form Tambah Pesanan Pengiriman</h5>
    </div>
    <div class="card-body">
        @if ($roleuserlogin == "Super Admin" )
        <a href="/SuperAdmin/PesananDeilver" class="btn btn-info btn-sm mb-2 text-light"><i class="fa fa-arrow-left"></i> Kembali</a>
    
        @elseif ($roleuserlogin == "Admin" )
        <a href="/Admin/PesananDeilver" class="btn btn-info btn-sm mb-2 text-light"><i class="fa fa-arrow-left"></i> Kembali</a>
        @endif
       
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <form action="{{ route('folder_pesanan_deliver.store') }}" method="post" enctype="multipart/form-data" class="row border  border-2 border-success rounded p-2">
            @csrf
            
            {{-- <div class="col-md-6">
                <div class="row">
                    <div class="form-group mb-2  col-md-12">
                        <label class="font-weight-bold text-success">Jenis</label>
                        <select class="form-select form-select-l m-1 @error('jenis') is-invalid @enderror" aria-label="Small select example"  name="jenis" id="">
                            <option  value="">Pilih Jenis</option>
                            <option value="Tahu Besar">Tahu Besar</option>
                            <option value="Tahu Kecil">Tahu Kecil</option>
                            <option value="Tahu Timur">Tahu Timur</option>
                        </select>
                        <!-- tampilkan pesan error -->
                        @error('jenis')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    
                </div>
            </div> --}}
            
            
            <div class="col-md-6">
                <div class="row">
                    <div class="form-group mb-2  col-md-12">
                        <label class="font-weight-bold text-success">Jenis</label>
                        <select class="form-select form-select-l m-1 @error('jenis') is-invalid @enderror" aria-label="Small select example"  name="jenis" id="">
                            <option  value="">Pilih Jenis</option>
                            <option value="Tahu Besar">Tahu Besar</option>
                            <option value="Tahu Kecil">Tahu Kecil</option>
                            <option value="Tahu Timur">Tahu Timur</option>
                        </select>
                        <!-- tampilkan pesan error -->
                        @error('jenis')
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
                        <label class="font-weight-bold text-success">Pengantar</label>
                        <select class="form-select form-select-l m-1 @error('pengantar') is-invalid @enderror" aria-label="Small select example"  name="pengantar" id="">
                            <option  value="">Pilih Pengantar</option>
                            @foreach($pengantarku as $pengantar)
                                <option value="{{ $pengantar->id}}">{{ $pengantar->akun }}</option>
                            @endforeach
                           
                           
                        </select>
                        <!-- tampilkan pesan error -->
                        @error('pengantar')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    
                </div>
            </div>
            <div class="col-md-12">
                <div class="row">
                    <div class="form-group mb-2  col-md-12">
                        <label class="font-weight-bold text-success">Nomor Kotak</label>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($kotakku as $kotak)
                                <div class="form-check form-check-inline m-2 align-items-center">
                                    <input 
                                        class="form-check-input me-1 {{ $kotak->status === 'Keluar' ? 'border-danger bg-danger-subtle' : 'border-success bg-success-subtle' }}"
                                        type="checkbox"
                                        name="kotak[]"
                                        id="kotak_{{ $kotak->id_kotak }}"
                                        value="{{ $kotak->id_kotak }}"
                                        style="width: 22px; height: 22px; cursor: pointer;"
                                        {{ $kotak->status === 'Keluar' ? 'disabled' : '' }}>

                                    <label 
                                        class="form-check-label fw-semibold {{ $kotak->status === 'Keluar' ? 'text-danger' : 'text-dark' }}" 
                                        for="kotak_{{ $kotak->id_kotak }}"
                                        style="font-size: 1.1rem; cursor: pointer;"
                                        @if($kotak->status === 'Keluar')
                                            data-bs-toggle="tooltip"
                                            data-bs-placement="top"
                                            title="Kotak ini sedang di luar (tidak tersedia)"
                                        @endif
                                    >
                                        {{ $kotak->nomor_kotak }}
                                    </label>
                                </div>
                            @endforeach




                        </div>

                        <!-- tampilkan pesan error -->
                        @error('kotak')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    
                </div>
            </div>
            
            
            
            
                   
            <div class="col-md-12 d-flex flex-row-reverse">
             <button type="submit" class="btn btn-md btn-success me-3">SIMPAN</button>
                <button type="reset" class="btn btn-md btn-secondary me-3">CLEAR</button>
            </div>
            
           
        </form>
    </div>
</div>
@endsection