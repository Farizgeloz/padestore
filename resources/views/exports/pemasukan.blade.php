<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Pelanggan</th>
            <th>Total Kotak</th>
            <th>Total Harga</th>
            <th>Tanggal</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($pemasukanku as $pemasukan)
            <tr>
                <td>{{ $pemasukanku->firstItem() + $loop->index }}</td>
                <td>{{ $pemasukan->nama_pelanggan }}</td>
                <td>{{ $pemasukan->total_kotak }}</td>
                <td>Rp {{ number_format($pemasukan->total_harga, 0, ',', '.') }}</td>
                <td>{{ \Carbon\Carbon::parse($pemasukan->updated_at)->translatedFormat('d F Y') }}</td>
                <td>{{ $pemasukan->status }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
