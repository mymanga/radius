<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-layout="vertical" data-topbar="dark" data-sidebar="light" data-sidebar-size="lg" data-layout-mode="{{ setting('theme') }}">
<head>
    <meta charset="utf-8" />
    <title>@yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Simplux" name="author" />

    <!-- Favicon and Apple Touch Icon -->
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/images/favicons/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/images/favicons/favicon-16x16.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/images/favicons/apple-touch-icon.png') }}">

    <!-- Web Manifest, Safari Pinned Tab, Microsoft Tile Color, and Theme Color -->
    <link rel="manifest" href="{{ asset('assets/images/favicons/site.webmanifest') }}">
    <link rel="mask-icon" href="{{ asset('assets/images/favicons/safari-pinned-tab.svg') }}" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

    <!-- Other CSS and Stylesheets -->
    @include('layouts.head-css')

    <!-- Livewire Styles -->
    @livewireStyles
</head>

<body>
    <!-- Include layout body -->
    @include('layouts.body')

    <!-- Begin page -->
    <div id="layout-wrapper">
        <!-- Include topbar and sidebar -->
        @include('layouts.customer-topbar')
        @include('layouts.sidebar')

        <!-- Start main content -->
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    <!-- Yield the content section -->
                    @yield('content')
                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

            <!-- Include footer -->
            @include('layouts.footer')
        </div>
        <!-- end main content -->
    </div>
    <!-- END layout-wrapper -->

    <!-- Back to top button -->
    <button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
        <i class="ri-arrow-up-line"></i>
    </button>

    <!-- Loader -->
    <div id="loader-wrapper" style="display: none;">
        <div id="loader"></div>
    </div>

    <!-- Include vendor scripts -->
    @include('layouts.vendor-scripts')

    <!-- Livewire Scripts -->
    @livewireScripts
</body>
</html>
