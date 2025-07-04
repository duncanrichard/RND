<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Detail Formula Produk</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 20px;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 9px;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 99%;
            margin: 0 auto;
            padding: 2px;
        }

        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 10px;
            padding: 10px;
        }

        .logo img {
            height: 100px;
        }

        .title {
            font-size: 24px;
            flex-grow: 1;
            text-align: center;
            margin-top: -70px;
            color: black;
        }

        h2 {
            margin-top: 30px;
            margin-bottom: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            border: 1px solid #000;
            padding: 6px 4px;
            text-align: left;
            line-height: 1.4;
        }

        th {
            background-color: #f1f1f1;
            font-weight: bold;
        }

                /* Style untuk tanda tangan */
                .signature-container {
            margin-top: 30px;
            display: flex;
            justify-content: space-between;
            width: 100%;
            gap: 15px; /* Memberi jarak antar kotak */
        }

        /* Kotak kiri (Dibuat Oleh) */
        .signature-box-left {
            width: 20%;
            border: 0px solid #000;
            background-color: white;
            padding: 15px;
            text-align: center;
            border-radius: 5px;
            height: 90px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            box-sizing: border-box;
        }

       /* Kotak kanan (Disetujui Oleh) */
       .signature-box-center {
            width: 20%;
            border: 0px solid #000;
            background-color: white; /* Warna putih */
            padding: 15px;
            text-align: center;
            border-radius: 5px;
            height: 90px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            box-sizing: border-box;
            margin-left: 250px; /* Memberi jarak dari kotak kiri */
            margin-top: -150px; /* Memberi jarak dari kotak kiri */
        }
       .signature-box-right {
            width: 20%;
            border: 0px solid #000;
            background-color: white; /* Warna putih */
            padding: 15px;
            text-align: center;
            border-radius: 5px;
            height: 90px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            box-sizing: border-box;
            margin-left: 510px; /* Memberi jarak dari kotak kiri */
            margin-top: -150px; /* Memberi jarak dari kotak kiri */
        }

        /* Garis tanda tangan */
        .signature-line {
    display: block;
    border-top: 1px solid #000;
    width: 80%;
    margin: 70px auto 0 auto; /* Garis turun lebih jauh */
}

        .signature-box p:last-child {
            margin-top: 10px;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="logo">
                <img src="{{ asset('assets/img/djc.png') }}" alt="Logo">
            </div>
            <h2 class="title">Master Formula Produk</h2>
        </div>

        <!-- Informasi Umum -->
        <h2>Informasi Produk</h2>
        <table>
            <tr><th>Nomor Formula</th><td>{{ $formula->nomor_formula }}</td><th>Kode Produk</th><td>{{ $formula->kode_produk }}</td></tr>
            <tr><th>Nama Merek</th><td>{{ $formula->nama_merek }}</td><th>Nama Produk</th><td>{{ $formula->nama_produk }}</td></tr>
            <tr><th>Tanggal</th><td>{{ \Carbon\Carbon::parse($formula->tanggal)->format('d-m-Y') }}</td><th>Batch Size Berat</th><td>{{ $formula->batch_size_berat }} / {{ $formula->satuan_berat }}</td></tr>
            <tr><th>Kategori</th><td>{{ $formula->kategori }}</td><th>Batch Size Satuan</th><td>{{ $formula->batch_size_satuan }} / {{ $formula->jenis_satuan }}</td></tr>
            <tr><th>ID Input</th><td>{{ $formula->id_input }}</td><th>Netto</th><td>{{ $formula->netto }}</td></tr>
        </table>

        <!-- Bahan Baku -->
        <h2>Bahan Baku</h2>
        <table>
            <thead>
                <tr>
                    <th>Kode Bahan Baku</th>
                    <th>Nama</th>
                    <th>Jumlah</th>
                    <th>Satuan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($formula->bahanBaku as $bahan)
                <tr>
                    <td>{{ $bahan->kode_bahan_baku }}</td>
                    <td>{{ $bahan->nama_coding }}</td>
                    <td>{{ $bahan->jumlah }}</td>
                    <td>{{ $bahan->satuan }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <h2>Total Data Bahan Baku: {{ $totalJumlahBahanBaku }}</h2>

        <!-- Bahan Kemas -->
        <h2>Bahan Kemas</h2>
        <table>
            <thead>
                <tr>
                    <th>Kode Bahan Kemas</th>
                    <th>Nama</th>
                    <th>Jumlah</th>
                    <th>Satuan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($formula->bahanKemas as $kemas)
                <tr>
                    <td>{{ $kemas->kode_kemasan }}</td>
                    <td>{{ $kemas->nama_kemasan }}</td>
                    <td>{{ $kemas->jumlah }}</td>
                    <td>{{ $kemas->satuan }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <h2>Total Data Bahan Kemas: {{ $totalJumlahBahanKemas }}</h2>

        <!-- Tanda Tangan dalam Box dengan 2 Kolom Kanan Kiri -->
        <div class="signature-container">
        <div class="signature-box-left">
            <p><strong>Dibuat Oleh</strong></p>
            <span class="signature-line"></span>
            <p>( &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; )</p>

            
        </div>
        <div class="signature-box-center">
            <p><strong>DiPeriksa Oleh</strong></p>
            <span class="signature-line"></span>
            <p>( &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; )</p>

        </div>
        <div class="signature-box-right">
            <p><strong>DiSetujui Oleh</strong></p>
            <span class="signature-line"></span>
            <p>( &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; )</p>
        </div>
    </div>
    </div>
</body>
</html>
