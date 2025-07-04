<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cetak Sample Progress</title>
    <style>
        @page { size: A4 portrait; margin: 20px; }
        body { font-family: Arial, sans-serif; font-size: 9px; color: #000; }
        .container { width: 98%; margin: auto; padding: 10px; }
        .header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; }
        .logo img { height: 80px; }
        .title { flex-grow: 1; text-align: center; font-size: 22px; margin-top: -60px; }
        h2 { margin: 30px 0 10px 0; }

        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 6px 4px; text-align: left; vertical-align: top; }
        th { background-color: #f1f1f1; }

      
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="logo">
                <img src="{{ public_path('assets/img/dwijaya-logo-01.png') }}" alt="Logo Dwijaya">
            </div>
            <div class="title">
                <strong>Detail Sample Progress</strong>
            </div>
        </div>

        <!-- Informasi Utama -->
        <h2>Informasi Sample</h2>
        <table>
            <tr><th>No Request Sample</th><td>{{ $sample->no_request_sample }}</td></tr>
            <tr><th>Tanggal</th><td>{{ $sample->tanggal }}</td></tr>
            <tr><th>Customer</th><td>{{ $sample->kode_customer }} - {{ $sample->nama_customer }}</td></tr>
            <tr><th>Alamat Pengiriman</th><td>{{ $sample->alamat_pengiriman_sample }}</td></tr>
            <tr><th>Telepon PIC</th><td>{{ $sample->nomor_telepon_pic }}</td></tr>
            <tr><th>Email</th><td>{{ $sample->alamat_email }}</td></tr>
            <tr><th>Nama Sample</th><td>{{ $sample->nama_sample }}</td></tr>
            <tr><th>Nomor Master Formula Sample</th><td>{{ $sample->nomor_master_formula_sample }}</td></tr>
            <tr><th>Kode Sample</th><td>{{ $sample->kode_sample }}</td></tr>
            <tr><th>Bahan Aktif</th><td>{{ $sample->bahan_aktif }}</td></tr>
        </table>

        <!-- Tabel Progres -->
        <h2>Riwayat Progres Sample</h2>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal Penyerahan</th>
                    <th>Status</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($progress as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->tanggal_penyerahan }}</td>
                        <td>{{ $item->report_sample == 1 ? 'Approved' : 'Not Approved' }}</td>
                        <td>{{ $item->keterangan_sample ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

       
    </div>
</body>
</html>
