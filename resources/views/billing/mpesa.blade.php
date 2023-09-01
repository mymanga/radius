@extends('layouts.master') @section('title') mpesa transaction @endsection @section('css')
<link href="{{URL::asset('assets/js/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{URL::asset('assets/css/datatable-custom.css')}}" rel="stylesheet" type="text/css" />
@endsection @section('content') 
{{-- @component('components.breadcrumb') @slot('li_1') Account @endslot @slot('title') settings @endslot @endcomponent --}}
<div class="page-title-box d-sm-flex align-items-center justify-content-between">
   <h4 class="mb-sm-0 font-size-18">Transactions</h4>
   <div class="page-title-right">
      <ol class="breadcrumb m-0">
         <li class="breadcrumb-item"><a href="{{ route('billing.index') }}">Finance</a></li>
         <li class="breadcrumb-item active"><a href="{{ route('billing.mpesa') }}">M-Pesa</a></li>
      </ol>
   </div>
</div>
<div class="row">
   @include('layouts.partials.flash')
   <div class="d-flex align-items-center mb-3">
      <div class="flex-grow-1">
      </div>
      <div class="flexshrink-0">
         {{-- <button id="print-btn" class="btn btn-soft-secondary btn-md">
            <i class="ri-printer-line align-bottom me-1"></i> Print
         </button>
         <button id="export-btn" class="btn btn-soft-secondary btn-md">
            <i class="ri-file-download-line align-bottom me-1"></i> Export
         </button> --}}
         <!-- Adding the Refresh button -->
         <button id="refresh-btn" class="btn btn-soft-secondary btn-md">
            <i class="ri-refresh-line align-bottom me-1"></i> Refresh
         </button>
      </div>
   </div>
   <div class="card">
      <div class="card-body">
         <div class="table-responsive table-card mb-1">
            <table class="table table-nowrap align-middle table-striped" id="datatable" style="width: 100%;">
               <thead class="text-muted table-light">
                  <tr>
                     <th>ID</th>
                     <th>Status</th>
                     <th>Amount</th>
                     <th>Transaction ID</th>
                     <th>Transaction Time</th>
                     <th>Reference</th>
                     <th>Org Account Balance</th>
                     <th>Phone Number</th>
                     <th>First Name</th>
                     <th>Middle Name</th>
                     <th>Last Name</th>
                     <th>View</th>
                  </tr>
               </thead>
               <tbody class="list form-check-all">
               </tbody>
            </table>
         </div>
      </div>
   </div>
</div>
<!--end col-->
<!--end row-->
@endsection @section('script')
<script src="{{ URL::asset('/assets/js/jquery-3.6.1.js')}}"></script>
<script src="{{ URL::asset('/assets/js/datatables/datatables.min.js') }}"></script>
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
<script src="{{ URL::asset('/assets/js/servertable.js') }}"></script>
<script>
   var url = '{{ route("billing.mpesa") }}';
   var columns = [
      { data: 'id', name: 'id', orderable: true },
      { data: 'status', name: 'status', orderable: true },
      { data: 'amount', name: 'amount', orderable: true },
      { data: 'transaction_id', name: 'transaction_id', orderable: true },
      { data: 'transaction_time', name: 'transaction_time', orderable: true },
      { data: 'bill_reference', name: 'bill_reference', orderable: true },
      { data: 'org_account_balance', name: 'org_account_balance', orderable: true },
      { data: 'phone_number', name: 'phone_number', orderable: true },
      { data: 'first_name', name: 'first_name', orderable: true },
      { data: 'middle_name', name: 'middle_name', orderable: true },
      { data: 'last_name', name: 'last_name', orderable: true },
      { data: 'view', name: 'view', orderable: false },
   ];
   renderTable(url, columns);
</script>
@endsection