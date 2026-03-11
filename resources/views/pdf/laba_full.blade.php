<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $judul }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { border-collapse: collapse; width: 100%; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: center; }
        th { background-color: #4CAF50; color: white; }
        .judul { background-color: #E6EE9C; font-weight: bold; text-align: center; padding: 10px; font-size: 16px; }
        .section-title { font-weight: bold; text-align: left; padding: 5px; background-color: #BBDEFB; }
        .total { background-color: #C8E6C9; font-weight: bold; }
    </style>
</head>
<body>
    <div class="judul">{{ $judul }}</div>

    @if($harian->count())
        <div class="section-title">--- PER HARI ---</div>
        <table>
            <thead>
                <tr>
                    <th>Periode</th>
                    <th>Total Pemasukan</th>
                    <th>Total Pengeluaran</th>
                    <th>Laba (Pemasukan - Pengeluaran)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($harian as $row)
                    <tr>
                        <td>{{ $row['periode'] }}</td>
                        <td>{{ number_format($row['total_pemasukan']) }}</td>
                        <td>{{ number_format($row['total_pengeluaran']) }}</td>
                        <td>{{ number_format($row['laba']) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    @if($bulanan->count())
        <div class="section-title">--- PER BULAN ---</div>
        <table>
            <thead>
                <tr>
                    <th>Periode</th>
                    <th>Total Pemasukan</th>
                    <th>Total Pengeluaran</th>
                    <th>Laba (Pemasukan - Pengeluaran)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bulanan as $row)
                    <tr>
                        <td>{{ $row['periode'] }}</td>
                        <td>{{ number_format($row['total_pemasukan']) }}</td>
                        <td>{{ number_format($row['total_pengeluaran']) }}</td>
                        <td>{{ number_format($row['laba']) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    @if($tahunan->count())
        <div class="section-title">--- PER TAHUN ---</div>
        <table>
            <thead>
                <tr>
                    <th>Periode</th>
                    <th>Total Pemasukan</th>
                    <th>Total Pengeluaran</th>
                    <th>Laba (Pemasukan - Pengeluaran)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tahunan as $row)
                    <tr>
                        <td>{{ $row['periode'] }}</td>
                        <td>{{ number_format($row['total_pemasukan']) }}</td>
                        <td>{{ number_format($row['total_pengeluaran']) }}</td>
                        <td>{{ number_format($row['laba']) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <table>
        <tbody>
            <tr class="total">
                <td>TOTAL KESELURUHAN</td>
                <td>{{ number_format($totalPemasukan) }}</td>
                <td>{{ number_format($totalPengeluaran) }}</td>
                <td>{{ number_format($totalLaba) }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
