<aside class="fixed inset-y-0 flex-wrap items-center justify-between block w-full p-0 my-4 overflow-y-auto antialiased transition-transform duration-200 -translate-x-full bg-white border-0 shadow-xl dark:shadow-none dark:bg-slate-850 max-w-64 ease-nav-brand z-990 xl:ml-6 rounded-2xl xl:left-0 xl:translate-x-0" aria-expanded="false" style="height: 100vh;">
  <div class="h-19">
    <i class="absolute top-0 right-0 p-4 opacity-50 cursor-pointer fas fa-times dark:text-white text-slate-400 xl:hidden" sidenav-close></i>
    <a class="block px-8 py-6 m-0 text-sm whitespace-nowrap dark:text-white text-slate-700" href="">
      <span class="ml-1 font-bold transition-all duration-200 ease-nav-brand">PT DWIJAYA COSMEDIKA</span>
    </a>

  </div>
  <hr class="h-px mt-0 bg-transparent bg-gradient-to-r from-transparent via-black/40 to-transparent dark:bg-gradient-to-r dark:from-transparent dark:via-white dark:to-transparent" />
  
  <div class="items-center block w-auto max-h-screen overflow-y-auto h-full grow basis-full">
    <ul class="flex flex-col pl-0 mb-0">
      <li class="mt-0.5 w-full">
        @can('view dashboard')
        <a id="dashboard" class="sidebar-item py-2.7 dark:text-white dark:opacity-80 text-sm ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap rounded-lg px-4 transition-colors" href="{{ route('home') }}">
          <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
            <i class="relative top-0 text-sm leading-normal fa-solid fa-tv"></i>
          </div>
          <span class="ml-1 duration-300 opacity-100 font-bold pointer-events-none ease">Dashboard</span>
        </a>
          @endcan
      </li>

      <li class="mt-0.5 w-full">
        <a id="master_data" class="sidebar-item py-2.7 dark:text-white dark:opacity-80 text-sm ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap px-4 transition-colors" href="javascript:void(0);" onclick="toggleDropdown('dropdown-menu-karyawan')">
            <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
                <i class="relative top-0 text-sm leading-normal text-blue-500 fa fa-receipt"></i>
            </div>
            <span class="ml-1 duration-300 font-bold opacity-100 pointer-events-none ease">Data Master</span>
            <i class="ml-auto text-sm leading-normal transition-transform duration-300 transform ni ni-bold-down"></i>
        </a>
        <ul id="dropdown-menu-karyawan" class="hidden ml-8 mt-2 space-y-2">
              @can('view master satuan')
            <li>
                <a class="sidebar-item py-2.7 dark:text-white dark:opacity-80 text-sm ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap px-4 transition-colors" href="{{ route('master_satuan.index') }}">
                    <span class="ml-1 duration-300 opacity-100 font-semibold text-xs pointer-events-none ease">Master Satuan</span>
                </a>
            </li>
               @endcan

               @can('view master bahan baku sample')
            <li>
                <a class="sidebar-item py-2.7 dark:text-white dark:opacity-80 text-sm ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap px-4 transition-colors" href="{{ route('master_bahan_baku.index') }}">
                    <span class="ml-1 duration-300 opacity-100 font-semibold text-xs pointer-events-none ease">Master List Sample Bahan Baku</span>
                </a>
            </li>
               @endcan

               @can('view master ppn')
            <li>
                <a class="sidebar-item py-2.7 dark:text-white dark:opacity-80 text-sm ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap px-4 transition-colors" href="{{ route('master_ppn.index') }}">
                    <span class="ml-1 duration-300 opacity-100 font-semibold text-xs pointer-events-none ease">Master PPN</span>
                </a>
            </li>
                  @endcan

                  @can('view master harga sample bahan baku')
            <li>
                <a class="sidebar-item py-2.7 dark:text-white dark:opacity-80 text-sm ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap px-4 transition-colors" href="{{ route('master_harga_sample_bahan_baku.index') }}">
                    <span class="ml-1 duration-300 opacity-100 font-semibold text-xs pointer-events-none ease">Master Harga Sample Bahan Baku</span>
                </a>
            </li>
                @endcan

                @can('view master formula sample')
            <li>
                <a class="sidebar-item py-2.7 dark:text-white dark:opacity-80 text-sm ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap px-4 transition-colors" href="{{ route('master_formula_sample.index') }}">
                    <span class="ml-1 duration-300 opacity-100 font-semibold text-xs pointer-events-none ease">Master Formula Sample</span>
                </a>
            </li>
             @endcan

        @can('view master data stabilitas rnd')
            <li>
                <a class="sidebar-item py-2.7 dark:text-white dark:opacity-80 text-sm ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap px-4 transition-colors" href="{{ route('master_data_stabilitas_rd.index') }}">
                    <span class="ml-1 duration-300 opacity-100 font-semibold text-xs pointer-events-none ease">Master Data Stabilitas RND</span>
                </a>
            </li>
               @endcan

        @can('view master kategori bahan baku')
            <li>
                <a class="sidebar-item py-2.7 dark:text-white dark:opacity-80 text-sm ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap px-4 transition-colors" href="{{ route('jenis-bahan-baku.index') }}">
                    <span class="ml-1 duration-300 opacity-100 font-semibold text-xs pointer-events-none ease">Master Kategori Bahan Baku</span>
                </a>
            </li>
                @endcan

        @can('view master bahan baku')
            <li>
                <a class="sidebar-item py-2.7 dark:text-white dark:opacity-80 text-sm ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap px-4 transition-colors" href="{{ route('bahan_baku.index') }}">
                    <span class="ml-1 duration-300 opacity-100 font-semibold text-xs pointer-events-none ease">Master  Bahan Baku</span>
                </a>
            </li>
               @endcan

        @can('view master formula produk jadi')
            <li>
                <a class="sidebar-item py-2.7 dark:text-white dark:opacity-80 text-sm ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap px-4 transition-colors" href="{{ route('master_formula_produk.index') }}">
                    <span class="ml-1 duration-300 opacity-100 font-semibold text-xs pointer-events-none ease">Master Formula Produk Jadi</span>
                </a>
            </li>
             @endcan

        @can('view master kategori bahan kemas')
           <li>
                <a class="sidebar-item py-2.7 dark:text-whicte dark:opacity-80 text-sm ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap px-4 transition-colors" href="{{ route('kode_bahan_kemas.index') }}">
                    <span class="ml-1 duration-300 opacity-100 font-semibold text-xs pointer-events-none ease">Kategori Bahan Kemas</span>
                </a>
            </li>
           @endcan

        @can('view master bahan kemas')
            <li>
                <a class="sidebar-item py-2.7 dark:text-white dark:opacity-80 text-sm ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap px-4 transition-colors" href="{{ route('master_kemasan.index') }}">
                    <span class="ml-1 duration-300 opacity-100 font-semibold text-xs pointer-events-none ease">Master Bahan Kemas</span>
                </a>
            </li>
            @endcan

        @can('view master kategori produk jadi')
            <li>
                <a class="sidebar-item py-2.7 dark:text-white dark:opacity-80 text-sm ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap px-4 transition-colors" href="{{ route('master_kategori_produk.index') }}">
                    <span class="ml-1 duration-300 opacity-100 font-semibold text-xs pointer-events-none ease">Master Kategori Produk Jadi </span>
                </a>
            </li>
              @endcan

        @can('view master produk jadi')
            <li>
                <a class="sidebar-item py-2.7 dark:text-white dark:opacity-80 text-sm ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap px-4 transition-colors" href="{{ route('master_produk_jadi.index') }}">
                    <span class="ml-1 duration-300 opacity-100 font-semibold text-xs pointer-events-none ease">Master Produk Jadi </span>
                </a>
            </li>
              @endcan

        @can('view cpb')
            <li>
                <a class="sidebar-item py-2.7 dark:text-white dark:opacity-80 text-sm ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap px-4 transition-colors" href="{{ route('master_cpb.index') }}">
                    <span class="ml-1 duration-300 opacity-100 font-semibold text-xs pointer-events-none ease">Master CPB </span>
                </a>
            </li> 
            @endcan

        @can('view master ckb')
            <li>
                <a class="sidebar-item py-2.7 dark:text-white dark:opacity-80 text-sm ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap px-4 transition-colors" href="{{ route('master_ckb.index') }}">
                    <span class="ml-1 duration-300 opacity-100 font-semibold text-xs pointer-events-none ease">Master CKB </span>
                </a>
            </li>
             @endcan

        @can('view sample progres')
            <li>
                <a class="sidebar-item py-2.7 dark:text-white dark:opacity-80 text-sm ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap px-4 transition-colors" href="{{ url('/sample-progress') }}">
                    <span class="ml-1 duration-300 opacity-100 font-semibold text-xs pointer-events-none ease">Sample Progres </span>
                </a>
            </li>
             @endcan

        @can('view singkatan merk')
            <li>
                <a class="sidebar-item py-2.7 dark:text-white dark:opacity-80 text-sm ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap px-4 transition-colors" href="{{ route('singkatan-merk.index') }}">
                    <span class="ml-1 duration-300 opacity-100 font-semibold text-xs pointer-events-none ease">Master Singkatan Merk</span>
                </a>
            </li>
             @endcan
        </ul>
      </li>

     @can('view purchase request')
      <li class="mt-0.5 w-full">
    <a id="rekam_medis" class="sidebar-item py-2.7 dark:text-white dark:opacity-80 text-sm ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap px-4 transition-colors" href="{{ route('purchase-requests.index') }}">
        <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center fill-current stroke-0 text-center xl:p-2.5">
            <i class="fa-solid fa-file-invoice text-red-500"></i>
        </div>
        <span class="ml-1 duration-300 opacity-100 font-bold pointer-events-none ease">Purchase Request</span>
    </a>
