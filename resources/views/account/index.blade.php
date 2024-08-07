@extends('layouts.master') @section('title') account @endsection @section('css') @endsection @section('content') @component('components.breadcrumb') @slot('li_1') Account @endslot @slot('title') settings @endslot
@endcomponent
<div class="position-relative mx-n4 mt-n4">
   <div class="profile-setting-img">
      {{-- <img src="{{asset('assets/images/profile-bg.jpg')}}" class="profile-wid-img" alt="">  --}}
   </div>
</div>
<div class="row">
   <div class="col-xxl-3">
      <div style="margin-top:-25px" class="card">
         <div class="card-body p-4">
            <div class="text-center">
               <div class="profile-user position-relative d-inline-block mx-auto mb-4">
                  <img id="user-profile-image" 
                  src="{{ auth()->user()->avatar ? asset(auth()->user()->avatar) : 'https://www.gravatar.com/avatar/' . md5(strtolower(trim(auth()->user()->email))) . '?s=100&d=mm&r=g' }}" 
                  class="rounded-circle avatar-xl img-thumbnail user-profile-image" 
                  alt="user-profile-image" />              
                  <div class="avatar-xs p-0 rounded-circle profile-photo-edit">
                     <form method="POST" action="{{ route('avatar.upload') }}" enctype="multipart/form-data" id="avatar-form">
                        @csrf
                        <input id="profile-img-file-input" type="file" class="profile-img-file-input" name="avatar" accept="image/*">
                     </form>
                     <label for="profile-img-file-input" class="profile-photo-edit avatar-xs">
                        <span class="avatar-title rounded-circle bg-light text-body">
                        <i class="ri-camera-fill"></i>
                        </span>
                     </label>
                  </div>
               </div>
               <h5 class="fs-16 mb-1">{{auth()->user()->firstname .' '. auth()->user()->lastname}}</h5>
               <p class="text-muted mb-0">@ {{ auth()->user()->username }}</p>
            </div>
         </div>
      </div>
      <!--end card-->
   </div>
   <!--end col-->
   <div class="col-xxl-9">
      <div class="card mt-xxl-n4">
         <div class="card-header">
            <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
               <li class="nav-item">
                  <a class="nav-link {{ $errors->has('currentpassword') || $errors->has('newpassword') || $errors->has('confirmpassword') ? '' : 'active' }}" data-bs-toggle="tab" href="#personalDetails" role="tab">
                  <i class="fas fa-home"></i>
                  Personal Details
                  </a>
               </li>
               <li class="nav-item">
                  <a class="nav-link {{ $errors->has('currentpassword') || $errors->has('newpassword') || $errors->has('confirmpassword') ? 'active' : '' }}" data-bs-toggle="tab" href="#changePassword" role="tab">
                  <i class="far fa-user"></i>
                  Password & Security
                  </a>
               </li>
            </ul>
         </div>
         <div class="card-body p-4">
            <div class="tab-content">
               <div class="tab-pane {{ $errors->has('currentpassword') || $errors->has('newpassword') || $errors->has('confirmpassword') ? '' : 'active' }}" id="personalDetails" role="tabpanel">
                  <form action="{{route('profile.update')}}" method="POST">
                     @csrf @method('put')
                     <div class="row">
                        @if (session('status'))
                        <div class="alert alert-success" role="alert">
                           {{session('status')}}
                        </div>
                        @endif
                        <div class="col-lg-6">
                           <div class="mb-3">
                              <label for="firstnameInput" class="form-label">First Name</label>
                              <input type="text" name="firstname" class="form-control @error('firstname') is-invalid @enderror" id="firstname" placeholder="Enter your firstname" value="{{auth()->user()->firstname}}" />
                              @error('firstname')
                              <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                           </div>
                        </div>
                        <!--end col-->
                        <div class="col-lg-6">
                           <div class="mb-3">
                              <label for="lastnameInput" class="form-label">Last Name</label>
                              <input type="text" name="lastname" class="form-control @error('lastname') is-invalid @enderror" id="lastname" placeholder="Enter your lastname" value="{{auth()->user()->lastname}}" />
                              @error('lastname')
                              <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                           </div>
                        </div>
                        <!--end col-->
                        @if (auth()->user()->type != 'client')
                        <div class="col-lg-6">
                           <div class="mb-3">
                              <label for="phonenumberInput" class="form-label">Phone Number</label>
                              <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" id="phonenumber" placeholder="Enter your phone number" value="{{auth()->user()->phone ?: old('phone')}}" />
                              @error('phone')
                              <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                           </div>
                        </div>
                        <!--end col-->
                        <div class="col-lg-6">
                           <div class="mb-3">
                              <label for="location" class="form-label">location</label>
                              <input type="text" name="location" class="form-control @error('location') is-invalid @enderror" id="location" placeholder="Location" value="{{auth()->user()->location ?: old('location')}}" />
                              @error('location')
                              <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                           </div>
                        </div>    
                        @endif
                        <!--end col-->
                        <div class="col-lg-12">
                           <div class="hstack gap-2 justify-content-end">
                              <button type="submit" class="btn btn-soft-success">Update</button>
                              <a href="" class="btn btn-light">Cancel</a>
                           </div>
                        </div>
                        <!--end col-->
                     </div>
                     <!--end row-->
                  </form>
               </div>
               <!--end tab-pane-->
               <div class="tab-pane {{ $errors->has('currentpassword') || $errors->has('newpassword') || $errors->has('confirmpassword') ? 'active' : '' }}" id="changePassword" role="tabpanel">
                  <form action="{{route('change_password')}}" id="password-form" method="POST">
                     @if (session('status'))
                     <div class="alert alert-success" role="alert">
                        {{session('status')}}
                     </div>
                     @endif @csrf
                     <div class="row g-2">
                        <div class="col-lg-4">
                           <div>
                              <label for="currentpassword" class="form-label">Current Password*</label>
                              <input type="password" name="currentpassword" class="form-control @error('currentpassword') is-invalid @enderror" id="currentpassword" placeholder="Enter current password" />
                              @error('currentpassword')
                              <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                           </div>
                        </div>
                        <!--end col-->
                        <div class="col-lg-4">
                           <div>
                              <label for="newpassword" class="form-label">New Password*</label>
                              <input type="password" name="newpassword" class="form-control @error('newpassword') is-invalid @enderror" id="newpassword" placeholder="Enter new password" />
                              @error('newpassword')
                              <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                           </div>
                        </div>
                        <!--end col-->
                        <div class="col-lg-4">
                           <div>
                              <label for="confirmpassword" class="form-label">Confirm Password*</label>
                              <input type="password" name="confirmpassword" class="form-control @error('confirmpassword') is-invalid @enderror" id="confirmpassword" placeholder="Confirm password" />
                              @error('confirmpassword')
                              <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                           </div>
                        </div>
                        <!--end col-->

                        <div class="col-lg-12">
                           <div class="hstack gap-2 justify-content-end">
                              <button type="submit" class="btn btn-soft-success">Change Password</button>
                           </div>
                        </div>

                        <!--end col-->
                     </div>
                     <!--end row-->
                  </form>
                  
               </div>
               <!--end tab-pane-->
            </div>
         </div>
      </div>
   </div>
   <!--end col-->
