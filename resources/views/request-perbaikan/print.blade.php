<html>

<head>
    <title>PRINT {{ strtoupper($data->Request->nomor_request_perbaikan) }}</title>
    <style>
        @media print {
            * {
                font-family: Arial, sans-serif !important;
            }

            @page {
                size: A4;
                margin: 0;
                padding: 2cm;
                /* Menghilangkan margin bawaan */
            }

            body {
                font-family: Arial, sans-serif;
                font-size: 9pt !important;
                margin: 0;
                padding: 0;
                display: flex;
                flex-direction: column;
                justify-content: flex-start;
                /* Pastikan konten mulai dari atas */
            }

            table {
                page-break-inside: avoid;
                font-size: 9pt;
            }

            tr {
                page-break-inside: avoid;
                page-break-after: auto;
            }

            thead {
                display: table-header-group;
            }
        }

        * {
            font-family: Arial, sans-serif !important;
        }

        body {

            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
            text-align: center;
            align-items: center;
            /* margin: 2cm; */
            /*  margin: 10px; */
            padding: 0;
            /* Sedikit padding agar tidak mepet */
        }

        .container {
            width: 100%;
            max-width: 21cm;
            /* Sesuai ukuran A4 */
            text-align: center;
            margin: 0 auto;
            /* Tengah secara horizontal */
        }

        .table-bordered {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #000;
            margin-top: 10px;
        }

        .table-bordered th,
        .table-bordered td {
            border: 1px solid #000;
            padding: 4px;
            text-align: left;
        }

        .logo {
            text-align: center;
            margin-bottom: 10px;
        }

        .logo img {
            height: 50px;
        }
    </style>
</head>

<body>
    <div class="container">
        <table class="table-bordered">
            <thead>
                <th colspan="2" style="height: 50px; padding: 0; text-align: center; vertical-align: middle;">
                    <table style="width: 100%; border: none; border-collapse: collapse;">
                        <tr style="background-color: white;">
                            <td style="width: 10%; text-align: center; vertical-align: middle; border: none;">
                                <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" style="height: 40px;margin-left: 7px;">
                            </td>
                            <td style="text-align: center; vertical-align: middle; font-size: 11pt; font-weight: bold; border: none;">
                                {{ $data->Request->jenis === 'Perbaikan' ? 'PERBAIKAN' : 'PEMELIHARAAN'}} TEKNIK
                            </td>
                        </tr>
                    </table>
                </th>
            </thead>
            <tbody>
                <tr>
                    <td>Jenis Request</td>
                    <td>: {{ $data->Request->jenis }}</td>
                </tr>
                <tr>
                    <td>Nomor Request</td>
                    <td>: {{ $data->Request->nomor_request_perbaikan }}</td>
                </tr>
                <tr>
                    <td>Tanggal</td>
                    <td>: {{ date('d M Y', strtotime($data->Request->tanggal)) }}</td>
                </tr>
                <tr>
                    <td>ID Input</td>
                    <td>: {{ strtoupper($data->Request->id_input) }}</td>
                </tr>
                <tr>
                    <td>Departemen Pemohon</td>
                    <td>: {{ $data->Request->departemen_pemohon }}</td>
                </tr>
                <tr>
                    <td>Lokasi / Ruangan</td>
                    <td>: {{ $data->Request->lokasi_ruangan }}</td>
                </tr>
                <tr>
                    <td>Kategori</td>
                    <td>: {{ $data->Request->jenis_perbaikan }}</td>
                </tr>

                <tr>
                    <td></td>
                    <td></td>
                </tr>

                @if($data->Request->jenis_perbaikan === 'Aset')
                <tr>
                    <td>Kode Aset</td>
                    <td>: {{ $data->kode_aset }}</td>
                </tr>
                <tr>
                    <td>Nama Aset</td>
                    <td>: {{ $data->nama_aset }}</td>
                </tr>
                <tr>
                    <td>Kategori Aset</td>
                    <td>: {{ $data->kategori_aset }}</td>
                </tr>
                @endif

                <tr>
                    <td>Deskripsi {{ $data->Request->jenis === 'Perbaikan' ? 'Kerusakan' : 'Pemeliharaan'}} </td>
                    <td style="text-align: justify;">: {{ $data->deskripsi_kerusakan }}</td>
                </tr>

                @php
                $dokKerusakan = json_decode($data->dokumentasi_kerusakan, true);
                @endphp
                <tr>
                    <td>Dokumentasi {{ $data->Request->jenis === 'Perbaikan' ? 'Kerusakan' : 'Pemeliharaan'}}</td>
                    <td>
                        @foreach($dokKerusakan as $dok)
                        <img src="{{ asset('engineering_storage/' . $dok) }}" width="120" style="margin: 5px;">
                        @endforeach
                    </td>
                </tr>

                @if($data->approval_status !== NULL)
                <tr>
                    <td>Tanggal {{ $data->approval_status === 1 ? 'Approval' : 'Rejected' }} Permohonan</td>
                    <td>: {{ !empty($data->tanggal_approval) ? date('d M Y', strtotime($data->tanggal_approval)) : '' }}</td>
                </tr>

                <tr>
                    <td></td>
                    <td></td>
                </tr>
                @endif

                @if(!empty($dataTindakan->id_teknisi_sementara))
                <tr>
                    <th colspan="2" style="text-align: center;">Tindakan Sementara</th>
                </tr>
                <tr>
                    <td>Nama Teknisi</td>
                    <td>: {{ $dataTindakan->id_teknisi_sementara }}</td>
                </tr>
                <tr>
                    <td>Tindakan Sementara</td>
                    <td style="text-align: justify;">: {{ $dataTindakan->tindakan_sementara }}</td>
                </tr>
                <tr>
                    <td>Tanggal</td>
                    <td>: {{ date('d M Y', strtotime($dataTindakan->tanggal_waktu_sementara)) }}</td>
                </tr>

                @php
                $dokSementara = json_decode($dataTindakan->dokumentasi_perbaikan_sementara, true);
                @endphp
                <tr>
                    <td>Dokumentasi {{ $data->Request->jenis === 'Perbaikan' ? 'Perbaikan' : 'Pemeliharaan'}}</td>
                    <td>
                        @foreach($dokSementara as $dok)
                        <img src="{{ asset('engineering_storage/' . $dok) }}" width="120px" style="margin: 5px;">
                        @endforeach
                    </td>
                </tr>

                <tr>
                    <td></td>
                    <td></td>
                </tr>
                @endif

                @if(!empty($dataTindakan->id_teknisi_lanjutan))
                <tr>
                    <th colspan="2" style="text-align: center;">Tindakan Lanjutan</th>
                </tr>
                <tr>
                    <td>Nama Teknisi</td>
                    <td>: {{ $dataTindakan->id_teknisi_lanjutan }}</td>
                </tr>
                <tr>
                    <td>Tindakan Lanjutan</td>
                    <td style="text-align: justify;">: {{ $dataTindakan->tindakan_lanjutan }}</td>
                </tr>
                <tr>
                    <td>Tanggal</td>
                    <td>: {{ date('d M Y', strtotime($dataTindakan->tanggal_waktu_lanjutan)) }}</td>
                </tr>

                @php
                $dokLanjutan = json_decode($dataTindakan->dokumentasi_perbaikan_lanjutan, true);
                @endphp
                <tr>
                    <td>Dokumentasi {{ $data->Request->jenis === 'Perbaikan' ? 'Perbaikan' : 'Pemeliharaan'}}</td>
                    <td>
                        @foreach($dokLanjutan as $dok)
                        <img src="{{ asset('engineering_storage/' . $dok) }}" width="120" style="margin: 5px;">
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                </tr>
                @endif

                @if(!empty($dataTindakan->Sparepart) && count($dataTindakan->Sparepart) > 0)
                <tr>
                    <td>Sparepart yang dibutuhkan</td>
                    <td>:
                        @foreach($dataTindakan->Sparepart as $index => $sparepart)
                        {{ $sparepart->masterSparepart->nama_sparepart }} yang digunakan {{ $sparepart->jumlah_terpakai }} <br>
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                </tr>
                @endif

                <tr>
                    <td>Tanggal Approval {{ $data->Request->jenis === 'Perbaikan' ? 'Perbaikan' : 'Pemeliharaan'}}</td>
                    <td>: {{ !empty($data->tanggal_close) ? date('d M Y', strtotime($data->tanggal_close)) : '' }}</td>
                </tr>
            </tbody>
        </table>
    </div>


    <script>
        // Cetak otomatis setelah halaman dimuat
        window.onload = function() {
            window.print();
        };
    </script>

</body>

</html>
