@extends('layouts.master-without-nav')
@section('title')
login
@endsection
@section('content')
<div class="auth-page-wrapper pt-5">
   <!-- auth page bg -->
   <div class="auth-one-bg-position auth-one-bg"  id="auth-particles">
      <div class="bg-overlay"></div>
      <div class="shape">
         <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1440 120">
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
                        <div>
                           <a href="index.html" class="d-inline-block auth-logo">
                              @if(!empty(setting('logo')) && file_exists(setting('logo')))
                                    <img src="{{ asset(setting('logo')) }}" alt="" style="max-height:120px; max-width:100%">
                              @endif
                           </a><br><br>
                           @if (session('error'))
                              <div class="alert alert-danger">
                                 {{ session('error') }}
                              </div>
                           @endif
                        </div>
                        <h5 class="text-primary">Welcome Back !</h5>
                        @if(!empty(setting('company')))
                           <p class="text-muted">Sign in to continue to {{setting('company')}}.</p>
                        @endif
                     </div>
                     <div class="p-2 mt-4">
                        <form action="{{ route('login') }}" method="POST">
                           @csrf
                           <div class="mb-3">
                              <label for="username" class="form-label">Username or Email</label>
                              <input type="text" class="form-control {{ $errors->has('username') || $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('username') ?: old('email') }}" id="login" name="login" placeholder="Enter username or email">
                              @error('username')
                              <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                           </div>
                           <div class="mb-3">
                              <div class="float-end">
                                 <a href="{{ route('password.request') }}" class="text-muted">Forgot password?</a>
                              </div>
                              <label class="form-label" for="password-input">Password</label>
                              <div class="position-relative auth-pass-inputgroup mb-3">
                                 <input type="password" class="form-control pe-5 @error('password') is-invalid @enderror" name="password" placeholder="Enter password" id="password-input">
                                 <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted" type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                                 @error('password')
                                 <span class="invalid-feedback" role="alert">
                                 <strong>{{ $message }}</strong>
                                 </span>
                                 @enderror
                              </div>
                           </div>
                           <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="" id="auth-remember-check">
                              <label class="form-check-label" for="auth-remember-check">Remember me</label>
                           </div>
                           <div class="mt-4">
                              <button class="btn btn-success w-100" type="submit">Sign In</button>
                           </div>
                           {{-- 
                           <div class="mt-4 text-center">
                              <div class="signin-other-title">
                                 <h5 class="fs-13 mb-4 title">Sign In with</h5>
                              </div>
                              <div>
                                 <button type="button" class="btn btn-primary btn-icon waves-effect waves-light"><i class="ri-facebook-fill fs-16"></i></button>
                                 <button type="button" class="btn btn-danger btn-icon waves-effect waves-light"><i class="ri-google-fill fs-16"></i></button>
                                 <button type="button" class="btn btn-dark btn-icon waves-effect waves-light"><i class="ri-github-fill fs-16"></i></button>
                                 <button type="button" class="btn btn-info btn-icon waves-effect waves-light"><i class="ri-twitter-fill fs-16"></i></button>
                              </div>
                           </div>
                           --}}
                        </form>
                     </div>
                  </div>
                  <!-- end card body -->
               </div>
               <!-- end card -->
               @if(!count(App\Models\User::all()))
                  <div class="mt-4 text-center">
                  <p class="mb-0">Don't have an account ? <a href="{{route('register')}}" class="fw-semibold text-primary text-decoration-underline"> Signup </a> </p>
               </div>
               @endif
               
            </div>
         </div>
         <!-- end row -->
      </div>
      <!-- end container -->
   </div>
   <!-- end auth page content -->
   @include('components.auth-footer')
</div>
@endsection
@section('script')
<script src="assets/libs/particles.js/particles.js.min.js"></script>
<script src="assets/js/pages/particles.app.js"></script>
<script src="assets/js/pages/password-addon.init.js"></script>
@endsection