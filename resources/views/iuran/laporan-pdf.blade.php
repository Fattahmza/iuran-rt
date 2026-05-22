<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Iuran Desa</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            padding: 20px;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #0a4d6e;
            padding-bottom: 15px;
        }
        .header h1 {
            color: #0a4d6e;
            margin: 0;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0 0;
            color: #666;
        }
        .stats {
            margin-bottom: 20px;
            overflow: hidden;
        }
        .stat-box {
            float: left;
            width: 33%;
            background: #f5f5f5;
            padding: 10px;
            text-align: center;
            border-radius: 5px;
            box-sizing: border-box;
        }
        .stat-box h3 {
            margin: 0;
            color: #0a4d6e;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background: #0a4d6e;
            color: white;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 10px;
            color: #666;
        }
        .text-success {
            color: #28a745;
        }
        .text-danger {
            color: #dc3545;
        }
        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN IURAN DESA</h1>
        <p>Dicetak: {{ date('d/m/Y H:i:s') }}</p>
    </div>

    <div class="stats">
        <div class="stat-box">
            <h3>Rp {{ number_format($totalPemasukan ?? 0, 0, ',', '.') }}</h3>
            <p>Total Pemasukan</p>
        </div>
        <div class="stat-box">
            <h3>Rp {{ number_format($totalPengeluaran ?? 0, 0, ',', '.') }}</h3>
            <p>Total Pengeluaran</p>
        </div>
        <div class="stat-box">
            <h3>Rp {{ number_format($saldoAkhir ?? 0, 0, ',', '.') }}</h3>
            <p>Saldo Akhir</p>
        </div>
    </div>

    <h3>📊 Pemasukan per Bulan</h3>
    <table>
        <thead>
            <tr>
                <th>Bulan</th>
                <th>Tahun</th>
                <th>Jumlah Transaksi</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @forelse($iuranPerBulan ?? [] as $item)
            <tr>
                <td>{{ $item->bulan }}</td>
                <td>{{ $item->tahun }}</td>
                <td>{{ $item->count }} transaksi</p>
                <td class="text-success">Rp {{ number_format($item->total, 0, ',', '.') }}</p>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center">Belum ada data pemasukan</p>
            </tr>
            @endforelse
        </tbody>
    </table>

    <h3>📊 Pengeluaran per Bulan</h3>
    <table>
        <thead>
            <tr>
                <th>Bulan</th>
                <th>Tahun</th>
                <th>Keterangan</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pengeluaranPerBulan ?? [] as $item)
            <tr>
                <td>{{ $item->bulan }}</td>
                <td>{{ $item->tahun }}</td>
                <td>{{ $item->keterangan ?? '-' }}</td>
                <td class="text-danger">Rp {{ number_format($item->total, 0, ',', '.') }}</p>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center">Belum ada data pengeluaran</p>
            </tr>
            @endforelse
        </tbody>
    </table>

    <h3>🏆 Top 10 Warga Pembayar</h3>
    <table>
        <thead>
            <tr>
                <th>Rank</th>
                <th>Nama Warga</th>
                <th>Total Bayar</th>
            </tr>
        </thead>
        <tbody>
            @forelse($topWarga ?? [] as $index => $warga)
            <tr>
                <td>{{ $index + 1 }}</p>
                <td>{{ $warga->user->name ?? 'Unknown' }}</p>
                <td class="text-success">Rp {{ number_format($warga->total ?? 0, 0, ',', '.') }}</p>
            </tr>
            @empty
            <tr>
                <td colspan="3" class="text-center">Belum ada data</p>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Laporan ini dibuat oleh Sistem Iuran Desa</p>
        <p>&copy; {{ date('Y') }} Iuran Desa - All Rights Reserved</p>
    </div>
</body>
</html>
