<div>
    <!-- Simplicity is the consequence of refined emotions. - Jean D'Alembert -->
</div>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Data Barang</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; }
        h1 { font-size: 18px; margin-bottom: 16px; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #444; padding: 6px; text-align: left; }
        th { background: #eee; }
        .number { text-align: right; }
    </style>
</head>
<body>
    <h1>Data Barang</h1>
    <table>
        <thead>
            <tr>
                <th>Kategori</th>
                <th>Nama Barang</th>
                <th>Harga</th>
                <th>Stok</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($barangs as $barang)
                <tr>
                    <td>{{ $barang->kategori->nama_kategori }}</td>
                    <td>{{ $barang->nama_barang }}</td>
                    <td class="number">{{ number_format((float) $barang->harga, 2, ',', '.') }}</td>
                    <td class="number">{{ $barang->stok }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">Tidak ada data barang.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
