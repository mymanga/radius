@extends('layouts.master')
@section('title') edit user @endsection
@section('css')
@endsection
@section('content')

<div class="page-title-box d-sm-flex align-items-center justify-content-between">
   <h4 class="mb-sm-0 font-size-18">Update user</h4>
   <div class="page-title-right">
      <ol class="breadcrumb m-0">
         <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Admin</a></li>
         <li class="breadcrumb-item active"><a>Update user</a></li>
      </ol>
   </div>
</div>
<!-- .card-->
<div class="row justify-content-center">
   <div class="col-lg-8">
      <div class="card">
         <div class="card-header border-bottom-dashed">
            <div class="d-flex align-items-center">
               <h5 class="card-title mb-0 flex-grow-1"><i class="ri-user-line"></i> Update user</h5>
               <div class="flex-shrink-0">
               </div>
            </div>
         </div>
         <div class="card-body form-card">
            <form class="row g-3" method="POST"
               action="{{ route('admin.user.update',[$user->id]) }}" enctype="multipart/form-data">
               @csrf
               @method('PUT')
               <div class="col-md-6">
                  <label for="useremail" class="form-label">First Name <span
                     class="text-danger">*</span></label>
                  <input type="text" class="form-control @error('firstname') is-invalid @enderror"
                     name="firstname" value="{{ old('firstname') ? old('firstname') : $user->firstname }}" id="firstname"
                     placeholder="Enter firstname" value="{{$user->firstname}}" required>
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
                     name="lastname" value="{{ old('lastname') ? old('lastname') : $user->lastname }}" id="lastname"
                     placeholder="Enter lastname" required>
                  @error('lastname')
                  <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                  </span>
                  @enderror
               </div>
               <div class="col-md-6">
                  <label for="useremail" class="form-label">Email <span
                     class="text-danger">*</span></label>
                  <input type="email" class="form-control @error('email') is-invalid @enderror"
                     name="email" value="{{ old('email') ? old('email') : $user->email }}" id="useremail"
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
                     name="phone" value="{{ old('phone') ? old('phone') : $user->phone }}" id="phone"
                     placeholder="Enter phone" required>
                  @error('phone')
                  <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                  </span>
                  @enderror
               </div>
               @foreach($roles as $role)
               <div class="col-md-6">
                  {{-- <label for="service_active" class="form-label">Service active <span class="text-danger">*</span></label> --}}
                  <div class="form-check form-switch form-switch-md mb-3" dir="ltr">
                     <input type="checkbox" name="role" class="form-check-input" id="customSwitchsizemd" {{$user->hasRole($role->name) ? 'checked' : ''}} value="{{$role->id}}">
                     <label class="form-check-label" for="labelswitchy">{{$role->name}}</label>
                  </div>
               </div>
               @endforeach
               <div class="mt-4">
                  <button class="btn btn-soft-info w-100" type="submit"><i class="las la-save"></i> Update user</button>
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