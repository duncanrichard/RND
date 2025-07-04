<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\DocumentWarehouseController;
use App\Http\Controllers\MasterSatuanController;
use App\Http\Controllers\MasterBahanBakuController;
use App\Http\Controllers\MasterPPNController;
use App\Http\Controllers\MasterHargaSampleBahanBakuController;
use App\Http\Controllers\StabilitasRDController;
use App\Http\Controllers\MasterHargaPOController;
use App\Http\Controllers\KategoriBahanBakuController;
use App\Http\Controllers\BahanBakuController;
use App\Http\Controllers\MasterFormulaSampleController;
use App\Http\Controllers\JenisBahanBakuController;
use App\Http\Controllers\ProdukJadiController;
use App\Http\Controllers\KodeBahanKemasController;
use App\Http\Controllers\MasterKemasanController;
use App\Http\Controllers\MasterFormulaProdukController;
use App\Http\Controllers\MasterKategoriProdukController;
use App\Http\Controllers\MasterProdukJadiController;
use App\Http\Controllers\MasterCPBController;
use App\Http\Controllers\MasterCKBController;
use App\Http\Controllers\SampleProgressController;
use App\Http\Controllers\PurchaseRequestController;
use App\Http\Controllers\SingkatanMerkController;
use App\Http\Controllers\permintaanController;
use App\Http\Controllers\pengembalianController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\AccountController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Berikut adalah tempat Anda dapat mendaftarkan rute web untuk aplikasi Anda.
| Rute ini dimuat oleh RouteServiceProvider dalam grup yang berisi grup "web".
| Buat sesuatu yang hebat!
|
*/

// Redirect root ke halaman home/dashboard
Route::get('/', function () {
    return redirect()->route('home');
});

// Rute untuk pengguna yang belum login (guest)
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login']);

    Route::get('register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [AuthController::class, 'register']);
});

