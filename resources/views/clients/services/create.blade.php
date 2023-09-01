@extends('layouts.master')
@section('title') create @endsection
@section('css')
@endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Service @endslot
@slot('title') Create @endslot
@endcomponent
<!-- .card-->
<div class="row">
   <div class="col-lg-9">
      <div class="card" id="orderList">
         <div class="card-header border-bottom-dashed alert-info alert-top-border">
            <div class="d-flex align-items-center">
               <h5 class="card-title mb-0 flex-grow-1"><i class="ri-router-line"></i> Create Service</h5>
               <div class="flex-shrink-0">
               </div>
            </div>
         </div>
         <div class="card-body pt-0">
            <form action="{{route('service.save',[$username])}}" method="POST">
               @csrf
               <div class="modal-body">
                  <input type="hidden" id="id-field" />
                  <div class="mb-3" id="modal-id">
                     <label for="package" class="form-label">Select package</label>
                     <select name="package" class="form-control">
                     @foreach($packages as $package)
                        <option value="{{$package->id}}">{{$package->name}}</option>
                     @endforeach
                     </select>
                     @error('package')
                     <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                     </span>
                     @enderror
                  </div>
                  <div class="mb-3">
                     <label for="username" class="form-label">PPPoE Username <span
                        class="text-danger">*</span></label>
                     <div class="input-group">
                        <input type="text" name="username" value="{{ old('username') }}" id="username" class="form-control @error('username') is-invalid @enderror" aria-label="username" placeholder="Portal login">
                        <button class="btn btn-outline-success" type="button" id="button" onclick="randomPortalLogin(this)">Generate</button>
                        @error('username')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                     </div>
                  </div>
                  <div class="mb-3">
                     <label for="userpassword" class="form-label">PPPoE Password <span
                        class="text-danger">*</span></label>
                     <div class="input-group">
                        <input type="text" name="password" value="{{ old('password') }}" id="username" class="form-control @error('password') is-invalid @enderror" aria-label="password" placeholder="portal password">
                        <button class="btn btn-outline-success" type="button" id="button" onclick="randomPortalPassword(this)">Generate</button>
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                     </div>
                  </div>
                  <div class="mb-3">
                     <label for="userpassword" class="form-label">Service active <span
                        class="text-danger">*</span></label>
                     <div class="form-check form-switch form-switch-md mb-3" dir="ltr">
                        <input type="checkbox" name="is_active" class="form-check-input" id="customSwitchsizemd" @if(old('is_active')) checked @endif>
                        <label class="form-check-label" for="customSwitchsizemd">Activate service now?</label>
                     </div>
                  </div>
               </div>
               
               <div class="modal-footer">
                  <div class="hstack gap-2 justify-content-end">
                     <a href="{{route('client.service',[$username])}}" class="btn btn-light">Cancel</a>
                     <button type="submit" class="btn btn-primary"
                        id="add-btn"><i class="las la-save"></i> Save</button>
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
<script>
   function randomPortalLogin(clicked_element)
   {
       var self = $(clicked_element);
       var random_string = generateRandomString(5);
       $('input[name=username]').val(random_string);
       {{-- self.remove(); --}}
   }
   
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
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection