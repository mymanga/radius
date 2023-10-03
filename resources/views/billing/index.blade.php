@extends('layouts.master') @section('title') billing @endsection @section('css')
<link href="{{URL::asset('assets/js/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{URL::asset('assets/css/datatable-custom.css')}}" rel="stylesheet" type="text/css" />
<style>
   .striped {
   background-color: #f7f8fc !important;
   }
</style>
@endsection @section('content') 
{{-- @component('components.breadcrumb') @slot('li_1') Dashboard @endslot @slot('title') Finance @endslot @endcomponent --}}
<div class="page-title-box d-sm-flex align-items-center justify-content-between">
   <h4 class="mb-sm-0 font-size-18">Finance</h4>
   <div class="page-title-right">
      <ol class="breadcrumb m-0">
         <li class="breadcrumb-item"><a>Crm</a></li>
         <li class="breadcrumb-item active"><a href="{{ route('billing.index') }}">Finance</a></li>
      </ol>
   </div>
</div>
<div class="row">
   <div class="col-lg-12">
      <div class="row">
         <div class="col-xl-3 col-sm-6 col-6">
            <div class="card card-animate">
               <div class="card-body">
                  <div class="d-flex">
                     <div class="flex-grow-1">
                        <h6 class="text-muted mb-3 d-none d-md-block">{{date('F')}} Payments</h6>
                        <h6 class="text-muted mb-3 d-md-none">{{date('F')}}</h6>
                        <h6 class="mb-0 text-info">
                           <span class="counter-value" data-target="{{ $transactions[0]->deposit_sum ?? '0' }}">{{ $transactions[0]->deposit_sum ?? '0' }}</span>
                           <small class="text-info fs-13">Ksh </small>
                        </h6>
                     </div>
                     {{-- 
                     <div class="flex-shrink-0 avatar-xs">
                        <div class="avatar-title bg-soft-info text-info fs-22 rounded"> {{ $transactions[0]->deposit_count ?? '0' }} </div>
                     </div>
                     --}}
                  </div>
               </div>
            </div>
         </div>
         <!--end col-->
         <div class="col-xl-3 col-sm-6 col-6">
            <div class="card card-animate">
               <div class="card-body">
                  <div class="d-flex">
                     <div class="flex-grow-1">
                        <h6 class="text-muted mb-3 d-none d-md-block">M-Pesa Payments</h6>
                        <h6 class="text-muted mb-3 d-md-none">M-Pesa</h6>
                        <h6 class="mb-0 text-info">
                           <span class="counter-value" data-target="{{ $mpesa[0]->sum ?? 0 }}">{{ $mpesa[0]->sum ?? 0 }}</span>
                           <small class="text-info fs-13">Ksh </small>
                        </h6>
                     </div>
                     {{-- 
                     <div class="flex-shrink-0 avatar-xs">
                        <div class="avatar-title bg-soft-info text-info fs-22 rounded"> {{ $mpesa[0]->count ?? 0 }} </div>
                     </div>
                     --}}
                  </div>
               </div>
            </div>
            <!--end card-->
         </div>
         <!--end col-->
         <div class="col-xl-3 col-sm-6 col-6">
            <div class="card card-animate">
               <div class="card-body">
                  <div class="d-flex">
                     <div class="flex-grow-1">
                        <h6 class="text-muted mb-3 d-none d-md-block">Other Payments</h6>
                        <h6 class="text-muted mb-3 d-md-none">Other</h6>
                        <h6 class="mb-0 text-info">
                           <span class="counter-value" data-target="{{ ($transactions[0]->deposit_sum ?? 0) - ($mpesa[0]->sum ?? 0) }}">{{ ($transactions[0]->deposit_sum ?? 0) - ($mpesa[0]->sum ?? 0) }}</span>
                           <small class="text-info fs-13">Ksh </small>
                        </h6>
                     </div>
                     {{-- 
                     <div class="flex-shrink-0 avatar-xs">
                        <div class="avatar-title bg-soft-info text-info fs-22 rounded"> {{ ($transactions[0]->deposit_count ?? 0) - ($mpesa[0]->count ?? 0) }} </div>
                     </div>
                     --}}
                  </div>
               </div>
            </div>
            <!--end card-->
         </div>
         <!--end col-->
         <div class="col-xl-3 col-sm-6 col-6">
            <div class="card card-animate">
               <div class="card-body">
                  <div class="d-flex">
                     <div class="flex-grow-1">
                        <h6 class="text-muted mb-3 d-none d-md-block">Paid services</h6>
                        <h6 class="text-muted mb-3 d-md-none">Services</h6>
                        <h6 class="mb-0 text-info">
                           <span class="counter-value" data-target="{{ abs($transactions[0]->withdraw_sum ?? 0) }}">{{ abs($transactions[0]->withdraw_sum ?? 0) }}</span>
                           <small class="text-info fs-13">Ksh </small>
                        </h6>
                     </div>
                     {{-- 
                     <div class="flex-shrink-0 avatar-xs">
                        <div class="avatar-title bg-soft-info text-info fs-22 rounded"> {{ $transactions[0]->withdraw_count ?? 0 }} </div>
                     </div>
                     --}}
                  </div>
               </div>
            </div>
            <!--end card-->
         </div>
         <!--end col-->
      </div>
      <!-- Data here -->
   </div>
   <!--end col-->
</div>
<div class="row">
   @foreach($growth as $key => $value)
   <div class="col-xl-4 col-md-4 col-12">
      <div class="card card-height-100">
         <div style="margin-bottom: 0px;" class="card-header align-items-center d-flex">
            <h4 class="card-title mb-0 flex-grow-1"> {{ $value->months }}</h4>
         </div>
         <!-- end card-header -->
         <div class="card-body p-0">
            <ul class="list-group list-group-flush border-dashed mb-0">
               <li class="list-group-item d-flex align-items-center striped">
                  <div class="flex-grow-1">
                     <h6 class="fs-14 mb-1">Payments</h6>
                  </div>
                  <div class="flex-shrink-0 text-end">
                     <h6 class="fs-14 mb-1 text-info">{{ $value->deposit_sum }} Ksh</h6>
                  </div>
               </li>
               <!-- end -->
               @php
               $withdrawCount = 0;
               $withdrawCount += $value->withdraw_count;
               @endphp
               <li class="list-group-item d-flex align-items-center">
                  <div class="flex-grow-1">
                     <h6 class="fs-14 mb-1">Paid Services </h6>
                  </div>
                  <div class="flex-shrink-0 text-end">
                     <h6 class="fs-14 mb-1">{{ abs($value->withdraw_sum) }} Ksh</h6>
                  </div>
               </li>
               <!-- end -->
               <li class="list-group-item d-flex align-items-center striped">
                  <div class="flex-grow-1">
                     <h6 class="fs-14 mb-1">Growth</h6>
                  </div>
                  <div class="flex-shrink-0 text-end">
                     <h6 class="fs-14 mb-1">
                        @if($key == 0)
                        base
                        @else
                        @php
                        $previous = $growth[$key-1];
                        $previous_month_sum = $previous->deposit_sum - $previous->withdraw_sum; // Sum for the previous month
                        $current_month_sum = $value->deposit_sum - $value->withdraw_sum;       // Sum for the current month
                        $growth_percentage = ($previous_month_sum != 0) ? 
                        (($current_month_sum - $previous_month_sum) / abs($previous_month_sum)) * 100 : 0;
                        @endphp
                        @if($growth_percentage > 0)
                        <span style="color:green;"><i class="ri-arrow-up-fill"></i> {{ number_format($growth_percentage, 2) }}%</span>
                        @elseif($growth_percentage < 0)
                        <span style="color:red;"><i class="ri-arrow-down-fill"></i> {{ number_format(abs($growth_percentage), 2) }}%</span>
                        @else
                        <span>No Change</span>
                        @endif
                        @endif
                     </h6>
                  </div>
               </li>
               <!-- end -->           
               <!-- end -->
            </ul>
            <!-- end ul -->
         </div>
         <!-- end card body -->
      </div>
      <!-- end card -->
   </div>
   @endforeach
</div>
<div class="row">
   <div class="col-md-6">
      <div style="width: 100%; height: 400px;" class="card">
         <div class="card-header">
            Monthly Transactions (graph)
         </div>
         <div class="card-body">
            <canvas id="myChart"></canvas>
         </div>
      </div>
   </div>
   <div class="col-md-6">
      <div style="width: 100%; height: 400px;" class="card">
         <div class="card-header">
            Top 5 Payers
         </div>
         <div class="card-body">
            <canvas id="pie-chart"></canvas>
         </div>
      </div>
   </div>
</div>
{{-- 
<div class="row">
   <div class="col-md-12">
      <div style="width: 100%; height: 400px;" class="card">
         <div class="card-header">
            Revenue growth (graph)
         </div>
         <div class="card-body">
            <canvas id="revenueChart"></canvas>
         </div>
      </div>
   </div>
</div>
--}}
<!--end row-->
@endsection 
@section('script')
<script src="{{ URL::asset('/assets/js/jquery-3.6.1.js')}}"></script>
{{-- <script src="{{ URL::asset('/assets/js/datatables/datatables.min.js') }}"></script> --}}
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
{{-- <script src="{{ URL::asset('/assets/js/datatable.js') }}"></script>  --}}
{{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.0/dist/chart.min.js"></script>
<script>
   var months = {!! json_encode($growth->pluck('months')) !!};
   var depositSums = {!! json_encode($growth->pluck('deposit_sum')) !!};
   var withdrawSums = {!! json_encode($growth->pluck('withdraw_sum')->map(function($value) { return abs($value); })) !!};
   
   var ctx = document.getElementById('myChart').getContext('2d');
   var chart = new Chart(ctx, {
     type: 'bar',
     data: {
       labels: months,
       datasets: [
         {
           label: 'Payments',
           data: depositSums,
           backgroundColor: 'rgba(0, 128, 0, 0.5)',
           borderColor: 'rgba(0, 128, 0, 1)',
           borderWidth: 1
         },
         {
           label: 'Service paid',
           data: withdrawSums,
           backgroundColor: 'rgba(255, 0, 0, 0.5)',
           borderColor: 'rgba(255, 0, 0, 1)',
           borderWidth: 1
         }
       ]
     },
     options: {
       plugins: {
         legend: {
           display: true,
           position: 'top'
         }
       },
       scales: {
         y: {
           title: {
             display: true,
             text: 'Amount (KSH)'
           },
           suggestedMin: 0
         },
         x: {
           title: {
             display: true,
             text: 'Month'
           }
         }
       },
       aspectRatio: false
     }
   });
</script>
<script>
   var topUsers = {!! json_encode($topUsers) !!};
   
   var labels = [];
   var data = [];
   var backgroundColor = [
   '#FF6384',
   '#36A2EB',
   '#6C0BA9',
   '#5cb85c',
   '#f0ad4e'
   ];
   
   // Loop through the top users and add data for users with non-zero transactions_sum_amount
   topUsers.forEach(function(user) {
   if(user.transactions_sum_amount > 0) {
       labels.push(user.firstname);
       data.push(user.transactions_sum_amount);
   }
   });
   
   var chartData = {
   labels: labels,
   datasets: [{
       data: data,
       backgroundColor: backgroundColor
   }]
   };
   
   var options = {
   responsive: true,
   maintainAspectRatio: false,
   tooltips: {
       callbacks: {
           label: function(tooltipItem, data) {
               var value = data.datasets[0].data[tooltipItem.index];
               return "Ksh " + value.toFixed(2);
           }
       }
   },
   legend: {
       position: 'bottom'
   }
   };
   
   var pieChart = new Chart(document.getElementById('pie-chart'), {
   type: 'pie',
   data: chartData,
   options: options
   });
</script>
@endsection