@extends('layouts.master')
@section('title') create lead @endsection
@section('css')
@endsection
@section('content')
{{-- @component('components.breadcrumb')
@slot('li_1') lead @endslot
@slot('title') Create @endslot
@endcomponent --}}
<div class="page-title-box d-sm-flex align-items-center justify-content-between">
   <h4 class="mb-sm-0 font-size-18">Create</h4>
   <div class="page-title-right">
      <ol class="breadcrumb m-0">
         <li class="breadcrumb-item"><a href="{{ route('lead.index') }}">Leads</a></li>
         <li class="breadcrumb-item active"><a href="{{ route('lead.create') }}">Create</a></li>
      </ol>
   </div>
</div>
<!-- .card-->
<div class="row justify-content-center">
   <div class="col-lg-8">
      <div class="card">
         <div class="card-header border-bottom-dashed">
            <div class="d-flex align-items-center">
               <h5 class="card-title mb-0 flex-grow-1"><i class="ri-router-line"></i> Create lead</h5>
               <div class="flex-shrink-0">
               </div>
            </div>
         </div>
         <div class="card-body">
            <form class="row g-3" method="POST"
               action="{{ route('lead.save') }}" enctype="multipart/form-data">
               @csrf
               <input type="hidden" name="username" value="{{sprintf("%06d", mt_rand(1, 999999))}}">
               <input type="hidden" name="password" value="{{sprintf("%08d", mt_rand(1, 999999))}}">
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
               
               <div class="col-md-12">
                  <label for="location" class="form-label">location <span class="text-muted">(optional)</span> </label>
                  <input type="text" name="location" class="form-control @error('location') is-invalid @enderror" id="location"
                     placeholder="Location"
                     value="{{auth()->user()->location ?: old('location')}}">
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
                        id="add-btn"><i class="las la-save"></i> Create lead</button>
                  </div>
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
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBhbbW5e_87sUBzZh3azjAw_mtXvmUJDVc&libraries=places"></script>
<!-- init js -->
<script src="{{URL::asset('assets/js/pages/form-pickers.init.js')}}"></script>
<script type="text/javascript">
   window.addEventListener('load', function () {
       var places = new google.maps.places.Autocomplete(document.getElementById('location'));
       google.maps.event.addListener(places, 'place_changed', function () {
   
       });
   });
</script>
<!-- App js -->
<script src="{{asset('assets/js/app.js')}}"></script>
@endsection