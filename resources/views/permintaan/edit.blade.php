@extends('layout.main')
@section('content')
<div class="w-full px-6 py-6 mx-auto mt-10">
    <div class="bg-white shadow-lg rounded-lg p-6">
        <div class="text-center flex-1 mb-6">
            <h2 class="mb-2 font-bold text-white rounded-md px-4 py-2 inline-block rounded-xl shadow-md md:text-lg text-2xl" style="background-color: #000923;">
                Edit Data Karir Karyawan
            </h2>
        </div>
        <form action="{{ route('riwayat_kerja_internal.update', $data->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="staff_input" class="font-bold text-gray-700">Staff Input</label>
                    <input type="text" id="staff_input" name="staff_input" 
                        class="rounded-lg mt-1 block w-full border border-gray-300 focus:ring-blue-500 focus:border-blue-500 text-gray-700 text-sm h-10 px-3" 
                        placeholder="Nama Staff Input" value="{{ old('staff_input', $data->staff_input) }}">
                </div>

                <div>
                    <label for="nama" class="font-bold text-gray-700">Nama</label>
                    <input type="text" id="nama" name="nama" 
                        class="rounded-lg mt-1 block w-full border border-gray-300 focus:ring-blue-500 focus:border-blue-500 text-gray-700 text-sm h-10 px-3" 
                        placeholder="Nama" value="{{ old('nama', $data->nama) }}">
                </div>

                <div>
                    <label for="nik" class="font-bold text-gray-700">NIK</label>
                    <input type="number" id="nik" name="nik" 
                        class="rounded-lg mt-1 block w-full border border-gray-300 focus:ring-blue-500 focus:border-blue-500 text-gray-700 text-sm h-10 px-3" 
                        placeholder="NIK" value="{{ old('nik', $data->nik) }}">
                </div>

                <div>
                    <label for="tanggal_mulai_training" class="font-bold text-gray-700">Tanggal Mulai Training</label>
                    <input type="date" id="tanggal_mulai_training" name="tanggal_mulai_training" 
                        class="rounded-lg mt-1 block w-full border border-gray-300 focus:ring-blue-500 focus:border-blue-500 text-gray-700 text-sm h-10 px-3" 
                        value="{{ old('tanggal_mulai_training', $data->tanggal_mulai_training) }}">
                </div>

                <div>
                    <label for="tanggal_berakhir_training" class="font-bold text-gray-700">Tanggal Berakhir Training</label>
                    <input type="date" id="tanggal_berakhir_training" name="tanggal_berakhir_training" 
                        class="rounded-lg mt-1 block w-full border border-gray-300 focus:ring-blue-500 focus:border-blue-500 text-gray-700 text-sm h-10 px-3" 
                        value="{{ old('tanggal_berakhir_training', $data->tanggal_berakhir_training) }}">
                </div>

                <div>
                    <label for="dokumen_training" class="font-bold text-gray-700">Dokumen Training (PDF, PNG, JPG, JPEG)</label>
                    <input type="file" id="dokumen_training" name="dokumen_training" accept=".pdf,.png,.jpg,.jpeg"
                        class="rounded-lg mt-1 block w-full border border-gray-300 focus:ring-blue-500 focus:border-blue-500 text-gray-700 text-sm h-10 px-3">
                </div>

                <div>
                    <label for="kontrak_pertama" class="font-bold text-gray-700">Kontrak Pertama</label>
                    <input type="date" id="kontrak_pertama" name="kontrak_pertama" 
                        class="rounded-lg mt-1 block w-full border border-gray-300 focus:ring-blue-500 focus:border-blue-500 text-gray-700 text-sm h-10 px-3" 
                        value="{{ old('kontrak_pertama', $data->kontrak_pertama) }}">
                </div>

                <div>
                    <label for="ber akhir_kontrak" class="font-bold text-gray-700">Berakhir Kontrak</label>
                    <input type="date" id="berakhir_kontrak" name="berakhir_kontrak" 
                        class="rounded-lg mt-1 block w-full border border-gray-300 focus:ring-blue-500 focus:border-blue-500 text-gray-700 text-sm h-10 px-3" 
                        value="{{ old('berakhir_kontrak', $data->berakhir_kontrak) }}">
                </div>

                <div>
                    <label for="dokumen_kontrak" class="font-bold text-gray-700">Dokumen Kontrak (PDF, PNG, JPG, JPEG)</label>
                    <input type="file" id="dokumen_kontrak" name="dokumen_kontrak" accept=".pdf,.png,.jpg,.jpeg"
                        class="rounded-lg mt-1 block w-full border border-gray-300 focus:ring-blue-500 focus:border-blue-500 text-gray-700 text-sm h-10 px-3">
                </div>

                <div>
                    <label for="kontrak_lanjutan" class="font-bold text-gray-700">Kontrak Lanjutan</label>
                    <input type="date" id="kontrak_lanjutan" name="kontrak_lanjutan" 
                        class="rounded-lg mt-1 block w-full border border-gray-300 focus:ring-blue-500 focus:border-blue-500 text-gray-700 text-sm h-10 px-3" 
                        value="{{ old('kontrak_lanjutan', $data->kontrak_lanjutan) }}">
                </div>

                <div>
                    <label for="berakhir_kontrak_lanjutan" class="font-bold text-gray-700">Berakhir Kontrak Lanjutan</label>
                    <input type="date" id="berakhir_kontrak_lanjutan" name="berakhir_kontrak_lanjutan" 
                        class="rounded-lg mt-1 block w-full border border-gray-300 focus:ring-blue-500 focus:border-blue-500 text-gray-700 text-sm h-10 px-3" 
                        value="{{ old('berakhir_kontrak_lanjutan', $data->berakhir_kontrak_lanjutan) }}">
                </div>

                <div>
                    <label for="dokumen_kontrak_lanjutan" class="font-bold text-gray-700">Dokumen Kontrak Lanjutan (PDF, PNG, JPG, JPEG)</label>
                    <input type="file" id="dokumen_kontrak_lanjutan" name="dokumen_kontrak_lanjutan" accept=".pdf,.png,.jpg,.jpeg"
                        class="rounded-lg mt-1 block w-full border border-gray-300 focus:ring-blue-500 focus:border-blue-500 text-gray-700 text-sm h-10 px-3">
                </div>

                <div>
                    <label for="status_kerja" class="font-bold text-gray-700">Status Kerja</label>
                    <input type="text" id="status_kerja" name="status_kerja" 
                        class="rounded-lg mt-1 block w-full border border-gray-300 focus:ring-blue-500 focus:border-blue-500 text-gray-700 text-sm h-10 px-3" 
                        placeholder="Status Kerja" value="{{ old('status_kerja', $data->status_kerja) }}">
                </div>

                <div>
                    <label for="tanggal_informasi" class="font-bold text-gray-700">Tanggal Informasi</label>
                    <input type="date" id="tanggal_informasi" name="tanggal_informasi" 
                        class="rounded-lg mt-1 block w-full border border-gray-300 focus:ring-blue-500 focus:border-blue-500 text-gray-700 text-sm h-10 px-3" 
                        value="{{ old('tanggal_informasi', $data->tanggal_informasi) }}">
                </div>

                <div>
                    <label for="brand_sekarang" class="font-bold text-gray-700">Brand Sekarang</label>
                    <input type="text" id="brand_sekarang" name="brand_sekarang" 
                        class="rounded-lg mt-1 block w-full border border-gray-300 focus:ring-blue-500 focus:border-blue-500 text-gray-700 text-sm h-10 px-3" 
                        placeholder="Brand Sekarang" value="{{ old('brand_sekarang', $data->brand_sekarang) }}">
                </div>

                <div>
                    <label for="divisi_sekarang" class="font-bold text-gray-700">Divisi Sekarang</label>
                    <input type="text" id="div isi_sekarang" name="divisi_sekarang" 
                        class="rounded-lg mt-1 block w-full border border-gray-300 focus:ring-blue-500 focus:border-blue-500 text-gray-700 text-sm h-10 px-3" 
                        placeholder="Divisi Sekarang" value="{{ old('divisi_sekarang', $data->divisi_sekarang) }}">
                </div>

                <div>
                    <label for="jabatan_sekarang" class="font-bold text-gray-700">Jabatan Sekarang</label>
                    <input type="text" id="jabatan_sekarang" name="jabatan_sekarang" 
                        class="rounded-lg mt-1 block w-full border border-gray-300 focus:ring-blue-500 focus:border-blue-500 text-gray-700 text-sm h-10 px-3" 
                        placeholder="Jabatan Sekarang" value="{{ old('jabatan_sekarang', $data->jabatan_sekarang) }}">
                </div>

                <div>
                    <label for="brand_new" class="font-bold text-gray-700">Brand Baru</label>
                    <input type="text" id="brand_new" name="brand_new" 
                        class="rounded-lg mt-1 block w-full border border-gray-300 focus:ring-blue-500 focus:border-blue-500 text-gray-700 text-sm h-10 px-3" 
                        placeholder="Brand Baru" value="{{ old('brand_new', $data->brand_new) }}">
                </div>

                <div>
                    <label for="divisi_new" class="font-bold text-gray-700">Divisi Baru</label>
                    <input type="text" id="divisi_new" name="divisi_new" 
                        class="rounded-lg mt-1 block w-full border border-gray-300 focus:ring-blue-500 focus:border-blue-500 text-gray-700 text-sm h-10 px-3" 
                        placeholder="Divisi Baru" value="{{ old('divisi_new', $data->divisi_new) }}">
                </div>

                <div>
                    <label for="jabatan_new" class="font-bold text-gray-700">Jabatan Baru</label>
                    <input type="text" id="jabatan_new" name="jabatan_new" 
                        class="rounded-lg mt-1 block w-full border border-gray-300 focus:ring-blue-500 focus:border-blue-500 text-gray-700 text-sm h-10 px-3" 
                        placeholder="Jabatan Baru" value="{{ old('jabatan_new', $data->jabatan_new) }}">
                </div>

                <div>
                    <label for="tanggal_efektif_mulai" class="font-bold text-gray-700">Tanggal Efektif Mulai</label>
                    <input type="date" id="tanggal_efektif_mulai" name="tanggal_efektif_mulai" 
                        class="rounded-lg mt-1 block w-full border border-gray-300 focus:ring-blue-500 focus:border-blue-500 text-gray-700 text-sm h-10 px-3" 
                        value="{{ old('tanggal_efektif_mulai', $data->tanggal_efektif_mulai) }}">
                </div>

                <div>
                    <label for="tanggal_berakhir" class="font-bold text-gray-700">Tanggal Berakhir</label>
                    <input type="date" id="tanggal_berakhir" name="tanggal_berakhir" 
                        class="rounded-lg mt-1 block w-full border border-gray-300 focus:ring-blue-500 focus:border-blue-500 text-gray-700 text-sm h-10 px-3" 
                        value="{{ old('tanggal_berakhir', $data->tanggal_berakhir) }}">
                </div>

                <div>
                    <label for="lampiran_dokumen" class="font-bold text-gray-700">Lampiran Dokumen (PDF, PNG, JPG, JPEG)</label>
                    <input type="file" id="lampiran_dokumen" name="lampiran_dokumen" accept=".pdf,.png,.jpg,.jpeg"
                        class="rounded-lg mt-1 block w-full border border-gray-300 focus:ring-blue-500 focus:border-blue-500 text-gray-700 text-sm h-10 px-3">
                </div>

                <div>
                    <label for="office_id" class="font-bold text-gray-700">Office ID</label>
                    <input type="text" id="office_id" name="office_id" 
                        class="rounded-lg mt-1 block w-full border border-gray-300 focus:ring-blue-500 focus:border-blue-500 text-gray-700 text-sm h-10 px-3" 
                        placeholder="Office ID" value="{{ old('office_id', $data->office_id) }}">
                </div>

                <div>
                    <label for="keterangan_informasi" class="font-bold text-gray-700">Keterangan Informasi</label>
                    <input type="text" id="keterangan_informasi" name="keterangan_informasi" 
                        class="rounded-lg mt-1 block w-full border border-gray-300 focus:ring-blue-500 focus:border-blue-500 text-gray-700 text-sm h-10 px-3" 
                        placeholder="Keterangan Informasi" value="{{ old('keterangan_informasi', $data->keterangan_informasi) }}">
                </div>
            </div>
            <div class="text-right mt-6">
                <button type="submit" 
                        class="px-6 py-2 bg-blue-500 text-white rounded-lg font-semibold hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 shadow-md">
                    Update
                </button>
            </div>
        </form>
    </div>
</div>
@endsection