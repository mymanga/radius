@extends('layouts.master')
@section('title')
Revenue
@endsection
@section('css')
<link href="{{ URL::asset('assets/js/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('assets/css/datatable-custom.css') }}" rel="stylesheet" type="text/css" />
{{-- 
<link href="{{ URL::asset('assets/css/daterangepicker.css') }}" rel="stylesheet" type="text/css" />
--}}
<style>
   .striped {
   background-color: #f7f8fc !important;
   }
   .card-animate {
   transition: all 0.3s ease-in-out;
   }
   .card-animate:hover {
   transform: translateY(-5px);
   }
   .profit {
   color: green;
   }
   .loss {
   color: red;
   }
   .chart-container {
   position: relative;
   height: 400px; /* Adjust height as needed */
   width: 100%;
   overflow: hidden;
   }
   .chart-wrapper {
   position: relative;
   height: 100%;
   width: 100%;
   }
   .insight-card {
   background: #fff;
   border-radius: 8px;
   box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
   padding: 20px;
   margin-bottom: 20px;
   text-align: center;
   }
   .insight-card h5 {
   font-size: 16px;
   font-weight: 600;
   margin-bottom: 15px;
   }
   .insight-card p {
   font-size: 18px;
   font-weight: 700;
   margin: 0;
   }
   .clickable-month {
   cursor: pointer;
   text-decoration: underline;
   color: #007bff; /* Adjust color to fit your theme */
   }
   .clickable-month:hover {
   color: #0056b3; /* Adjust hover color to fit your theme */
   }
   .clickable-card {
   text-decoration: none;
   color: inherit;
   }
   .clickable-card:hover .card {
   box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
   }
</style>
@endsection
@section('content')
<div class="page-title-box d-sm-flex align-items-center justify-content-between">
   <h4 class="mb-sm-0 font-size-18">Revenue</h4>
   <div class="page-title-right">
      <ol class="breadcrumb m-0">
         <li class="breadcrumb-item"><a href="{{ route('hotspot.index') }}">Hotspot</a></li>
         <li class="breadcrumb-item active"><a href="#">Revenue</a></li>
      </ol>
   </div>
</div>
@php
$selectedMonths = request()->input('months', 4); // Default to 4 if not provided
$hour = \Carbon\Carbon::now()->format('H');
if ($hour >= 5 && $hour < 12) {
$greeting = 'Good Morning';
} elseif ($hour >= 12 && $hour < 17) {
$greeting = 'Good Afternoon';
} else {
$greeting = 'Good Evening';
}
@endphp
<div class="row mb-3 pb-1">
   <div class="col-12">
      <div class="d-flex align-items-lg-center flex-lg-row flex-column">
         <div class="flex-grow-1">
            <h4 class="fs-16 mb-1">{{ $greeting }}, {{ auth()->user()->firstname }}!</h4>
            <p class="text-muted mb-0">Here's what's happening with your hotspot.</p>
         </div>
         <div class="mt-3 mt-lg-0">
            <form id="filter-form" action="{{ route('hotspot.revenue') }}" method="GET">
               <div class="row g-3 mb-0 align-items-center">
                  <div class="col-sm-auto">
                     <select id="months-selector" name="months" class="form-control">
                     <option value="2" {{ $selectedMonths == 2 ? 'selected' : '' }}>2 Months</option>
                     <option value="3" {{ $selectedMonths == 3 ? 'selected' : '' }}>3 Months</option>
                     <option value="4" {{ $selectedMonths == 4 ? 'selected' : '' }}>4 Months</option>
                     <option value="5" {{ $selectedMonths == 5 ? 'selected' : '' }}>5 Months</option>
                     <option value="6" {{ $selectedMonths == 6 ? 'selected' : '' }}>6 Months</option>
                     <option value="7" {{ $selectedMonths == 7 ? 'selected' : '' }}>7 Months</option>
                     <option value="8" {{ $selectedMonths == 8 ? 'selected' : '' }}>8 Months</option>
                     <option value="9" {{ $selectedMonths == 9 ? 'selected' : '' }}>9 Months</option>
                     <option value="10" {{ $selectedMonths == 10 ? 'selected' : '' }}>10 Months</option>
                     <option value="11" {{ $selectedMonths == 11 ? 'selected' : '' }}>11 Months</option>
                     <option value="12" {{ $selectedMonths == 12 ? 'selected' : '' }}>12 Months</option>
                     </select>
                  </div>
                  <div class="col-auto">
                     <button type="submit" class="btn btn-soft-success">
                     <i class="ri-filter-line align-middle me-1"></i> Apply Filter
                     </button>
                  </div>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>
