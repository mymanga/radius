@extends('layouts.master') @section('title') mpesa transactions @endsection 
@section('css') 
@endsection 
@section('content') @component('components.breadcrumb') @slot('li_1') Nas @endslot @slot('title') Create @endslot
@endcomponent
<!-- .card-->
<div class="row justify-content-center">
<div class="col-lg-6 col-md-8">
   <div class="card">
      <div class="card-header">
         <h5 class="card-title mb-0"><i class="ri-secure-payment-line align-bottom me-1 text-muted"></i> Transaction Details</h5>
      </div>
      <div class="card-body">
         <div class="d-flex align-items-center mb-2">
            <div class="flex-shrink-0">
               <p class="text-muted mb-0">Transaction Type:</p>
            </div>
            <div class="flex-grow-1 ms-2">
               <h6 class="mb-0">{{$transaction->transaction_type}}</h6>
            </div>
         </div>
         <div class="d-flex align-items-center mb-2">
            <div class="flex-shrink-0">
               <p class="text-muted mb-0">Transaction ID:</p>
            </div>
            <div class="flex-grow-1 ms-2">
               <h6 class="mb-0">{{$transaction->transaction_id}}</h6>
            </div>
         </div>
         <div class="d-flex align-items-center mb-2">
            <div class="flex-shrink-0">
               <p class="text-muted mb-0">Transaction Time:</p>
            </div>
            <div class="flex-grow-1 ms-2">
               <h6 class="mb-0">{{ date('d F Y h:i A', strtotime($transaction->transaction_time)) }}</h6>
            </div>
         </div>
         <div class="d-flex align-items-center mb-2">
            <div class="flex-shrink-0">
               <p class="text-muted mb-0">Amount:</p>
            </div>
            <div class="flex-grow-1 ms-2">
               <h6 class="mb-0">Ksh {{$transaction->amount}}</h6>
            </div>
         </div>
         <div class="d-flex align-items-center mb-2">
            <div class="flex-shrink-0">
               <p class="text-muted mb-0">Business Short Code:</p>
            </div>
            <div class="flex-grow-1 ms-2">
               <h6 class="mb-0">{{$transaction->business_short_code}}</h6>
            </div>
         </div>
         <div class="d-flex align-items-center mb-2">
            <div class="flex-shrink-0">
               <p class="text-muted mb-0">Bill Reference:</p>
            </div>
            <div class="flex-grow-1 ms-2">
               <h6 class="mb-0">{{$transaction->bill_reference}}</h6>
            </div>
         </div>
         <div class="d-flex align-items-center mb-2">
            <div class="flex-shrink-0">
               <p class="text-muted mb-0">Invoice Number:</p>
            </div>
            <div class="flex-grow-1 ms-2">
               <h6 class="mb-0">{{$transaction->invoice_number}}</h6>
            </div>
         </div>
         <div class="d-flex align-items-center mb-2">
            <div class="flex-shrink-0">
               <p class="text-muted mb-0">Org Account Balance:</p>
            </div>
            <div class="flex-grow-1 ms-2">
               <h6 class="mb-0">{{$transaction->org_account_balance}}</h6>
            </div>
         </div>
         <div class="d-flex align-items-center mb-2">
            <div class="flex-shrink-0">
               <p class="text-muted mb-0">Third Party Transaction ID:</p>
            </div>
            <div class="flex-grow-1 ms-2">
               <h6 class="mb-0">{{$transaction->third_party_trans_id}}</h6>
            </div>
         </div>
         <div class="d-flex align-items-center mb-2">
            <div class="flex-shrink-0">
               <p class="text-muted mb-0">Phone Number:</p>
            </div>
            <div class="flex-grow-1 ms-2">
               <h6 class="mb-0">{{substr($transaction->phone_number, 0, 20)}}</h6>
            </div>
         </div>
         <div class="d-flex align-items-center mb-2">
            <div class="flex-shrink-0">
               <p class="text-muted mb-0">First Name:</p>
            </div>
            <div class="flex-grow-1 ms-2">
               <h6 class="mb-0">{{$transaction->first_name}}</h6>
            </div>
         </div>
         <div class="d-flex align-items-center mb-2">
            <div class="flex-shrink-0">
               <p class="text-muted mb-0">Middle Name:</p>
            </div>
            <div class="flex-grow-1 ms-2">
               <h6 class="mb-0">{{$transaction->middle_name}}</h6>
            </div>
         </div>
         <div class="d-flex align-items-center mb-2">
            <div class="flex-shrink-0">
               <p class="text-muted mb-0">Last Name:</p>
            </div>
            <div class="flex-grow-1 ms-2">
               <h6 class="mb-0">{{$transaction->last_name}}</h6>
            </div>
         </div>
         <div class="d-flex align-items-center mb-2">
            <div class="flex-shrink-0">
               <p class="text-muted mb-0">Status:</p>
            </div>
            <div class="flex-grow-1 ms-2">
               <h6 class="mb-0">{{$transaction->status}}</h6>
            </div>
         </div>
      </div>
   </div>
   <!--end card-->
</div>
<!--end col-->
@endsection @section('script')
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection