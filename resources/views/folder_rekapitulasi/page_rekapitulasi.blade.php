@extends("layouts.app")
 
@section("content")
<div class="mt-1 mb-5 card bg-body-tertiary">
   
    <div class="bg-white card-header">
        <h4><i class="fa fa-database"></i> Daftar Rekapitulasi</h4>
    </div>
    
    <div class="card-body">
 
        @session("success")
        <div class="alert alert-success">{{ $value }}</div>
        @endsession
       
        @if ($roleuserlogin == "Super Admin" )
        <form method="GET" action="/SuperAdmin/Rekapitulasi/Search" class="mb-2 row">
        @elseif ($roleuserlogin == "Admin" )
        <form method="GET" action="/Admin/Rekapitulasi/Search" class="mb-2 row">
        @else
        <form method="GET" action="/Rekapitulasi/Search" class="mb-2 row">
        @endif
            <div class="row">
                <div class="col-md-4 col-10">
                    <div class="input-group row" style="margin-right:5px;">
                        <div class="form-outline col-md-10 col-9" data-mdb-input-init>
                            <p>Jenis Pencarian</p>
                            <select class="form-select form-select-l m-1 @error('status') is-invalid @enderror"
                                    name="search_jenis" id="search_jenis">
                                <option value="">Pilih Jenis Pencarian</option>
                                <option value="Harian" {{ request('search_jenis') == 'Harian' ? 'selected' : '' }}>Harian</option>
                                <option value="Bulanan" {{ request('search_jenis') == 'Bulanan' ? 'selected' : '' }}>Bulanan</option>
                                <option value="Tahunan" {{ request('search_jenis') == 'Tahunan' ? 'selected' : '' }}>Tahunan</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-12">
                    <div class="input-group row" style="margin-right:5px;">
                        <div class="form-outline col-md-10 col-9" data-mdb-input-init>
                            <p>Tanggal / Bulan / Tahun</p>
                            <input type="text" id="search_input" name="search"
                                class="border border-2 form-control"
                                autocomplete="off"
                                placeholder="Pilih tanggal/bulan/tahun"
                                value="{{ request('search') }}">
                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-12">
                    <div class="align-items-end">
                        <div class="input-group">
                            <button type="submit" class="rounded btn btn-primary" style="width:100px;height:40px;">Cari</button>
                        </div>
                        @if(request('search'))
                            <a 
                                href="{{ route('folder_rekapitulasi.page_rekapitulasi') }}" 
                                class="btn btn-secondary"
                                style="width:100px;height:40px;margin-top:5px;"
                            >
                                Reset
                            </a>
                        @endif
                       
                    </div>
                </div>
            </div>

            

        </form>
        <div class="table-responsive">
            <table class="table table-striped table-bordered"  style="width:100%">
                <thead class="text-white bg-success textsize9">
                    <tr>
                        <th scope="col" width="50px">No</th>
                        <th>Tanggal</th>
                        <th>Pemasukan (Rp)</th>
                        <th>Pengeluaran (Rp)</th>
                        <th>Laba (Rp)</th>
                        
                        <th scope="col" style="width: 20%"  class="text-center">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rekapitulasiku as $data)
                        <tr>
                            <td class="textsize9">{{ $rekapitulasiku->firstItem() + $loop->index }}</td>
                        
                            <td>{{ \Carbon\Carbon::parse($data->tanggal)->translatedFormat('d F Y') }}</td>
                            <td>{{ number_format($data->total_pemasukan, 0, ',', '.') }}</td>
                            <td>{{ number_format($data->total_pengeluaran, 0, ',', '.') }}</td>
                            <td class="text-success fw-bold">{{ number_format($data->laba_harian, 0, ',', '.') }}</td>
                            <td class="text-center align-items-center">
                                <!-- dari middleware UserAkses-->
                                    @if($errors->any())
                                        <p class="textsize6 text-danger mb-1">{{$errors->first()}}</p>
                                    @endif
                                    <a href="/SuperAdmin/Rekapitulasi/Detail/{{ $data->tanggal }}" class="textsize6 text-primary mb-1">
                                        <button type="button" class="btn btn-primary btn-sm"  {{-- data-bs-toggle="modal" data-bs-target="#exampleModalDetail{{ $data->tanggal }}" --}}>
                                        <i class="fa fa-eye"></i>
                                        </button>
                                    </a>
                                    
                                
                                    
                                </form>
                            </td>
                            
                        </tr>
                        <!------------------------ Modal Detail----------------------------->
                        <div class="modal fade" id="exampleModalDetail{{ $data->tanggal }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-xl w-100" style="">
                                <div class="p-2 modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Tanggal {{ \Carbon\Carbon::parse($data->tanggal)->translatedFormat('d F Y') }}</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="p-2 border border-2 rounded modal-body border-success">
                                        <div class="p-2 row">
                                            
                                            <div class="col-md-6">
                                                <div class="border rounded row border-1 m-2">
                                                    <div class="col-md-12">
                                                            <p>Total Pemasukan :</p>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <code class="text-secondary">
                                                            <p>{{ number_format($data->total_pemasukan, 0, ',', '.') }}</p>
                                                        </code>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="border rounded row border-1 m-2">
                                                    <div class="col-md-12">
                                                            <p>Total Pengeluaran :</p>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <code class="text-secondary">
                                                            <p>{{ number_format($data->total_pengeluaran, 0, ',', '.') }}</p>
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

                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted textsize9">
                                TIDAK ADA DATA REKAPITULASI
                            </td>
                        </tr>
                    @endforelse
                    {{-- 🔹 Baris Total Keseluruhan --}}
                    <tr class=" bg-success fw-bold text-white">
                        <td colspan="2" class="text-center text-white">TOTAL SEMUA</td>
                        <td class="text-white">{{ number_format($totalKeseluruhan->total_pemasukan, 0, ',', '.') }}</td>
                        <td class="text-white">{{ number_format($totalKeseluruhan->total_pengeluaran, 0, ',', '.') }}</td>
                        <td class="text-white">{{ number_format($totalKeseluruhan->total_laba, 0, ',', '.') }}</td>
                        <td class="text-white"></td>
                        
                        
                    </tr>
                    <tr>
                        <td colspan="2" class="text-center bg-secondary fw-bold text-white">JENIS PENCARIAN</td>
                        <td colspan="1" class="bg-secondary fw-bold text-white">
                            @if ($jenis_pencarian !== '')
                                {{$jenis_pencarian}}
                            @else
                                {{ '-' }}
                            @endif
                        </td>
                        <td class="bg-secondary fw-bold text-white" colspan="2">
                            @if ($jenis_pencarian == 'Harian')
                                {{ \Carbon\Carbon::parse($value_pencarian)->translatedFormat('d F Y') }}
                            @elseif ($jenis_pencarian == 'Bulanan')
                                {{ \Carbon\Carbon::parse($value_pencarian)->translatedFormat('F Y') }}
                            @elseif ($jenis_pencarian == 'Tahunan')
                                {{ \Carbon\Carbon::parse($value_pencarian)->translatedFormat('Y') }}
                            @else
                                {{ '-' }}
                            @endif
                        </td>
                        <td class="bg-secondary text-center align-items-center">
                            <!-- dari middleware UserAkses-->
                                @if (!empty($jenis_pencarian) && !empty($value_pencarian) && $rekapitulasiku->count() > 0)
                                    <a href="/SuperAdmin/Rekapitulasi/Detail/{{ $value_pencarian }}" class="textsize6 text-primary mb-1">
                                        <button type="button" class="btn btn-primary btn-sm"  {{-- data-bs-toggle="modal" data-bs-target="#exampleModalDetail{{ $data->tanggal }}" --}}>
                                        <i class="fa fa-eye"></i>
                                        </button>
                                    </a>
                                @endif 
                               
                                
                            </form>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="d-flex custom-pagination justify-content-end">
            {{ $rekapitulasiku->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/plugins/monthSelect/index.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/plugins/monthSelect/style.css">

<script>
$(document).ready(function() {
    const input = $("#search_input");

    function setDatepicker(type) {
        if (input[0]._flatpickr) input[0]._flatpickr.destroy();

        if (type === "Harian") {
            input.flatpickr({
                dateFormat: "Y-m-d",
                allowInput: true
            });
        } 
        else if (type === "Bulanan") {
            input.flatpickr({
                allowInput: true,
                altInput: true,
                altFormat: "F Y",
                dateFormat: "Y-m",
                plugins: [
                    new monthSelectPlugin({
                        shorthand: true,
                        dateFormat: "Y-m",
                        altFormat: "F Y"
                    })
                ]
            });
        } 
        else if (type === "Tahunan") {
            input.flatpickr({
                allowInput: true,
                altInput: true,
                altFormat: "Y",
                dateFormat: "Y",
                plugins: [
                    new monthSelectPlugin({
                        shorthand: true,
                        dateFormat: "Y",
                        altFormat: "Y"
                    })
                ]
            });
        }
    }

    setDatepicker($("#search_jenis").val());
    $("#search_jenis").on("change", function() {
        input.val("");
        setDatepicker($(this).val());
    });
});
</script>



@endsection