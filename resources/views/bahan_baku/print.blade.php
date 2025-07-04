<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Bahan Baku</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table, th, td {
            border: 1px solid #444;
            padding: 6px;
        }

        th {
            background-color: #eee;
        }

        h2 {
            text-align: center;
        }
    </style>
</head>
<body>
    <h2>Data Master Bahan Baku</h2>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kategori Bahan Baku</th>
                <th>Kode kategori bahan baku</th>
                <th>Nama Bahan Baku</th>
                <th>Nama Coding</th>
                <th>Nama Inci</th>
                <th>Jenis Sediaan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bahanBakus as $index => $bahan)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $bahan->jenisBahanBaku->nama_bahan_baku ?? '-' }}</td>
                <td>{{ $bahan->jenis_bahan_baku_jenis_urut }}</td>
                <td>{{ $bahan->koding_bahan_baku }}</td>
                <td>{{ $bahan->nama_coding }}</td>
                <td>{{ $bahan->nama_inci }}</td>
                <td>{{ $bahan->jenis_sediaan }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
