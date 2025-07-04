<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Master Bahan Kemas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        h2 {
            text-align: center;
        }
    </style>
</head>
<body>
    <h2>Data Master Bahan Kemas</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kategori Bahan Kemas</th>
                <th>Jenis Bahan Kemas</th>
                <th>Kode Bahan Kemas</th>
                <th>Nama Bahan Kemas</th>
                <th>Satuan</th>
                <th>Cara Penyimpanan</th>
                <th>Harga PO</th>
                <th>PPN</th>
                <th>Additional Cost</th>
                <th>HPBK</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->kategori_kemasan == 1 ? 'Primer' : 'Sekunder' }}</td>
                    <td>{{ $item->jenisKemasan->nama_kode ?? '-' }}</td>
                    <td>{{ $item->kode_kemasan }}</td>
                    <td>{{ $item->nama_kemasan }}</td>
                    <td>{{ $item->satuan }}</td>
                    <td>{{ $item->cara_penyimpanan }}</td>
                    <td>{{ number_format($item->harga_po, 2, ',', '.') }}</td>
                    <td>{{ number_format($item->ppn, 2, ',', '.') }}</td>
                    <td>{{ number_format($item->mark_up, 2, ',', '.') }}</td>
                    <td>{{ number_format($item->hpbk, 2, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
