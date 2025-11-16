<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Pembayaran</title>
    <style>
        body { font-family: 'Arial', sans-serif; margin: 40px; }
        h2, h3 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table, th, td { border: 1px solid #000; }
        th, td { padding: 8px; text-align: left; }
        .total { text-align: right; font-weight: bold; }
        .info p { margin: 2px 0; }
        .footer { margin-top: 30px; text-align: right; font-style: italic; }
        @media print { .no-print { display: none; } }
    </style>
</head>
<body>

    <div class="no-print" style="text-align:right;">
        <button onclick="window.print()">🖨️ Cetak Sekarang</button>
    </div>

    <h2>Klinik Gigi ToothArts</h2>
    <h3>Rincian Pembayaran</h3>

    <div class="info">
        <p><strong>Nama Pasien:</strong> {{ $pembayaran->rekamMedis->pasien->nama }}</p>
        <p><strong>Nama Dokter:</strong> {{ $pembayaran->rekamMedis->dokter->nama ?? '-' }}</p>
        <p><strong>SIP:</strong> {{ $pembayaran->rekamMedis->dokter->sip ?? '-' }}</p>
        <p><strong>STR:</strong> {{ $pembayaran->rekamMedis->dokter->str ?? '-' }}</p>
        <p><strong>Tanggal Pembayaran:</strong> {{ \Carbon\Carbon::parse($pembayaran->tanggal_pembayaran)->format('d-m-Y') }}</p>
        <p><strong>Metode Pembayaran:</strong> {{ ucfirst($pembayaran->metode_pembayaran) }}</p>
        <p><strong>Catatan Pasien:</strong> {{ ucfirst($catatan_pasien) }}</p>

</p>
    </div>

    <h4>Rincian Item & Perawatan</h4>
    <table>
        <thead>
            <tr>
                <th>Deskripsi</th>
                <th>Jumlah</th>
                <th>Harga Satuan</th>
                <th>Diskon</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pembayaran->details as $detail)
                <tr>
                    <td>{{ $detail->deskripsi }}</td>
                    <td>{{ $detail->jumlah }}</td>
                    <td>Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                    <td>{{ $detail->diskon ?? 0 }}%</td>
                    <td>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p class="total">Total Pembayaran: Rp {{ number_format($pembayaran->total_bayar, 0, ',', '.') }}</p>

    <div class="footer">
        <p>Dicetak pada {{ \Carbon\Carbon::now('Asia/Jakarta')->format('d/m/Y H:i') }} WIB</p>
    </div>

</body>
</html>
