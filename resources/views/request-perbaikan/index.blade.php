@extends('layout.main')
@section('content')
<div class="w-full px-6 py-6 mx-auto mt-10">
    <div class="bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-2xl font-bold mb-4">{{ $title }}</h2>
        <li class="relative flex items-center justify-end pr-2">
            @if ($subType === 'Open')
            <a href="{{ route('request_perbaikan.create') }}" id="tambah_master_sparepart"
                class="inline-block px-4 py-2 mr-2 font-bold text-center text-white uppercase align-middle transition-all rounded-lg cursor-pointer bg-gradient-to-tl from-blue-700 to-cyan-500 leading-normal text-xs ease-in tracking-tight-rem shadow-xs bg-150 bg-x-25 hover:-translate-y-px active:opacity-85 hover:shadow-md">
                <i class="cursor-pointer"></i> Tambah Data
            </a>
            @endif <!-- ($subType === 'Open') -->
        </li>
        <div class="overflow-x-auto mt-6">
            <div class="relative flex flex-col min-w-0 break-words bg-white border-0 shadow-xl rounded-2xl bg-clip-border">
                <div class="table-responsive">
                    <table id="pengujian_table" class="display nowrap" style="width:100%">
                        <thead class="thead-light">
                            <tr>
                                <th class="">No</th>
                                <th class="">Nomor Request {{ $type === 'Perbaikan' ? 'Perbaikan' : 'Pemeliharaan'}}</th>
                                <th class="">Tanggal</th>
                                @if($type === 'Pemeliharaan')
                                <th class="">Periode</th>
                                @endif <!-- if($type === 'Pemeliharaan') -->
                                <th class="">Departemen {{ $type === 'Perbaikan' ? 'Pemohon' : 'Tujuan'}}</th>
                                <th class="">Lokasi / Ruangan</th>
                                <th class="">Kode Aset</th>
                                <th class="">Nama Aset</th>
                                <th class="">Kategori Aset</th>
                                <th class="">Deskripsi {{ $type === 'Perbaikan' ? 'Kerusakan' : 'Pemeliharaan'}}</th>
                                <th class="">Dokumentasi {{ $type === 'Perbaikan' ? 'Kerusakan' : 'Pemeliharaan'}}</th>
                                <th class="">Status Permohonan</th>
                                <th class="">Status Perbaikan</th>
                                <th class="">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $counter = 1; // Variabel penghitung manual dimulai dari 1
                            @endphp
                            @foreach ($data as $key => $item)
                            @foreach ($item->Detail as $detailKey => $detail)
                            <tr class="w-full border-b hover:bg-gray-100">
                                <td class="text-sm font-normal leading-normal" width="5%">
                                    {{ $counter++ }}
                                    <!-- Gunakan variabel penghitung manual dan increment -->
                                    <!--  {{ $key + 1 }}.{{ $detailKey + 1 }} -->
                                </td>
                                <td class="text-sm font-normal leading-normal">
                                    <a href="{{ route('request_perbaikan.show', ['id' => $detail->id]) }}"
                                        class="inline-block px-4 py-2 mr-2 text-center text-gray-500 uppercase align-middle transition-all rounded-lg cursor-pointer bg-gradient-to-tl bg-white border-blue-500 border-2 leading-normal text-xs ease-in tracking-tight-rem shadow-xs bg-150 bg-x-25 hover:-translate-y-px active:opacity-85 hover:shadow-md"
                                        id="btn_perbaikan" name="btn_perbaikan">
                                        {{ $item->nomor_request_perbaikan }}
                                    </a>
                                </td>
                                <td class="text-sm font-normal leading-normal">
                                    <text>Pengajuan : {{ date('d M Y', strtotime($item->tanggal)) }}</text><br>
                                    @if($subType == 'Progress')
                                    <text>Mulai Pengerjaan : {{ date('d M Y', strtotime($detail->tanggal_progress)) }}</text><br>
                                    @elseif($subType == 'Close')
                                    <text>Close : {{ date('d M Y', strtotime($detail->tanggal_close)) }}</text>
                                    @endif <!-- if($subType == 'Progress') -->
                                </td>
                                @if($type === 'Pemeliharaan')
                                <td class="text-sm font-normal leading-normal">
                                    {{ $item->periode }}
                                </td>
                                @endif <!-- if($type === 'Pemeliharaan') -->
                                <td class="text-sm font-normal leading-normal">{{ $item->departemen_pemohon }}
                                </td>
                                <td class="text-sm font-normal leading-normal">{{ $item->lokasi_ruangan }}</td>
                                <td class="text-sm font-normal leading-normal">{{ $detail->kode_aset }}</td>
                                <td class="text-sm font-normal leading-normal">{{ $detail->nama_aset }}</td>
                                <td class="text-sm font-normal leading-normal">{{ $detail->kategori_aset }}
                                </td>
                                <td class="text-sm font-normal leading-normal">
                                    <div style="width: 300px; max-height: 200px; overflow-y: auto; word-wrap: break-word; white-space: normal;">
                                        <p>{{ $detail->deskripsi_kerusakan }}</p>
                                    </div>
                                </td>
                                <td class="text-sm font-normal leading-normal">
                                    @php
                                    $images = json_decode($detail->dokumentasi_kerusakan, true); // Decode JSON ke array
                                    $totalImages = count($images);
                                    @endphp
                                    <div class="flex space-x-2">
                                        @foreach ($images as $index => $image)
                                        @if ($index < 3)
                                            <a href="{{ asset('engineering_storage/' . $image) }}" class="glightbox"
                                            data-title="Gambar {{ $index + 1 }}: {{ basename($image) }}">
                                            <img src="{{ asset('engineering_storage/' . $image) }}"
                                                alt="Dokumentasi Kerusakan"
                                                class="w-20 h-auto rounded-lg" width="80px"
                                                height="80px">
                                            </a>
                                            @elseif ($index === 3)
                                            <a href="{{ asset('engineering_storage/' . $image) }}"
                                                class="glightbox relative"
                                                data-title="Gambar {{ $index + 1 }}: {{ basename($image) }}">
                                                <img src="{{ asset('engineering_storage/' . $image) }}"
                                                    alt="Dokumentasi Kerusakan"
                                                    class="w-20 h-auto rounded-lg opacity-80" width="80px"
                                                    height="80px">
                                                <div
                                                    class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-60 text-white font-bold text-sm">
                                                    +{{ $totalImages - 4 }}
                                                </div>
                                            </a>
                                            @endif <!-- if ($index < 3) -->
                                            @endforeach <!-- foreach ($images as $index => $image) -->
                                    </div>
                                </td>

                                <td class="text-sm font-normal leading-normal">
                                    <span class="py-1.4 px-2.5 text-xs rounded-1.8 inline-block whitespace-nowrap text-center bg-gradient-to-tl {{ $detail->status_permohonan == 'Not Confirmed' ? 'from-slate-600 to-slate-300' : 'from-emerald-500 to-teal-400' }}  align-baseline font-bold uppercase leading-none text-white">{{ $detail->status_permohonan }}</span>
                                </td>
                                <td class="text-sm font-normal leading-normal">
                                    @if ($detail->approval_status === 0)
                                    <span
                                        class="py-1.4 px-2.5 text-xs rounded-1.8 inline-block whitespace-nowrap text-center bg-gradient-to-tl
                                            from-red-600 to-orange-600 align-baseline font-bold uppercase leading-none text-white">
                                        {{ $detail->approval_status === 0 ? 'Ditolak' : '' }}
                                    </span>
                                    @else
                                    <span
                                        class="py-1.4 px-2.5 text-xs rounded-1.8 inline-block whitespace-nowrap text-center bg-gradient-to-tl
                                        {{ $detail->status_perbaikan == 'Open'
                                            ? 'from-slate-600 to-slate-300'
                                            : ($detail->status_perbaikan == 'Progress'
                                                ? 'from-orange-500 to-yellow-500'
                                                : ($detail->status_perbaikan == 'Close'
                                                    ? 'from-emerald-500 to-teal-400'
                                                    : '')) }}
                                        align-baseline font-bold uppercase leading-none text-white">
                                        {{ $detail->status_perbaikan }}
                                    </span>
                                    @endif <!-- if ($detail->approval_status === 0) -->
                                </td>

                                <td class="text-sm font-normal leading-normal">
                                    @if ($detail->approval_status === null)
                                    <div class="flex space-x-2">
                                        @if ($type === 'Pemeliharaan')
                                        <a href="#"
                                            class="inline-block px-4 py-2 mr-2 font-bold text-center text-white uppercase align-middle transition-all rounded-lg cursor-pointer bg-gradient-to-tl from-blue-500 to-violet-500 leading-normal text-xs ease-in tracking-tight-rem shadow-xs bg-150 bg-x-25 hover:-translate-y-px active:opacity-85 hover:shadow-md btn-approval"
                                            id="btn_approval_modal" name="btn_approval_modal" aria-expanded="false"
                                            data-id_detail="{{ $detail->id }}"
                                            data-nomor_request_perbaikan="{{ $item->nomor_request_perbaikan }}"
                                            data-jenis_perbaikan="{{ $item->jenis_perbaikan }}"
                                            data-departemen_pemohon="{{ $item->departemen_pemohon }}"
                                            data-lokasi_ruangan="{{ $item->lokasi_ruangan }}"
                                            data-kode_aset="{{ $detail->kode_aset }}"
                                            data-nama_aset="{{ $detail->nama_aset }}"
                                            data-deskripsi_kerusakan="{{ $detail->deskripsi_kerusakan }}"
                                            data-dokumentasi_kerusakan="{{ $detail->dokumentasi_kerusakan }}">
                                            Detail
                                        </a>
                                        @elseif($type === 'Perbaikan')
                                        <form action="{{ route('request_perbaikan.destroy', ['id' => $detail->id]) }}" method="POST" id="delete-form-{{ $detail->id }}">
                                            @csrf
                                            @method('POST')
                                            <input type="hidden" name="type" value="{{ $type }}">
                                            <button type="button"
                                                class="inline-block px-4 py-2 mr-2 font-bold text-center text-white uppercase align-middle transition-all rounded-lg cursor-pointer bg-gradient-to-tl from-red-600 from-red-600 to-orange-600 leading-normal text-xs ease-in tracking-tight-rem shadow-xs bg-150 bg-x-25 hover:-translate-y-px active:opacity-85 hover:shadow-md"
                                                onclick="Notiflix.Confirm.show('Konfirmasi Hapus', 'Apakah Anda yakin ingin menghapus data ini?', 'Ya', 'Tidak', function() {
                                                document.getElementById('delete-form-{{ $detail->id }}').submit();
                                            }, function() {
                                                // Do nothing on cancel
                                            });">
                                                Delete
                                            </button>
                                        </form>
                                        @endif <!-- if ($type === 'Pemeliharaan') -->
                                    </div>
                                    @elseif($detail->approval_status === 1)
                                    @php /* form close untuk user pemohon perbaikan */ @endphp
                                    @if($detail->status_perbaikan === 'Progress' && $detail->input_tindakan_status == 1)
                                    @if( strtoupper($item->id_input) === strtoupper(Auth::user()->username))
                                    <form
                                        action="{{ route('request_perbaikan.update_progress_to_close', ['id_detail' => $detail->id]) }}"
                                        method="POST" id="close-perbaikan-form-{{ $detail->id }}">
                                        @csrf
                                        @method('PUT')
                                        <!-- Input hidden untuk menyimpan username -->
                                        <input type="hidden" name="closed_by" value="{{ Auth::user()->username }}">
                                        <input type="hidden" name="type" value="{{ $type }}">
                                        <input type="hidden" name="departemen_pemohon" value="{{ $item->departemen_pemohon }}">
                                        <input type="hidden" name="nama_pemohon" value="{{ $item->id_input }}">
                                        <input type="hidden" name="nomor_request_perbaikan" value="{{ $item->nomor_request_perbaikan }}">

                                        <button type="button"
                                            class="inline-block px-4 py-2 mr-2 font-bold text-center text-white uppercase align-middle transition-all rounded-lg cursor-pointer bg-gradient-to-tl from-zinc-800 to-zinc-700 leading-normal text-xs ease-in tracking-tight-rem shadow-xs bg-150 bg-x-25 hover:-translate-y-px active:opacity-85 hover:shadow-md"
                                            onclick="Notiflix.Confirm.show('Konfirmasi Close Perbaikan', 'Apakah Anda yakin ingin menyelesaikan perbaikan?', 'Ya', 'Tidak', function() {
                                                    document.getElementById('close-perbaikan-form-{{ $detail->id }}').submit();
                                                }, function() {
                                                    // Do nothing on cancel
                                                });">
                                            <i class="cursor-pointer"></i> Update Close
                                        </button>
                                    </form>
                                    @endif <!-- if( strtoupper($item->id_input) === strtoupper(Auth::user()->username)) -->
                                    @endif <!-- if($detail->status_perbaikan === 'Progress' && $detail->input_tindakan_status == 1) -->
                                    @endif <!-- if ($detail->approval_status === null) -->
                                </td>
                            </tr>
                            @endforeach <!-- foreach ($data as $key => $item) -->
                            @endforeach <!--  foreach ($item->Detail as $detailKey => $detail) -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@if ($type === 'Pemeliharaan')
