
@extends("layouts.app")
 
@section("content")
<div class="card mb-5 bg-body-tertiary">
    <div class="card-header  bg-white">
        <h4>Form Edit Pesanan Pengiriman</h4>
    </div>
    <div class="card-body">
        @if ($roleuserlogin == "Super Admin" )
        <a href="/SuperAdmin/Pesanan/Deliver" class="btn btn-info btn-l mb-3 text-white"><i class="fa fa-arrow-left"></i> Kembali</a>
        
        <form action="/SuperAdmin/Pesanan/Deliver/Update/{{$pesananku->id_pesanan}}" method="POST"  enctype="multipart/form-data" class="row border  border-2 border-success bg-success-subtle rounded p-2"
            enctype="multipart/form-data">
    
        @elseif ($roleuserlogin == "Admin" )
        <a href="/Admin/Kotak" class="btn btn-info btn-l mb-3 text-white"><i class="fa fa-arrow-left"></i> Kembali</a>
        
        <form action="/Admin/Pesanan/Deliver/Update/{{$pesananku->id_pesanan}}" method="POST"  enctype="multipart/form-data" class="row border  border-2 border-success bg-success-subtle rounded p-2"
            enctype="multipart/form-data">
        @endif
        
            @csrf
            @method('PUT')

            <div class="col-md-3">
                <div class="row">
                    <div class="form-group mb-2  col-md-12">
                        <label class="font-weight-bold">Pelanggan</label>
                        <input type="hidden" class="form-control form-control-lg m-1 @error('pelanggan') is-invalid @enderror"  placeholder="Nama Pelanggan"
                            name="pelangganold" value="{{ old('pelanggan', $pesananku->pelanggan) }}" id="">
                        
                        <select 
                            class="form-select form-select-lg @error('pelanggan') is-invalid @enderror" 
                            aria-label="Small select example"  
                            name="pelanggan" 
                            id=""
                        >
                            <option  value="{{ old('pelanggan', $pesananku->pelanggan) }}">{{ old('pelanggan', $pesananku->nama_pelanggan) }}</option>
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
            <div class="col-md-3">
                <div class="row">
                    <div class="form-group mb-2  col-md-12">
                        <label class="font-weight-bold">Jenis</label>
                        <select 
                            class="form-select form-select-lg @error('jenis') is-invalid @enderror" 
                            name="jenis" 
                            id="jenis"
                        >
                            {{-- Opsi default dari data lama --}}
                            <option value="{{ old('jenis', $pesananku->jenis) }}" selected hidden>
                                {{ old('jenis', $pesananku->jenis) ?? 'Pilih jenis tahu...' }}
                            </option>

                            {{-- Pilihan tetap --}}
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
            <div class="col-md-3">
                <div class="row">
                    <div class="form-group mb-2  col-md-12">
                        <label class="font-weight-bold">Status</label>
                        <input type="hidden" class="form-control form-control-lg m-1 @error('status') is-invalid @enderror"  placeholder="Status"
                            name="statusold" value="{{ old('status', $pesananku->status) }}" id="">
                        <select 
                            class="form-select form-select-lg @error('status') is-invalid @enderror" 
                            aria-label="Small select example"  
                            name="status" 
                            id="">
                            
                            <option  value="{{ old('status', $pesananku->status) }}">{{ old('status', $pesananku->status) }}</option>
                            <option value="Dropsit">Dropsit</option>
                            <option value="Deliver">Deliver</option>
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
            <div class="col-md-10">
                <div class="row">
                    <div class="form-group mb-2  col-md-12">
                        <label class="font-weight-bold">Nomor Kotak</label>
                        <input type="hidden" class="form-control form-control-lg m-1 @error('kotak') is-invalid @enderror"  placeholder="kotak"
                            name="kotakold" value="{{ old('kotak', $pesananku->kotak) }}" id="">
                        <div class="m-1">
                            <div class="d-flex flex-wrap gap-3">
                                @foreach($kotakku as $kotak)
                                    @php
                                        $isSelected = old('kotak', $pesananku->kotak) == $kotak->id_kotak;
                                        $isKeluar = $kotak->status === 'Keluar';
                                    @endphp

                                    <div class="form-check form-check-inline m-2 align-items-center  border  border-2 {{ $isKeluar ? 'border-danger' : 'border-success' }} rounded">
                                        <input 
                                            class="form-check-input me-1 {{ $isKeluar ? 'border-danger bg-danger' : 'border-success bg-success' }}"
                                            type="radio" 
                                            name="kotak" 
                                            id="kotak_{{ $kotak->id_kotak }}" 
                                            value="{{ $kotak->id_kotak }}"
                                            {{ $isSelected ? 'checked' : '' }}
                                            style="width: 22px; height: 22px; cursor: pointer; margin-top: 2px;"
                                            {{-- ❌ hanya disable kalau “Keluar” DAN bukan kotak yang sedang dipilih --}}
                                            {{ $isKeluar && !$isSelected ? 'disabled' : '' }}
                                        >

                                        <label 
                                            class="form-check-label px-1 fw-semibold {{ $isKeluar ? 'text-danger' : 'text-dark' }}" 
                                            for="kotak_{{ $kotak->id_kotak }}"
                                            style="font-size: 1.1rem; cursor: pointer;"
                                            @if($isKeluar && !$isSelected)
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

                            @error('kotak')
                                <div class="invalid-feedback d-block mt-1">
                                    {{ $message }}
                                </div>
                            @enderror


                        </div>
                    </div>
                </div>
            </div>
            
            
            <div class="col-md-12 d-flex flex-row-reverse">
                <button type="submit" class="btn btn-l btn-success me-3 mt-3">UPDATE</button>
                <button type="reset" class="btn btn-l btn-secondary me-3 mt-3">CLEAR</button>
             </div>
        </form>
    </div>
</div>
@endsection