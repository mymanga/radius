@extends('layouts.master-without-nav')
@section('title')
register
@lang('translation.signup')
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
                        <h5 class="text-primary">Create New Account</h5>
                        <p class="text-muted">Get your free {{setting('company')}} account now</p>
                     </div>
                     <div class="p-2 mt-4">
                        <form class="needs-validation" novalidate method="POST"
                           action="{{ route('register') }}" enctype="multipart/form-data">
                           @csrf
                           <div class="mb-3">
                              <label for="useremail" class="form-label">First Name <span
                                 class="text-danger">*</span></label>
                              <input type="text" class="form-control @error('firstname') is-invalid @enderror"
                                 name="firstname" value="{{ old('firstname') }}" id="firstname"
                                 placeholder="Enter your firstname" required>
                              @error('firstname')
                              <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                              <div class="invalid-feedback">
                                 Please enter firstname
                              </div>
                           </div>
                           <div class="mb-3">
                              <label for="useremail" class="form-label">Last Name <span
                                 class="text-danger">*</span></label>
                              <input type="text" class="form-control @error('lastname') is-invalid @enderror"
                                 name="lastname" value="{{ old('lastname') }}" id="lastname"
                                 placeholder="Enter your lastname" required>
                              @error('lastname')
                              <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                              <div class="invalid-feedback">
                                 Please enter lastname
                              </div>
                           </div>
                           <div class="mb-3">
                              <label for="useremail" class="form-label">Email <span
                                 class="text-danger">*</span></label>
                              <input type="email" class="form-control @error('email') is-invalid @enderror"
                                 name="email" value="{{ old('email') }}" id="useremail"
                                 placeholder="Enter email address" required>
                              @error('email')
                              <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                              <div class="invalid-feedback">
                                 Please enter email
                              </div>
                           </div>
                           <div class="mb-3">
                              <label for="useremail" class="form-label">Username <span
                                 class="text-danger">*</span></label>
                              <input type="text" class="form-control @error('username') is-invalid @enderror"
                                 name="username" value="{{ old('username') }}" id="username"
                                 placeholder="Enter your username" required>
                              @error('username')
                              <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                              <div class="invalid-feedback">
                                 Please enter username
                              </div>
                           </div>
                           <div class="mb-2">
                              <label for="userpassword" class="form-label">Password <span
                                 class="text-danger">*</span></label>
                              <input type="password"
                                 class="form-control @error('password') is-invalid @enderror" name="password"
                                 id="userpassword" placeholder="Enter password" required>
                              @error('password')
                              <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                              <div class="invalid-feedback">
                                 Please enter password
                              </div>
                           </div>
                           <div class=" mb-4">
                              <label for="input-password">Confirm Password</label>
                              <input type="password"
                                 class="form-control @error('password_confirmation') is-invalid @enderror"
                                 name="password_confirmation" id="input-password"
                                 placeholder="Enter Confirm Password" required>
                              <div class="form-floating-icon">
                                 <i data-feather="lock"></i>
                              </div>
                           </div>
                           {{-- 
                           <div class=" mb-4">
                              <input type="file" class="form-control @error('avatar') is-invalid @enderror"
                                 name="avatar" id="input-avatar" required>
                              @error('avatar')
                              <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                              <div class="">
                                 <i data-feather="file"></i>
                              </div>
                           </div>
                           --}}
                           <div class="mb-4">
                              <p class="mb-0 fs-12 text-muted fst-italic">By registering you agree to the
                                 <a href="#"
                                    class="text-primary text-decoration-underline fst-normal fw-medium">Terms
                                 of Use</a>
                              </p>
                           </div>
                           <div class="mt-4">
                              <button class="btn btn-success w-100" type="submit">Sign Up</button>
                           </div>
                           {{-- 
                           <div class="mt-4 text-center">
                              <div class="signin-other-title">
                                 <h5 class="fs-13 mb-4 title text-muted">Create account with</h5>
                              </div>
                              <div>
                                 <button type="button"
                                    class="btn btn-primary btn-icon waves-effect waves-light"><i
                                    class="ri-facebook-fill fs-16"></i></button>
                                 <button type="button"
                                    class="btn btn-danger btn-icon waves-effect waves-light"><i
                                    class="ri-google-fill fs-16"></i></button>
                                 <button type="button"
                                    class="btn btn-dark btn-icon waves-effect waves-light"><i
                                    class="ri-github-fill fs-16"></i></button>
                                 <button type="button"
                                    class="btn btn-info btn-icon waves-effect waves-light"><i
                                    class="ri-twitter-fill fs-16"></i></button>
                              </div>
                           </div>
                           --}}
                        </form>
                     </div>
                  </div>
                  <!-- end card body -->
               </div>
               <!-- end card -->
               <div class="mt-4 text-center">
                  <p class="mb-0">Already have an account ? <a href="{{route('login')}}"
                     class="fw-semibold text-primary text-decoration-underline"> Signin </a> </p>
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
<script src="{{ URL::asset('assets/js/pages/form-validation.init.js') }}"></script>
@endsection