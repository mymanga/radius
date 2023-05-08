@extends('layouts.master')
@section('title') client details @endsection
@section('css')
@endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Account @endslot
@slot('title') settings @endslot
@endcomponent
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
<div class="row">
   <div class="col-lg-12">
      <div class="tab-content text-muted">
         <div>
            <div class="row">
               <div class="col-xl-9 col-lg-8">
                  <div class="card">
                     <div class="card-body">
                        <div class="text-muted">
                           <h6 class="mb-3 fw-semibold text-uppercase">Summary</h6>
                           <form class="needs-validation" novalidate method="POST"
                              action="{{ route('client.update',[$client->username]) }}" enctype="multipart/form-data">
                              @csrf
                              @method('put')
                              <div class="mb-2">
                                 <label for="userpassword" class="form-label">Portal Password <span
                                    class="text-danger">*</span></label>
                                 <div class="input-group">
                                    <input type="text" name="password" value="{{ $client->text_pass }}" id="username" class="form-control @error('password') is-invalid @enderror" aria-label="password" placeholder="portal password">
                                    <button class="btn btn-outline-success" type="button" id="button" onclick="randomPortalPassword(this)">Generate</button>
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                 </div>
                              </div>
                              <div class="mb-3">
                                 <label for="useremail" class="form-label">First Name <span
                                    class="text-danger">*</span></label>
                                 <input type="text" class="form-control @error('firstname') is-invalid @enderror"
                                    name="firstname" value="{{ $client->firstname}}" id="firstname"
                                    placeholder="Enter firstname" required>
                                 @error('firstname')
                                 <span class="invalid-feedback" role="alert">
                                 <strong>{{ $message }}</strong>
                                 </span>
                                 @enderror
                              </div>
                              <div class="mb-3">
                                 <label for="useremail" class="form-label">Last Name <span
                                    class="text-danger">*</span></label>
                                 <input type="text" class="form-control @error('lastname') is-invalid @enderror"
                                    name="lastname" value="{{ $client->lastname}}" id="lastname"
                                    placeholder="Enter lastname" required>
                                 @error('lastname')
                                 <span class="invalid-feedback" role="alert">
                                 <strong>{{ $message }}</strong>
                                 </span>
                                 @enderror
                              </div>
                              <div class="mb-3">
                                 <label for="useremail" class="form-label">Email <span
                                    class="text-danger">*</span></label>
                                 <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" value="{{ $client->email}}" id="useremail"
                                    placeholder="Enter address" required>
                                 @error('email')
                                 <span class="invalid-feedback" role="alert">
                                 <strong>{{ $message }}</strong>
                                 </span>
                                 @enderror
                              </div>
                              <div class="mb-3">
                                 <label for="phone" class="form-label">Phone <span
                                    class="text-danger">*</span></label>
                                 <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                    name="phone" value="{{ $client->phone}}" id="phone"
                                    placeholder="Enter phone" required>
                                 @error('phone')
                                 <span class="invalid-feedback" role="alert">
                                 <strong>{{ $message }}</strong>
                                 </span>
                                 @enderror
                              </div>
                              <div class="mb-3">
                                 <label for="birthday" class="form-label">Birthday <span
                                    class="text-danger">*</span></label>
                                 <input type="date" class="form-control @error('birthday') is-invalid @enderror"
                                    name="birthday" value="{{ $client->birthday}}" id="birthday"
                                    placeholder="Enter birthday" required>
                                 @error('birthday')
                                 <span class="invalid-feedback" role="alert">
                                 <strong>{{ $message }}</strong>
                                 </span>
                                 @enderror
                              </div>
                              <div class="mb-3">
                                 <label for="identification" class="form-label">Identification <span
                                    class="text-danger">*</span></label>
                                 <input type="text" class="form-control @error('identification') is-invalid @enderror"
                                    name="identification" value="{{ $client->identification}}" id="identification"
                                    placeholder="Enter identification" required>
                                 @error('identification')
                                 <span class="invalid-feedback" role="alert">
                                 <strong>{{ $message }}</strong>
                                 </span>
                                 @enderror
                              </div>
                              <div class="mb-3">
                                 <div class="mb-3">
                                    <label for="location" class="form-label">location</label>
                                    <input type="text" name="location" class="form-control @error('location') is-invalid @enderror" id="location"
                                       placeholder="Location"
                                       value="{{$client->location ?: old('location')}}">
                                    @error('location')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                 </div>
                              </div>
                              <div class="mt-4">
                                 <button class="btn btn-primary w-100" type="submit"><i class="las la-save"></i> Update client</button>
                              </div>
                           </form>
                        </div>
                     </div>
                     <!-- end card body -->
                  </div>
                  <!-- end card -->
                  <div class="card">
                                        <div class="card-header border-bottom-dashed align-items-center d-flex">
                                            <h4 class="card-title mb-0 flex-grow-1">Recent Activity</h4>
                                            <div class="flex-shrink-0">
                                                <button type="button" class="btn btn-soft-primary btn-sm">
                                                    View All Activity
                                                </button>
                                            </div>
                                        </div><!-- end cardheader -->
                                        <div class="card-body p-0">
                                            <div data-simplebar="init" style="max-height: 364px;" class="p-3"><div class="simplebar-wrapper" style="margin: -16px;"><div class="simplebar-height-auto-observer-wrapper"><div class="simplebar-height-auto-observer"></div></div><div class="simplebar-mask"><div class="simplebar-offset" style="right: 0px; bottom: 0px;"><div class="simplebar-content-wrapper" tabindex="0" role="region" aria-label="scrollable content" style="height: auto; overflow: hidden scroll;"><div class="simplebar-content" style="padding: 16px;">
                                                <div class="acitivity-timeline acitivity-main">
                                                    <div class="acitivity-item d-flex">
                                                        <div class="flex-shrink-0 avatar-xs acitivity-avatar">
                                                            <div class="avatar-title bg-soft-success text-success rounded-circle">
                                                                <i class="ri-shopping-cart-2-line"></i>
                                                            </div>
                                                        </div>
                                                        <div class="flex-grow-1 ms-3">
                                                            <h6 class="mb-1">Purchase by James Price</h6>
                                                            <p class="text-muted mb-1">Product noise evolve smartwatch
                                                            </p>
                                                            <small class="mb-0 text-muted">02:14 PM Today</small>
                                                        </div>
                                                    </div>
                                                </div>
                                               <div class="acitivity-item py-3 d-flex">
                                                        <div class="flex-shrink-0">
                                                            <img src="{{asset('assets/images/users/avatar-2.jpg')}}" alt="" class="avatar-xs rounded-circle acitivity-avatar">
                                                        </div>
                                                        <div class="flex-grow-1 ms-3">
                                                            <h6 class="mb-1">Natasha Carey have liked the products</h6>
                                                            <p class="text-muted mb-1">Allow users to like products in
                                                                your WooCommerce store.</p>
                                                            <small class="mb-0 text-muted">25 Dec, 2021</small>
                                                        </div>
                                                    </div>
                                            </div></div></div></div><div class="simplebar-placeholder" style="width: auto; height: 898px;"></div></div><div class="simplebar-track simplebar-horizontal" style="visibility: hidden;"><div class="simplebar-scrollbar" style="width: 0px; display: none;"></div></div><div class="simplebar-track simplebar-vertical" style="visibility: visible;"><div class="simplebar-scrollbar" style="height: 147px; transform: translate3d(0px, 0px, 0px); display: block;"></div></div></div>
                                        </div><!-- end card body -->
                                    </div>
                  <!-- end card -->
               </div>
               <!-- ene col -->
               <div class="col-xl-3 col-lg-4">
                  <div class="card">
                     <div class="card-body">
                        <h5 class="card-title mb-4">Location</h5>
                        
                     </div>
                     <!-- end card body -->
                  </div>
               </div>
               <!-- end col -->
            </div>
            <!-- end row -->
         </div>

         <!-- end tab pane -->
      </div>
   </div>
   <!-- end col -->
</div>
<!--end row-->
@endsection
@section('script')
<script src="{{ URL::asset('/assets/js/jquery-3.6.1.js')}}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBhbbW5e_87sUBzZh3azjAw_mtXvmUJDVc&libraries=places"></script>
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
<!-- profile-setting init js -->
<script src="{{asset('assets/js/pages/profile-setting.init.js')}}"></script>
<!-- App js -->
<script src="{{asset('assets/js/app.js')}}"></script>
@endsection