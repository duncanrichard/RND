<main class="relative h-full max-h-screen transition-all duration-200 ease-in-out xl:ml-68 rounded-xl">
      <!-- Navbar -->
      <nav class="relative flex flex-wrap items-center justify-between px-0 py-2 mx-6 transition-all ease-in shadow-none duration-250 rounded-2xl lg:flex-nowrap lg:justify-start" navbar-main navbar-scroll="false">
        <div class="flex items-center justify-between w-full px-4 py-1 mx-auto flex-wrap-inherit">
          <nav>
            <!-- breadcrumb -->
            <ol class="flex flex-wrap pt-1 mr-12 bg-transparent rounded-lg sm:mr-16">
              <li class="text-sm leading-normal">
                <a class="text-white opacity-50" href="javascript:;">Pages</a>
              </li>
              <li id="dashboard-label" class="text-sm pl-2 capitalize leading-normal text-white before:float-left before:pr-2 before:text-white before:content-['/']" aria-current="page">
                  {{ ucfirst(Request::segment(count(Request::segments()))) }}
              </li>
            </ol>
          </nav>
          @if(auth()->user()->role == 'admin')
          
              <li class="relative flex items-center pr-2">
                <p class="hidden transform-dropdown-show"></p>
                <a href="javascript:;" class="block p-0 text-sm text-white font-bold transition-all ease-nav-brand" dropdown-trigger aria-expanded="false">
                  <i class="cursor-pointer">Master Data</i>
                </a>
                <ul dropdown-menu class="text-sm transform-dropdown before:font-awesome before:leading-default before:duration-350 before:ease lg:shadow-3xl duration-250 min-w-44 before:sm:right-8 before:text-5.5 pointer-events-none absolute right-0 top-0 z-50 origin-top list-none rounded-lg border-0 border-solid border-transparent dark:shadow-dark-xl dark:bg-slate-850 bg-white bg-clip-padding px-2 py-4 text-left text-slate-500 opacity-0 transition-all before:absolute before:right-2 before:left-auto before:top-0 before:z-50 before:inline-block before:font-normal before:text-white before:antialiased before:transition-all before:content-['\f0d8'] sm:-mr-6 lg:absolute lg:right-0 lg:left-auto lg:mt-2 lg:block lg:cursor-pointer"
    style="max-height: 250px; overflow-y: auto; scrollbar-width: thin; scrollbar-color: #888 #f1f1f1;">
    <!-- Tambahkan style untuk scroll -->
    

                  <!-- add show class on dropdown open js -->
                  
                  <!-- Master Satuan -->
                  <li class="relative mb-2">
                    <a class="dark:hover:bg-slate-900 ease py-1.2 clear-both block w-full whitespace-nowrap rounded-lg bg-transparent px-4 duration-300 hover:bg-gray-200 hover:text-slate-700 lg:transition-colors" href="{{ route('master_satuan.index') }}">
                      <div class="flex py-1">
                        <div class="my-auto">
                          <img src="./assets/img/inventaris.png" class="inline-flex items-center justify-center mr-4 text-sm text-white h-9 w-9 max-w-none rounded-xl" />
                        </div>
                        <div class="flex flex-col justify-center">
                          <h6 class="mb-1 text-sm font-normal leading-normal dark:text-white">
                            <span class="font-semibold">Master Satuan</span>
                          </h6>
                          <p class="mb-0 text-xs leading-tight text-slate-400 dark:text-white/80"></p>
                        </div>
                      </div>
                    </a>
                  </li>

                  <!-- Master List Sample Bahan Baku (Gudang R&D) -->
                  <li class="relative mb-2">
                    <a class="dark:hover:bg-slate-900 ease py-1.2 clear-both block w-full whitespace-nowrap rounded-lg bg-transparent px-4 duration-300 hover:bg-gray-200 hover:text-slate-700 lg:transition-colors" href="{{ route('master_bahan_baku.index') }}">
                      <div class="flex py-1">
                        <div class="my-auto">
                          <img src="./assets/img/inventaris.png" class="inline-flex items-center justify-center mr-4 text-sm text-white h-9 w-9 max-w-none rounded-xl" />
                        </div>
                        <div class="flex flex-col justify-center">
                          <h6 class="mb-1 text-sm font-normal leading-normal dark:text-white">
                            <span class="font-semibold">Master List Sample Bahan Baku</span>
                          </h6>
                          <p class="mb-0 text-xs leading-tight text-slate-400 dark:text-white/80"></p>
                        </div>
                      </div>
                    </a>
                  </li>

                  <!-- Master PPN -->
                  <li class="relative mb-2">
                    <a class="dark:hover:bg-slate-900 ease py-1.2 clear-both block w-full whitespace-nowrap rounded-lg bg-transparent px-4 duration-300 hover:bg-gray-200 hover:text-slate-700 lg:transition-colors" href="{{ route('master_ppn.index') }}">
                      <div class="flex py-1">
                        <div class="my-auto">
                          <img src="./assets/img/inventaris.png" class="inline-flex items-center justify-center mr-4 text-sm text-white h-9 w-9 max-w-none rounded-xl" />
                        </div>
                        <div class="flex flex-col justify-center">
                          <h6 class="mb-1 text-sm font-normal leading-normal dark:text-white">
                            <span class="font-semibold">Master PPN</span>
                          </h6>
                          <p class="mb-0 text-xs leading-tight text-slate-400 dark:text-white/80"></p>
                        </div>
                      </div>
                    </a>
                  </li>

                  <!-- master harga sample bahan baku -->
                  <li class="relative mb-2">
                    <a class="dark:hover:bg-slate-900 ease py-1.2 clear-both block w-full whitespace-nowrap rounded-lg bg-transparent px-4 duration-300 hover:bg-gray-200 hover:text-slate-700 lg:transition-colors" href="{{ route('master_harga_sample_bahan_baku.index') }}">
                      <div class="flex py-1">
                        <div class="my-auto">
                          <img src="./assets/img/inventaris.png" class="inline-flex items-center justify-center mr-4 text-sm text-white h-9 w-9 max-w-none rounded-xl" />
                        </div>
                        <div class="flex flex-col justify-center">
                          <h6 class="mb-1 text-sm font-normal leading-normal dark:text-white">
                            <span class="font-semibold">Master Harga Sample Bahan Baku</span>
                          </h6>
                          <p class="mb-0 text-xs leading-tight text-slate-400 dark:text-white/80"></p>
                        </div>
                      </div>
                    </a>
                  </li>

                  <!-- Master Formula Sample -->
                  <li class="relative mb-2">
                    <a class="dark:hover:bg-slate-900 ease py-1.2 clear-both block w-full whitespace-nowrap rounded-lg bg-transparent px-4 duration-300 hover:bg-gray-200 hover:text-slate-700 lg:transition-colors" href="{{ route('master_formula_sample.index') }}">
                      <div class="flex py-1">
                        <div class="my-auto">
                          <img src="./assets/img/inventaris.png" class="inline-flex items-center justify-center mr-4 text-sm text-white h-9 w-9 max-w-none rounded-xl" />
                        </div>
                        <div class="flex flex-col justify-center">
                          <h6 class="mb-1 text-sm font-normal leading-normal dark:text-white">
                            <span class="font-semibold">Master Formula Sample</span>
                          </h6>
                          <p class="mb-0 text-xs leading-tight text-slate-400 dark:text-white/80"></p>
                        </div>
                      </div>
                    </a>
                  </li>

                  <!-- Master Data Stabilitas R&D -->
                  <li class="relative mb-2">
                    <a class="dark:hover:bg-slate-900 ease py-1.2 clear-both block w-full whitespace-nowrap rounded-lg bg-transparent px-4 duration-300 hover:bg-gray-200 hover:text-slate-700 lg:transition-colors" href="{{ route('master_data_stabilitas_rd.index') }}">
                      <div class="flex py-1">
                        <div class="my-auto">
                          <img src="./assets/img/inventaris.png" class="inline-flex items-center justify-center mr-4 text-sm text-white h-9 w-9 max-w-none rounded-xl" />
                        </div>
                        <div class="flex flex-col justify-center">
                          <h6 class="mb-1 text-sm font-normal leading-normal dark:text-white">
                            <span class="font-semibold">Master Data Stabilitas R&D</span>
                          </h6>
                          <p class="mb-0 text-xs leading-tight text-slate-400 dark:text-white/80"></p>
                        </div>
                      </div>
                    </a>
                  </li>

                  <!-- Master Jenis Bahan Baku-->
                  <li class="relative mb-2">
                    <a class="dark:hover:bg-slate-900 ease py-1.2 clear-both block w-full whitespace-nowrap rounded-lg bg-transparent px-4 duration-300 hover:bg-gray-200 hover:text-slate-700 lg:transition-colors" href="{{ route('jenis-bahan-baku.index') }}">
                      <div class="flex py-1">
                        <div class="my-auto">
                          <img src="./assets/img/inventaris.png" class="inline-flex items-center justify-center mr-4 text-sm text-white h-9 w-9 max-w-none rounded-xl" />
                        </div>
                        <div class="flex flex-col justify-center">
                          <h6 class="mb-1 text-sm font-normal leading-normal dark:text-white">
                            <span class="font-semibold">Master Kategori Bahan Baku</span>
                          </h6>
                          <p class="mb-0 text-xs leading-tight text-slate-400 dark:text-white/80"></p>
                        </div>
                      </div>
                    </a>
                  </li>

                   <!-- Master Bahan Baku-->
                   <li class="relative mb-2">
                    <a class="dark:hover:bg-slate-900 ease py-1.2 clear-both block w-full whitespace-nowrap rounded-lg bg-transparent px-4 duration-300 hover:bg-gray-200 hover:text-slate-700 lg:transition-colors" href="{{ route('bahan_baku.index') }}">
                      <div class="flex py-1">
                        <div class="my-auto">
                          <img src="./assets/img/inventaris.png" class="inline-flex items-center justify-center mr-4 text-sm text-white h-9 w-9 max-w-none rounded-xl" />
                        </div>
                        <div class="flex flex-col justify-center">
                          <h6 class="mb-1 text-sm font-normal leading-normal dark:text-white">
                            <span class="font-semibold">Master Bahan Baku</span>
                          </h6>
                          <p class="mb-0 text-xs leading-tight text-slate-400 dark:text-white/80"></p>
                        </div>
                      </div>
                    </a>
                  </li>

                  <!-- Master Formula Produk Jadi -->
                  <li class="relative mb-2">
                    <a class="dark:hover:bg-slate-900 ease py-1.2 clear-both block w-full whitespace-nowrap rounded-lg bg-transparent px-4 duration-300 hover:bg-gray-200 hover:text-slate-700 lg:transition-colors" href="{{ route('master_formula_produk.index') }}">
                      <div class="flex py-1">
                        <div class="my-auto">
                          <img src="./assets/img/inventaris.png" class="inline-flex items-center justify-center mr-4 text-sm text-white h-9 w-9 max-w-none rounded-xl" />
                        </div>
                        <div class="flex flex-col justify-center">
                          <h6 class="mb-1 text-sm font-normal leading-normal dark:text-white">
                            <span class="font-semibold">Master Formula Produk Jadi</span>
                          </h6>
                          <p class="mb-0 text-xs leading-tight text-slate-400 dark:text-white/80"></p>
                        </div>
                      </div>
                    </a>
                  </li>


                  <!-- Kode Bahan Kemas-->
                  <li class="relative mb-2">
                    <a class="dark:hover:bg-slate-900 ease py-1.2 clear-both block w-full whitespace-nowrap rounded-lg bg-transparent px-4 duration-300 hover:bg-gray-200 hover:text-slate-700 lg:transition-colors" href="{{ route('kode_bahan_kemas.index') }}">
                      <div class="flex py-1">
                        <div class="my-auto">
                          <img src="./assets/img/inventaris.png" class="inline-flex items-center justify-center mr-4 text-sm text-white h-9 w-9 max-w-none rounded-xl" />
                        </div>
                        <div class="flex flex-col justify-center">
                          <h6 class="mb-1 text-sm font-normal leading-normal dark:text-white">
                            <span class="font-semibold">Master Kategori Bahan Kemas</span>
                          </h6>
                          <p class="mb-0 text-xs leading-tight text-slate-400 dark:text-white/80"></p>
                        </div>
                      </div>
                    </a>
                  </li>


                   <!-- Master Bahan Kemas-->
                   <li class="relative mb-2">
                    <a class="dark:hover:bg-slate-900 ease py-1.2 clear-both block w-full whitespace-nowrap rounded-lg bg-transparent px-4 duration-300 hover:bg-gray-200 hover:text-slate-700 lg:transition-colors" href="{{ route('master_kemasan.index') }}">
                      <div class="flex py-1">
                        <div class="my-auto">
                          <img src="./assets/img/inventaris.png" class="inline-flex items-center justify-center mr-4 text-sm text-white h-9 w-9 max-w-none rounded-xl" />
                        </div>
                        <div class="flex flex-col justify-center">
                          <h6 class="mb-1 text-sm font-normal leading-normal dark:text-white">
                            <span class="font-semibold">Master Bahan Kemas</span>
                          </h6>
                          <p class="mb-0 text-xs leading-tight text-slate-400 dark:text-white/80"></p>
                        </div>
                      </div>
                    </a>
                  </li>

                  <!-- Master Kategori Produk Jadi -->
                  <li class="relative mb-2">
                    <a class="dark:hover:bg-slate-900 ease py-1.2 clear-both block w-full whitespace-nowrap rounded-lg bg-transparent px-4 duration-300 hover:bg-gray-200 hover:text-slate-700 lg:transition-colors" href="{{ route('master_kategori_produk.index') }}">
                      <div class="flex py-1">
                        <div class="my-auto">
                          <img src="./assets/img/inventaris.png" class="inline-flex items-center justify-center mr-4 text-sm text-white h-9 w-9 max-w-none rounded-xl" />
                        </div>
                        <div class="flex flex-col justify-center">
                          <h6 class="mb-1 text-sm font-normal leading-normal dark:text-white">
                            <span class="font-semibold">Master Kategori Produk Jadi</span>
                          </h6>
                          <p class="mb-0 text-xs leading-tight text-slate-400 dark:text-white/80"></p>
                        </div>
                      </div>
                    </a>
                  </li>


                  <!--  Master Produk Jadi -->
                  <li class="relative mb-2">
                    <a class="dark:hover:bg-slate-900 ease py-1.2 clear-both block w-full whitespace-nowrap rounded-lg bg-transparent px-4 duration-300 hover:bg-gray-200 hover:text-slate-700 lg:transition-colors" href="{{ route('master_produk_jadi.index') }}">
                      <div class="flex py-1">
                        <div class="my-auto">
                          <img src="./assets/img/inventaris.png" class="inline-flex items-center justify-center mr-4 text-sm text-white h-9 w-9 max-w-none rounded-xl" />
                        </div>
                        <div class="flex flex-col justify-center">
                          <h6 class="mb-1 text-sm font-normal leading-normal dark:text-white">
                            <span class="font-semibold">Master Produk Jadi</span>
                          </h6>
                          <p class="mb-0 text-xs leading-tight text-slate-400 dark:text-white/80"></p>
                        </div>
                      </div>
                    </a>
                  </li>

                   <!--  Master CPB -->
                   <li class="relative mb-2">
                      <a class="dark:hover:bg-slate-900 ease py-1.2 clear-both block w-full whitespace-nowrap rounded-lg bg-transparent px-4 duration-300 hover:bg-gray-200 hover:text-slate-700 lg:transition-colors" href="{{ route('master_cpb.index') }}">
                          <div class="flex py-1">
                              <div class="my-auto">
                                  <img src="./assets/img/inventaris.png" class="inline-flex items-center justify-center mr-4 text-sm text-white h-9 w-9 max-w-none rounded-xl" />
                              </div>
                              <div class="flex flex-col justify-center">
                                  <h6 class="mb-1 text-sm font-normal leading-normal dark:text-white">
                                      <span class="font-semibold">Master CPB</span>
                                  </h6>
                                  <p class="mb-0 text-xs leading-tight text-slate-400 dark:text-white/80"></p>
                              </div>
                          </div>
                      </a>
                  </li>


                  <!-- Master CKB -->
                  <li class="relative mb-2">
                      <a class="dark:hover:bg-slate-900 ease py-1.2 clear-both block w-full whitespace-nowrap rounded-lg bg-transparent px-4 duration-300 hover:bg-gray-200 hover:text-slate-700 lg:transition-colors" href="{{ route('master_ckb.index') }}">
                          <div class="flex py-1">
                              <div class="my-auto">
                                  <img src="./assets/img/inventaris.png" class="inline-flex items-center justify-center mr-4 text-sm text-white h-9 w-9 max-w-none rounded-xl" />
                              </div>
                              <div class="flex flex-col justify-center">
                                  <h6 class="mb-1 text-sm font-normal leading-normal dark:text-white">
                                      <span class="font-semibold">Master CKB</span>
                                  </h6>
                                  <p class="mb-0 text-xs leading-tight text-slate-400 dark:text-white/80"></p>
                              </div>
                          </div>
                      </a>
                  </li>
                 <!--  Sample Progress -->
                 <li class="relative mb-2">
                      <a class="dark:hover:bg-slate-900 ease py-1.2 clear-both block w-full whitespace-nowrap rounded-lg bg-transparent px-4 duration-300 hover:bg-gray-200 hover:text-slate-700 lg:transition-colors" href="{{ url('/sample-progress') }}">
                          <div class="flex py-1">
                              <div class="my-auto">
                                  <img src="./assets/img/inventaris.png" class="inline-flex items-center justify-center mr-4 text-sm text-white h-9 w-9 max-w-none rounded-xl" />
                              </div>
                              <div class="flex flex-col justify-center">
                                  <h6 class="mb-1 text-sm font-normal leading-normal dark:text-white">
                                      <span class="font-semibold">Sample Progres</span>
                                  </h6>
                                  <p class="mb-0 text-xs leading-tight text-slate-400 dark:text-white/80"></p>
                              </div>
                          </div>
                      </a>
                  </li>

   <!-- Formulir Purchase Request -->
                <li class="relative mb-2">
                      <a class="dark:hover:bg-slate-900 ease py-1.2 clear-both block w-full whitespace-nowrap rounded-lg bg-transparent px-4 duration-300 hover:bg-gray-200 hover:text-slate-700 lg:transition-colors" href="{{ route('purchase-requests.index') }}">
                          <div class="flex py-1">
                              <div class="my-auto">
                                  <img src="./assets/img/inventaris.png" class="inline-flex items-center justify-center mr-4 text-sm text-white h-9 w-9 max-w-none rounded-xl" />
                              </div>
                              <div class="flex flex-col justify-center">
                                  <h6 class="mb-1 text-sm font-normal leading-normal dark:text-white">
                                      <span class="font-semibold">Formulir Purchase Request</span>
                                  </h6>
                                  <p class="mb-0 text-xs leading-tight text-slate-400 dark:text-white/80"></p>
                              </div>
                          </div>
                      </a>
              </li>
                </ul>
              </li>
          @endif
          <div class="flex items-center mt-2 grow sm:mt-0 sm:mr-6 md:mr-0 lg:flex lg:basis-auto">
            <div class="flex items-center md:ml-auto md:pr-4">
              <div class="relative flex flex-wrap items-stretch w-full transition-all rounded-lg ease">
              </div>
            </div>
            <ul class="flex flex-row justify-end pl-0 mb-0 list-none md-max:w-full">
           
              <li class="flex items-center pl-4 xl:hidden">
                <a href="javascript:;" class="block p-0 text-sm text-white transition-all ease-nav-brand" sidenav-trigger>
                  <div class="w-4.5 overflow-hidden">
                    <i class="ease mb-0.75 relative block h-0.5 rounded-sm bg-white transition-all"></i>
                    <i class="ease mb-0.75 relative block h-0.5 rounded-sm bg-white transition-all"></i>
                    <i class="ease relative block h-0.5 rounded-sm bg-white transition-all">      
                    </i>
                  </div>
                </a>
              </li>
              <li class="flex items-center px-4">
                <a href="javascript:;" class="p-0 text-sm text-white transition-all ease-nav-brand">
                  <i fixed-plugin-button-nav class="cursor-pointer fa fa-cog"></i>
                </a>
              </li>
              <li class="relative flex items-center pr-2">
                <p class="hidden transform-dropdown-show"></p>
                <a href="javascript:;" class="block p-0 text-sm text-white transition-all ease-nav-brand" dropdown-trigger aria-expanded="false">
                  <i class="cursor-pointer fa fa-user"></i>
                </a>
                <ul dropdown-menu class="text-sm transform-dropdown before:font-awesome before:leading-default before:duration-350 before:ease lg:shadow-3xl duration-250 min-w-44 before:sm:right-8 before:text-5.5 pointer-events-none absolute right-0 top-0 z-50 origin-top list-none rounded-lg border-0 border-solid border-transparent dark:shadow-dark-xl dark:bg-slate-850 bg-white bg-clip-padding px-2 py-4 text-left text-slate-500 opacity-0 transition-all before:absolute before:right-2 before:left-auto before:top-0 before:z-50 before:inline-block before:font-normal before:text-white before:antialiased before:transition-all before:content-['\f0d8'] sm:-mr-6 lg:absolute lg:right-0 lg:left-auto lg:mt-2 lg:block lg:cursor-pointer">
                  
                  <!-- Menampilkan nama pengguna -->
                  <li class="relative mb-2">
                    <div class="dark:hover:bg-slate-900 ease py-1.2 clear-both block w-full whitespace-nowrap rounded-lg bg-transparent px-4 duration-300 hover:bg-gray-200 hover:text-slate-700 lg:transition-colors">
                      <div class="flex py-1">
                        <div class="flex flex-col justify-center">
                          <h6 class="mb-1 text-sm font-normal leading-normal dark:text-white">
                            <span class="font-semibold">Hai  {{ Auth::user()->nama }}</span> <!-- Nama pengguna -->
                          </h6>
                        </div>
                      </div>
                    </div>
                  </li>

                  <li class="relative mb-2">
                      <form method="POST" action="{{ route('logout') }}">
                          @csrf
                          <button type="submit" class="dark:hover:bg-slate-900 ease py-1.2 clear-both block w-full whitespace-nowrap rounded-lg bg-transparent px-4 duration-300 hover:bg-gray-200 hover:text-slate-700 lg:transition-colors">
                              <div class="flex py-1">
                                  <div class="my-auto">
                                      <img src="{{ asset('assets/img/exit.png') }}" class="inline-flex items-center justify-center mr-4 text-sm text-white h-9 w-9 max-w-none rounded-xl" />
                                  </div>
                                  <div class="flex flex-col justify-center">
                                      <h6 class="mb-1 text-sm font-normal leading-normal dark:text-white">
                                          <span class="font-semibold">Logout</span>
                                      </h6>
                                  </div>
                              </div>
                          </button>
                      </form>
                  </li>

                </ul>
            </li>

            </ul>

          </div>
        </div>
      </nav>