// Rute untuk pengguna yang sudah login (authenticated)
Route::middleware('auth')->group(function () {
    // Rute home/dashboard
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Master Satuan
    Route::resource('master_satuan', MasterSatuanController::class);

    // Master Bahan Baku
    Route::resource('master_bahan_baku', MasterBahanBakuController::class);
    Route::get('/master_bahan_baku/create', [MasterBahanBakuController::class, 'create'])->name('master_bahan_baku.create');
    Route::get('/master_bahan_baku/{id}/edit', [MasterBahanBakuController::class, 'edit'])->name('master_bahan_baku.edit');
    Route::put('/master_bahan_baku/{id}', [MasterBahanBakuController::class, 'update'])->name('master_bahan_baku.update');
    Route::get('/api/get-next-kode-bahan-baku', [MasterBahanBakuController::class, 'getNextKodeBahanBaku']);
    Route::patch('/master_bahan_baku/{id}/toggle-approval', [MasterBahanBakuController::class, 'toggleApproval'])->name('master_bahan_baku.toggleApproval');

    
    // Master PPN
    Route::resource('master_ppn', MasterPPNController::class);
    

    // Master Harga Sample Bahan Baku
    Route::resource('master_harga_sample_bahan_baku', MasterHargaSampleBahanBakuController::class);
    Route::get('/master_harga_sample_bahan_baku', [MasterHargaSampleBahanBakuController::class, 'index'])->name('master_harga_sample_bahan_baku.index');
    Route::get('/bahan-baku/search', [MasterHargaSampleBahanBakuController::class, 'searchBahanBaku'])->name('bahan_baku.search');
    Route::get('/suppliers', [MasterHargaSampleBahanBakuController::class, 'getSuppliers'])->name('suppliers.search');


    
    Route::get('/get-bahan-baku', [MasterHargaSampleBahanBakuController::class, 'getBahanBaku'])->name('get-bahan-baku');
    Route::get('/get-bahan-baku-detail', [MasterHargaSampleBahanBakuController::class, 'getBahanBakuDetail'])->name('get-bahan-baku-detail');
    Route::get('/get-kategori-satuan', [MasterHargaSampleBahanBakuController::class, 'getKategoriSatuan'])->name('get-kategori-satuan');
    Route::get('/search-bahan-baku', [MasterHargaSampleBahanBakuController::class, 'searchBahanBaku']);

    /* Master Formula Sample */
    /* Route::resource('master_formula_sample', MasterFormulaSampleController::class); */
    Route::get('/search-bahan-baku', [MasterFormulaSampleController::class, 'searchBahanBaku']);
    Route::resource('master_formula_sample', MasterFormulaSampleController::class);
    Route::post('search-bahan-baku', [MasterFormulaSampleController::class, 'searchBahanBaku'])->name('search-bahan-baku');
    Route::get('master-formula-sample/{id}', [MasterFormulaSampleController::class, 'show'])->name('master_formula_sample.show');
    Route::delete('/master_formula_sample/{id}', [MasterFormulaSampleController::class, 'destroy'])->name('master_formula_sample.destroy');
    Route::get('/master-formula-sample/{id}/print', [MasterFormulaSampleController::class, 'print'])->name('master_formula_sample.print');
    Route::get('/master_formula_sample/{id}/edit', [MasterFormulaSampleController::class, 'edit'])->name('master_formula_sample.edit');
    Route::put('/master_formula_sample/{id}', [MasterFormulaSampleController::class, 'update'])->name('master_formula_sample.update');
    Route::get('/generate-kode-sample', [MasterFormulaSampleController::class, 'generateKodeSample']);
    Route::get('/master-formula-sample/group/{kode_sample}', [MasterFormulaSampleController::class, 'groupDetail'])->name('master_formula_sample.groupDetail');
    Route::get('/master-formula-sample/revisi/{kode_sample}', [MasterFormulaSampleController::class, 'createRevisi'])
    ->name('master_formula_sample.createRevisi');
    Route::get('search-bahan-baku', [MasterFormulaSampleController::class, 'searchBahanBaku']);
    Route::get('/cek-kode-sample-revisi', [MasterFormulaSampleController::class, 'cekKodeSampleRevisi']);
    Route::get('/get-revisi-terakhir', [MasterFormulaSampleController::class, 'getRevisiTerakhir']);


    // Master Data Stabilitas R&D
    Route::get('/master_data_stabilitas_rd', [StabilitasRDController::class, 'index'])->name('master_data_stabilitas_rd.index');
    Route::get('/master_data_stabilitas_rd/create', [StabilitasRDController::class, 'create'])->name('master_data_stabilitas_rd.create');
    Route::post('/master_data_stabilitas_rd', [StabilitasRDController::class, 'store'])->name('master_data_stabilitas_rd.store');
    Route::delete('/master_data_stabilitas_rd/{id}', [StabilitasRDController::class, 'destroy'])->name('master_data_stabilitas_rd.destroy');
    Route::get('/master_data_stabilitas_rd/{id}/edit', [StabilitasRDController::class, 'edit'])->name('master_data_stabilitas_rd.edit');
    Route::put('/master_data_stabilitas_rd/{id}', [StabilitasRDController::class, 'update'])->name('master_data_stabilitas_rd.update');
    Route::get('/master_data_stabilitas_rd/{id}', [StabilitasRDController::class, 'show'])->name('master_data_stabilitas_rd.show');
    Route::get('/search', [StabilitasRDController::class, 'search'])->name('master_data_stabilitas_rd.search');
    Route::get('stabilitas-rd/{id}/print', [StabilitasRDController::class, 'printPDF'])->name('master_data_stabilitas_rd.print');


    
    /* Kode Kategori Bahan Baku */
    Route::resource('kategori_bahan_baku', KategoriBahanBakuController::class);

    // Master Harga PO
    Route::resource('master_harga_po', MasterHargaPOController::class);

    /* Jenis Master Bahan Baku */
    Route::resource('jenis-bahan-baku', JenisBahanBakuController::class);
    

    /* Master Bahan Baku */
    Route::prefix('bahan-baku')->name('bahan_baku.')->group(function () {
        Route::get('/', [BahanBakuController::class, 'index'])->name('index');
        Route::get('/create', [BahanBakuController::class, 'create'])->name('create');
        Route::post('/', [BahanBakuController::class, 'store'])->name('store');
    
        // 🟢 Pindahkan ke atas
        Route::get('/print', [BahanBakuController::class, 'print'])->name('print');
    
        Route::get('/{id}/edit', [BahanBakuController::class, 'edit'])->name('edit');
        Route::put('/{id}', [BahanBakuController::class, 'update'])->name('update');
        Route::delete('/{id}', [BahanBakuController::class, 'destroy'])->name('destroy');
        Route::get('/{id}', [BahanBakuController::class, 'show'])->name('show');
    });
    
    
    /* Kode Bahan Kemas */
    Route::resource('kode_bahan_kemas', KodeBahanKemasController::class);

    /* Master Kemasan */
    Route::prefix('master-kemasan')->name('master_kemasan.')->group(function () {
        Route::get('/', [MasterKemasanController::class, 'index'])->name('index');
        Route::get('/create', [MasterKemasanController::class, 'create'])->name('create');
        Route::post('/', [MasterKemasanController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [MasterKemasanController::class, 'edit'])->name('edit'); // Tambahkan ini
        Route::put('/update/{id}', [MasterKemasanController::class, 'update'])->name('update'); // Tambahkan ini
        Route::delete('/destroy/{id}', [MasterKemasanController::class, 'destroy'])->name('destroy'); // Tambahkan ini
        Route::get('/generate-kode/{id}', [MasterKemasanController::class, 'generateKodeKemasan']);
        Route::get('/master-kemasan/generate-kode/{id}', [MasterKemasanController::class, 'generateKodeKemasan']);
        Route::get('/print', [MasterKemasanController::class, 'print'])->name('print');

    });
    Route::get('/kode-bahan-kemas/filter-jenis/{kategoriKemasan}', [KodeBahanKemasController::class, 'filterJenisKemasan']);

    /* Master Kategori Produk */
    Route::resource('master_kategori_produk', MasterKategoriProdukController::class);

    /* Master Produk Jadi */
    Route::resource('master_produk_jadi', MasterProdukJadiController::class);
    Route::get('/master-produk-jadi/get-latest-kode', [MasterProdukJadiController::class, 'getLatestKode']);
    Route::get('/master_produk_jadi/{id}/edit', [MasterProdukJadiController::class, 'edit'])->name('master_produk_jadi.edit');
    Route::put('/master_produk_jadi/{id}', [MasterProdukJadiController::class, 'update'])->name('master_produk_jadi.update');
    Route::get('/kode-bahan-kemas/filter-jenis/{kategori}', [MasterProdukJadiController::class, 'filterJenisKemasan']);
    Route::get('/master_produk_jadi/{id}/detail', [MasterProdukJadiController::class, 'show'])->name('master_produk_jadi.show');
    Route::get('/master_produk_jadi/{id}/print', [MasterProdukJadiController::class, 'printDetail'])->name('master_produk_jadi.printDetail');
    Route::get('/master_produk_jadi/previewPdf/{id}', [MasterProdukJadiController::class, 'previewPdf'])->name('master_produk_jadi.previewPdf');


   /* Master Formula Produk */
    Route::prefix('master-formula-produk')->name('master_formula_produk.')->group(function () {
        Route::get('/', [MasterFormulaProdukController::class, 'index'])->name('index');
        Route::get('/create', [MasterFormulaProdukController::class, 'create'])->name('create');
        Route::post('/store', [MasterFormulaProdukController::class, 'store'])->name('store'); 
        Route::delete('/delete/{id}', [MasterFormulaProdukController::class, 'destroy'])->name('destroy');
        Route::get('/show/{id}', [MasterFormulaProdukController::class, 'show'])->name('show');
        Route::get('/print-pdf/{id}', [MasterFormulaProdukController::class, 'printPdf'])->name('print_pdf');
        Route::get('/edit/{id}', [MasterFormulaProdukController::class, 'edit'])->name('edit'); 
        Route::put('/update/{id}', [MasterFormulaProdukController::class, 'update'])->name('update');
        
        Route::get('/master-formula-produk/create', [MasterFormulaProdukController::class, 'create'])->name('master_formula_produk.create');
        Route::get('/master-formula-produk/generate-nomor-formula', [MasterFormulaProdukController::class, 'getGeneratedNomorFormula']);

        Route::get('/get-products', [MasterFormulaProdukController::class, 'getProducts'])->name('get_products');
        Route::get('/master-formula-produk/get-products', [MasterFormulaProdukController::class, 'getProducts'])->name('master_formula_produk.get_products');
        Route::get('/master-formula-produk/get-bahan-baku', [MasterFormulaProdukController::class, 'getBahanBaku']);
        Route::get('/master-formula-produk/get-nomor-formula', [MasterFormulaProdukController::class, 'getNomorFormula'])->name('master_formula_produk.get_nomor_formula');
        Route::get('/master-formula-produk/get-products', [MasterFormulaProdukController::class, 'getProducts']);
        Route::get('/master-formula-produk/get-bahan-baku', [MasterFormulaProdukController::class, 'getBahanBaku']);
        
    });

    Route::get('/master-formula-produk/get-bahan-baku', [MasterFormulaProdukController::class, 'getBahanBaku'])->name('master_formula_produk.get_bahan_baku');
    Route::get('/master-formula-produk/get-bahan-kemas', [MasterFormulaProdukController::class, 'getBahanKemas']);


    /* Master CPB */
    Route::resource('master_cpb', MasterCPBController::class);

    /* Master CKB */
    Route::resource('master_ckb', MasterCKBController::class);
    Route::get('/master-ckb/get-products', [MasterCKBController::class, 'getProducts'])->name('master_ckb.get_products');
    Route::get('/master-ckb/get-nomor-formula', [MasterCKBController::class, 'getNomorFormula'])->name('master_ckb.get_nomor_formula');
    
   /*  Sample Progres */
   
   
   Route::post('/sample-progress', [SampleProgressController::class, 'store'])->name('sample-progress.store');
   Route::get('/sample-progress/check/{id}', [SampleProgressController::class, 'checkProgress'])->name('sample-progress.check');
   Route::get('/sample-progress/{id}/edit', [SampleProgressController::class, 'edit'])->name('sample-progress.edit'); // Tambahkan ini
   Route::post('/sample-progress/{id}/update', [SampleProgressController::class, 'update'])->name('sample-progress.update'); // Tambahkan ini
   Route::get('/sample-progress', [SampleProgressController::class, 'notConfirm'])->name('sample-progress.index');
   Route::get('/sample-progress/confirm', [SampleProgressController::class, 'confirm'])->name('sample-progress.confirm');
   Route::get('/sample-progress/not-confirm', [SampleProgressController::class, 'notConfirm'])->name('sample-progress.not-confirm');
   Route::get('/sample-progress/{id}', [SampleProgressController::class, 'show'])->name('sample-progress.show');
   Route::put('/sample-progress/{id}/confirm', [SampleProgressController::class, 'confirmSample'])->name('sample-progress.confirm-sample');
   Route::get('/sample-progress/{id}/print', [SampleProgressController::class, 'print'])->name('sample-progress.print');


});

 /* Formulir Purchase Request */
 Route::get('/purchase-requests', [PurchaseRequestController::class, 'index'])->name('purchase-requests.index');
 Route::get('/purchase-requests/create', [PurchaseRequestController::class, 'create'])->name('purchase-requests.create');
 Route::get('/purchase-requests/search-asset', [PurchaseRequestController::class, 'searchAsset'])->name('purchase-requests.search-asset');
 Route::get('/purchase-requests/get-satuan', [PurchaseRequestController::class, 'getMasterSatuan'])->name('purchase-requests.get-satuan');
 Route::post('/purchase-requests', [PurchaseRequestController::class, 'store'])->name('purchase-requests.store');
 Route::resource('purchase-requests', PurchaseRequestController::class);
 Route::get('/search-barang', [PurchaseRequestController::class, 'searchBarang'])->name('purchase-requests.search-barang');
 Route::get('/purchase-requests/{id}/print', [PurchaseRequestController::class, 'print'])->name('purchase-requests.print');

 //Singkatan Merk
 Route::resource('singkatan-merk', SingkatanMerkController::class);


 /* Permintaan Warehouse */
Route::prefix('permintaan')->group(function () {
    Route::get('/', [permintaanController::class, 'index'])->name('permintaan')->middleware('auth');
    Route::get('/create', [permintaanController::class, 'create'])->name('permintaan.create');
    Route::delete('/{id}', [permintaanController::class, 'destroy'])->name('permintaan.destroy');
    Route::get('/cariNomorSuratPerintahProduksiPermintaan', [permintaanController::class, 'cariNomorSuratPerintahProduksiPermintaan'])->name('cariNomorSuratPerintahProduksiPermintaan');
    Route::get('/detailNomorSuratPerintahProduksiPermintaan', [permintaanController::class, 'detailNomorSuratPerintahProduksiPermintaan'])->name('detailNomorSuratPerintahProduksiPermintaan');
    Route::get('/detai/{id}', [permintaanController::class, 'show'])->name('permintaan.detail');
    Route::get('/get-stok-barang', [permintaanController::class, 'getStokBarang'])->name('permintaan.getStokBarang');
    Route::get('/get-master-satuan', [permintaanController::class, 'getMasterSatuan'])->name('permintaan.getMasterSatuan');
    Route::post('/simpanPermintaan', [permintaanController::class, 'simpanPermintaan'])->name('permintaan.simpanPermintaan');
    Route::get('/warehouse', [permintaanController::class, 'Warehouse'])->name('permintaan.warehouse');
    Route::get('/export', [permintaanController::class, 'export'])->name('permintaan.export');
    Route::get('/printStokBahanKemasAll', [permintaanController::class, 'printStokBahanKemasAll'])->name('permintaan.printStokBahanKemasAll');
    Route::get('/exportDetailStokBahanKemas', [permintaanController::class, 'exportDetailStokBahanKemas'])->name('permintaan.exportDetailStokBahanKemas');
    Route::get('/printDetailPermintaan{id}', [permintaanController::class, 'printDetailPermintaan'])->name('permintaan.printDetailPermintaan');
});

/* Pengembalian Warehouse */
Route::prefix('pengembalian')->group(function () {
    Route::get('/', [pengembalianController::class, 'index'])->name('pengembalian')->middleware('auth');
    Route::get('/create', [pengembalianController::class, 'create'])->name('pengembalian.create');
    Route::delete('/{id}', [pengembalianController::class, 'destroy'])->name('pengembalian.destroy');
    Route::get('/cariNomorSuratPerintahProduksiPengembalian', [pengembalianController::class, 'cariNomorSuratPerintahProduksiPengembalian'])->name('cariNomorSuratPerintahProduksiPengembalian');
    Route::get('/detailNomorSuratPerintahProduksiPengembalian', [pengembalianController::class, 'detailNomorSuratPerintahProduksiPengembalian'])->name('detailNomorSuratPerintahProduksiPengembalian');
    Route::post('/simpanPengembalian', [pengembalianController::class, 'simpanPengembalian'])->name('simpanPengembalian');
    Route::get('/detail/{id}', [pengembalianController::class, 'show'])->name('pengembalian.detail');
    Route::get('/get-master-satuan', [pengembalianController::class, 'getMasterSatuan'])->name('pengembalian.getMasterSatuan');
    Route::get('/get-stok-barang', [pengembalianController::class, 'getStokBarang'])->name('pengembalian.getStokBarang');
    Route::post('/simpanPengembalian', [pengembalianController::class, 'simpanPengembalian'])->name('pengembalian.simpanPengembalian');

    Route::get('/warehouse', [pengembalianController::class, 'warehouse'])->name('pengembalian.warehouse');
    Route::get('/export', [pengembalianController::class, 'export'])->name('pengembalian.export');
    Route::get('/printStokBahanKemasAll', [pengembalianController::class, 'printStokBahanKemasAll'])->name('pengembalian.printStokBahanKemasAll');
    Route::get('/exportDetailStokBahanKemas', [pengembalianController::class, 'exportDetailStokBahanKemas'])->name('pengembalian.exportDetailStokBahanKemas');
    Route::get('/printDetailPengembalian/{id}', [pengembalianController::class, 'printDetailPengembalian'])->name('pengembalian.printDetailPengembalian');
});


Route::middleware(['auth', 'role:SUPER ADMIN'])->group(function () {
    Route::get('/role-permission', [RolePermissionController::class, 'index'])->name('role-permission.index');
    Route::post('/role-permission', [RolePermissionController::class, 'assign'])->name('role-permission.assign');
});

Route::middleware(['auth', 'role:SUPER ADMIN'])->prefix('accounts')->name('accounts.')->group(function () {
    Route::get('/', [AccountController::class, 'index'])->name('index');
    Route::get('/create', [AccountController::class, 'create'])->name('create');
    Route::post('/store', [AccountController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [AccountController::class, 'edit'])->name('edit');
    Route::put('/update/{id}', [AccountController::class, 'update'])->name('update');
    Route::delete('/destroy/{id}', [AccountController::class, 'destroy'])->name('destroy');

});



// Rute logout
Route::post('/logout', function () {
    Auth::logout();
    return redirect()->route('login')->with('success', 'Anda telah logout.');
})->name('logout');
