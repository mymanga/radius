@extends('layouts.master') @section('title') kopokopo settings @endsection
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
         <div class="card-header border-bottom-dashed">
            <div class="d-flex align-items-center">
               <h5 class="card-title mb-0 flex-grow-1"> KOPOKOPO</h5>
               
               <div class="flex-shrink-0">
               </div>
            </div>
         </div>
         <div class="card-body">
            <form class="form-margin" action="{{route('settings.kopokopo_save')}}" Method="POST">
               @csrf
               <div class="row mb-3">
                  <div class="col-lg-3">
                     <label for="consumerkey" class="form-label">Client ID</label>
                  </div>
                  <div class="col-lg-9">
                     <input type="text" name="KOPOKOPO_CLIENT_ID" value="{{ old('KOPOKOPO_CLIENT_ID') ?: config('kopokopo.client_id')}}" class="form-control @error('KOPOKOPO_CLIENT_ID') is-invalid @enderror" id="KOPOKOPO_CLIENT_ID" placeholder="Enter Kopokopo client ID">
                     @error('KOPOKOPO_CLIENT_ID')
                     <div class="text-danger">{{ $message }}</div>
                     @enderror
                  </div>
               </div>
               <div class="row mb-3">
                  <div class="col-lg-3">
                     <label for="consumersecret" class="form-label">Client secret</label>
                  </div>
                  <div class="col-lg-9">
                     <input type="text" name="KOPOKOPO_CLIENT_SECRET" value="{{ old('KOPOKOPO_CLIENT_SECRET') ?: config('kopokopo.client_secret')}}" class="form-control @error('KOPOKOPO_CLIENT_SECRET') is-invalid @enderror" id="KOPOKOPO_CLIENT_SECRET" placeholder="Enter client secret">
                     @error('KOPOKOPO_CLIENT_SECRET')
                     <div class="text-danger">{{ $message }}</div>
                     @enderror
                  </div>
               </div>
               <div class="row mb-3">
                  <div class="col-lg-3">
                     <label for="passkey" class="form-label">Api Key</label>
                  </div>
                  <div class="col-lg-9">
                     <input type="text" name="KOPOKOPO_API_KEY" value="{{ old('KOPOKOPO_API_KEY') ?: config('kopokopo.api_key')}}" class="form-control @error('KOPOKOPO_API_KEY') is-invalid @enderror" id="KOPOKOPO_API_KEY" placeholder="Enter api key">
                     @error('KOPOKOPO_API_KEY')
                     <div class="text-danger">{{ $message }}</div>
                     @enderror
                  </div>
               </div>
               <div class="row mb-3">
                  <div class="col-lg-3">
                     <label for="paybill" class="form-label">Stk Till</label>
                  </div>
                  <div class="col-lg-9">
                     <input type="text" name="KOPOKOPO_STK_TILL" value="{{ old('KOPOKOPO_STK_TILL') ?: config('kopokopo.stk_till') }}" class="form-control @error('KOPOKOPO_STK_TILL') is-invalid @enderror" id="KOPOKOPO_STK_TILL" placeholder="Enter stk till">
                     @error('KOPOKOPO_STK_TILL')
                     <div class="text-danger">{{ $message }}</div>
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