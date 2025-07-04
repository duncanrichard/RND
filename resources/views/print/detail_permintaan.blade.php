<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FORMULIR PERMINTAAN</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
        }

        .subtitle {
            text-align: center;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .header {
            position: relative;
            height: 70px;
            margin-bottom: 20px;
        }

        .header img {
            position: absolute;
            left: 0;
            top: 0;
            height: 70px;
        }

        .header-text {
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            transform: translateY(-50%);
            font-size: 20px;
            font-weight: bold;
            text-align: center;
            line-height: normal;
            margin: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            border: 1px solid #000;
            padding: 3px;
            font-size: 9px;
        }

        th {
            text-align: center;
            background-color: #f2f2f2;
        }

        .signature {
            margin-top: 70px;
            text-align: center;
        }

        .signature div {
            display: inline-block;
            width: 22%; 
            margin: 0 1%;
            font-size: 9px;
        }

        .signature div span {
            display: block;
            margin-top: 60px;     
            margin-bottom: 70px;   
            border-top: 1px solid #000;
        }


        .icon-check, .icon-cross {
            font-size: 10px;
        }

        .table-no-border td {
            border: none;
            padding: 2px 4px; 
            font-size: 9px;
        }

        .table-no-border td:nth-child(1) {
            width: 5%; 
            white-space: nowrap;
        }

        .table-no-border td:nth-child(2) {
            width: 5px; 
            text-align: center;
            padding: 0 2px;
        }

        .table-no-border td:nth-child(3) {
            width: auto;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ $base64Image }}" alt="Logo">
        <div class="header-text">FORMULIR PERMINTAAN BARANG</div>
    </div>

    <table class="table-no-border">
        <tr>
            <td><strong>NOMOR PERMINTAAN BARANG</strong></td>
            <td>:</td>
            <td>{{ $data[0]->nomor_permintaan_barang }}</td>
        </tr>
       
        <tr>
            <td><strong>DEPARTEMEN</strong></td>
            <td>:</td>
            <td>{{ $data[0]->departemen }}</td>
        </tr>
        <tr>
            <td><strong>TANGGAL</strong></td>
            <td>:</td>
            <td>{{ \Carbon\Carbon::parse($data[0]->tanggal)->format('d-m-Y') }}</td>
        </tr>
        <tr>
            <td><strong>NAMA GUDANG</strong></td>
            <td>:</td>
            <td>{{ $data[0]->nama_gudang }}</td>
        </tr>
        <tr>
            <td><strong>JENIS PERMINTAAN</strong></td>
            <td>:</td>
            <td>{{ $data[0]->jenis_permintaan }}</td>
        </tr>
        <tr>
            <td><strong>TUJUAN PERMINTAAN</strong></td>
            <td>:</td>
            <td>{{ $data[0]->tujuan_permintaan_barang }}</td>
        </tr>
    </table>
    <table>
        <thead>
            <tr>
                <th>NO</th>
                <th>KODE BARANG</th>
                <th>NAMA BARANG</th>
                <th>JUMLAH</th>
                <th>SATUAN</th>
                <th>KETERANGAN</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $key => $bahan)
            <tr>
                <td style="text-align: center;">{{ $key + 1 }}</td>
                <td>{{ $bahan->kode_barang }}</td>
                <td>{{ $bahan->nama_barang }}</td>
                <td>{{ $bahan->jumlah }}</td>
                <td>{{ $bahan->satuan}}</td>
                <td>{{ $bahan->keterangan }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="signature">
        <div>
            Dibuat Oleh,<br>
            <span>(_____________)</span>
        </div>
        <div>
            Disetujui Oleh,<br>
            <span>(Manager Pemohon)</span>
        </div>
        <div>
            Diterima Oleh,<br>
            <span>(Warehouse Supervisor)</span>
        </div>
    </div>
</body>
</html>