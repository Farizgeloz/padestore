
@extends("layouts.app")
 
@section("content")
<div class="card mt-5">
    <div class="card-header">
        <h4>Product Show</h4>
    </div>
    <div class="card-body">
        <a href="{{ route('folder_biolist.index') }}" class="btn btn-info btn-sm mb-3"><i class="fa fa-arrow-left"></i> Back</a>
 
        <div class="mt-4">
            <p><strong>Name:</strong> {{ $anggotalist->nama_lengkap }}</p>
            <p><strong>Detail:</strong> {{ $anggotalist->deskripsi }}</p>
        </div>
    </div>
</div>
@endsection