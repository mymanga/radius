<!doctype html >
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-layout="vertical" data-topbar="dark" data-sidebar="{{setting('theme') ? setting('theme') : 'light'}}" data-sidebar-size="lg" data-layout-mode="{{setting('theme')}}">
   <head>
      <meta charset="utf-8" />
      <title>@yield('title')</title>
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
      <meta content="Themesbrand" name="author" />
      <!-- App favicon -->
      <link rel="shortcut icon" href="{{ URL::asset('assets/images/favicon.ico')}}">
      @include('layouts.head-css')
      {{-- 
      <style>
         .navbar-menu .navbar-nav .nav-link[data-bs-toggle="collapse"][aria-expanded="true"] {
         background: #405189;
         color: #fff;
         }
         .navbar-menu .navbar-nav .nav-sm .nav-link.active {
         color: #299cdb;
         }
         .navbar-menu .navbar-nav .nav-link.active {
         color: #fff;
         }
      </style>
      --}}
      @livewireStyles
   </head>
   @section('body')
   @include('layouts.body')
   @show
   <!-- Begin page -->
   <div id="layout-wrapper">
      @include('layouts.topbar')
      @include('layouts.sidebar')
      <!-- ============================================================== -->
      <!-- Start right Content here -->
      <!-- ============================================================== -->
      <div class="main-content">
         <div class="page-content">
            <div class="container-fluid">
               @yield('content')
            </div>
            <!-- container-fluid -->
         </div>
         <!-- End Page-content -->
         @include('layouts.footer')
      </div>
      <!-- end main content-->
   </div>
   <!-- END layout-wrapper -->
   {{-- @include('layouts.customizer') --}}
   <!--start back-to-top-->
   <button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
   <i class="ri-arrow-up-line"></i>
   </button>
   <div id="loader-wrapper" style="display: none;">
      <div id="loader"></div>
   </div>
   <!--end back-to-top-->
   {{-- 
   <div id="loader" class="loader-container">
      <div class="loader"></div>
   </div>
   --}}
   <!-- JAVASCRIPT -->
   @include('layouts.vendor-scripts')
   @livewireScripts
   {{-- <script>
      window.addEventListener('load', function() {
          var loader = document.getElementById('loader');
          loader.classList.add('hidden');
      });
      
      var button = document.getElementById('loading');
      button.addEventListener('click', function() {
          var loader = document.getElementById('loader');
          loader.classList.remove('hidden');
      });
   </script> --}}
   </body>
</html>