</li>
@endcan

{{-- Permintaan --}}
@can('view permintaan')
<li class="mt-0.5 w-full">
        <a id="permintaan" class="sidebar-item py-2.7 dark:text-white dark:opacity-80 text-sm ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap px-4 transition-colors" href="{{ route('permintaan') }}">
          <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center fill-current stroke-0 text-center xl:p-2.5">
            <i class="relative top-0 text-sm leading-normal text-blue-500 fa-solid fa-hand-holding-heart"></i>
          </div>
          <span class="ml-1 duration-300 opacity-100 font-bold pointer-events-none ease">Permintaan</span>
        </a>
      </li>
      @endcan

{{-- Pengembalian --}}
@can('view pengembalian')
      <li class="mt-0.5 w-full">
        <a id="pengembalian" class="sidebar-item py-2.7 dark:text-white dark:opacity-80 text-sm ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap px-4 transition-colors" href="{{ route('pengembalian') }}">
          <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center fill-current stroke-0 text-center xl:p-2.5">
            <i class="relative top-0 text-sm leading-normal fa-solid fa-repeat" style="color: #A95C68;"></i>
          </div>
          <span class="ml-1 duration-300 opacity-100 font-bold pointer-events-none ease">Pengembalian</span>
        </a>
      </li> 
      @endcan

       <li class="w-full mt-4">
                <h6 class="pl-6 ml-2 text-xs font-bold leading-tight uppercase dark:text-white opacity-60">Maintenance</h6>
            </li>

            <li class="mt-0.5 w-full">
                <a id="request_perbaikan" class="sidebar-item py-2.7 dark:text-white dark:opacity-80 text-sm ease-nav-brand my-0 mx-2 flex items-center  rounded-lg px-4 transition-colors {{ request()->routeIs('request_perbaikan.index', 'request_perbaikan.progress', 'request_perbaikan.close') ? 'bg-blue-500/13 rounded-lg font-semibold text-slate-700 active' : '' }}" href="#" onclick="toggleDropdown('dropdown-menu-request-perbaikan')">
                    <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
                        <i class="relative top-0 text-sm leading-normal text-cyan-500 fas fa-tools"></i>
                    </div>
                    <span class="ml-1 duration-300 opacity-100 font-bold pointer-events-none ease">Request Perbaikan</span>
                    <i class="ml-auto text-xs leading-normal transition-transform duration-300 transform ni ni-bold-down"></i>
                </a>
                <ul id="dropdown-menu-request-perbaikan" class=" {{ request()->routeIs('request_perbaikan.index', 'request_perbaikan.progress', 'request_perbaikan.close') ? '' : 'hidden' }} ml-8 mt-2 space-y-2">
                    <li>
                        <a class="sidebar-item py-2.7 dark:text-white dark:opacity-80 text-sm ease-nav-brand my-0 mx-2 flex items-center  px-6 transition-colors {{ request()->routeIs('request_perbaikan.index') ? 'bg-blue-500/13 rounded-lg font-semibold text-slate-700 active' : '' }}" href="{{ route('request_perbaikan.index') }}">
                            <span class="ml-1 duration-300 opacity-100 font-semibold text-xs pointer-events-none ease">Open</span>
                        </a>
                    </li>
                      <li>
                        <a class="sidebar-item py-2.7 dark:text-white dark:opacity-80 text-sm ease-nav-brand my-0 mx-2 flex items-center  px-6 transition-colors {{ request()->routeIs('request_perbaikan.progress') ? 'bg-blue-500/13 rounded-lg font-semibold text-slate-700 active' : '' }}" href="{{ route('request_perbaikan.progress') }}">
                            <span class="ml-1 duration-300 opacity-100 font-semibold text-xs pointer-events-none ease">Progress</span>
                        </a>
                    </li>
                    <li>
                        <a class="sidebar-item py-2.7 dark:text-white dark:opacity-80 text-sm ease-nav-brand my-0 mx-2 flex items-center  px-6 transition-colors {{ request()->routeIs('request_perbaikan.close') ? 'bg-blue-500/13 rounded-lg font-semibold text-slate-700 active' : '' }}" href="{{ route('request_perbaikan.close') }}">
                            <span class="ml-1 duration-300 opacity-100 font-semibold text-xs pointer-events-none ease">Close</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="mt-0.5 w-full">
                <a id="request_pemeliharaan" class="sidebar-item py-2.7 dark:text-white dark:opacity-80 text-sm ease-nav-brand my-0 mx-2 flex items-center  rounded-lg px-4 transition-colors {{ request()->routeIs('request_pemeliharaan.index', 'request_pemeliharaan.progress', 'request_pemeliharaan.close') ? 'bg-blue-500/13 rounded-lg font-semibold text-slate-700 active' : '' }}" href="#" onclick="toggleDropdown('dropdown-menu-request-pemliharaan')">
                    <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
                        <i class="relative top-0 text-sm leading-normal text-cyan-500 fas fa-tools"></i>
                    </div>
                    <span class="ml-1 duration-300 opacity-100 font-bold pointer-events-none ease">Request Pemeliharaan</span>
                    <i class="ml-auto text-xs leading-normal transition-transform duration-300 transform ni ni-bold-down"></i>
                </a>
                <ul id="dropdown-menu-request-pemliharaan" class=" {{ request()->routeIs('request_pemeliharaan.index', 'request_pemeliharaan.progress', 'request_pemeliharaan.close') ? '' : 'hidden' }} ml-8 mt-2 space-y-2">
                   <li>
                        <a class="sidebar-item py-2.7 dark:text-white dark:opacity-80 text-sm ease-nav-brand my-0 mx-2 flex items-center  px-6 transition-colors {{ request()->routeIs('request_pemeliharaan.index') ? 'bg-blue-500/13 rounded-lg font-semibold text-slate-700 active' : '' }}" href="{{ route('request_pemeliharaan.index') }}">
                            <span class="ml-1 duration-300 opacity-100 font-semibold text-xs pointer-events-none ease">Open</span>
                        </a>
                    </li>
                    <li>
                        <a class="sidebar-item py-2.7 dark:text-white dark:opacity-80 text-sm ease-nav-brand my-0 mx-2 flex items-center  px-6 transition-colors {{ request()->routeIs('request_pemeliharaan.progress') ? 'bg-blue-500/13 rounded-lg font-semibold text-slate-700 active' : '' }}" href="{{ route('request_pemeliharaan.progress') }}">
                            <span class="ml-1 duration-300 opacity-100 font-semibold text-xs pointer-events-none ease">Progress</span>
                        </a>
                    </li>
                    <li>
                        <a class="sidebar-item py-2.7 dark:text-white dark:opacity-80 text-sm ease-nav-brand my-0 mx-2 flex items-center  px-6 transition-colors {{ request()->routeIs('request_pemeliharaan.close') ? 'bg-blue-500/13 rounded-lg font-semibold text-slate-700 active' : '' }}" href="{{ route('request_pemeliharaan.close') }}">
                            <span class="ml-1 duration-300 opacity-100 font-semibold text-xs pointer-events-none ease">Close</span>
                        </a>
                    </li>