<div class="row">
   <div class="col-lg-12">
      <div class="row">
         @foreach($growthData as $data)
         <div class="col-xl-3 col-md-6 col-12">
            <a href="{{ route('hotspotstats.show', ['month' => $data['month']]) }}" class="clickable-card" data-bs-toggle="tooltip" title="Click to view more stats for {{ Carbon\Carbon::createFromFormat('Y-m', $data['month'])->format('F Y') }}">
               <div class="card card-animate card-height-100">
                  <div class="card-body">
                     <div class="d-flex align-items-center justify-content-between">
                        <div class="flex-grow-1">
                           <h6 class="text-muted mb-3 d-none d-md-block">{{ Carbon\Carbon::createFromFormat('Y-m', $data['month'])->format('F Y') }}</h6>
                           <h6 class="text-muted mb-3 d-md-none">{{ Carbon\Carbon::createFromFormat('Y-m', $data['month'])->format('F Y') }}</h6>
                           <h6 class="mb-0 text-info">
                              <span class="counter-value fs-13" data-target="{{ $data['total_amount'] }}">{{ $data['total_amount'] }}</span>
                           </h6>
                        </div>
                        <div class="text-end">
                           @if(!is_null($data['growth']))
                           <h5 class="{{ $data['growth'] >= 0 ? 'text-success' : 'text-danger' }} fs-14 mb-0">
                              <i class="{{ $data['growth'] >= 0 ? 'ri-arrow-right-up-line' : 'ri-arrow-right-down-line' }} fs-13 align-middle"></i> 
                              {{ number_format(abs($data['growth']), 2) }} %
                           </h5>
                           <p class="mb-0 fs-13 {{ $data['difference'] >= 0 ? 'profit' : 'loss' }}">{{ $data['difference'] >= 0 ? 'Increase: +' : 'Drop: -' }}</p>
                           <p class="mb-0 fs-13">{{ number_format(abs($data['difference']), 2) }}</p>
                           @else
                           <h5 class="text-muted fs-14 mb-0">N/A</h5>
                           @endif
                        </div>
                     </div>
                  </div>
               </div>
            </a>
         </div>
         @endforeach
      </div>
   </div>
</div>
<div class="row">
   @if($months < 2)
   <div class="col-lg-12">
      <div class="card">
         <div class="card-body">
            <h5 class="card-title">
               Daily Trend ({{ $months }} month)
            </h5>
            <p>Not enough data to display the trend charts. Please select at least 2 months.</p>
         </div>
      </div>
   </div>
   @else
   <div class="col-lg-6">
      <div class="card">
         <div class="card-body">
            <h5 class="card-title">
               {{ $months }} Months Trend
            </h5>
            <div class="chart-container">
               <div class="chart-wrapper">
                  <canvas id="revenueTrendChart"></canvas>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="col-lg-6">
      <div class="card">
         <div class="card-body">
            <h5 class="card-title">
               Daily Trend ({{ $months }} months)
            </h5>
            <div class="chart-container">
               <div class="chart-wrapper">
                  <canvas id="dailyRevenueChart"></canvas>
               </div>
            </div>
         </div>
      </div>
   </div>
   @endif
