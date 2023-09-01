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
               <h6 class="mb-0">{{ isset($transaction->transaction_type) ? $transaction->transaction_type : 'Not Available' }}</h6>
            </div>
         </div>
         <div class="d-flex align-items-center mb-2">
            <div class="flex-shrink-0">
               <p class="text-muted mb-0">Transaction ID:</p>
            </div>
            <div class="flex-grow-1 ms-2">
               <h6 class="mb-0">{{ isset($transaction->transaction_id) ? $transaction->transaction_id : 'Not Available' }}</h6>
            </div>
         </div>
         <div class="d-flex align-items-center mb-2">
            <div class="flex-shrink-0">
               <p class="text-muted mb-0">Transaction Time:</p>
            </div>
            <div class="flex-grow-1 ms-2">
               <h6 class="mb-0">{{ isset($transaction->transaction_time) ? date('d F Y h:i A', strtotime($transaction->transaction_time)) : 'Not Available' }}</h6>
            </div>
         </div>
         <div class="d-flex align-items-center mb-2">
            <div class="flex-shrink-0">
               <p class="text-muted mb-0">Amount:</p>
            </div>
            <div class="flex-grow-1 ms-2">
               <h6 class="mb-0">Ksh {{ isset($transaction->amount) ? $transaction->amount : 'Not Available' }}</h6>
            </div>
         </div>
         <div class="d-flex align-items-center mb-2">
            <div class="flex-shrink-0">
               <p class="text-muted mb-0">Business Short Code:</p>
            </div>
            <div class="flex-grow-1 ms-2">
               <h6 class="mb-0">{{ isset($transaction->business_short_code) ? $transaction->business_short_code : 'Not Available' }}</h6>
            </div>
         </div>
         <div class="d-flex align-items-center mb-2">
            <div class="flex-shrink-0">
               <p class="text-muted mb-0">Bill Reference:</p>
            </div>
            <div class="flex-grow-1 ms-2">
               <h6 class="mb-0">{{ isset($transaction->bill_reference) ? $transaction->bill_reference : 'Not Available' }}</h6>
            </div>
         </div>
         <div class="d-flex align-items-center mb-2">
            <div class="flex-shrink-0">
               <p class="text-muted mb-0">Invoice Number:</p>
            </div>
            <div class="flex-grow-1 ms-2">
               <h6 class="mb-0">{{ isset($transaction->invoice_number) ? $transaction->invoice_number : 'Not Available' }}</h6>
            </div>
         </div>
         <div class="d-flex align-items-center mb-2">
            <div class="flex-shrink-0">
               <p class="text-muted mb-0">Org Account Balance:</p>
            </div>
            <div class="flex-grow-1 ms-2">
               <h6 class="mb-0">{{ isset($transaction->org_account_balance) ? $transaction->org_account_balance : 'Not Available' }}</h6>
            </div>
         </div>
         <div class="d-flex align-items-center mb-2">
            <div class="flex-shrink-0">
               <p class="text-muted mb-0">Third Party Transaction ID:</p>
            </div>
            <div class="flex-grow-1 ms-2">
               <h6 class="mb-0">{{ isset($transaction->third_party_trans_id) ? $transaction->third_party_trans_id : 'Not Available' }}</h6>
            </div>
         </div>
         <div class="d-flex align-items-center mb-2">
            <div class="flex-shrink-0">
               <p class="text-muted mb-0">Phone Number:</p>
            </div>
            <div class="flex-grow-1 ms-2">
               <h6 class="mb-0">{{ isset($transaction->phone_number) ? substr($transaction->phone_number, 0, 20) : 'Not Available' }}</h6>
            </div>
         </div>
         <div class="d-flex align-items-center mb-2">
            <div class="flex-shrink-0">
               <p class="text-muted mb-0">First Name:</p>
            </div>
            <div class="flex-grow-1 ms-2">
               <h6 class="mb-0">{{ isset($transaction->first_name) ? $transaction->first_name : 'Not Available' }}</h6>
            </div>
         </div>
         <div class="d-flex align-items-center mb-2">
            <div class="flex-shrink-0">
               <p class="text-muted mb-0">Middle Name:</p>
            </div>
            <div class="flex-grow-1 ms-2">
               <h6 class="mb-0">{{ isset($transaction->middle_name) ? $transaction->middle_name : 'Not Available' }}</h6>
            </div>
         </div>
         <div class="d-flex align-items-center mb-2">
            <div class="flex-shrink-0">
               <p class="text-muted mb-0">Last Name:</p>
            </div>
            <div class="flex-grow-1 ms-2">
               <h6 class="mb-0">{{ isset($transaction->last_name) ? $transaction->last_name : 'Not Available' }}</h6>
            </div>
         </div>
         <div class="d-flex align-items-center mb-2">
            <div class="flex-shrink-0">
               <p class="text-muted mb-0">Status:</p>
            </div>
            <div class="flex-grow-1 ms-2">
               <h6 class="mb-0">{{ isset($transaction->status) ? $transaction->status : 'Not Available' }}</h6>
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