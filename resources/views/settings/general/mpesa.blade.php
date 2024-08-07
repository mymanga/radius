@extends('layouts.master') @section('title') mpesa settings @endsection
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
               <h5 class="card-title mb-0 flex-grow-1"> M-PESA</h5>
               <div class="d-flex align-items-center mb-3">
                    <div class="flex-grow-1">
                        
                    </div>
                    <div class="flexshrink-0">
                        <form action="{{route('mpesa.register_url')}}" method="post">
                        @csrf
                        <button style="margin-bottom:-15px" type="submit" id="loading" class="btn btn-soft-info btn-md">Register urls</button>
                        </form>
                    </div>
                </div>
               <div class="flex-shrink-0">
               </div>
            </div>
         </div>
         <div class="card-body">
            <form class="form-margin" action="{{route('settings.mpesa_save')}}" Method="POST">
               @csrf
               <div class="row mb-3">
                  <div class="col-lg-3">
                     <label for="consumerkey" class="form-label">Consumer key</label>
                  </div>
                  <div class="col-lg-9">
                     <input type="text" name="MPESA_CONSUMER_KEY" value="{{ old('MPESA_CONSUMER_KEY') ?: config('mpesa.credentials.consumer_key')}}" class="form-control @error('MPESA_CONSUMER_KEY') is-invalid @enderror" id="MPESA_CONSUMER_KEY" placeholder="Enter mpesa consumer key">
                     @error('MPESA_CONSUMER_KEY')
                     <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                     </span>
                     @enderror
                  </div>
               </div>
               <div class="row mb-3">
                  <div class="col-lg-3">
                     <label for="consumersecret" class="form-label">Consumer secret</label>
                  </div>
                  <div class="col-lg-9">
                     <input type="text" name="MPESA_CONSUMER_SECRET" value="{{ old('MPESA_CONSUMER_SECRET') ?: config('mpesa.credentials.consumer_secret')}}" class="form-control @error('MPESA_CONSUMER_SECRET') is-invalid @enderror" id="MPESA_CONSUMER_SECRET" placeholder="Enter consumer secret">
                     @error('MPESA_CONSUMER_SECRET')
                     <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                     </span>
                     @enderror
                  </div>
               </div>
               <div class="row mb-3">
                  <div class="col-lg-3">
                     <label for="passkey" class="form-label">Passkey</label>
                  </div>
                  <div class="col-lg-9">
                     <input type="text" name="MPESA_PASSKEY" value="{{ old('MPESA_PASSKEY') ?: config('mpesa.credentials.passkey')}}" class="form-control @error('MPESA_PASSKEY') is-invalid @enderror" id="MPESA_PASSKEY" placeholder="Enter passkey">
                     @error('MPESA_PASSKEY')
                     <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                     </span>
                     @enderror
                  </div>
               </div>
               <div class="row mb-3">
                  <div class="col-lg-3">
                     <label for="paybill" class="form-label">Shortcode</label>
                  </div>
                  <div class="col-lg-9">
                     <input type="text" name="MPESA_SHORTCODE" value="{{ old('MPESA_SHORTCODE') ?: config('mpesa.credentials.shortcode') }}" class="form-control @error('MPESA_SHORTCODE') is-invalid @enderror" id="MPESA_SHORTCODE" placeholder="Enter paybill number">
                     @error('MPESA_SHORTCODE')
                     <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                     </span>
                     @enderror
                  </div>
               </div>   

               <div class="row mb-3">
                  <div class="col-lg-3">
                     <label for="apiVersion" class="form-label">API Version</label>
                  </div>
                  <div class="col-lg-9">
                     <select name="MPESA_API_VERSION" class="form-select @error('MPESA_API_VERSION') is-invalid @enderror" id="MPESA_API_VERSION">
                        <option value="1" {{ setting('MPESA_API_VERSION') == '1' ? 'selected' : '' }}>Version 1</option>
                        <option value="2" {{ setting('MPESA_API_VERSION') == '2' ? 'selected' : '' }}>Version 2</option>
                     </select>
                     @error('MPESA_API_VERSION')
                     <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                     </span>
                     @enderror
                  </div>
               </div>
               <div class="col-12 text-end">
                  <div class="hstack gap-2 justify-content-end">
                     <button type="submit" id="loading" class="btn btn-soft-success"
                        id="add-btn"><i class="las la-save"></i> Update</button>
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
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection