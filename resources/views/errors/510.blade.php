<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg">
   <head>
      <meta charset="utf-8" />
      <title>License Error</title>
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta content="Simple ISP" name="author" />
      <!-- App favicon -->
      <link rel="shortcut icon" href="assets/images/favicon.ico">
      <!-- Layout config Js -->
      <script src="{{URL::asset('assets/js/layout.js')}}"></script>
      <!-- Bootstrap Css -->
      <link href="{{URL::asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
      <!-- Icons Css -->
      <link href="{{URL::asset('assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
      <!-- App Css-->
      <link href="{{URL::asset('assets/css/app.min.css')}}" rel="stylesheet" type="text/css" />
      <!-- custom Css-->
      <link href="{{URL::asset('assets/css/custom.min.css')}}" rel="stylesheet" type="text/css" />
   </head>
   <body>
      <!-- auth-page wrapper -->
      <div class="auth-page-wrapper auth-bg-cover py-5 d-flex justify-content-center align-items-center min-vh-100">
         <div class="bg-overlay"></div>
         <!-- auth page content -->
         <div class="auth-page-content overflow-hidden pt-lg-5">
            <div class="container">
               @include('components.auth-header')
               <div class="row justify-content-center">
                  <div class="col-xl-5">
                     <div class="card overflow-hidden">
                        <div class="card-body p-4">
                           <div class="text-center">
                              <lord-icon class="avatar-xl"
                                 src="https://cdn.lordicon.com/spxnqpau.json"
                                 trigger="loop"
                                 colors="primary:#405189,secondary:#0ab39c">
                              </lord-icon>
                              <h1 class="text-primary mb-4">Oops !</h1>
                              <h4 class="text-uppercase text-danger">License Error 😭</h4>
                              <p class="text-muted mb-4">{{ $exception->getMessage() }}</p>
                              <a href="{{ route('license.index') }}" class="btn btn-success"><i class="mdi mdi-home me-1"></i>Licence Activation</a>
                           </div>
                        </div>
                     </div>
                     <!-- end card -->
                  </div>
                  <!-- end col -->
               </div>
               <!-- end row -->
            </div>
            <!-- end container -->
         </div>
         <!-- end auth page content -->
      </div>
      <!-- end auth-page-wrapper -->
      <!-- JAVASCRIPT -->
      <script src="{{URL::asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
      <script src="{{URL::asset('assets/libs/simplebar/simplebar.min.js')}}"></script>
      <script src="{{URL::asset('assets/libs/node-waves/waves.min.js')}}"></script>
      <script src="{{URL::asset('assets/libs/feather-icons/feather.min.js')}}"></script>
      <script src="{{URL::asset('assets/js/pages/plugins/lord-icon-2.1.0.js')}}"></script>
      <script src="{{URL::asset('assets/js/plugins.js')}}"></script>
   </body>
</html>