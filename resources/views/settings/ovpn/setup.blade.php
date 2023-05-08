@extends('layouts.master') @section('title') openvpn setup @endsection @section('css')
<link href="{{URL::asset('assets/js/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{URL::asset('assets/css/datatable-custom.css')}}" rel="stylesheet" type="text/css" />
@endsection @section('content') 
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">OpenVpn</h4>
        </div>
    </div>
</div>
<!-- end page title -->
<div class="row">
   <div class="col-lg-12">
      @if (session('status'))
      <div class="alert alert-success alert-dismissible alert-label-icon label-arrow fade show" role="alert">
         <i class="ri-check-double-line label-icon"></i><strong>Success</strong> - {{session('status')}}
         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      @endif @if (session('error'))
      <div class="alert alert-danger alert-dismissible alert-label-icon label-arrow fade show mb-xl-0" role="alert">
         <i class="ri-error-warning-line label-icon"></i><strong>Failed</strong>
         - {!!session('error')!!}
         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      <br />
      @endif

      <div class="row justify-content-center">
         <div class="col-lg-8 col-md-8">
               <div class="card">
                  <div class="card-body">
                     <div class="text-center">
                           <div class="row justify-content-center">
                              <div class="col-lg-9">
                                 <h4 class="mt-4 fw-semibold">OpenVpn Notice</h4>
                                 <p class="text-muted mt-3">OpenVpn server is not installed 
                                 </p>
                              </div>
                           </div>

                           <div class="row justify-content-center mt-5 mb-2">
                              <div class="col-sm-7 col-8">
                                 <img src="{{asset('assets/images/comingsoon.png')}}" alt="" class="img-fluid">
                              </div>
                           </div>
                     </div>
                  </div>
               </div>
               <!--end card-->
         </div>
         <!--end col-->
      </div>

   </div>
   <!--end col-->
</div>


@endsection
@section('script')
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection