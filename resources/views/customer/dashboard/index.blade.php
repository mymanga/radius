@extends('layouts.master')
@section('title') Customer - Dashboard @endsection
@section('css')
<link href="{{URL::asset('assets/js/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
{{-- 
<link href="{{URL::asset('assets/css/datatable-custom.css')}}" rel="stylesheet" type="text/css" />
--}}
<style>
   table.dataTable thead th, 
   table.dataTable thead td {
   border-top: none !important;
   border-bottom: 1px solid #eee !important;
   }
   table.dataTable {
   border-bottom: none !important;
   }
   /* Styles for dark layout mode */
   [data-layout-mode=dark] table.dataTable thead th, 
   table.dataTable thead td {
   border-bottom: 1px solid #32383e !important;
   }
   table.dataTable > tbody > tr.child ul.dtr-details > li {
   border-bottom: none !important;
   }
</style>
@endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Customer @endslot
@slot('title') Dashboard @endslot
@endcomponent
<div class="row">
   <div class="col-lg-12">
      @if (session('status'))
      <div class="alert alert-success" role="alert">
         {{session('status')}}
      </div>
      @endif
   </div>
   <div class="col-lg-6 col-md-6">
      <div class="card">
         <div class="card-body">
            <div class="d-flex align-items-center">
               <div class="avatar-sm flex-shrink-0">
                  <span class="avatar-title bg-light text-info rounded-circle fs-3">
                  <i class="ri-money-dollar-circle-fill align-middle"></i>
                  </span>
               </div>
               <div class="flex-grow-1 ms-3">
                  <p class="text-uppercase fw-semibold fs-12 text-muted mb-1"> Account Balance</p>
                  <h5 class=" mb-0">KES <span class="counter-value" data-target="{{ $customer->balance }}">{{ $customer->balance }}</span></h5>
               </div>
            </div>
         </div>
         <!-- end card body -->
      </div>
      <!-- end card -->
   </div>
   <!-- end col -->
   <div class="col-lg-6 col-md-6">
      <div class="card">
         <a href="#" class="card-body text-decoration-none">
            <div class="d-flex align-items-center">
               <div class="avatar-sm flex-shrink-0">
                  <span class="avatar-title bg-light text-danger rounded-circle fs-3">
                  <i class="ri-arrow-up-circle-fill align-middle"></i>
                  </span>
               </div>
               <div class="flex-grow-1 ms-3">
                  <p class="text-uppercase fw-semibold fs-12 text-muted mb-1">Unpaid Invoices</p>
                  <h5 class="mb-0">KES <span class="counter-value" data-target="{{ $unpaidinvoices }}">KES {{ $unpaidinvoices }}</span></h5>
               </div>
            </div>
         </a>
         <!-- end card body -->
      </div>
      <!-- end card -->
   </div>
   <!-- end col -->
</div>
<div class="row">
   <div class="col-xl-8">
      <div class="card card-height-100">
         <div class="card-header align-items-center d-flex">
            <h4 class="card-title mb-0 flex-grow-1">My internet Services</h4>
         </div>
         <!-- end card header -->
         <div class="card-body">
            <div class="table-responsive table-card">
               <table
                  class="table table-hover table-borderless table-centered align-middle table-nowrap mb-0" id="datatable" style="width:100%">
                  <thead class="text-muted bg-light-subtle">
                     <tr>
                        <th>Status</th>
                        <th>Package</th>
                        <th>Price</th>
                        <th>Expiry</th>
                        @if(setting('customerPortal') == 'enabled' && setting('customerServiceChange') == 'enabled')
                        <th>Action</th>
                        @endif
                     </tr>
                  </thead>
                  <!-- end thead -->
                  <tbody>
                     @foreach($customer->services as $service)
                     <tr>
                        <td>
                           <span class="status-text">{!! $service->status() !!}</span>
                           <span class="online-status">{!! $service->getOnlineStatus() !!}</span>
                        </td>
                        <td>{{ $service->package->name }} </td>
                        <td>{{ $service->price }} ksh</td>
                        <td>
                           @php
                           $displayExpiry = $service->grace_expiry && Carbon\Carbon::parse($service->grace_expiry) > Carbon\Carbon::parse($service->expiry) && Carbon\Carbon::parse($service->grace_expiry) > Carbon\Carbon::now() ? Carbon\Carbon::parse($service->grace_expiry) : Carbon\Carbon::parse($service->expiry);
                           @endphp
                           @if($displayExpiry->isPast())
                           <div class="badge badge-soft-danger badge-border fs-12">Expired {{$displayExpiry->format('d F Y')}}</div>
                           @else
                           @if($displayExpiry->lte(\Carbon\Carbon::now()->addWeek()))
                           <div class="badge badge-soft-info badge-border fs-12">{{$displayExpiry->diffForHumans()}}</div>
                           @else
                           <div class="badge badge-soft-info badge-border fs-12">{{ $displayExpiry->format('d F Y') }}</div>
                           @endif
                           @endif
                        </td>
                        @if(setting('customerPortal') == 'enabled' && setting('customerServiceChange') == 'enabled')
                        <td>
                           <a href="{{ route('customer.updateService',[$service->username]) }}" class="btn btn-soft-info btn-sm"> Change</a>
                        </td>
                        @endif
                     </tr>
                     @endforeach
                  </tbody>
                  <!-- end tbody -->
               </table>
               <!-- end table -->
            </div>
            <!-- end tbody -->
         </div>
         <!-- end cardbody -->
      </div>
      <!-- end card -->
   </div>
   <!-- end col -->
   <div class="col-xl-4">
      <div class="card card-height-100">
         <div class="card-header align-items-center border-0 d-flex">
            <h4 class="card-title mb-0 flex-grow-1">M-Pesa Topup</h4>
         </div>
         <div class="card-body p-0">
            <div class="tab-content p-0">
               <div class="tab-pane active" id="buy-tab" role="tabpanel">
                  <!-- <div class="p-3">
                     <div class="float-end ms-2">
                        <h6 class="text-warning">Current balance : <span class="text-body">KES {{ number_format($customer->balance) }} </span></h6>
                     </div>
                     </div> -->
                  <form id="mpesaForm" action="{{ route('mpesa.customer.stk') }}" method="post">
                     @csrf
                     <div class="p-3">
                        <div>
                           <input type="hidden" name="account_number" value="{{ $customer->username }}">
                           <input type="hidden" name="type" value="client">
                           <div class="input-group mb-3">
                              <label class="input-group-text">Amount</label>
                              <input type="number" name="amount" class="form-control" placeholder="Enter amount" required min="5">
                              <label class="input-group-text">KES</label>
                           </div>
                           <div class="input-group mb-0">
                              <label class="input-group-text">Phone No</label>
                              <input type="text" class="form-control" name="phone" placeholder="Phone number" value="{{ $customer->phone }}">
                           </div>
                        </div>
                        <!-- <div class="mt-3 pt-2">
                           </div> -->
                        <div class="mt-3 pt-2">
                           <button type="submit" class="btn btn-primary w-100">Top Up Account</button>
                        </div>
                     </div>
                  </form>
               </div>
               <!-- end tabpane -->
            </div>
            <!-- end tab pane -->
         </div>
         <!-- end card body -->
      </div>
      <!-- end card -->
   </div>
</div>
<!-- end row -->
<div class="row">
   <div class="col-lg-12">
      <div class="card card-height-100">
         <div class="card-header align-items-center d-flex">
            <h4 class="card-title mb-0 flex-grow-1">Recent Transactions</h4>
         </div>
         <!-- end card header -->
         <div class="card-body">
            <div class="table-responsive table-card">
               <table
                  class="table table-hover table-borderless table-centered align-middle table-nowrap mb-0" id="transactions" style="width:100%">
                  <thead class="text-muted bg-light-subtle">
                     <tr>
                        <th>Type</th>
                        <th>Amount</th>
                        <th>Date</th>
                        <th>Action</th>
                     </tr>
                  </thead>
                  <!-- end thead -->
                  <tbody>
                     @foreach($transactions as $transaction)
                     <tr>
                        <td>
                           @if($transaction->type == 'deposit')
                           <div class="badge badge-soft-success">{{$transaction->type}}</div>
                           @else
                           <div class="badge badge-soft-info">Payment</div>
                           @endif
                        </td>
                        <td>
                           @if($transaction->type == 'deposit')
                           <code class="fs-14 text-dark">{{ number_format(abs($transaction->amount), 2) }} ksh</code> <!-- Display credit amount -->
                           @else
                           <code class="fs-14">{{ number_format(abs($transaction->amount), 2) }} ksh</code> <!-- Display debit amount -->
                           @endif
                        </td>
                        <td>{{ $transaction->created_at->format('d-M-Y h:i A') }} </td>
                        <td>
                           <a href="{{ route('transaction.show',[$transaction->id]) }}" class="btn btn-soft-info btn-sm"><i class="ri-eye-2-line"></i> View</a>
                        </td>
                     </tr>
                     @endforeach
                  </tbody>
                  <!-- end tbody -->
               </table>
               <!-- end table -->
            </div>
            <!-- end tbody -->
         </div>
         <!-- end cardbody -->
      </div>
   </div>
</div>
@endsection
@section('script')
<script src="{{ URL::asset('/assets/js/jquery-3.6.1.js')}}"></script>
<script src="{{ URL::asset('/assets/js/datatables/datatables.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
<script>
   $(document).ready(function () {
    var table = $('#datatable').DataTable({
        responsive: true,
        deferRender: true,
        paging: false,
        searching: false,
        info: false,
    });
    var table = $('#transactions').DataTable({
        responsive: true,
        deferRender: true,
        paging: false,
        searching: false,
        info: false,
    });
   
   })
</script>
<script>
   document.addEventListener('DOMContentLoaded', function () {
       // Form submission handler
       document.getElementById('mpesaForm').addEventListener('submit', function (event) {
           event.preventDefault(); // Prevent default form submission
   
           // Show processing message with loading spinner
           Swal.fire({
               title: 'Processing...',
               html: '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div><p>Please wait...</p>',
               allowOutsideClick: false,
               showConfirmButton: false // Hide the "OK" button
           });
   
           // Serialize form data
           var formData = new FormData(this);
   
           // Submit form data using AJAX
           fetch(this.action, {
               method: 'POST',
               body: formData
           })
           .then(response => response.json())
           .then(data => {
               // Close the processing message
               Swal.close();
   
               // Display SweetAlert2 message based on the response
               if (data.errorCode) {
                   // Display error message
                   Swal.fire({
                       icon: 'error',
                       title: 'Error',
                       text: data.errorMessage
                   }).then((result) => {
                       // Reload the page when "OK" button is clicked
                       if (result.isConfirmed) {
                           location.reload();
                       }
                   });
               } else {
                   // Display success message
                   Swal.fire({
                       icon: 'success',
                       title: 'Success',
                       text: 'Payment accepted for processing.!'
                   }).then((result) => {
                       // Reload the page when "OK" button is clicked
                       if (result.isConfirmed) {
                           location.reload();
                       }
                   });
               }
           })
           .catch(error => {
               console.error('Error:', error);
               // Close the processing message
               Swal.close();
               // Display generic error message
               Swal.fire({
                   icon: 'error',
                   title: 'Oops...',
                   text: 'Something went wrong!'
               });
           });
       });
   });
</script>
@endsection