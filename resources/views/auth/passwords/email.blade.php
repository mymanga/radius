@extends('layouts.master-without-nav')
@section('title')
reset password
@endsection
@section('content')
<div class="auth-page-wrapper pt-5">
   <!-- auth page bg -->
   <div class="auth-one-bg-position auth-one-bg" id="auth-particles">
      <div class="bg-overlay"></div>
      <div class="shape">
         <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
            viewBox="0 0 1440 120">
            <path d="M 0,36 C 144,53.6 432,123.2 720,124 C 1008,124.8 1296,56.8 1440,40L1440 140L0 140z"></path>
         </svg>
      </div>
   </div>
   <!-- auth page content -->
   <div class="auth-page-content">
      <div class="container">
         @include('components.auth-header')
         <!-- end row -->
         <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
               <div class="card mt-4">
                  <div class="card-body p-4">
                     <div class="text-center mt-2">
                        <h5 class="text-primary">Forgot Password?</h5>
                        <p class="text-muted">Reset password with {{setting('company')}}</p>
                        <lord-icon src="https://cdn.lordicon.com/rhvddzym.json" trigger="loop"
                           colors="primary:#0ab39c" class="avatar-xl">
                        </lord-icon>
                     </div>
                     @if (session('status'))
                     <div class="alert alert-success" role="alert">
                        {{session('status')}}
                     </div>
                     @else
                     <div class="alert alert-borderless alert-warning text-center mb-2 mx-2" role="alert">
                        Enter your email address below!
                     </div>
                     @endif
                     <div class="p-2">
                        <form class="form-horizontal" method="POST" action="{{ route('password.email') }}">
                           @csrf
                           <div class="mb-3">
                              <label for="useremail" class="form-label">Email</label>
                              <input type="email" class="form-control @error('email') is-invalid @enderror" id="useremail" name="email" placeholder="Enter email" value="{{old('email')}}" id="email">
                              @error('email')
                              <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                           </div>
                           <div class="text-end">
                              <button class="btn btn-primary w-md waves-effect waves-light" type="submit">Send</button>
                           </div>
                        </form>
                        <!-- end form -->
                     </div>
                  </div>
                  <!-- end card body -->
               </div>
               <!-- end card -->
               <div class="mt-4 text-center">
                  <p class="mb-0">Wait, I remember my password... <a href="{{route('login')}}"
                     class="fw-semibold text-primary text-decoration-underline"> Click here </a> </p>
               </div>
            </div>
         </div>
         <!-- end row -->
      </div>
      <!-- end container -->
   </div>
   <!-- end auth page content -->
   <!-- footer -->
   @include('components.auth-footer')
   <!-- end Footer -->
</div>
<!-- end auth-page-wrapper -->
@endsection
@section('script')
<script src="{{ URL::asset('assets/libs/particles.js/particles.js.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/pages/particles.app.js') }}"></script>
@endsection