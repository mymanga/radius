
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-layout="vertical" data-topbar="dark" data-sidebar="{{ auth()->check() && auth()->user()->type == 'client' ? 'dark' : (setting('theme') ? setting('theme') : 'light') }}" data-sidebar-size="lg" data-layout-mode="{{ auth()->check() && auth()->user()->type == 'client' ? 'light' : setting('theme') }}" >
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

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
     
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <link href="{{ asset('vendor/laravel_backup_panel/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/laravel_backup_panel/app.css') }}" rel="stylesheet">
    <!-- Other CSS and Stylesheets -->
    @include('layouts.head-css')
    <style>
        .table thead th {
        vertical-align: bottom;
        border-bottom: none !important;
        }
        .table th, .table td {
        padding: .75rem;
        vertical-align: top;
        border-top: none !important;
        }
        .toastify-custom {
            padding: 16px;
            border-radius: 8px;
            background-color: #1fb16e;
            color: white;
            font-family: Arial, sans-serif;
        }

        .toastify-custom p {
            margin: 0;
        }

        .toastify-custom .toastify-icon {
            margin-right: 8px;
        }

        .toastify-custom .toastify-close {
            display: none; /* Hide the close button */
        }

    </style>

    <!-- Livewire Styles -->
    @livewireStyles
</head>

<body>
    <!-- Include layout body -->
    @include('layouts.body')

    <!-- Begin page -->
    <div id="layout-wrapper">
        <!-- Include topbar and sidebar -->
        @if(auth()->check())
         @if(auth()->user()->type == 'client' || auth()->user()->type == 'lead')
         @include('layouts.customer.customer-topbar')
         @include('layouts.customer.customer-sidebar')
         @else
         @include('layouts.topbar')
         @include('layouts.sidebar')
         @endif
        @endif

        <!-- Start main content -->
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                           <div class="card mt-n4 mx-n4">
                              <div class="bg-soft-light">
                                 @include('settings.backup.header')
                                 <!-- end card body -->
                              </div>
                           </div>
                           <!-- end card -->
                        </div>
                        <!-- end col -->
                     </div>
                    <!-- Yield the content section -->
                    <livewire:laravel_backup_panel::app />
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
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="{{ URL::asset('assets/libs/bootstrap/bootstrap.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/node-waves/node-waves.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/feather-icons/feather-icons.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/pages/plugins/lord-icon-2.1.0.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="{{URL::asset('assets/libs/choices.js/choices.js.min.js')}}"></script>
    <script src="{{URL::asset('assets/libs/flatpickr/flatpickr.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>

    <!-- Livewire Scripts -->
    @livewireScripts
</body>
</html>

