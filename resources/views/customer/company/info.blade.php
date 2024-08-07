@extends('layouts.master')
@section('title')
Customer - Company info
@endsection
@section('css')
<!-- Additional CSS -->
@endsection 
@section('content') 
@component('components.breadcrumb')
@slot('li_1')
Customer
@endslot
@slot('title')
Company info
@endslot
@endcomponent
<div class="row">
   <div class="col-xl-6">
      <div class="card">
         <div class="card-body p-0">
            <ul class="list-group list-group-flush border-dashed mb-0">
               <li class="list-group-item d-flex align-items-center">
                  <div class="flex-grow-1 ms-3">
                     <h6 class="fs-14 mb-1">Company</h6>
                  </div>
                  <div class="flex-shrink-0 text-end">
                     <h6 class="fs-14 mb-1">{{ setting('company') }}</h6>
                  </div>
               </li>
               <li class="list-group-item d-flex align-items-center">
                  <div class="flex-grow-1 ms-3">
                     <h6 class="fs-14 mb-1">Phone Number</h6>
                  </div>
                  <div class="flex-shrink-0 text-end">
                     <h6 class="fs-14 mb-1">{{ setting('company_phone') }}</h6>
                  </div>
               </li>
               <li class="list-group-item d-flex align-items-center">
                  <div class="flex-grow-1 ms-3">
                     <h6 class="fs-14 mb-1">Email address</h6>
                  </div>
                  <div class="flex-shrink-0 text-end">
                     <h6 class="fs-14 mb-1">{{ setting('company_email') }}</h6>
                  </div>
               </li>
               <li class="list-group-item d-flex align-items-center">
                  <div class="flex-grow-1 ms-3">
                     <h6 class="fs-14 mb-1">Location</h6>
                  </div>
                  <div class="flex-shrink-0 text-end">
                     <h6 class="fs-14 mb-1">{{ setting('city') }}</h6>
                  </div>
               </li>
               <!-- end -->
            </ul>
            <!-- end ul -->
         </div>
         <!-- end card body -->
      </div>
   </div>
</div>
<!--end row-->
@endsection 
@section('script')
<script src="{{ URL::asset('/assets/js/jquery-3.6.1.js')}}"></script>
<script src="{{ URL::asset('/assets/js/datatables/datatables.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.9/dist/sweetalert2.all.min.js"></script>
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
<!-- Additional Scripts -->
@endsection