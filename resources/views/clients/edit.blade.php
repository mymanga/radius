@extends('layouts.master')
@section('title') edit client @endsection
@section('css')
@endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') client @endslot
@slot('title') Create @endslot
@endcomponent
<!-- .card-->
<div class="row justify-content-center">
   <div class="col-lg-8">
      <div class="card" id="orderList">
         <div class="card-header bg-soft-warning">
            <div class="d-flex align-items-center">
               <h5 class="card-title mb-0 flex-grow-1"><i class="ri-router-line"></i> Update client</h5>
               <div class="flex-shrink-0">
               </div>
            </div>
         </div>
         <div class="card-body">
            <form class="row g-3" class="needs-validation" novalidate method="POST"
               action="{{ route('client.update',[$client->username]) }}" enctype="multipart/form-data">
               @csrf
               @method('put')

               <div class="col-md-6">
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
              
               <div class="col-md-6">
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
                  <option {{$client->billingType =='monthly' ? 'selected' : ''}} value="monthly">Monthly</option>
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
               <div class="col-md-12">
                     <label for="location" class="form-label">location <span class="text-muted">(optional)</span> </label>
                     <input type="text" name="location" class="form-control @error('location') is-invalid @enderror" id="location"
                        placeholder="Location"
                        value="{{$client->location ?: old('location')}}">
                     @error('location')
                     <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                     </span>
                     @enderror
               </div>
               @if(setting('googlemap') == 'enabled')
                  <div class="col-md-6">
                     <label for="location-lat" class="form-label">Latitude</label>
                     <input type="text" name="latitude" class="form-control" id="location-lat" value="{{$client->latitude}}" readonly>
                  </div>
                  <div class="col-md-6">
                     <label for="location-lng" class="form-label">Longitude</label>
                     <input type="text" name="longitude" class="form-control" id="location-lng" value="{{$client->longitude}}" readonly>
                  </div>
                  <div class="col-md-12"><div id="map" style="height: 400px; border:1px solid #ddd; border-radius:5px"></div></div>
               @endif
               
               <div class="col-12">
                  <div class="hstack gap-2 justify-content-end">
                     <a href="{{route('client.index')}}" class="btn btn-light w-50">Cancel</a>
                     <button type="submit" class="btn btn-soft-info w-50"
                        id="add-btn"><i class="las la-save"></i> Update client</button>
                  </div>
               </div>
            </form>
         </div>
         <!--end modal -->
      </div>
   </div>
</div>
@php
    $latitude = $client->latitude ?? 0;
    $longitude = $client->longitude ?? 0;
@endphp
@endsection
@section('script')
<script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>

@if(setting('googlemap') == 'enabled')
   <script src="https://maps.googleapis.com/maps/api/js?key={{setting('google_map_api_key')}}&libraries=places&callback=initializeMapAndVariables" async defer></script>
   <script src="{{ asset('/assets/js/google_map.js') }}" data-latitude="{{ $latitude }}" data-longitude="{{ $longitude }}"></script>
@endif

<!-- init js -->
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
@endsection