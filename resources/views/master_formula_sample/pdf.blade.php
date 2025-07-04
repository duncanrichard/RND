<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formula Sample</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 20px;
        }

        body { font-family: Arial, sans-serif; font-size: 9px; margin: 0; padding: 0; }

        .container { width: 99%; margin: 0 auto; padding: 2px; }

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

        h2 {
            margin-top: 30px;
            margin-bottom: 5px;
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
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="logo">
                <img src="{{ asset('assets/img/dwijaya-logo-01.png') }}" alt="Logo Dwijaya">
            </div>
            <h2 class="title">Master Formula Sample
            </h2>
        </div>

        <!-- Informasi Utama -->
        <h2>Informasi Utama</h2>
        <table>
            <tr><th>Nama Sample</th><td>{{ $formulaSample->nama_sample ?? '-' }}</td></tr>
            <tr><th>Kode Sample</th><td>{{ $formulaSample->kode_sample ?? '-' }}</td></tr>
            <tr><th>Bahan Aktif</th><td>{{ $formulaSample->bahan_aktif ?? '-' }}</td></tr>
            <tr><th>ID Input</th><td>{{ $formulaSample->id_input ?? '-' }}</td></tr>
        </table>

        <!-- Detail Bahan -->
        <h2>Detail Bahan</h2>
        <table>
            <thead>
                <tr>
                    <th>Premix</th>
                    <th>Kode Bahan Baku</th>
                    <th>Nama Bahan Baku</th>
                    <th>Function</th>
                    <th>Supplier</th>
                    <th>Jumlah</th>
                    <th>Satuan</th>
                    <th>HPP</th>
                </tr>
            </thead>
            <tbody>
                @forelse($formulaSample->details as $detail)
                <tr>
                    <td>{{ $detail->premix ?? '-' }}</td>
                    <td>{{ $detail->kode_bahan_baku ?? '-' }}</td>
                    <td>{{ $detail->nama_bahan_baku ?? '-' }}</td>
                    <td>{{ $detail->function ?? '-' }}</td>
                    <td>{{ $detail->supplier ?? '-' }}</td>
                    <td>{{ $detail->jumlah_satuan ?? '-' }}</td>
                    <td>{{ $detail->satuanModel->nama_satuan ?? '-' }}</td>
                    <td>{{ $detail->hpp ?? '-' }}</td>
                </tr>
                @empty
                <tr><td colspan="8">Tidak ada data bahan baku.</td></tr>
                @endforelse
            </tbody>
        </table>

        <!-- Prosedur Kerja -->
        <h2>Prosedur Kerja</h2>
        @if($formulaSample->prosedurs->count() > 0)
        <ol>
            @foreach($formulaSample->prosedurs->sortBy('id') as $prosedur)
            <li>{{ preg_replace('/^\d+\.\s?/', '', $prosedur->detail) }}</li>
            @endforeach
        </ol>
        @else
        <p>-</p>
        @endif

        <!-- Spesifikasi -->
        <h2>Spesifikasi</h2>
        <table>
            <tr><th>Bentuk</th><td>{{ $spesifikasi->bentuk ?? '-' }}</td></tr>
            <tr><th>Warna</th><td>{{ $spesifikasi->warna ?? '-' }}</td></tr>
            <tr><th>Bau</th><td>{{ $spesifikasi->bau ?? '-' }}</td></tr>
            <tr><th>pH</th><td>{{ $spesifikasi->ph ?? '-' }}</td></tr>
            <tr><th>Viskositas</th><td>{{ $spesifikasi->viskositas ?? '-' }}</td></tr>
        </table>

        <!-- Spesifikasi Tambahan -->
        <h2>Spesifikasi Tambahan</h2>
        @if($formulaSample->spesifikasiTambahan->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>Data Spesifikasi</th>
                    <th>Hasil</th>
                </tr>
            </thead>
            <tbody>
                @foreach($formulaSample->spesifikasiTambahan as $tambahan)
                <tr>
                    <td>{{ $tambahan->data_spesifikasi ?? '-' }}</td>
                    <td>{{ $tambahan->hasil ?? '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <p>-</p>
        @endif

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
</div>
    </div>
</body>
</html>
