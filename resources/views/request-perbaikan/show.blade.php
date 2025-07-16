@extends('layout.main')

@section('title', 'Detail Tindakan Perbaikan/Pemeliharaan')

@section('content')
@php
$jenis = $data->request->jenis;
@endphp
<div class="w-full px-6 py-6 mx-auto mt-10">
    <div class="bg-white shadow-lg rounded-lg p-6">
        <h3 class="text-2xl font-bold mb-4 flex items-center">
            Detail {{ $jenis === 'Perbaikan' ? 'Perbaikan' : 'Pemeliharaan'}} - {{ $data->request->nomor_request_perbaikan }}
            <span class="py-2 px-4 ml-4 text-lg rounded-3 inline-block whitespace-nowrap text-center bg-gradient-to-tl {{ $data->status_permohonan == 'Not Confirmed' ? 'from-slate-600 to-slate-300' : 'from-emerald-500 to-teal-400' }}  align-baseline font-bold uppercase leading-none text-white">
                {{ $data->status_permohonan }}
            </span>
            @if ($data->approval_status === 0)
            <span class="py-2 px-4 ml-4 text-lg rounded-3 inline-block whitespace-nowrap text-center bg-gradient-to-tl from-red-600 to-orange-600 align-baseline font-bold uppercase leading-none text-white">
                {{ $data->approval_status === 0 ? 'Ditolak' : '' }}
            </span>
            @else
            <span class="py-2 px-4 ml-4 text-lg rounded-3 inline-block whitespace-nowrap text-center bg-gradient-to-tl
                    {{ $data->status_perbaikan == 'Open'
                        ? 'from-slate-600 to-slate-300'
                        : ($data->status_perbaikan == 'Progress'
                            ? 'from-orange-500 to-yellow-500'
                            : ($data->status_perbaikan == 'Close'
                                ? 'from-emerald-500 to-teal-400'
                                : '')) }}
                    align-baseline font-bold uppercase leading-none text-white">
                {{ $data->status_perbaikan }}
            </span>
            @endif
        </h3>

        <div class="flex-auto p-6">
            <div class="flex flex-wrap -mx-3 mb-2 items-center">
                <div class="w-full max-w-full px-3 shrink-0 md:w-6/12 md:flex-0">
                    <label class="leading-normal uppercase dark:text-white dark:opacity-60 text-sm">Detail Permohonan</label>
                </div>
                <div class="w-full max-w-full px-3 shrink-0 md:w-6/12 md:flex-0 flex justify-end">
                    <a href="{{ route('request_perbaikan.print', ['id' => $data->id]) }}" target="_blank"
                        class="inline-block px-3 py-1.5 text-center bg-blue-500 uppercase align-middle transition-all rounded-lg cursor-pointer leading-[1.4] text-[0.75rem] ease-in tracking-tight shadow-xs bg-150 bg-x-25 hover:-translate-y-px active:opacity-[.85] hover:shadow-md text-white"
                        id="btn_cetak" name="btn_cetak">
                        <i class="fas fa-print mr-2"></i>Print
                    </a>
                </div>
            </div>
            <div class="flex flex-wrap -mx-3">
                <div class="w-full max-w-full px-3 shrink-0 md:w-6/12 md:flex-0">
                    <div class="mb-4">
                        <label for="nomor_request_perbaikan" class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700 dark:text-white/80">Nomor Request {{ $jenis === 'Perbaikan' ? 'Perbaikan' : 'Pemeliharaan'}}</label>
                        <input type="text" name="nomor_request_perbaikan" id="nomor_request_perbaikan" value="{{ $data->request->nomor_request_perbaikan }}" class="focus:shadow-primary-outline dark:bg-slate-850 dark:text-white text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-gray-500 bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none" readonly>
                    </div>
                </div>
                <div class="w-full max-w-full px-3 shrink-0 md:w-6/12 md:flex-0">
                    <div class="mb-4">
                        <label for="tanggal_request_perbaikan" class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700 dark:text-white/80">Tanggal Permohonan</label>
                        <input type="text" id="tanggal_request_perbaikan" name="tanggal_request_perbaikan" value="{{ date('d M Y', strtotime($data->request->tanggal)) }}" class="focus:shadow-primary-outline dark:bg-slate-850 dark:text-white text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-gray-500 bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none" readonly>
                    </div>
                </div>
                <div class="w-full max-w-full px-3 shrink-0 md:w-4/12 md:flex-0">
                    <div class="mb-4">
                        <label for="nama_pemohon" class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700 dark:text-white/80">Nama Pemohon</label>
                        <input type="text" id="nama_pemohon" name="nama_pemohon" value="{{ $data->request->id_input }}" class="focus:shadow-primary-outline dark:bg-slate-850 dark:text-white text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-gray-500 bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none" readonly>
                    </div>
                </div>
                <div class="w-full max-w-full px-3 shrink-0 md:w-4/12 md:flex-0">
                    <div class="mb-4">
                        <label for="departemen_pemohon" class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700 dark:text-white/80">Departemen {{ $jenis === 'Perbaikan' ? 'Pemohon' : 'Tujuan'}}</label>
                        <input type="text" id="departemen_pemohon" name="departemen_pemohon" value="{{ $data->request->departemen_pemohon }}" class="focus:shadow-primary-outline dark:bg-slate-850 dark:text-white text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-gray-500 bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none" readonly>
                    </div>
                </div>
                <div class="w-full max-w-full px-3 shrink-0 md:w-4/12 md:flex-0">
                    <div class="mb-4">
                        <label for="lokasi_ruangan" class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700 dark:text-white/80">Lokasi Ruangan</label>
                        <input type="text" name="lokasi_ruangan" id="lokasi_ruangan" value="{{ $data->request->lokasi_ruangan }}" class="focus:shadow-primary-outline dark:bg-slate-850 dark:text-white text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-gray-500 bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none" readonly>
                    </div>
                </div>
                @if($data->Request->jenis_perbaikan === 'Aset')
                <div class="w-full max-w-full px-3 shrink-0 md:w-6/12 md:flex-0">
                    <div class="mb-4">
                        <label for="kode_aset" class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700 dark:text-white/80">Kode Aset</label>
                        <input type="text" name="kode_aset" id="kode_aset" value="{{ $data->kode_aset }}" class="focus:shadow-primary-outline dark:bg-slate-850 dark:text-white text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-gray-500 bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none" readonly>
                    </div>
                </div>
                <div class="w-full max-w-full px-3 shrink-0 md:w-6/12 md:flex-0">
                    <div class="mb-4">
                        <label for="nama_aset" class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700 dark:text-white/80">Nama Aset</label>
                        <input type="text" name="nama_aset" id="nama_aset" value="{{ $data->nama_aset }}" class="focus:shadow-primary-outline dark:bg-slate-850 dark:text-white text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-gray-500 bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none" readonly>
                    </div>
                </div>
                @endif <!-- if($data->Request->jenis_perbaikan === 'Aset') -->
                <div class="w-full max-w-full px-3 shrink-0 md:w-full md:flex-0">
                    <div class="mb-4">
                        <label for="deskripsi_kerusakan" class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700 dark:text-white/80">Deskripsi {{ $jenis === 'Perbaikan' ? 'Kerusakan' : 'Pemeliharaan'}}</label>
                        <p name="deskripsi_kerusakan" id="deskripsi_kerusakan" class="focus:shadow-primary-outline text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-gray-500 bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none" style="text-align: justify;">{{ $data->deskripsi_kerusakan }}</p>
                    </div>
                </div>
                <p class="px-3 leading-normal ml-1 font-bold text-slate-700 dark:text-white dark:opacity-60 text-xs">Dokumentasi {{ $jenis === 'Perbaikan' ? 'Kerusakan' : 'Pemeliharaan'}}</p>
                <div class="w-full max-w-full px-3 shrink-0 md:w-full md:flex-0">
                    @php
                    $images = json_decode($data->dokumentasi_kerusakan, true); // Decode JSON ke array
                    $totalImages = count($images);
                    @endphp
                    <div class="flex space-x-2 mb-2">
                        @foreach ($images as $index => $image)
                        @if ($index < 3)
                            <a href="{{ asset('engineering_storage/' . $image) }}" class="glightbox mr-2"
                            data-title="Gambar {{ $index + 1 }}: {{ basename($image) }}">
                            <img src="{{ asset('engineering_storage/' . $image) }}"
                                alt="Dokumentasi Kerusakan"
                                class="w-20 h-auto rounded-lg" width="120px">
                            </a>
                            @elseif ($index === 3)
                            <a href="{{ asset('engineering_storage/' . $image) }}"
                                class="glightbox relative"
                                data-title="Gambar {{ $index + 1 }}: {{ basename($image) }}">
                                <img src="{{ asset('engineering_storage/' . $image) }}"
                                    alt="Dokumentasi Kerusakan"
                                    class="w-20 h-auto rounded-lg opacity-80" width="120px">
                                <div
                                    class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-60 text-white font-bold text-sm">
                                    +{{ $totalImages - 4 }}
                                </div>
                            </a>
                            @endif
                            @endforeach
                    </div>
                </div>
            </div>

            @if($data->approval_status !== NULL)
            <hr class="h-px mx-0 my-4 bg-transparent border-0 opacity-25 bg-gradient-to-r from-transparent via-black/40 to-transparent dark:bg-gradient-to-r dark:from-transparent dark:via-white dark:to-transparent ">

            <p class="leading-normal uppercase dark:text-white dark:opacity-60 text-sm">Approval</p>

            <div class="flex flex-wrap -mx-3">
                <div class="w-full max-w-full px-3 shrink-0 md:w-6/12 md:flex-0">
                    <div class="mb-4">
                        <label for="nama_approval" class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700 dark:text-white/80">Nama {{ $data->approval_status == 0 ? 'Pe-reject' : 'Peng-approve'}}</label>
                        <input type="text" name="nama_approval" id="nama_approval" value="{{ $data->approval_by ?? '' }}" class="focus:shadow-primary-outline dark:bg-slate-850 dark:text-white text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-gray-500 bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none" placeholder="Masukkan Nama Teknisi" readonly>
                    </div>
                </div>
                <div class="w-full max-w-full px-3 shrink-0 md:w-6/12 md:flex-0">
                    <div class="mb-4">
                        <label for="tanggal_waktu_approval" class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700 dark:text-white/80">Tanggal dan Waktu {{ $data->approval_status == 0 ? 'Di-reject' : 'Di-approve'}}</label>
                        <input type="datetime-local" name="tanggal_waktu_approval" id="tanggal_waktu_approval" value="{{ $data->tanggal_approval ?? '' }}" class="focus:shadow-primary-outline dark:bg-slate-850 dark:text-white text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-gray-500 bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none" readonly>
                    </div>
                </div>
            </div>
            @endif

            @if(!empty($dataTindakan->id))
            @if(!empty($dataTindakan->Sparepart) && count($dataTindakan->Sparepart) > 0)
            <hr class="h-px mx-0 my-4 bg-transparent border-0 opacity-25 bg-gradient-to-r from-transparent via-black/40 to-transparent dark:bg-gradient-to-r dark:from-transparent dark:via-white dark:to-transparent ">

            <!-- Form Pencarian Sparepart -->
            <div class="flex flex-wrap -mx-3">
                <!-- Detail Barang -->
                <div class="w-full max-w-full px-3 shrink-0 md:w-full md:flex-0">
                    <h3 class="block font-bold text-sm text-slate-700 mt-2">Detail Sparepart</h3>
                    <div class="overflow-x-auto">
                        <table id="details" class="table-auto w-full border-collapse border border-gray-300">
                            <thead>
                                <tr class="bg-gray-200">
                                    <th class="border border-gray-300 px-4 py-2 font-bold text-sm text-slate-700">No</th>
                                    <th class="border border-gray-300 px-4 py-2 font-bold text-sm text-slate-700">Kode Sparepart</th>
                                    <th class="border border-gray-300 px-4 py-2 font-bold text-sm text-slate-700">Nama Sparepart</th>
                                    <th class="border border-gray-300 px-4 py-2 font-bold text-sm text-slate-700">Jml Digunakan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(!empty($dataTindakan->Sparepart) && count($dataTindakan->Sparepart) > 0)
                                @foreach($dataTindakan->Sparepart as $index => $sparepart)
                                <tr data-from-db="true">
                                    <td class="border px-4 py-2">
                                        {{ $index+1 }}
                                    </td>
                                    <td class="border px-4 py-2">
                                        {{ $sparepart->masterSparepart->kode_sparepart }}
                                    </td>
                                    <td class="border px-4 py-2">
                                        {{ $sparepart->masterSparepart->nama_sparepart }}
                                    </td>
                                    <td class="border px-4 py-2">
                                        {{ $sparepart->jumlah_terpakai }}
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td class="border px-4 py-2 text-center" colspan="4">Tidak ada data sparepart</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif <!-- endif untuk !empty($dataTindakan->Sparepart) -->

            @if(!empty($dataTindakan->id_teknisi_sementara) || !empty($dataTindakan->tanggal_waktu_sementara) || !empty($dataTindakan->tindakan_sementara))
            <hr class="h-px mx-0 my-4 bg-transparent border-0 opacity-25 bg-gradient-to-r from-transparent via-black/40 to-transparent dark:bg-gradient-to-r dark:from-transparent dark:via-white dark:to-transparent ">

            <p class="leading-normal uppercase dark:text-white dark:opacity-60 text-sm">Tindakan Sementara</p>
            <div class="flex flex-wrap -mx-3">
                <div class="w-full max-w-full px-3 shrink-0 md:w-6/12 md:flex-0">
                    <div class="mb-4">
                        <label for="nama_teknisi_sementara" class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700 dark:text-white/80">Teknisi</label>
                        <input type="text" name="nama_teknisi_sementara" id="nama_teknisi_sementara" value="{{ $dataTindakan->id_teknisi_sementara ?? '' }}" class="focus:shadow-primary-outline dark:bg-slate-850 dark:text-white text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-gray-500 bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none" placeholder="Masukkan Nama Teknisi" readonly>
                    </div>
                </div>
                <div class="w-full max-w-full px-3 shrink-0 md:w-6/12 md:flex-0">
                    <div class="mb-4">
                        <label for="tanggal_waktu_sementara" class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700 dark:text-white/80">Tanggal dan Waktu</label>
                        <input type="datetime-local" name="tanggal_waktu_sementara" id="tanggal_waktu_sementara" value="{{ $dataTindakan->tanggal_waktu_sementara ?? '' }}" class="focus:shadow-primary-outline dark:bg-slate-850 dark:text-white text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-gray-500 bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none" readonly>
                    </div>
                </div>
                <div class="w-full max-w-full px-3 shrink-0 md:w-full md:flex-0">
                    <div class="mb-4">
                        <label for="tindakan_sementara" class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700 dark:text-white/80">Tindakan Sementara</label>
                        <p name="tindakan_sementara" id="tindakan_sementara" class="focus:shadow-primary-outline text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-gray-500 bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none" style="text-align: justify;">{{ $dataTindakan->tindakan_sementara ?? '' }}</p>
                    </div>
                </div>
            </div>

            <p class="leading-normal ml-1 font-bold text-slate-700 dark:text-white dark:opacity-60 text-xs">Dokumentasi {{ $jenis === 'Perbaikan' ? 'Perbaikan' : 'Pemeliharaan'}} Sementara</p>

            @if(!empty($dataTindakan->dokumentasi_perbaikan_sementara))
            @php
            $dokSementara = json_decode($dataTindakan->dokumentasi_perbaikan_sementara, true);
            @endphp
            <div class="flex flex-wrap -mx-3">
                <div class="w-full max-w-full px-3 shrink-0 md:w-full md:flex-0">
                    @php
                    $dokSementara = json_decode($dataTindakan->dokumentasi_perbaikan_sementara, true);
                    $totalImages = count($dokSementara);
                    @endphp
                    <div class="flex space-x-2">
                        @foreach($dokSementara as $index => $dok)
                        @if ($index < 3)
                            <a href="{{ asset('engineering_storage/' . $dok) }}" class="glightbox"
                            data-title="Gambar {{ $index + 1 }}: {{ basename($dok) }}">
                            <img src="{{ asset('engineering_storage/' . $dok) }}"
                                alt="Dokumentasi {{ $jenis === 'Perbaikan' ? 'Perbaikan' : 'Pemeliharaan'}} Sementara"
                                class="w-20 h-auto rounded-lg" width="120px">
                            </a>
                            @elseif ($index === 3)
                            <a href="{{ asset('engineering_storage/' . $dok) }}"
                                class="glightbox relative"
                                data-title="Gambar {{ $index + 1 }}: {{ basename($dok) }}">
                                <img src="{{ asset('engineering_storage/' . $dok) }}"
                                    alt="Dokumentasi {{ $jenis === 'Perbaikan' ? 'Perbaikan' : 'Pemeliharaan'}} Sementara"
                                    class="w-20 h-auto rounded-lg opacity-80" width="120px">
                                <div
                                    class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-60 text-white font-bold text-sm">
                                    +{{ $totalImages - 4 }}
                                </div>
                            </a>
                            @endif
                            @endforeach
                    </div>
                </div>
            </div>
            @endif <!--  if(!empty($dataTindakan->dokumentasi_perbaikan_sementara)) -->
            @endif <!-- if(!empty($dataTindakan->id_teknisi_sementara) || !empty($dataTindakan->tanggal_waktu_sementara || !empty($dataTindakan->tindakan_sementara))) -->

            @if(!empty($dataTindakan->id_teknisi_lanjutan) || !empty($dataTindakan->tanggal_waktu_lanjutan) || !empty($dataTindakan->tindakan_lanjutan))
            <hr class="h-px mx-0 my-4 bg-transparent border-0 opacity-25 bg-gradient-to-r from-transparent via-black/40 to-transparent dark:bg-gradient-to-r dark:from-transparent dark:via-white dark:to-transparent ">

            <p class="leading-normal uppercase dark:text-white dark:opacity-60 text-sm">Tindakan Lanjutan</p>
            <div class="flex flex-wrap -mx-3">
                <div class="w-full max-w-full px-3 shrink-0 md:w-6/12 md:flex-0">
                    <div class="mb-4">
                        <label for="nama_teknisi_lanjutan" class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700 dark:text-white/80">Teknisi</label>
                        <input type="text" name="nama_teknisi_lanjutan" id="nama_teknisi_lanjutan" value="{{ $dataTindakan->id_teknisi_lanjutan ?? '' }}" class="focus:shadow-primary-outline dark:bg-slate-850 dark:text-white text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-gray-500 bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none" placeholder="Masukkan Nama Teknisi" readonly>
                    </div>

                </div>
                <div class="w-full max-w-full px-3 shrink-0 md:w-6/12 md:flex-0">
                    <div class="mb-4">
                        <label for="tanggal_waktu_lanjutan" class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700 dark:text-white/80">Tanggal dan Waktu</label>
                        <input type="datetime-local" name="tanggal_waktu_lanjutan" id="tanggal_waktu_lanjutan" value="{{  $dataTindakan->tanggal_waktu_lanjutan ?? '' }}" class="focus:shadow-primary-outline dark:bg-slate-850 dark:text-white text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-gray-500 bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none" readonly>
                    </div>
                </div>
                <div class="w-full max-w-full px-3 shrink-0 md:w-full md:flex-0">
                    <div class="mb-4">
                        <label for="tindakan_lanjutan" class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700 dark:text-white/80">Tindakan Lanjutan</label>
                        <p name="tindakan_lanjutan" id="tindakan_lanjutan" class="focus:shadow-primary-outline text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-gray-500 bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none" style="text-align: justify;">{{ $dataTindakan->tindakan_lanjutan ?? '' }}</p>
                    </div>
                </div>
            </div>

            <p class="leading-normal ml-1 font-bold text-slate-700 dark:text-white dark:opacity-60 text-xs">Dokumentasi {{ $jenis === 'Perbaikan' ? 'Perbaikan' : 'Pemeliharaan'}} Lanjutan</p>

            @if(!empty($dataTindakan->dokumentasi_perbaikan_lanjutan))
            @php
            $dokLanjutan = json_decode($dataTindakan->dokumentasi_perbaikan_lanjutan, true);
            @endphp
            <div class="flex flex-wrap -mx-3">
                <div class="w-full max-w-full px-3 shrink-0 md:w-full md:flex-0">
                    @php
                    $dokLanjutan = json_decode($dataTindakan->dokumentasi_perbaikan_lanjutan, true);
                    $totalImages = count($dokLanjutan);
                    @endphp
                    <div class="flex space-x-2">
                        @foreach($dokLanjutan as $index => $dok)
                        @if ($index < 3)
                            <a href="{{ asset('engineering_storage/' . $dok) }}" class="glightbox-perbaikan-lanjutan"
                            data-title="Gambar {{ $index + 1 }}: {{ basename($dok) }}">
                            <img src="{{ asset('engineering_storage/' . $dok) }}"
                                alt="Dokumentasi {{ $jenis === 'Perbaikan' ? 'Perbaikan' : 'Pemeliharaan'}} Lanjutan"
                                class="w-20 h-auto rounded-lg" width="120px">
                            </a>
                            @elseif ($index === 3)
                            <a href="{{ asset('engineering_storage/' . $dok) }}"
                                class="glightbox-perbaikan-lanjutan relative"
                                data-title="Gambar {{ $index + 1 }}: {{ basename($dok) }}">
                                <img src="{{ asset('engineering_storage/' . $dok) }}"
                                    alt="Dokumentasi {{ $jenis === 'Perbaikan' ? 'Perbaikan' : 'Pemeliharaan'}} Lanjutan"
                                    class="w-20 h-auto rounded-lg opacity-80" width="120px">
                                <div
                                    class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-60 text-white font-bold text-sm">
                                    +{{ $totalImages - 4 }}
                                </div>
                            </a>
                            @endif
                            @endforeach
                    </div>
                </div>
            </div>
            @endif <!-- if(!empty($dataTindakan->dokumentasi_perbaikan_lanjutan)) -->
            @endif <!-- endif untuk if(!empty($dataTindakan->id_teknisi_lanjutan) || !empty($dataTindakan->tanggal_waktu_lanjutan || !empty($dataTindakan->tindakan_lanjutan))) -->
            @endif <!-- endif untuk !empty($dataTindakan->id) -->

            <hr class="h-px mx-0 my-4 bg-transparent border-0 opacity-25 bg-gradient-to-r from-transparent via-black/40 to-transparent dark:bg-gradient-to-r dark:from-transparent dark:via-white dark:to-transparent ">
            <button type="button" class="ml-3 inline-block px-4 py-2 text-center bg-gray-500 uppercase align-middle transition-all rounded-lg cursor-pointer leading-[1.4] text-[0.75rem] ease-in tracking-tight shadow-xs bg-150 bg-x-25 hover:-translate-y-px active:opacity-[.85] hover:shadow-md text-white" onclick="history.back()">Kembali</button>
        </div>

    </div>
</div>

<script>
    $(document).ready(function() {
        // Inisialisasi Glightbox
        const lightbox = GLightbox({
            selector: '.glightbox', // Selector untuk elemen dengan kelas "glightbox"
            touchNavigation: true,
            zoomable: true,
            draggable: true,
        });

        // Inisialisasi Glightbox
        const lightboxPerbaikanLanjutan = GLightbox({
            selector: '.glightbox-perbaikan-lanjutan', // Selector untuk elemen dengan kelas "glightbox"
            touchNavigation: true,
            zoomable: true,
            draggable: true,
        });
    });
</script>

@endsection