</div>
<!--end row-->
@endsection 
@section('script')
<script src="{{ URL::asset('/assets/js/jquery-3.6.1.js')}}"></script>
<!-- App js -->
<script src="{{asset('assets/js/app.js')}}"></script>

<script>
$(document).ready(function() {
  $('#profile-img-file-input').change(function(e) {
    e.preventDefault();
    var file = e.target.files[0];
    var reader = new FileReader();
    reader.onload = function() {
      var img = new Image();
      img.src = reader.result;
      img.onload = function() {
        var canvas = document.createElement('canvas');
        var ctx = canvas.getContext('2d');
        var width = img.width;
        var height = img.height;
        if (width > height) {
          var ratio = width / height;
          width = 200;
          height = parseInt(width / ratio);
        } else {
          var ratio = height / width;
          height = 200;
          width = parseInt(height / ratio);
        }
        canvas.width = width;
        canvas.height = height;
        ctx.drawImage(img, 0, 0, width, height);

        // Crop the image to make it square
        var squareSize = Math.min(width, height);
        var xOffset = (width - squareSize) / 2;
        var yOffset = (height - squareSize) / 2;
        var squareCanvas = document.createElement('canvas');
        squareCanvas.width = squareSize;
        squareCanvas.height = squareSize;
        var squareCtx = squareCanvas.getContext('2d');
        squareCtx.drawImage(canvas, xOffset, yOffset, squareSize, squareSize, 0, 0, squareSize, squareSize);

        squareCanvas.toBlob(function(blob) {
          var formData = new FormData($('#avatar-form')[0]);
          formData.set('avatar', blob, 'avatar.jpg');
          $.ajax({
            url: "{{ route('avatar.upload') }}",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
              // Update the avatar section with the new image
              $('#user-profile-image').attr('src', response.avatar_url);

              // Auto-update the image section
              $('#user-profile-image').load(function() {
                console.log('Image loaded!');
              });
            },
            error: function(xhr, status, error) {
              console.log(error);
            }
          });
        }, 'image/jpeg', 0.8);
      };
    };
    reader.readAsDataURL(file);
  });
});
</script>
@endsection