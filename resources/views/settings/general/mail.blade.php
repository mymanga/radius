@extends('layouts.master') @section('title') email settings @endsection
@section('css')
@endsection
@section('content') 
{{-- @component('components.breadcrumb') @slot('li_1') Settings @endslot @slot('title') General @endslot @endcomponent  --}}
<div class="row">
   <div class="col-lg-12">
      <div class="card mt-n4 mx-n4">
         <div class="bg-soft-light">
            @include('settings.general.header')
            <!-- end card body -->
         </div>
      </div>
      <!-- end card -->
   </div>
   <!-- end col -->
</div>
<div class="row justify-content-center">
   <div class="col-lg-8">
      @if (session('status'))
      <div class="alert alert-success alert-dismissible alert-label-icon label-arrow fade show" role="alert">
         <i class="ri-check-double-line label-icon"></i><strong>Success</strong> - {{session('status')}}
         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      @endif @if (session('error'))
      <div class="alert alert-danger alert-dismissible alert-label-icon label-arrow fade show mb-xl-0" role="alert">
         <i class="ri-error-warning-line label-icon"></i><strong>Failed</strong>
         - {{session('error')}}
         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      <br />
      @endif
      <div class="card">
         <div class="card-header border-bottom-dashed bg-soft-warning">
            <div class="d-flex align-items-center">
               <h5 class="card-title mb-0 flex-grow-1"><i class="ri-mail-line"></i> SMTP Mail config</h5>
               <code>[NO SPACES ALLOWED]</code>
               <div class="flex-shrink-0">
               </div>
            </div>
         </div>
         <div class="card-body">
            <form class="form-margin" action="{{route('settings.mail_save')}}" Method="POST">
               @csrf
               <div class="row mb-3">
                  <div class="col-lg-3">
                     <label for="mailHost" class="form-label">Mail host</label>
                  </div>
                  <div class="col-lg-9">
                     <input type="text" name="MAIL_HOST" value="{{Setting::get('MAIL_HOST')}}" class="form-control @error('MAIL_HOST') is-invalid @enderror" id="mail_host" placeholder="Enter email host">
                     @error('MAIL_HOST')
                     <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                     </span>
                     @enderror
                  </div>
               </div>
               <div class="row mb-3">
                  <div class="col-lg-3">
                     <label for="mailPort" class="form-label">Mail port</label>
                  </div>
                  <div class="col-lg-9">
                     <input type="number" name="MAIL_PORT" value="{{Setting::get('MAIL_PORT')}}" class="form-control" id="mailPort" placeholder="Email port">
                     @error('MAIL_PORT')
                     <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                     </span>
                     @enderror
                  </div>
               </div>
               <div class="row mb-3">
                  <div class="col-lg-3">
                     <label for="mailusername" class="form-label">Mail username</label>
                  </div>
                  <div class="col-lg-9">
                     <input type="text" name="MAIL_USERNAME" value="{{Setting::get('MAIL_USERNAME')}}" class="form-control @error('MAIL_USERNAME') is-invalid @enderror" id="mailusername" placeholder="Enter email username">
                     @error('MAIL_USERNAME')
                     <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                     </span>
                     @enderror
                  </div>
               </div>
               <div class="row mb-3">
                  <div class="col-lg-3">
                     <label for="mailpassword" class="form-label">Mail password</label>
                  </div>
                  <div class="col-lg-9">
                     <input type="text" name="MAIL_PASSWORD" value="{{Setting::get('MAIL_PASSWORD')}}" class="form-control @error('MAIL_PASSWORD') is-invalid @enderror" id="mailpassword" placeholder="Enter email password">
                     @error('MAIL_PASSWORD')
                     <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                     </span>
                     @enderror
                  </div>
               </div>
               <div class="row mb-3">
                  <div class="col-lg-3">
                     <label for="encryption" class="form-label">Mail encryption</label>
                  </div>
                  <div class="col-lg-9">
                     <select name="MAIL_ENCRYPTION" id="mailencryption" class="form-control">
                     <option {{Setting::get('MAIL_ENCRYPTION') == null ? 'selected' : ''}} value="">NONE</option>
                     <option {{Setting::get('MAIL_ENCRYPTION') == 'tls' ? 'selected' : ''}} value="tls">TLS</option>
                     <option {{Setting::get('MAIL_ENCRYPTION') == 'ssl' ? 'selected' : ''}} value="ssl">SSL</option>
                     </select>
                     @error('MAIL_ENCRYPTION')
                     <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                     </span>
                     @enderror
                  </div>
               </div>
               <div class="row mb-3">
                  <div class="col-lg-3">
                     <label for="mailfrom" class="form-label">Mail from address</label>
                  </div>
                  <div class="col-lg-9">
                     <input type="email" name="MAIL_FROM_ADDRESS" value="{{Setting::get('MAIL_FROM_ADDRESS')}}" class="form-control @error('MAIL_FROM_ADDRESS') is-invalid @enderror" id="mailfrom" placeholder="Enter email address">
                     @error('MAIL_FROM_ADDRESS')
                     <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                     </span>
                     @enderror
                  </div>
               </div>
               <div class="row mb-3">
                  <div class="col-lg-3">
                     <label for="mailfromname" class="form-label">Mail from name</label>
                  </div>
                  <div class="col-lg-9">
                     <input type="text" name="MAIL_FROM_NAME" value="{{Setting::get('MAIL_FROM_NAME') !== null ? Setting::get('MAIL_FROM_NAME') : Setting::get('company')}}" class="form-control @error('MAIL_FROM_NAME') is-invalid @enderror" id="mailfromnane" placeholder="Enter name">
                     @error('MAIL_FROM_NAME')
                     <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                     </span>
                     @enderror
                  </div>
               </div>
               <div class="col-12 text-end">
                  <div class="hstack gap-2 justify-content-end">
                     <button type="submit" class="btn btn-soft-success"
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
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
<script>
   $(function() {
   $('.formfield input[type=text]').on('keypress', function(e) {
       if (e.which == 32)
           return false;
   });
   });
</script>
@endsection