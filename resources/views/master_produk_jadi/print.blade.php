<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Produk Jadi</title>
    <style>
         body { font-family: Arial, sans-serif; font-size: 9px; margin: 0; padding: 0; }
        table { width: 100%; border-collapse: collapse; margin-top: -20px; }
        th, td { border: 0px solid #000; padding: 5px; text-align: left; }

        .signature-table { margin-top: 40px; width: 70%; margin-left: auto; margin-right: auto; }
        .col-titik-dua { width: 3%; text-align: center; }
        /* Styling untuk Header */
        .header {
            display: flex;
            align-items: center; /* Menyamakan tinggi antara logo & teks */
            justify-content: space-between; /* Logo tetap di kiri, judul tetap rata kanan */
            margin-bottom: 20px;
            padding: 10px;
        }
        
        /* Styling untuk Logo */
        .logo img {
            height: 100px; /* Perbesar ukuran logo */
        }

        /* Styling untuk Judul */
        .title {
            font-size: 24px;
            flex-grow: 1; /* Membuat judul fleksibel mengikuti lebar */
            text-align: center; /* Agar teks tetap di tengah */
            padding: 10px 0; /* Menjaga jarak dalam */
            margin-top:-70px;
            color: Black;
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

    <!-- Bagian Header dengan Logo -->
    <div class="header">
        <div class="logo">
            <img src="{{ asset('assets/img/dwijaya-logo-01.png') }}" alt="Logo Dwijaya">
        </div>
        <h2 class="title">MASTER PRODUK JADI</h2>
    </div>

    <!-- Tabel Utama -->
    <table>
        <tr>
            <th>KODE PRODUK</th>
            <td class="col-titik-dua">:</td>
            <td>{{ $produk->kode_produk_jadi }}</td>
        </tr>
        <tr>
            <th>NAMA MERK</th>
            <td class="col-titik-dua">:</td>
            <td>{{ $produk->nama_merek ?? '-' }}</td>

        </tr>
        <tr>
            <th>KATEGORI PRODUK</th>
            <td class="col-titik-dua">:</td>
            <td>{{ $produk->kategori_produk_jadi }}</td>
        </tr>
        <tr>
            <th>NAMA PRODUK</th>
            <td class="col-titik-dua">:</td>
            <td>{{ $produk->nama_produk }}</td>
        </tr>
        <tr>
            <th>NETTO</th>
            <td class="col-titik-dua">:</td>
            <td>{{ $produk->netto }} {{ $produk->satuan }}</td>
        </tr>
        <tr>
            <th>KATEGORI KEMASAN</th>
            <td class="col-titik-dua">:</td>
            <td class="border px-4 py-2">
        {{ $produk->kategori_kemasan == 1 ? 'Primer' : ($produk->kategori_kemasan == 2 ? 'Sekunder' : '-') }}
    </td>
        </tr>
        <tr>
            <th>JENIS KEMASAN</th>
            <td class="col-titik-dua">:</td>
            <td>{{ $produk->nama_jenis_kemasan ?? '-' }}</td>
        </tr>
        <tr>
            <th>EXPIRED DATE</th>
            <td class="col-titik-dua">:</td>
            <td>{{ $produk->expired_date_produk_jadi }}</td>
        </tr>
        <tr>
            <th>REKOMNDASI PENYIMPANAN</th>
            <td class="col-titik-dua">:</td>
            <td>{{ $produk->rekomendasi_penyimpanan }}</td>
        </tr>
        <tr>
            <th>NO MERK</th>
            <td class="col-titik-dua">:</td>
            <td>{{ $produk->nomor_merk ?? '-' }}</td>
        </tr>
        <tr>
            <th>MASA BERLAKU MERK</th>
            <td class="col-titik-dua">:</td>
            <td>{{ $produk->masa_berlaku_merk ?? '-' }}</td>
        </tr>
        <tr>
            <th>NO HAKI</th>
            <td class="col-titik-dua">:</td>
            <td>{{ $produk->nomor_haki ?? '-' }}</td>
        </tr>
        <tr>
            <th>MASA BERLAKU HAKI</th>
            <td class="col-titik-dua">:</td>
            <td>{{ $produk->masa_berlaku_haki ?? '-' }}</td>
        </tr>
        <tr>
            <th>NO NOTIFIKASI BPOM</th>
            <td class="col-titik-dua">:</td>
            <td>{{ $produk->nomor_notifikasi_bpom ?? '-' }}</td>
        </tr>
        <tr>
            <th>MASA BERLAKU BPOM</th>
            <td class="col-titik-dua">:</td>
            <td>{{ $produk->masa_berlaku_notifikasi_bpom ?? '-' }}</td>
        </tr>
        <tr>
            <th>NO SERTIFIKAT HALAL</th>
            <td class="col-titik-dua">:</td>
            <td>{{ $produk->nomor_sertifikat_halal ?? '-' }}</td>
        </tr>
        <tr>
            <th>MASA BERLAKU SERTIFIKAT HALAL</th>
            <td class="col-titik-dua">:</td>
            <td>{{ $produk->masa_berlaku_sertifikat_halal ?? '-' }}</td>
        </tr>

        
    </table>

    <!--  Bagian Tanda Tangan  -->
   <!--  <div class="signature-container">
        <div class="signature-box-left">
            <p><strong>Dibuat Oleh</strong></p>
            <span class="signature-line"></span>
            <p>( Staff PR )</p>

            
        </div> 
        <div class="signature-box-center">
            <p><strong>Diterima oleh</strong></p>
            <span class="signature-line"></span>
            <p>( Staff Legal )</p>

        </div> 
        <div class="signature-box-right">
            <p><strong>Diterima Oleh</strong></p>
            <span class="signature-line"></span>
            <p>( PPIC Manager )</p>
        </div>
    </div> -->

</body>
</html>
