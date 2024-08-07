@extends('layouts.master') @section('title') S3 Storage settings @endsection
@section('css')
@endsection
@section('content') 
{{-- @component('components.breadcrumb') @slot('li_1') Settings @endslot @slot('title') General @endslot @endcomponent  --}}
<div class="row">
   <div class="col-lg-12">
      <div class="card mt-n4 mx-n4">
         <div class="bg-soft-light">
            @include('settings.backup.header')
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
               <h5 class="card-title mb-0 flex-grow-1"><i class="ri-mail-line"></i>&nbsp;  S3 Storage</h5>
               <div class="flex-shrink-0">
               </div>
            </div>
         </div>
         <div class="card-body">
            <form class="form-margin" action="{{route('settings.general_save')}}" Method="POST">
               @csrf
               <div class="row mb-3">
                  <div class="col-lg-3">
                     <label for="AccessKey" class="form-label"> Access Key</label>
                  </div>
                  <div class="col-lg-9">
                     <input type="text" name="s3_access_key" value="{{ Setting::get('s3_access_key') }}" class="form-control @error('s3_access_key') is-invalid @enderror" id="AccessKey" placeholder="Enter  Access Key">
                     @error('s3_access_key')
                     <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                     </span>
                     @enderror
                  </div>
               </div>
               <div class="row mb-3">
                  <div class="col-lg-3">
                     <label for="SecretKey" class="form-label"> Secret Key</label>
                  </div>
                  <div class="col-lg-9">
                     <input type="text" name="s3_secret_key" value="{{ Setting::get('s3_secret_key') }}" class="form-control @error('s3_secret_key') is-invalid @enderror" id="SecretKey" placeholder="Enter  Secret Key">
                     @error('s3_secret_key')
                     <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                     </span>
                     @enderror
                  </div>
               </div>
               <div class="row mb-3">
                  <div class="col-lg-3">
                     <label for="Region" class="form-label"> Region</label>
                  </div>
                  <div class="col-lg-9">
                     <input type="text" name="s3_region" value="{{ Setting::get('s3_region') }}" class="form-control @error('s3_region') is-invalid @enderror" id="Region" placeholder="Enter  Region">
                     @error('s3_region')
                     <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                     </span>
                     @enderror
                  </div>
               </div>
               <div class="row mb-3">
                  <div class="col-lg-3">
                     <label for="Bucket" class="form-label"> Bucket</label>
                  </div>
                  <div class="col-lg-9">
                     <input type="text" name="s3_bucket" value="{{ Setting::get('s3_bucket') }}" class="form-control @error('s3_bucket') is-invalid @enderror" id="Bucket" placeholder="Enter  Bucket">
                     @error('s3_bucket')
                     <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                     </span>
                     @enderror
                  </div>
               </div>
               <div class="row mb-3">
                  <div class="col-lg-3">
                     <label for="Endpoint" class="form-label"> Endpoint</label>
                  </div>
                  <div class="col-lg-9">
                     <input type="text" name="s3_endpoint" value="{{ Setting::get('s3_endpoint') }}" class="form-control @error('s3_endpoint') is-invalid @enderror" id="Endpoint" placeholder="Enter  Endpoint">
                     @error('s3_endpoint')
                     <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                     </span>
                     @enderror
                  </div>
               </div>
               <div class="row mb-3">
                  <div class="col-lg-3">
                     <label for="Url" class="form-label"> URL</label>
                  </div>
                  <div class="col-lg-9">
                     <input type="url" name="s3_url" value="{{ Setting::get('s3_url') }}" class="form-control @error('s3_url') is-invalid @enderror" id="Url" placeholder="Enter  URL">
                     @error('s3_url')
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