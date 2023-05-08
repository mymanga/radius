@extends('layouts.master')
@section('title') edit lead @endsection
@section('css')
@endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') lead @endslot
@slot('title') Create @endslot
@endcomponent
<!-- .card-->
<div class="row justify-content-center">
   <div class="col-lg-8">
      <div class="card" id="orderList">
         <div class="card-header">
            <div class="d-flex align-items-center">
               <h5 class="card-title mb-0 flex-grow-1"><i class="ri-router-line"></i> Update lead</h5>
               <div class="flex-shrink-0">
               </div>
            </div>
         </div>
         <div class="card-body">
            <form class="row g-3" novalidate method="POST"
               action="{{ route('lead.update',[$lead->username]) }}" enctype="multipart/form-data">
               @csrf
               @method('put')
               <div class="col-md-6">
                  <label for="useremail" class="form-label">First Name <span
                     class="text-danger">*</span></label>
                  <input type="text" class="form-control @error('firstname') is-invalid @enderror"
                     name="firstname" value="{{ $lead->firstname}}" id="firstname"
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
                     name="lastname" value="{{ $lead->lastname}}" id="lastname"
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
                     name="email" value="{{ $lead->email}}" id="useremail"
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
                     name="phone" value="{{ $lead->phone}}" id="phone"
                     placeholder="Enter phone" required>
                  @error('phone')
                  <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                  </span>
                  @enderror
               </div>
 
               <div class="col-md-12">
                  <label for="location" class="form-label">location <span class="text-muted">(optional)</span> </label>
                  <input type="text" name="location" class="form-control @error('location') is-invalid @enderror" id="location"
                     placeholder="Location"
                     value="{{$lead->location ?: old('location')}}">
                  @error('location')
                  <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                  </span>
                  @enderror
               </div>
               <div class="col-12">
                  <div class="hstack gap-2 justify-content-end">
                     <a href="{{route('lead.index')}}" class="btn btn-light w-50">Cancel</a>
                     <button type="submit" class="btn btn-soft-info w-50"
                        id="add-btn"><i class="las la-save"></i> Update lead</button>
                  </div>
               </div>
            </form>
         </div>
         <!--end modal -->
      </div>
   </div>
</div>
@endsection
@section('script')
<script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBhbbW5e_87sUBzZh3azjAw_mtXvmUJDVc&libraries=places"></script>
<!-- init js -->
<script src="{{URL::asset('/assets/js/pages/form-pickers.init.js')}}"></script>
<script type="text/javascript">
   google.maps.event.addDomListener(window, 'load', function () {
       var places = new google.maps.places.Autocomplete(document.getElementById('location'));
       google.maps.event.addListener(places, 'place_changed', function () {
   
       });
   });
</script>
<script>
   function randomPortalPassword(clicked_element)
   {
       var self = $(clicked_element);
       var random_string = generateRandomString(7);
       $('input[name=password]').val(random_string);
       {{-- self.remove(); --}}
   }
   
   function generateRandomString(string_length)
   {
       var characters = '0123456789';
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
<!-- App js -->
<script src="{{asset('assets/js/app.js')}}"></script>
@endsection