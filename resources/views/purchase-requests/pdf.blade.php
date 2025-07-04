<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Order Registrasi</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 9px; margin: 0; padding: 0; }
        .container { width: 99%; margin: 0 auto; padding: 2px; }
        .kop-surat { text-align: center; font-size: 14px; font-weight: bold; margin-top: 5px; }
        .header { text-align: left; margin-bottom: 5px; font-size: 9px; }
        table {
    border-bottom: 1px solid black;
    border-collapse: collapse;
    width: 100%;
}
       
th, td {
    border: 1px solid #000;
    padding: 5px 3px; /* Tambahkan padding agar baris lebih lebar */
    text-align: left;
    line-height: 1.6; /* Menambahkan jarak antar teks dalam satu sel */
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
        /* Buat teks pada header tabel berada di tengah */
th.center-text, td.center-text {
    text-align: center;
    vertical-align: middle;
}
/* Membuat teks di tengah untuk header tabel */
th.center-text, td.center-text {
    text-align: center;
    vertical-align: middle;
}

/* Pastikan angka tetap rata kanan */
td.right-align {
    text-align: right;
}

/* Menambahkan garis kiri pada tabel */
.border-left {
    border-left: 1px solid black;
}

/* Menambahkan garis kanan pada tabel */
.border-right {
    border-right: 1px solid black;
}

/* Menghilangkan border pada sel kosong sebelum Sub Total */
.no-border {
    border: none;
}

/* Menambahkan garis bawah untuk batas akhir tabel */
table {
    border-bottom: 1px solid black;
}
/* Container untuk Data PO & Supplier */
.info-container {
        display: table;
        width: 100%;
        font-size: 10px;
        margin-bottom: 10px;
    }

    /* Setiap baris informasi */
    .info-row {
        display: table-row;
    }

    /* Label bagian kiri */
    .info-label, .info-separator, .info-data {
        display: table-cell;
        padding: 2px 5px;
    }

    /* Label teks kiri (judul) */
    .info-label {
        min-width: 150px; /* Lebar tetap untuk meratakan titik dua */
        font-weight: bold;
        text-align: left;
    }

    /* Titik dua sejajar */
    .info-separator {
        min-width: 10px; /* Pastikan titik dua memiliki lebar tetap */
        text-align: left;
    }

    /* Data di sebelah kanan */
    .info-data {
        text-align: left;
        padding-left: 5px;
    }
/* Menghilangkan border bawah dari baris terakhir dalam tabel */
/* Menghilangkan border bawah pada baris terakhir tabel */
table tbody tr:last-child td {
    border-bottom: none !important;
}

/* Menghilangkan border bawah dari kolom kosong sebelum Sub Total */
.no-border-bottom {
    border-bottom: none !important;
}
.info-container {
        display: table;
        width: 100%;
        font-size: 10px;
        margin-bottom: 10px;
    }

    /* Setiap baris informasi */
    .info-row {
        display: table-row;
    }

    /* Label bagian kiri */
    .info-label, .info-separator, .info-data {
        display: table-cell;
        padding: 2px 5px;
    }

    /* Label teks kiri (judul) */
    .info-label {
        min-width: 150px; /* Lebar tetap untuk meratakan titik dua */
        font-weight: bold;
        text-align: left;
    }

    /* Titik dua sejajar */
   /* Titik dua lebih dekat dengan judul */
.info-separator {
    min-width: 5px; /* Kurangi lebar untuk mendekatkan titik dua */
    padding-right:500px; /* Tambahkan sedikit jarak ke kanan */
    text-align: left;
}

    /* Data di sebelah kanan */
    .info-data {
    display: block;
    text-align: left;
    margin-left: -490px; /* Geser ke kiri */
}
    </style>
</head>
<body>

<div class="container">
    
<div class="header">
        <div class="logo">
            <img src="{{ asset('assets/img/dwijaya-logo-01.png') }}" alt="Logo Dwijaya">
        </div>
        <h2 class="title">FORMULIR PURCHASE REQUEST</h2>
        <div class="info-container">
    <div class="info-row">
        <div class="info-label">NO PURCHASE REQUEST</div>
        <div class="info-separator">:</div>
        <div class="info-data"> {{ $purchaseRequest->no_purchase_request }}</div>
    </div>
    <div class="info-row">
        <div class="info-label">TANGGAL</div>
        <div class="info-separator">:</div>
        <div class="info-data"> {{ \Carbon\Carbon::parse($purchaseRequest->tanggal)->format('d/m/Y') }}</div>

    </div>
    <div class="info-row">
        <div class="info-label">DEPARTEMEN</div>
        <div class="info-separator">:</div>
        <div class="info-data"> {{ $purchaseRequest->departemen }}</div>
    </div>
    <div class="info-row">
        <div class="info-label">KATEGORI BARANG</div>
        <div class="info-separator">:</div>
        <div class="info-data"> {{ $purchaseRequest->kategori_barang }}</div>
    </div>
    </div>

    </div>

  
    <!-- Detail Barang -->
    <table>
    <thead>
        <tr>
            <th class="center-text border-left">NO</th>
            <th class="center-text">KODE BARANG</th>
            <th class="center-text">NAMA BARANG</th>
            <th class="center-text">KATEGORI</th>
            <th class="center-text">JUMLAH</th>
            <th class="center-text">SATUAN</th>
            <th class="center-text">RENCANA KEDATANGAN</th>
            <th class="center-text">KETERANGAN</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($purchaseRequest->details as $key => $detail)
        <tr>
        <td class="center-text border-left">{{ $key + 1 }}</td>
            <td class="left-align border-left">{{ $detail->kode_barang }}</td>
            <td class="left-align border-left">{{ $detail->nama_barang }}</td>
            <td class="left-align border-left">{{ $detail->kategori }}</td>
            <td class="center-text border-left">{{ $detail->jumlah }}</td>
            <td class="center-text border-left">{{ $detail->satuan }}</td>
            <td class="left-align border-left">{{ \Carbon\Carbon::parse($detail->rencana_kedatangan)->format('d/m/Y') }}</td>
            <td class="left-align border-left">{{ $detail->keterangan }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

    <!-- Tanda Tangan dalam Box dengan 2 Kolom Kanan Kiri -->
    <div class="signature-container">
        <div class="signature-box-left">
            <p><strong>Dibuat Oleh</strong></p>
            <span class="signature-line"></span>
            <p>( &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; )</p>

            
        </div>
        <div class="signature-box-center">
            <p><strong>Disetujui Oleh</strong></p>
            <span class="signature-line"></span>
            <p>( &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; )</p>

        </div>
        <div class="signature-box-right">
            <p><strong>Diterima Oleh</strong></p>
            <span class="signature-line"></span>
            <p>( Staff Purchasing )</p>
        </div>
    </div>
</div>
</body>
</html>
