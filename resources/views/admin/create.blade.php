@extends('layouts.master')
@section('title') create user @endsection
@section('css')
@endsection
@section('content')

<div class="page-title-box d-sm-flex align-items-center justify-content-between">
   <h4 class="mb-sm-0 font-size-18">Create user</h4>
   <div class="page-title-right">
      <ol class="breadcrumb m-0">
         <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Admin</a></li>
         <li class="breadcrumb-item active"><a href="{{ route('admin.user.create') }}">Create user</a></li>
      </ol>
   </div>
</div>
<!-- .card-->
<div class="row justify-content-center">
   <div class="col-lg-8">
      <div class="card">
         <div class="card-header border-bottom-dashed">
            <div class="d-flex align-items-center">
               <h5 class="card-title mb-0 flex-grow-1"><i class="ri-router-line"></i> Create user</h5>
               <div class="flex-shrink-0">
               </div>
            </div>
         </div>
         <div class="card-body form-card">
            <form class="row g-3" method="POST"
               action="{{ route('admin.user.save') }}" enctype="multipart/form-data">
               @csrf
               <div class="col-md-6">
                  <label for="useremail" class="form-label">First Name <span
                     class="text-danger">*</span></label>
                  <input type="text" class="form-control @error('firstname') is-invalid @enderror"
                     name="firstname" value="{{ old('firstname') }}" id="firstname"
                     placeholder="Enter firstname" required>
                  @error('firstname')
                  <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                  </span>
                  @enderror
               </div>
               <div class="col-md-6">
                  <label for="useremail" class="form-label">Last Name <span
                     class="text-danger">*</span></label>
                  <input type="text" class="form-control @error('lastname') is-invalid @enderror"
                     name="lastname" value="{{ old('lastname') }}" id="lastname"
                     placeholder="Enter lastname" required>
                  @error('lastname')
                  <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                  </span>
                  @enderror
               </div>
               <div class="col-md-6">
                  <label for="useremail" class="form-label">Username <span
                     class="text-danger">*</span></label>
                  <div class="input-group">
                     <input type="text" name="username" value="{{ old('username') }}" id="username" class="form-control @error('username') is-invalid @enderror" aria-label="username" placeholder="Username">
                     {{-- <button class="btn btn-soft-info" type="button" id="button" onclick="randomPortalLogin(this)">Generate</button> --}}
                     @error('username')
                     <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                     </span>
                     @enderror
                  </div>
               </div>
               <div class="col-md-6">
                  <label for="userpassword" class="form-label">Password <span
                     class="text-danger">*</span></label>
                  <div class="input-group">
                     <input type="text" name="password" value="{{ old('password') }}" id="username" class="form-control @error('password') is-invalid @enderror" aria-label="password" placeholder="Password">
                     <button class="btn btn-soft-info" type="button" id="button" onclick="randomPortalPassword(this)">Generate</button>
                     @error('password')
                     <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                     </span>
                     @enderror
                  </div>
               </div>
               <div class="col-md-6">
                  <label for="useremail" class="form-label">Email <span
                     class="text-danger">*</span></label>
                  <input type="email" class="form-control @error('email') is-invalid @enderror"
                     name="email" value="{{ old('email') }}" id="useremail"
                     placeholder="Enter address" required>
                  @error('email')
                  <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                  </span>
                  @enderror
               </div>
               <div class="col-md-6">
                  <label for="phone" class="form-label">Phone <span
                     class="text-danger">*</span></label>
                  <input type="text" class="form-control @error('phone') is-invalid @enderror"
                     name="phone" value="{{ old('phone') }}" id="phone"
                     placeholder="Enter phone" required>
                  @error('phone')
                  <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                  </span>
                  @enderror
               </div>
               @foreach($roles as $role)
               <div class="col-md-6 col-sm-6">
                  {{-- <label for="service_active" class="form-label">Service active <span class="text-danger">*</span></label> --}}
                  <div class="form-check form-switch form-switch-md mb-3" dir="ltr">
                     <input type="checkbox" name="role" class="form-check-input" id="customSwitchsizemd" {{old('role') == $role->id ? 'checked' : ''}} value="{{$role->id}}">
                     <label class="form-check-label" for="customSwitchsizemd">{{$role->name}}</label>
                  </div>
               </div>
               @endforeach
               {{-- <script>
                  $(document).ready(function(){
                  $('.form-check-input').click(function() {
                  $('.form-check-input').not(this).prop('checked', false);
                  });
                  });
               </script> --}}
               <div class="mt-4">
                  <button class="btn btn-soft-info w-100" type="submit"><i class="las la-save"></i> Create user</button>
               </div>
            </form>
            <!--end modal -->
         </div>
      </div>
   </div>
</div>
@endsection
@section('script')
<script src="{{ URL::asset('/assets/js/jquery-3.6.1.js')}}"></script>
<script type="text/javascript">
   window.addEventListener('load', function () {
       var places = new google.maps.places.Autocomplete(document.getElementById('location'));
       google.maps.event.addListener(places, 'place_changed', function () {
   
       });
   });
</script>
<script>
   function randomPortalLogin(clicked_element)
   {
       var self = $(clicked_element);
       var random_string = generateRandomString(5);
       $('input[name=username]').val(random_string);
       self.remove();
   }
   
   function randomPortalPassword(clicked_element)
   {
       var self = $(clicked_element);
       var random_string = generateRandomString(9);
       $('input[name=password]').val(random_string);
       {{-- self.remove(); --}}
   }
   
   function generateRandomString(string_length)
   {
       var characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ*#!$%^&+?aeiou';
       var string = '';
   
       for(var i = 0; i <= string_length; i++)
       {
           var rand = Math.round(Math.random() * (characters.length - 1));
           var character = characters.substr(rand, 1);
           string = string + character;
       }
   
       return string;
   }
   
</script>
<script>
   // the selector will match all input controls of type :checkbox
   // and attach a click event handler 
   $("input:checkbox").on('click', function() {
   // in the handler, 'this' refers to the box clicked on
   var $box = $(this);
   if ($box.is(":checked")) {
   // the name of the box is retrieved using the .attr() method
   // as it is assumed and expected to be immutable
   var group = "input:checkbox[name='" + $box.attr("name") + "']";
   // the checked state of the group/box on the other hand will change
   // and the current value is retrieved using .prop() method
   $(group).prop("checked", false);
   $box.prop("checked", true);
   } else {
   $box.prop("checked", false);
   }
   });
</script>
<!-- App js -->
<script src="{{asset('assets/js/app.js')}}"></script>
@endsection