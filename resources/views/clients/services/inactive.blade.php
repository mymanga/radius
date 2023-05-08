@extends('layouts.master') @section('title') inactive @endsection @section('css')
<link href="{{URL::asset('assets/js/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{URL::asset('assets/css/datatable-custom.css')}}" rel="stylesheet" type="text/css" />
@endsection @section('content') 
{{-- @component('components.breadcrumb') @slot('li_1') Account @endslot @slot('title') settings @endslot @endcomponent --}}
<div class="row">
   <div class="col-12">
      <div class="page-title-box d-sm-flex align-items-center justify-content-between">
         <h4 class="mb-sm-0 font-size-18"></h4>
         <div class="page-title-right">
            <ol class="breadcrumb m-0">
               <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
               <li class="breadcrumb-item active">Services</li>
            </ol>
         </div>
      </div>
   </div>
</div>
<div class="row">
   <div class="col-lg-12">
      <!-- show success message  -->
      @if (session('status'))
      <div class="alert alert-success alert-dismissible alert-label-icon label-arrow fade show" role="alert">
         <i class="ri-check-double-line label-icon"></i><strong>Success</strong> - {{session('status')}}
         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      <!-- show error message  -->
      @endif @if (session('error'))
      <div class="alert alert-danger alert-dismissible alert-label-icon label-arrow fade show mb-xl-0" role="alert">
         <i class="ri-error-warning-line label-icon"></i><strong>Failed</strong>
         - {{session('error')}}
         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      <br />
      @endif
      @if (session('info'))
      <div class="alert alert-info alert-dismissible alert-label-icon label-arrow fade show mb-xl-0" role="alert">
         <i class="ri-error-warning-line label-icon"></i><strong>Failed</strong>
         - {{session('info')}}
         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      <br />
      @endif

      <div class="card">
         <div class="card-header border-bottom-dashed">
            <div class="d-flex align-items-center">
               <h5 class="card-title mb-0 flex-grow-1"><i class="ri-router-line text-danger"></i> Inactive Services</h5>
            </div>
         </div>
         <div class="card-body pt-0">
            <div>
               <!-- show services message  -->
               @if(count($services))
               <div class="table-responsive table-card mb-1">
                  <table class="table table-nowrap align-middle table-striped" id="datatable" style="width: 100%;">
                     <thead class="text-muted table-light">
                        <tr class="text-uppercase">
                           <th class="sort" data-sort="id">ID</th>
                           <th class="sort" data-sort="client">Client</th>
                           <th class="sort" data-sort="date">Status</th>
                           <th class="sort" data-sort="client_name">Name</th>
                           <th class="sort" data-sort="product_name">Price</th>
                           <th class="sort" data-sort="ip_address">IP Address</th>
                           <th class="sort" data-sort="amount">Username</th>
                           <th class="sort" data-sort="password">Password</th>
                           <th class="sort" data-sort="expiry">Expiry</th>
                           {{-- <th class="sort" data-sort="city">Action</th> --}}
                        </tr>
                     </thead>
                     <tbody class="list form-check-all">
                        @foreach($services as $service)
                         @include('clients.services.partials.row')
                        @endforeach
                     </tbody>
                  </table>
               </div>
               @else
               <div class="noresult" style="display: block;">
                  <div class="text-center">
                     <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop" colors="primary:#121331,secondary:#08a88a" style="width: 75px; height: 75px;"> </lord-icon>
                     <h5 class="mt-2 text-danger">Sorry! No service Found</h5>
                     <p class="text-muted mb-0">You have not added any internet service. You need atleast one to proceed</p>
                  </div>
               </div>
               @endif
           
            <!--end modal -->
         </div>
      </div>
   </div>
   <!--end col-->
</div>
<!--end row-->
@endsection @section('script')
<script src="{{ URL::asset('/assets/js/jquery-3.6.1.js')}}"></script>
<script src="{{ URL::asset('/assets/js/datatables/datatables.min.js') }}"></script>
<!-- init js -->
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
<script src="{{ URL::asset('/assets/js/datatable.js') }}"></script>
@endsection