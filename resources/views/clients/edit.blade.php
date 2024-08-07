@extends('layouts.master')
@section('title') edit client @endsection
@section('css')
<!-- Leaflet CSS and JavaScript -->
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.3/css/selectize.min.css">
<style>
   .leaflet-control-geocoder-form input {
   color: #495057 !important;
   }
   .ri-close-fill {
   cursor: pointer;
   margin-left: 5px;
   font-size: 12px;
   color: #ffff;
   } 
   .selectize-control.multi .selectize-input > div {
   cursor: pointer;
   margin: 0 3px 3px 0;
   padding: 2px 6px;
   background: #299cdb;
   color: #fff;
   border: 1px solid #299cdb;
   border-radius: 4px;
   transition: background-color 0.3s ease;
   }
   .selectize-control.multi .selectize-input > div:hover {
   background: #0056b3;
   }
   .selectize-control.multi .selectize-input > div:active {
   background: #003080;
   }
   [data-layout-mode=dark] .selectize-input {
   background-color: var(--vz-input-bg);
   background-clip: padding-box;
   border: 1px solid var(--vz-input-border);
   color: #fff;
   }
   [data-layout-mode=dark] .selectize-input > input {
   color: #fff;
   }
   [data-layout-mode=dark] .selectize-control.multi .selectize-input > div {
   cursor: pointer;
   color: #299cdb;
   background-color: rgba(41,156,219,.1);
   border-color: transparent;
   }
</style>
@endsection
@section('content')
{{-- @component('components.breadcrumb')
@slot('li_1') client @endslot
@slot('title') Create @endslot
@endcomponent --}}
<div class="row">
   <div class="col-lg-12">
      <div class="card mt-n4 mx-n4">
         <div class="bg-soft-light">
            @include('clients.header')
            <!-- end card body -->
         </div>
      </div>
      <!-- end card -->
   </div>
   <!-- end col -->
</div>
<!-- .card-->
<div class="row">
   <div class="col-lg-12">
      @if (session('status'))
      <div class="alert alert-success" role="alert">
         {{session('status')}}
      </div>
      @endif
   </div>
</div>
<form class="needs-validation" novalidate method="POST"
   action="{{ route('client.update',[$client->username]) }}" enctype="multipart/form-data">
   @csrf
   @method('put')
   <div class="row">
      <div class="col-xl-6">
         <div class="card card-height-100">
            <div class="card-header align-items-center d-flex">
               <h4 class="card-title mb-0 flex-grow-1">Basic Info</h4>
            </div>
            <!-- end card header -->
            <div class="card-body">
               <div class="row g-3">
                  <div class="col-md-12">
                     <!-- Input with Icon -->
                     <label for="useremail" class="form-label">Portal login <span
                        class="text-danger">*</span> <code>[ Account number ]</code> </label>
                     <div class="input-group form-icon">
                        <input type="text" name="username" value="{{ old('username') ? old('username') : $client->username }}" id="username" class="form-control form-control-icon @error('username') is-invalid @enderror" aria-label="username" placeholder="Portal login" required>
                        <i class="ri-fingerprint-line text-muted"></i>
                        <button class="btn btn-soft-info" type="button" id="button" onclick="randomPortalLogin(this)">Generate</button>
                        @error('username')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                     </div>
                  </div>
                  <div class="col-md-12">
                     <label for="userpassword" class="form-label">Portal Password <span
                        class="text-danger">*</span></label>
                     <div class="input-group form-icon">
                        <input type="text" name="password" value="{{ $client->text_pass }}" id="userpassword" class="form-control form-control-icon @error('password') is-invalid @enderror" aria-label="password" placeholder="portal password" required>
                        <i class="ri-rotate-lock-fill text-muted"></i>
                        <button class="btn btn-soft-info" type="button" id="button" onclick="randomPortalPassword(this)">Generate</button>
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                     </div>
                  </div>
                  <div class="col-md-6">
                     <label for="firstname" class="form-label">First Name <span
                        class="text-danger">*</span></label>
                     <div class="form-icon">
                        <input type="text" class="form-control form-control-icon @error('firstname') is-invalid @enderror"
                           name="firstname" value="{{ $client->firstname}}" id="firstname"
                           placeholder="Enter firstname" required>
                        <i class="ri-user-shared-2-line text-muted"></i>
                     </div>
                     @error('firstname')
                     <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                     </span>
                     @enderror
                  </div>
                  <div class="col-md-6">
                     <label for="lastname" class="form-label">Last Name </label>
                     <div class="form-icon">
                        <input type="text" class="form-control form-control-icon @error('lastname') is-invalid @enderror"
                           name="lastname" value="{{ $client->lastname}}" id="lastname"
                           placeholder="Enter lastname" required>
                        <i class="ri-user-shared-2-line text-muted"></i>
                     </div>
                     @error('lastname')
                     <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                     </span>
                     @enderror
                  </div>
                  <!-- Input with Icon -->
                  <div class="col-md-6">
                     <label for="useremail" class="form-label">Email </label>
                     <div class="form-icon">
                        <input type="email" class="form-control form-control-icon @error('email') is-invalid @enderror"
                           name="email" value="{{ $client->email}}" id="useremail"
                           placeholder="Enter address" required>
                        <i class="ri-mail-unread-line text-muted"></i>
                     </div>
                     @error('email')
                     <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                     </span>
                     @enderror
                  </div>
                  <div class="col-md-6">
                     <label for="phone" class="form-label">Phone </label>
                     <div class="form-icon">
                        <input type="text" class="form-control form-control-icon @error('phone') is-invalid @enderror"
                           name="phone" value="{{ old('phone', $client->phone) }}" id="phone"
                           placeholder="Enter phone" required>
                        <i class="ri-phone-line text-muted"></i>
                     </div>
                     @error('phone')
                     <div class="text-danger">{{ $message }}</div>
                     @enderror
                  </div>
                  <div class="col-md-6">
                     <label for="birthday" class="form-label">Birthday <span
                        class="text-muted">(optional)</span></label>
                     <input type="text" class="form-control @error('birthday') is-invalid @enderror"
                        name="birthday" data-provider="flatpickr"  value="{{ $client->birthday}}" id="birthday"
                        placeholder="Enter birthday">
                     @error('birthday')
                     <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                     </span>
                     @enderror
                  </div>
                  <div class="col-md-6">
                     <label for="phone" class="form-label">Category <span
                        class="text-danger">*</span></label>
                     <select name="category" id="" class="form-control" data-choices>
                     <option {{$client->category =='individual' ? 'selected' : ''}} value="individual">Individual</option>
                     <option {{$client->category =='business' ? 'selected' : ''}} value="business">Business</option>
                     </select>
                     @error('category')
                     <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                     </span>
                     @enderror
                  </div>
                  <div class="col-md-6">
                     <label for="phone" class="form-label">Billing type <span
                        class="text-danger">*</span></label>
                     <select name="billingType" id="" class="form-control" data-choices>
                     <option {{$client->billingType =='monthly' ? 'selected' : ''}} value="monthly">Monthly (prepaid) </option>
                     <option {{$client->billingType =='recurring' ? 'selected' : ''}} value="recurring">Recurring</option>
                     </select>
                     @error('billingType')
                     <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                     </span>
                     @enderror
                  </div>
                  <div class="col-md-6">
                     <label for="identification" class="form-label">Identification <span
                        class="text-muted">(optional)</span></label>
                     <input type="text" class="form-control @error('identification') is-invalid @enderror"
                        name="identification" value="{{ $client->identification}}" id="identification"
                        placeholder="Enter identification">
                     @error('identification')
                     <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                     </span>
                     @enderror
                  </div>
               </div>
            </div>
            <!-- end cardbody -->
         </div>
         <!-- end card -->
      </div>
      <!-- end col -->
      <div class="col-xl-6">
         <div class="card card-height-100">
            <div class="card-header align-items-center d-flex">
               <h4 class="card-title mb-0 flex-grow-1">Location Data</h4>
            </div>
            <div class="card-body">
               <div class="row g-3">
                  @if(setting('map') == 'google')
                  <div class="col-md-6">
                     <label for="map" class="form-label">Map <span class="text-muted">(Search map)</span> </label>
                     <input type="text" class="form-control" id="location"
                        placeholder="Change Map location">
                  </div>
                  @endif
                  <div class="{{ setting('map') == 'google' ? 'col-md-6' : 'col-md-4' }}">
                     <label for="location" class="form-label">location <small class="text-muted">/</small> building </label>
                     <input type="text" name="location" class="form-control @error('location') is-invalid @enderror"
                        placeholder="Location"
                        value="{{$client->location ?: old('location')}}">
                     @error('location')
                     <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                     </span>
                     @enderror
                  </div>
                  <div class="{{ setting('map') == 'google' ? 'col-md-6' : 'col-md-4' }}">
                     <label for="location-lat" class="form-label">Latitude</label>
                     <input type="text" name="latitude" class="form-control" id="location-lat" value="{{$client->latitude}}">
                  </div>
                  <div class="{{ setting('map') == 'google' ? 'col-md-6' : 'col-md-4' }}">
                     <label for="location-lng" class="form-label">Longitude</label>
                     <input type="text" name="longitude" class="form-control" id="location-lng" value="{{$client->longitude}}">
                  </div>
                  <div class="col-md-12">
                     <p class="text-muted text-center">MOVE MAP MARKER FOR PRECISE LOCATION</p>
                     <div id="map" style="height: 400px; border:1px solid #ddd; border-radius:5px"></div>
                  </div>
               </div>
            </div>
            <!-- end card body -->
         </div>
         <!-- end card -->
      </div>
   </div>
   <div class="row">
      <div class="col-md-12">
         <div class="card mb-3">
            <div class="card-header">Tags</div>
            <div class="card-body">
               <div class="row g-3">
                  <div class="col-md-12">
                     <label for="tags" class="form-label">Tags <span class="text-muted">(search or create)</span></label>
                     <select id="tags" name="tags[]" multiple>
                        @foreach($tags as $tag)
                        <option value="{{ $tag }}" selected>{{ $tag }}</option>
                        @endforeach
                     </select>
                     <span class="text-muted">Tags are a way of grouping clients. To add a new tag just type and press enter or Tab</span>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="card mb-3">
      <div class="card-body">
         <div class="row">
            <div class="col-12">
               <div class="hstack gap-2 justify-content-end">
                  <a href="{{route('client.index')}}" class="btn btn-light w-50">Cancel</a>
                  <button type="submit" class="btn btn-soft-info w-50"
                     id="add-btn"><i class="las la-save"></i> Update client</button>
               </div>
            </div>
         </div>
      </div>
   </div>
