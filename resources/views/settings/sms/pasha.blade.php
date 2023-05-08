@extends('layouts.master') @section('title') pasha @endsection
@section('css')
@endsection
@section('content') 
{{-- @component('components.breadcrumb') @slot('li_1') Settings @endslot @slot('title') sms @endslot @endcomponent  --}}
<div class="row">
   <div class="col-lg-12">
      <div class="card mt-n4 mx-n4">
         <div class="bg-soft-light">
            @include('settings.sms.header')
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
         {{-- 
         <div class="card-header border-bottom-dashed">
            <div class="d-flex align-items-center">
               <h5 class="card-title mb-0 flex-grow-1"><i class="ri-mail-line"></i> Pasha</h5>
               <div class="flex-shrink-0">
               </div>
            </div>
         </div>
         --}}
         <div class="card-body">
            <form class="form-margin" action="{{route('settings.sms_save')}}" Method="POST">
               @csrf
               <input type="hidden" name="pasha_gateway" value="Pasha" class="form-control" id="gateway" placeholder="gateway" readonly>
               <div class="row mb-3">
                  <div class="col-lg-3">
                     <label for="sender_id" class="form-label">Sender ID</label>
                  </div>
                  <div class="col-lg-9">
                     <input type="text" name="pasha_sender_id" value="{{Setting::get('pasha_sender_id')}}" class="form-control" id="sender_id" placeholder="sender id ">
                  </div>
               </div>
               <div class="row mb-3">
                  <div class="col-lg-3">
                     <label for="api_key" class="form-label">API Key</label>
                  </div>
                  <div class="col-lg-9">
                     <input type="text" name="pasha_api_key" value="{{Setting::get('pasha_api_key')}}" class="form-control" id="api_key" placeholder="api key">
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
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection