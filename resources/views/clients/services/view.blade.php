@extends('layouts.master') @section('title') active @endsection @section('css')
<link href="{{URL::asset('assets/js/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{URL::asset('assets/css/datatable-custom.css')}}" rel="stylesheet" type="text/css" />
<style>
   .dot {
   width: 10px;
   height: 10px;
   border-radius: 50%;
   display: inline-block;
   animation: pulse 1s infinite;
   }
   .green {
   background-color: green;
   }
   .orange {
   background-color: orange;
   }
   @keyframes pulse {
   0% {
   transform: scale(0.95);
   box-shadow: 0 0 0 0 rgba(0, 128, 0, 0.7);
   }
   70% {
   transform: scale(1);
   box-shadow: 0 0 0 10px rgba(0, 128, 0, 0);
   }
   100% {
   transform: scale(0.95);
   box-shadow: 0 0 0 0 rgba(0, 128, 0, 0);
   }
   }
</style>
@endsection @section('content') 
{{-- @component('components.breadcrumb') @slot('li_1') Services @endslot @slot('title') Active @endslot @endcomponent --}}
<!-- start page title -->
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
   <div class="card">
      <div class="card-header border-bottom-dashed">
         <div class="d-flex align-items-center">
            <h5 class="card-title mb-0 flex-grow-1"><i class="ri-router-line text-success"></i> {{ ucfirst($type) }} Services</h5>
         </div>
      </div>
      <div class="card-body pt-0">
         <div>
            <!-- show services message  -->
            <div class="table-responsive table-card mb-1">
               <table class="table table-nowrap align-middle table-striped" id="datatable" style="width: 100%;">
                  <thead class="text-muted table-light">
                     <tr>
                        <th>Client Name</th>
                        <th>Wallet</th>
                        <th>Status</th>
                        <th>Description</th>
                        <th>Package</th>
                        <th>Price (ksh)</th>
                        <th>IP Address</th>
                        <th>Username</th>
                        <th>Password</th>
                        <th>Expiry</th>
                     </tr>
                  </thead>
               </table>
            </div>
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
<script src="{{ URL::asset('/assets/js/servertable.js') }}"></script>
<script>
   var url = '{{ route('client.view.services', ['type' => $type]) }}';
       var columns = [
           { data: 'client_name' },
           { data: 'balance', orderable: false, searchable: false },
           { data: 'status', orderable: false, searchable: false },
           { data: 'description', orderable: false },
           { data: 'package', orderable: false },
           { data: 'price', orderable: false },
           { data: 'ipaddress', orderable: false},
           { data: 'username', orderable: false },
           { data: 'password', orderable: false },
           { data: 'expiry', orderable: false, searchable: false },
      ];
       renderTable(url, columns);  
</script>
@endsection