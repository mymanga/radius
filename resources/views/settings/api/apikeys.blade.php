@extends('layouts.master') @section('title') api keys @endsection
@section('css')
@endsection
@section('content') 
{{-- @component('components.breadcrumb') @slot('li_1') Settings @endslot @slot('title') Maps @endslot @endcomponent  --}}
<div class="row">
   <div class="col-12">
      <div class="page-title-box d-sm-flex align-items-center justify-content-between">
         <h4 class="mb-sm-0 font-size-18">Api Keys</h4>
      </div>
   </div>
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
      <form class="form-margin" action="{{route('settings.general_save')}}" Method="POST">
         <!-- Api key card -->
         <div class="card">
            <div class="card-header border-bottom-dashed">
               <div class="d-flex align-items-center">
                  <h5 class="card-title mb-0 flex-grow-1 text-muted"> Google map api key</h5>
                  <div class="flex-shrink-0">
                  </div>
               </div>
            </div>
            <div class="card-body">
               @csrf
               <div class="row mb-3">
                  <div class="col-lg-12">
                     <input type="text" name="google_map_api_key" value="{{setting('google_map_api_key')}}" class="form-control" id="map_api_key" placeholder="map_api key">
                  </div>
               </div>
               <div class="col-12 text-end">
                  <div class="hstack gap-2 justify-content-end">
                     <button type="submit" class="btn btn-soft-success"
                        id="add-btn"><i class="las la-save"></i> Save</button>
                  </div>
               </div>
               <!--end modal -->
            </div>
         </div>
      </form>
   </div>
</div>
@endsection
@section('script')
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection