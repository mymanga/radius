@extends('layouts.master') @section('title') revenue @endsection @section('css')
<link href="{{URL::asset('assets/js/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{URL::asset('assets/css/datatable-custom.css')}}" rel="stylesheet" type="text/css" />
<style>
   .striped {
   background-color: #f7f8fc !important;
   }
</style>
@endsection @section('content') 
<div class="page-title-box d-sm-flex align-items-center justify-content-between">
   <h4 class="mb-sm-0 font-size-18">Revenue</h4>
   <div class="page-title-right">
      <ol class="breadcrumb m-0">
         <li class="breadcrumb-item"><a href="{{ route('hotspot.index') }}">Hotspot</a></li>
         <li class="breadcrumb-item active"><a href="#">Revenue</a></li>
      </ol>
   </div>
</div>
<div class="row">
   <div class="col-lg-12">
      <div class="row">
         @foreach($transactions as $transaction)
         <div class="col-xl-3 col-sm-6 col-6">
            <div class="card card-animate">
               <div class="card-body">
                  <div class="d-flex">
                     <div class="flex-grow-1">
                        <h6 class="text-muted mb-3 d-none d-md-block">{{ $transaction->month }} Revenue</h6>
                        <h6 class="text-muted mb-3 d-md-none">{{ $transaction->month }}</h6>
                        <h6 class="mb-0 text-info">
                           <span class="counter-value" data-target="{{ $transaction->total_amount }}">{{ $transaction->total_amount }}</span>
                           <small class="text-info fs-13">Ksh </small>
                        </h6>
                     </div>
                     <div class="flex-shrink-0 avatar-xs">
                        <div class="avatar-title bg-soft-info text-info fs-22 rounded"> {{ $transaction->total_count }} </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         @endforeach    
         <!--end col-->
      </div>
      <!-- Data here -->
   </div>
   <!--end col-->
</div>
<div class="row">
   <div class="col-lg-12">
      <div class="card">
         <div class="card-body">
            
               <div class="table-responsive table-card mb-1">
                  <table class="table align-middle" id="datatable" style="width: 100%;">
                     <thead class="table-light text-muted">
                        <tr class="text-uppercase">
                           @foreach(['#', 'Voucher', 'Payment Method', 'Amount', 'Reference', 'Timestamp'] as $cell)
                           <th>{{ $cell }}</th>
                           @endforeach
                        </tr>
                     </thead>
                     <tbody class="list form-check-all">
                        {{-- @foreach($payments as $payment) 
                        <tr class="no-border">
                           <td>{{ $payment->id }}</td>
                           <td>{{ $payment->code }}</td>
                           <td>{{ $payment->payment_method }}</td>
                           <td>Ksh {{ number_format($payment->amount, 2) }}</td>
                           <td>{{ $payment->reference ?: 'N/A' }}</td>
                           <td>{{ $payment->created_at->format('d M Y H:i') }}</td>
                        </tr>
                        @endforeach --}}
                     </tbody>
                  </table>
               </div>
           
            <!--end modal -->
         </div>
      </div>
   </div>
   <!--end col-->
</div>
<!--end row-->
@endsection 
@section('script')
<script src="{{ URL::asset('/assets/js/jquery-3.6.1.js')}}"></script>
<script src="{{ URL::asset('/assets/js/datatables/datatables.min.js') }}"></script>
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
{{-- <script src="{{ URL::asset('/assets/js/datatable.js') }}"></script>  --}}
{{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.0/dist/chart.min.js"></script>
<script>
   $(document).ready(function() {
       $('#datatable').DataTable({
           processing: true,
           serverSide: true,
           ajax: {
               url: "{{ route('hotspot.revenue') }}",
               type: "GET",
               headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
           },
           columns: [
               {data: 'id', name: 'id'},
               {data: 'code', name: 'code'},
               {data: 'payment_method', name: 'payment_method'},
               {
                   data: 'amount', 
                   name: 'amount', 
                   render: function(data, type, row) {
                       return 'KSH ' + parseFloat(data).toLocaleString(undefined, {
                           minimumFractionDigits: 2,
                           maximumFractionDigits: 2
                       });
                   }
               },
               {data: 'reference', name: 'reference'},
               {
                   data: 'created_at', 
                   name: 'created_at', 
                   render: function(data, type, row) {
                       var date = new Date(data);
                       var options = {
                           day: 'numeric',
                           month: 'short',
                           year: 'numeric',
                           hour: 'numeric',
                           minute: 'numeric',
                           hour12: true
                       };
                       return date.toLocaleString('en-US', options);
                   }
               }
           ],
           order: [[0, 'desc']],
           lengthMenu: [[20, 35, 50, 100], [20, 35, 50, 100]],
           language: {
               searchPlaceholder: 'Search...',
               paginate: {
                   first: 'First',
                   last: 'Last',
                   next: '&rarr;',
                   previous: '&larr;'
               }
           },
           responsive: true // Make the DataTable responsive
       });
   });
</script>
@endsection