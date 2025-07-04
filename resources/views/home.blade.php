@extends('layout.main')
@section('content')
    <div class="w-full px-6 py-6 mx-auto">
        <div class="w-full px-6 py-6 mx-auto">
            <div class="flex flex-wrap -mx-3">
                @if(auth()->user()->role == 'admin')
                <a href="{{ route('master_bahan_baku.index') }}" class="block w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
                    <div class="relative flex flex-col min-w-0 break-words bg-white shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border transform transition-transform duration-300 hover:scale-105">
                        <div class="flex-auto p-4">
                            <div class="flex flex-row -mx-3">
                                <div class="flex-none w-2/3 max-w-full px-3">
                                    <div>
                                        <h5 class="mb-2 font-bold dark:text-white">List Sample Bahan Baku</h5>
                                    </div>
                                </div>
                                <div class="px-3 text-right basis-1/3">
                                    <div class="card bg-white shadow-lg rounded-lg overflow-hidden">
                                        <img src="./assets/img/penerimaan.png" alt="icon" class="w-full h-full object-cover">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
                    <a href="{{ route('master_harga_sample_bahan_baku.index') }}" class="block w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
                        <div class="relative flex flex-col min-w-0 break-words bg-white shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border transform transition-transform duration-300 hover:scale-105">
                            <div class="flex-auto p-4">
                                <div class="flex flex-row -mx-3">
                                    <div class="flex-none w-2/3 max-w-full px-3">
                                        <div>
                                            <h5 class="mb-2 font-bold dark:text-white">Harga Sample Bahan Baku</h5>
                                        </div>
                                    </div>
                                    <div class="px-3 text-right basis-1/3">
                                        <div class="card bg-white shadow-lg rounded-lg overflow-hidden">
                                            <img src="./assets/img/pengajuan.png" alt="icon" class="w-full h-full object-cover">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                @endif
                <a href="{{ route('master_data_stabilitas_rd.index') }}" class="block w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
                    <div class="relative flex flex-col min-w-0 break-words bg-white shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border transform transition-transform duration-300 hover:scale-105">
                        <div class="flex-auto p-4">
                            <div class="flex flex-row -mx-3">
                                <div class="flex-none w-2/3 max-w-full px-3">
                                    <div>
                                        <h5 class="mb-2 font-bold dark:text-white">Data Stabilitas RND</h5>
                                        
                                    </div>
                                </div>
                                <div class="px-3 text-right basis-1/3">
                                    <div class="card bg-white shadow-lg rounded-lg overflow-hidden">
                                        <img src="./assets/img/pemasukan.png" alt="icon" class="w-full h-full object-cover">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
                @if(auth()->user()->role == 'admin')
                    <a href="{{ route('master_kemasan.index') }}" class="block w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
                        <div class="relative flex flex-col min-w-0 break-words bg-white shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border transform transition-transform duration-300 hover:scale-105">
                            <div class="flex-auto p-4">
                                <div class="flex flex-row -mx-3">
                                    <div class="flex-none w-2/3 max-w-full px-3">
                                        <div>
                                            <h5 class="mb-2 font-bold dark:text-white">Master Bahan Kemas</h5>
                                            <p class="mb-0 dark:text-white dark:opacity-60">
                                                <span class="text-sm font-bold leading-normal text-red-600"> </span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="px-3 text-right basis-1/3">
                                        <div class="card bg-white shadow-lg rounded-lg overflow-hidden">
                                            <img src="./assets/img/pengeluaran.jpeg" alt="icon" class="w-full h-full object-cover">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                @endif
            </div>
    </div>
    
@endsection
