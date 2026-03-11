<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Pengeluaran</th>
            <th>Nominal</th>
            <th>Tanggal</th>
            <th>Validasi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($pengeluaranku as $pengeluaran)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $pengeluaran->nama_pengeluaran }}</td>
                <td>Rp {{ number_format($pengeluaran->nominal, 0, ',', '.') }}</td>
                <td>{{ \Carbon\Carbon::parse($pengeluaran->tanggal)->translatedFormat('d F Y') }}</td>
                <td>{{ $pengeluaran->validasi }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
