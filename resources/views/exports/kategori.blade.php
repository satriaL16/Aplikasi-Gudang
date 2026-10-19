<div>
    <!-- I have not failed. I've just found 10,000 ways that won't work. - Thomas Edison -->
</div>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Data Kategori</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; }
        h1 { font-size: 18px; margin-bottom: 16px; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #444; padding: 6px; text-align: left; }
        th { background: #eee; }
    </style>
</head>
<body>
    <h1>Data Kategori</h1>
    <table>
        <thead>
            <tr>
                <th>Nama Kategori</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($kategoris as $kategori)
                <tr>
                    <td>{{ $kategori->nama_kategori }}</td>
                </tr>
            @empty
                <tr>
                    <td>Tidak ada data kategori.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