@role(['SUPER ADMIN', 'Direktur (DIR-OPS)'])
<li class="mt-0.5 w-full">
  <a id="hak_akses" class="sidebar-item py-2.7 dark:text-white dark:opacity-80 text-sm ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap px-4 transition-colors" href="{{ route('role-permission.index') }}">
    <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center text-center xl:p-2.5">
      <i class="fa-solid fa-user-shield text-blue-600"></i>
    </div>
    <span class="ml-1 duration-300 opacity-100 font-bold pointer-events-none ease">Hak Akses</span>
  </a>
</li>
<li class="mt-0.5 w-full">
  <a id="jabatan" class="sidebar-item py-2.7 dark:text-white dark:opacity-80 text-sm ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap px-4 transition-colors" href="{{ route('roles.index') }}">
    <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center text-center xl:p-2.5">
      <i class="fa-solid fa-briefcase text-purple-600"></i>
    </div>
    <span class="ml-1 duration-300 opacity-100 font-bold pointer-events-none ease">Jabatan</span>
  </a>
</li>

<li class="mt-0.5 w-full">
  <a id="account" class="sidebar-item py-2.7 dark:text-white dark:opacity-80 text-sm ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap px-4 transition-colors" href="{{ route('accounts.index') }}">
    <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center text-center xl:p-2.5">
      <i class="fa-solid fa-users-cog text-green-600"></i>
    </div>
    <span class="ml-1 duration-300 opacity-100 font-bold pointer-events-none ease">Account Management</span>
  </a>
</li>
@endrole



    </ul>
  </div>
</aside>

<script>
  document.addEventListener('DOMContentLoaded', function () {
      const sidebarItems = document.querySelectorAll('.sidebar-item');

      sidebarItems.forEach(item => {
          item.addEventListener('mouseover', function () {
              if (!this.classList.contains('clicked')) {
                  this.classList.add('bg-blue-500/13');
              }
          });

          item.addEventListener('mouseout', function () {
              if (!this.classList.contains('clicked')) {
                  this.classList.remove('bg-blue-500/13');
              }
          });

          item.addEventListener('click', function () {
              removeActiveClasses();
              this.classList.add('bg-blue-500/13', 'font-bold', 'clicked');
          });
      });

      function removeActiveClasses() {
          sidebarItems.forEach(item => {
              item.classList.remove('bg-blue-500/13', 'font-bold', 'clicked');
          });
      }
  });

  function toggleDropdown(menuId) {
      var dropdownMenu = document.getElementById(menuId);
      dropdownMenu.classList.toggle('hidden');
  }
</script>