<!-- Modal approval Request Perbaikan -->
<div id="approval_modal"
    class="fixed top-0 left-0 w-full hidden overflow-x-hidden overflow-y-auto transition-opacity ease-linear z-sticky outline-0 flex items-center justify-center"
    style="top: 15px;">
    <div class="relative top-0 bg-white rounded-lg shadow-lg w-full max-w-md transform transition-all duration-300 modal-container">
        <!-- Tambahkan "relative top-20" untuk menggeser ke tengah atas -->
        <div class="px-6 py-4 border-b">
            <h3 id="title_approval_modal" class="text-lg font-bold text-gray-700">Approval</h3>
        </div>
        <div class="p-6 overflow-y-auto" style="max-height: calc(90vh - 60px);">
            <form id="approval_data_form" action="{{ route('request_perbaikan.update_approval') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="flex flex-wrap -mx-3">
                    <div class="w-full max-w-full px-3 shrink-0 md:w-4/12 md:flex-0">
                        <input type="hidden" id="id_detail" name="id_detail">
                        <div class="mb-4">
                            <label for="nomor_request_perbaikan"
                                class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700 dark:text-white/80">Nomor
                                Request {{ $type === 'Perbaikan' ? 'Perbaikan' : 'Pemeliharaan'}}</label>
                            <input type="text" name="nomor_request_perbaikan" id="nomor_request_perbaikan"
                                value=""
                                class="focus:shadow-primary-outline dark:bg-slate-850 dark:text-white text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-gray-500 bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none"
                                readonly>
                            <input name="nama_approval" id="nama_approval" type="hidden"
                                value="{{ Auth::user()->username }}">
                        </div>
                    </div>
                    <div class="w-full max-w-full px-3 shrink-0 md:w-4/12 md:flex-0">
                        <div class="mb-4">
                            <label for="departemen_pemohon"
                                class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700 dark:text-white/80">Departemen
                                {{ $type === 'Perbaikan' ? 'Pemohon' : 'Tujuan'}}</label>
                            <input type="text" id="departemen_pemohon" name="departemen_pemohon" value=""
                                class="focus:shadow-primary-outline dark:bg-slate-850 dark:text-white text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-gray-500 bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none"
                                readonly>
                        </div>
                    </div>
                    <div class="w-full max-w-full px-3 shrink-0 md:w-4/12 md:flex-0">
                        <div class="mb-4">
                            <label for="lokasi_ruangan"
                                class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700 dark:text-white/80">Lokasi
                                Ruangan</label>
                            <input type="text" name="lokasi_ruangan" id="lokasi_ruangan" value=""
                                class="focus:shadow-primary-outline dark:bg-slate-850 dark:text-white text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-gray-500 bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none"
                                readonly>
                        </div>
                    </div>
                    <div class="w-full max-w-full px-3 shrink-0 md:w-6/12 md:flex-0" id="div_kode_aset">
                        <div class="mb-4">
                            <label for="kode_aset"
                                class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700 dark:text-white/80">Kode
                                Aset</label>
                            <input type="text" name="kode_aset" id="kode_aset" value=""
                                class="focus:shadow-primary-outline dark:bg-slate-850 dark:text-white text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-gray-500 bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none"
                                readonly>
                        </div>
                    </div>
                    <div class="w-full max-w-full px-3 shrink-0 md:w-6/12 md:flex-0" id="div_nama_aset">
                        <div class="mb-4">
                            <label for="nama_aset"
                                class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700 dark:text-white/80">Nama
                                Aset</label>
                            <input type="text" name="nama_aset" id="nama_aset" value=""
                                class="focus:shadow-primary-outline dark:bg-slate-850 dark:text-white text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-gray-500 bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none"
                                readonly>
                        </div>
                    </div>
                    <div class="w-full max-w-full px-3 shrink-0 md:w-full md:flex-0">
                        <div class="mb-4">
                            <label for="deskripsi_kerusakan"
                                class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700 dark:text-white/80">Deskripsi
                                {{ $type === 'Perbaikan' ? 'Kerusakan' : 'Pemeliharaan'}}</label>
                            <textarea name="deskripsi_kerusakan" id="deskripsi_kerusakan"
                                class="focus:shadow-primary-outline text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-gray bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none"
                                style="text-align: justify;" rows="5" placeholder="Tuliskan detail kerusakan" readonly></textarea>
                        </div>
                        <div class="mb-4">
                            <label for="deskripsi_kerusakan"
                                class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700 dark:text-white/80">Status
                                Approval</label>
                            <select name="status_acc" id="status_acc"
                                class="focus:shadow-primary-outline text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none">
                                <option value="">-- Pilih --</option>
                                <option value="1">Approve</option>
                                <option value="0">Reject</option>
                            </select>
                            <span id="error-message" class="text-red-500 text-sm"></span>
                            @error('status_acc')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div id="dokumentasi_kerusakan_preview" class="flex space-x-2 mb-4">
                        <!-- Preview gambar akan diisi melalui JavaScript -->
                    </div>
                </div>
                <div class="flex justify-end">
                    <button type="button" id="cancel_approval_modal"
                        class="px-4 py-2 bg-gray-200 text-black rounded-lg mr-2">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif <!-- if($type === 'Pemeliharaan') -->

<script>
    $(document).ready(function() {
        $('#pengujian_table').DataTable({
            scrollX: true,
            "columnDefs": [{
                "targets": [3, 9, 10, 11],
                "class": "text-center",
            }, ],
        });

        // Inisialisasi Glightbox
        const lightbox = GLightbox({
            selector: '.glightbox', // Selector untuk elemen dengan kelas "glightbox"
            touchNavigation: true,
            zoomable: true,
            draggable: true,
        });

        // Tambahkan log untuk memastikan inisialisasi berhasil
        //console.log('Glightbox initialized.');

        openApprovalModal();
    });

    function openApprovalModal() {
        const modal = $('#approval_modal'); // Modal untuk approval
        const cancelModal = $('#cancel_approval_modal'); // Tombol batal pada modal
        const form = $('#approval_data_form'); // Form di modal
        const errorMessage = $('#error-message'); // Error message container (jika ada)

        // Event listener untuk tombol Approve
        $(document).on('click', '.btn-approval', function(e) {
            e.preventDefault();

            // Ambil data dari atribut data-* pada tombol yang diklik
            const id = $(this).data('id_detail');
            const nomorRequestPerbaikan = $(this).data('nomor_request_perbaikan');
            const jenisPerbaikan = $(this).data('jenis_perbaikan');
            const departemenPemohon = $(this).data('departemen_pemohon');
            const lokasiRuangan = $(this).data('lokasi_ruangan');
            const kodeAset = $(this).data('kode_aset');
            const namaAset = $(this).data('nama_aset');
            const deskripsiKerusakan = $(this).data('deskripsi_kerusakan');
            // Ambil nilai atribut data-dokumentasi_kerusakan dengan attr()
            const rawData = $(this).attr('data-dokumentasi_kerusakan');

            let images = [];
            try {
                // Decode JSON string
                images = JSON.parse(rawData);
            } catch (error) {
                // console.error('Invalid JSON:', rawData);
                return; // Hentikan jika parsing gagal
            }

            //console.log('Parsed Images:', images); // Debug hasil parsing

            const textTitle = `Approval - ${nomorRequestPerbaikan}`;

            // Set nilai field di modal
            $('#title_approval_modal').text(textTitle);
            $('#id_detail').val(id);
            $('#nomor_request_perbaikan').val(nomorRequestPerbaikan);
            $('#departemen_pemohon').val(departemenPemohon);
            $('#lokasi_ruangan').val(lokasiRuangan);
            $('#kode_aset').val(kodeAset);
            $('#nama_aset').val(namaAset);
            $('#deskripsi_kerusakan').val(deskripsiKerusakan);

            if (jenisPerbaikan === 'Bangunan') {
                $('#div_kode_aset').addClass('hidden');
                $('#div_nama_aset').addClass('hidden');
            }

            // Jika JSON valid, lanjutkan menampilkan gambar
            const previewContainer = $('#dokumentasi_kerusakan_preview');
            previewContainer.empty(); // Kosongkan kontainer pratinjau

            images.forEach(image => {
                // Gunakan asset helper di frontend untuk menambahkan 'storage' ke path
                const imageUrl = `{{ asset('engineering_storage') }}/${image}`;
                previewContainer.append(`
                    <a href="${imageUrl}" class="glightbox-modal mr-2">
                        <img src="${imageUrl}" alt="Dokumentasi Kerusakan" class="w-20 h-auto rounded-lg" width="120px" >
                    </a>
                `);
            });

            // Inisialisasi ulang lightbox jika perlu
            GLightbox({
                selector: '.glightbox-modal',
            });


            // Tampilkan modal
            modal.removeClass('hidden');
        });

        // Event listener untuk tombol Batal di modal
        cancelModal.on('click', function() {
            modal.addClass('hidden'); // Sembunyikan modal
        });

        // Validasi dan pengiriman form
        form.on('submit', function(e) {
            const statusAcctVal = $('#status_acc').val();
            let isValid = true;

            // Reset pesan error
            if (errorMessage.length > 0) {
                errorMessage.text('');
            }

            // Validasi input
            if (!statusAcctVal) {
                e.preventDefault();
                isValid = false;
                errorMessage.text('Kode Sparepart harus diisi'); // Tampilkan pesan error
            }

            // Jika valid, kirim form
            if (isValid) {
                form.off('submit'); // Lepaskan pencegahan default
                form.submit(); // Kirim form
            }
        });
    }
</script>
@endsection