</div>
<div class="row">
   <div class="col-lg-4">
      <div class="card card-animate card-height-100">
         <div class="card-body">
            <div class="d-flex align-items-center justify-content-between">
               <div class="flex-grow-1">
                  <h5 class="text-muted mb-3">Average Daily Revenue</h5>
                  <h6 class="mb-0 text-info">
                     <span class="counter-value fs-13" data-target="{{ $averageDailyRevenueFormatted }}">{{ $averageDailyRevenueFormatted }}</span>
                  </h6>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="col-lg-4">
      <div class="card card-animate card-height-100">
         <div class="card-body">
            <div class="d-flex align-items-center justify-content-between">
               <div class="flex-grow-1">
                  <h5 class="text-muted mb-3">Average Hourly Revenue</h5>
                  <h6 class="mb-0 text-info">
                     <span class="counter-value fs-13" data-target="{{ $averageHourlyRevenueFormatted }}">{{ $averageHourlyRevenueFormatted }}</span>
                  </h6>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="col-lg-4">
   <div class="card card-animate card-height-100">
      <div class="card-body">
         <div class="d-flex align-items-center justify-content-between">
            <div class="flex-grow-1">
               <h5 class="text-muted mb-3">Top and least ({{ $months }} {{ $months == 1 ? 'Month' : 'Months' }}) </h5>
               @if(isset($mostRevenueDay))
                  <p class="mb-0 fs-13">Most: {{ \Carbon\Carbon::create()->startOfWeek()->addDays($mostRevenueDay->day_of_week - 1)->format('l') }} (Ksh {{ number_format($mostRevenueDay->total_amount, 2) }})</p>
               @else
                  <p class="mb-0 fs-13">Most: Data not available</p>
               @endif
               @if(isset($leastRevenueDay))
                  <p class="mb-0 fs-13">Least: {{ \Carbon\Carbon::create()->startOfWeek()->addDays($leastRevenueDay->day_of_week - 1)->format('l') }} (Ksh {{ number_format($leastRevenueDay->total_amount, 2) }})</p>
               @else
                  <p class="mb-0 fs-13">Least: Data not available</p>
               @endif
            </div>
         </div>
      </div>
   </div>
</div>
</div>
<div class="row">
   <div class="col-lg-12">
      <div class="card">
         <div class="card-body">
            <div class="table-responsive table-card mb-1">
               <table class="table align-middle" id="datatable" style="width: 100%;">
                  <thead class="table-light text-muted">
                     <tr class="text-uppercase">
                        @foreach(['Voucher', 'Payment Method', 'Amount', 'Reference', 'Timestamp'] as $cell)
                        <th>{{ $cell }}</th>
                        @endforeach
                     </tr>
                  </thead>
                  <tbody class="list form-check-all">
                  </tbody>
               </table>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection
@section('script')
<!-- jQuery -->
<script src="{{ URL::asset('/assets/js/jquery-3.6.1.js') }}"></script>
<!-- DataTables -->
<script src="{{ URL::asset('/assets/js/datatables/datatables.min.js') }}"></script>
<!-- App JS -->
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.0/dist/chart.min.js"></script>
<!-- Moment.js -->
<script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/min/moment.min.js"></script>
<!-- Chart.js Moment.js Adapter -->
<script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-moment@1.0.0/dist/chartjs-adapter-moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/simple-statistics/7.7.0/simple-statistics.min.js"></script>
<script>
   $(document).ready(function() {
       $('#datatable').DataTable({
           processing: true,
           serverSide: true,
           ajax: {
               url: "{{ route('hotspot.revenue') }}",
               type: "GET",
               headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
           },
           columns: [
               { data: 'code', name: 'code' },
               { data: 'payment_method', name: 'payment_method' },
               {
                   data: 'amount',
                   name: 'amount',
                   render: function(data) {
                       return 'KSH ' + parseFloat(data).toLocaleString(undefined, {
                           minimumFractionDigits: 2,
                           maximumFractionDigits: 2
                       });
                   }
               },
               { data: 'reference', name: 'reference' },
               {
                   data: 'created_at',
                   name: 'created_at',
                   render: function(data) {
                       var date = new Date(data);
                       var options = {
                           day: 'numeric',
                           month: 'short',
                           year: 'numeric',
                           hour: 'numeric',
                           minute: 'numeric',
                           hour12: true
                       };
                       return date.toLocaleString(undefined, options);
                   }
               }
           ],
           pageLength: 20,
           order: [[0, 'desc']], // Order by the 'id' column in descending order
           language: {
               searchPlaceholder: 'Search...',
               paginate: {
                   first: 'First',
                   last: 'Last',
                   next: '&rarr;',
                   previous: '&larr;'
               }
           },
           lengthMenu: [[20, 35, 50, 100], [20, 35, 50, 100]],
           responsive: true
       });
   
       // Revenue Trend Chart
       var growthData = @json($growthData);
   
       if (growthData.length > 0) {
           var ctx = document.getElementById('revenueTrendChart').getContext('2d');
           var revenueTrendChart = new Chart(ctx, {
               type: 'line',
               data: {
                   labels: growthData.map(data => data.month),
                   datasets: [{
                       label: 'Total Revenue',
                       data: growthData.map(data => data.total_amount),
                       borderColor: 'rgba(75, 192, 192, 1)',
                       backgroundColor: 'rgba(75, 192, 192, 0.2)',
                       fill: true
                   }, {
                       label: 'Revenue Difference',
                       data: growthData.map(data => data.difference),
                       borderColor: 'rgba(255, 99, 132, 1)',
                       backgroundColor: 'rgba(255, 99, 132, 0.2)',
                       fill: true
                   }]
               },
               options: {
                   responsive: true,
                   maintainAspectRatio: false,
                   scales: {
                       x: {
                           type: 'time',
                           time: {
                               unit: 'month'
                           },
                           title: {
                               display: true,
                               text: 'Months'
                           }
                       },
                       y: {
                           beginAtZero: true,
                           title: {
                               display: true,
                               text: 'Amount (Ksh)'
                           }
                       }
                   },
                   plugins: {
                       tooltip: {
                           callbacks: {
                               label: function(tooltipItem) {
                                   return tooltipItem.dataset.label + ': Ksh ' + tooltipItem.raw.toLocaleString(undefined, {
                                       minimumFractionDigits: 2,
                                       maximumFractionDigits: 2
                                   });
                               }
                           }
                       },
                       annotation: {
                           annotations: {
                               line1: {
                                   type: 'line',
                                   yMin: 0,
                                   yMax: 0,
                                   borderColor: 'rgb(75, 192, 192)',
                                   borderWidth: 2,
                                   label: {
                                       content: 'Baseline',
                                       enabled: true,
                                       position: 'center'
                                   }
                               }
                           }
                       }
                   }
               }
           });
       } else {
           console.error('No growth data available for chart rendering.');
       }
   
       // Daily Revenue Chart
       var dailyRevenueData = @json($chartData);
   
       if (dailyRevenueData.data && dailyRevenueData.data.length > 0) {
           var ctxDaily = document.getElementById('dailyRevenueChart').getContext('2d');
           var dailyRevenueChart = new Chart(ctxDaily, {
               type: 'bar',
               data: {
                   labels: dailyRevenueData.labels,
                   datasets: [{
                       label: 'Total Revenue',
                       data: dailyRevenueData.data,
                       backgroundColor: 'rgba(54, 162, 235, 0.2)',
                       borderColor: 'rgba(54, 162, 235, 1)',
                       borderWidth: 1
                   }]
               },
               options: {
                   responsive: true,
                   maintainAspectRatio: false,
                   scales: {
                       y: {
                           beginAtZero: true,
                           title: {
                               display: true,
                               text: 'Amount (Ksh)'
                           }
                       }
                   },
                   plugins: {
                       tooltip: {
                           callbacks: {
                               label: function(tooltipItem) {
                                   var total = tooltipItem.dataset.data.reduce((acc, value) => acc + value, 0);
                                   var value = tooltipItem.raw;
                                   var percentage = ((value / total) * 100).toFixed(2);
                                   return tooltipItem.label + ': Ksh ' + value.toLocaleString(undefined, {
                                       minimumFractionDigits: 2,
                                       maximumFractionDigits: 2
                                   }) + ' (' + percentage + '%)';
                               }
                           }
                       },
                       datalabels: {
                           anchor: 'end',
                           align: 'top',
                           formatter: function(value, context) {
                               var total = context.dataset.data.reduce((acc, curr) => acc + curr, 0);
                               var percentage = ((value / total) * 100).toFixed(2);
                               return percentage + '%';
                           }
                       }
                   }
               }
           });
       } else {
           console.error('No daily revenue data available for chart rendering.');
       }
   });
</script>
<script>
   document.addEventListener('DOMContentLoaded', function () {
       var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
       var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
           return new bootstrap.Tooltip(tooltipTriggerEl)
       })
   });
</script>
@endsection