</form>
@php
$latitude = $client->latitude ?? 0;
$longitude = $client->longitude ?? 0;
@endphp
@endsection
@section('script')
<script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
@if(setting('map') == 'google')
<!-- Google Maps JavaScript -->
<script src="https://maps.googleapis.com/maps/api/js?key={{ setting('google_map_api_key') }}&libraries=places"></script>
<script src="{{ asset('assets/js/google_map.js') }}" data-latitude="{{ $latitude }}" data-longitude="{{ $longitude }}"></script>
@else
<!-- Leaflet Control Geocoder -->
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
<!-- Leaflet Draggable JavaScript -->
<script src="{{ asset('assets/js/openStreet.js') }}" data-latitude="{{ $latitude }}" data-longitude="{{ $longitude }}"></script>
@endif
<!-- init js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.3/js/standalone/selectize.min.js"></script>
<script src="{{URL::asset('/assets/js/pages/form-pickers.init.js')}}"></script>
<!-- App js -->
<script src="{{asset('assets/js/app.js')}}"></script>
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
       var random_string = generateRandomString(7);
       $('input[name=password]').val(random_string);
       self.remove();
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
<script>
   $(document).ready(function() {
       $('#tags').selectize({
           delimiter: ',',
           persist: false,
           create: function(input) {
               return {
                   value: input,
                   text: input
               };
           },
           load: function(query, callback) {
               if (!query.length) return callback();
               $.ajax({
                   url: '{{ route("fetch.tags") }}',
                   type: 'GET',
                   dataType: 'json',
                   data: {
                       q: query
                   },
                   success: function(response) {
                       // Format response as an array of objects with 'value' and 'text' properties
                       var formattedTags = response.tags.map(function(tag) {
                           return { value: tag, text: tag };
                       });
                       callback(formattedTags);
                   }
               });
           },
           render: {
               item: function(item, escape) {
                   return '<div>' +
                       (item.text ? '<span class="tag">' + escape(item.text) + '</span>' : '') +
                       '<i class="ri-close-fill" data-value="' + escape(item.value) + '"></i>' +
                   '</div>';
               },
               option_create: function(data, escape) {
                   return '<div class="create">Add <strong>' + escape(data.input) + '</strong>&hellip;</div>';
               }
           },
           onItemRemove: function(value) {
               // Handle tag removal logic here
               console.log('Tag removed:', value);
           }
       });
   
       // Event delegation to handle click events on cancel icons
       $(document).on('click', '.ri-close-fill', function(e) {
           e.preventDefault();
           var value = $(this).data('value');
           var selectize = $('#tags')[0].selectize;
           selectize.removeItem(value);
       });
   });
</script>
@endsection