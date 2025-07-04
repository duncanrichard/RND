<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Stabilitas R&D</title>
    <style>
        @page { size: A4 portrait; margin: 20px; }
        body { font-family: Arial, sans-serif; font-size: 9px; margin: 0; padding: 0; color: #000; }
        .container { width: 99%; margin: 0 auto; padding: 2px; }
        .header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px; padding: 10px; }
        .logo img { height: 100px; }
        .title { font-size: 24px; flex-grow: 1; text-align: center; margin-top: -70px; color: black; }
        h2 { margin-top: 30px; margin-bottom: 5px; }

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

        td:first-child, th:first-child {
            text-align: left;
        }

        /* Signature box */
        .signature-container {
            margin-top: 30px;
            display: flex;
            justify-content: space-between;
            width: 100%;
            gap: 15px;
        }

        .signature-box-left, .signature-box-right {
            width: 45%;
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

        .signature-box-right {
            margin-left: auto;
            margin-top: -120px;
        }

        .signature-line {
            border-top: 1px solid #000;
            width: 60%;
            margin: 50px auto 0 auto;
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
            <h2 class="title">Formulir Data Stabilitas
            </h2>
        </div>

        <!-- Informasi Utama -->
        <h2>Informasi Utama</h2>
        <table>
            <tr><th>Nama Produk</th><td>{{ $product->nama_produk ?? '-' }}</td></tr>
            <tr><th>Kode Sample</th><td>{{ $product->kode_sample ?? '-' }}</td></tr>
            <tr><th>No Formula</th><td>{{ $product->no_formula ?? '-' }}</td></tr>
            <tr><th>ID Input</th><td>{{ $product->id_input ?? '-' }}</td></tr>
            <tr><th>Tanggal</th><td>{{ $product->tanggal ?? '-' }}</td></tr>
            <tr><th>Tanggal Trial</th><td>{{ $product->tgl_trial ?? '-' }}</td></tr>
        </table>

        <!-- Accelerated Stability -->
        <h2>Accelerated Stability Testing</h2>
        <table>
            <thead>
                <tr>
                    <th>Parameter</th>
                    <th>Syarat</th>
                    @foreach(['Awal', 1, 2, 3, 4, 5, 6] as $tp)
                        <th>{{ $tp }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($product->stabilities->where('type', 'accelerated') as $stab)
                @php $list = json_decode($stab->checklist, true) ?? []; @endphp
                <tr>
                    <td>{{ $stab->parameter }}</td>
                    <td>{{ $stab->syarat }}</td>
                    @foreach(['awal', 1, 2, 3, 4, 5, 6] as $tp)
                        <td>
                            {{ $list[$tp]['keterangan'] ?? '-' }}<br>
                            ({{ $list[$tp]['value'] ?? '-' }})
                        </td>
                    @endforeach
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Long Term Stability -->
        <h2>Long Term Stability Testing</h2>
        <table>
            <thead>
                <tr>
                    <th>Parameter</th>
                    <th>Syarat</th>
                    @foreach(['Awal', 3, 6, 9, 12, 18, 24, 36] as $tp)
                        <th>{{ $tp }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($product->stabilities->where('type', 'long_term') as $stab)
                @php $list = json_decode($stab->checklist, true) ?? []; @endphp
                <tr>
                    <td>{{ $stab->parameter }}</td>
                    <td>{{ $stab->syarat }}</td>
                    @foreach(['awal', 3, 6, 9, 12, 18, 24, 36] as $tp)
                        <td>
                            {{ $list[$tp]['keterangan'] ?? '-' }}<br>
                            ({{ $list[$tp]['value'] ?? '-' }})
                        </td>
                    @endforeach
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Signature -->
      <!--   <div class="signature-container">
            <div class="signature-box-left">
                <p><strong>Dibuat Oleh</strong></p>
                <span class="signature-line"></span>
                <p>( Staff R&D )</p>
            </div>
            <div class="signature-box-right">
                <p><strong>Disetujui Oleh</strong></p>
                <span class="signature-line"></span>
                <p>( Manager R&D )</p>
            </div>
        </div> -->
    </div>
</body>
</html>
