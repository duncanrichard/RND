<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>PT DWIJAYA COSMEDIKA</title>
    @include('layout.partials.link')
    
  </head>

  <body class="m-0 font-sans text-base antialiased font-normal dark:bg-slate-900 leading-default bg-gray-50 text-slate-500">
    <div class="absolute w-full bg-blue-500 dark:hidden min-h-75"></div>
    @include('layout.partials.header')
    @include('layout.partials.dashboard')

      @yield('content')
      @include('layout.partials.konfigurasi')
      @include('layout.partials.footer')
      @stack('scripts')

  </body>
@include('layout.partials.script')
</html>
