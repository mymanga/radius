@extends('layouts.master')
@section('title')
Revenue
@endsection
@section('css')
<link href="{{ URL::asset('assets/js/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('assets/css/datatable-custom.css') }}" rel="stylesheet" type="text/css" />
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
   height: 400px;
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
$selectedOption = request()->input('report_type', 'quick'); // Default to 'quick' if not provided
$hour = \Carbon\Carbon::now()->format('H');
$formattedMonth = \Carbon\Carbon::createFromFormat('Y-m', $month)->format('F Y');

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
                <p class="text-muted mb-0">Here's the report for the month of {{ $formattedMonth }}.</p>
            </div>
            <div class="mt-3 mt-lg-0">
                <div class="row g-3 mb-0 align-items-center">
                    <div class="col-auto">
                        <select id="report-type-selector" name="report_type" class="form-control">
                            <option value="quick" {{ $selectedOption == 'quick' ? 'selected' : '' }}>Quick Report</option>
                            <option value="full" {{ $selectedOption == 'full' ? 'selected' : '' }}>Full Report</option>
                        </select>
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-primary" id="generate-pdf-button">
                            <i class="ri-file-download-line align-middle me-1"></i> Generate PDF
                        </button>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('hotspot.revenue') }}" class="btn btn-soft-info btn-icon waves-effect waves-light layout-rightside-btn"><i class="ri-arrow-go-back-line"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="row">
   <!-- Top Cards -->
   <div class="col-xl-4 col-md-6 col-12">
      <div class="card card-animate card-height-100">
         <div class="card-body">
            <div class="d-flex align-items-center justify-content-between">
               <div class="flex-grow-1">
                  <h5 class="text-muted mb-3">Total Revenue</h5>
                  <h6 class="mb-0 text-info">
                     <span class="counter-value fs-13" data-target="{{ $totalRevenue }}">{{ number_format($totalRevenue, 2) }}</span>
                  </h6>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="col-xl-4 col-md-6 col-12">
      <div class="card card-animate card-height-100">
         <div class="card-body">
            <div class="d-flex align-items-center justify-content-between">
               <div class="flex-grow-1">
                  <h5 class="text-muted mb-3">Growth from Previous Month</h5>
                  <h6 class="mb-0 {{ is_null($growth) ? 'text-muted' : ($growth >= 0 ? 'text-success' : 'text-danger') }}">
                     {{ is_null($growth) ? 'N/A' : number_format($growth, 2) . ' %' }}
                  </h6>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="col-xl-4 col-md-6 col-12">
      <div class="card card-animate card-height-100">
         <div class="card-body">
            <div class="d-flex align-items-center justify-content-between">
               <div class="flex-grow-1">
                  <h5 class="text-muted mb-3">Total Payments</h5>
                  <h6 class="mb-0 text-info">
                     <span class="counter-value fs-13" data-target="{{ $totalPayments }}">{{ $totalPayments }}</span>
                  </h6>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<div class="row">
   <!-- 30-day Graph -->
   <div class="col-lg-12">
      <div class="card">
         <div class="card-body">
            <h5 class="card-title">30-Day Payments Trend</h5>
            <div class="chart-container">
               <div class="chart-wrapper">
                  <canvas id="dailyRevenueChart"></canvas>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<div class="row">
   <!-- Weekly Growth Pie Chart -->
   <div class="col-lg-12">
      <div class="card card-height-100">
         <div class="card-body">
            <div class="chart-container">
               <div class="chart-wrapper">
                  <canvas id="weeklyGrowthChart"></canvas>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- Revenue by weekday -->
   <div class="col-lg-12">
      <div class="card card-height-100">
         <div class="card-body">
            <div class="chart-container">
               <div class="chart-wrapper">
                  <canvas id="dailyWeekdayRevenueChart"></canvas>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<div class="row">
   <!-- Transactions Table -->
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
                     <!-- Table data will be populated by DataTables -->
                  </tbody>
               </table>
            </div>
         </div>
      </div>
   </div>
</div>

@endsection
@section('script')
<script src="{{ URL::asset('/assets/js/jquery-3.6.1.js') }}"></script>
<!-- DataTables -->
<script src="{{ URL::asset('/assets/js/datatables/datatables.min.js') }}"></script>
<!-- App JS -->
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
<!-- Moment.js -->
<script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/min/moment.min.js"></script>
<!-- Chart.js Moment.js Adapter -->
<script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-moment@1.0.0/dist/chartjs-adapter-moment.min.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.7/dist/sweetalert2.all.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>


<script>
   $(document).ready(function() {
       $('#datatable').DataTable({
           processing: true,
           serverSide: true,
           ajax: {
               url: "{{ route('hotspotstats.data', ['month' => $month]) }}",
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
           order: [[4, 'desc']],
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

       
   
    //    function getBase64Image(chart) {
    //         return chart.toBase64Image().replace(/^data:image\/(png|jpg);base64,/, "");
    //     }
        
        function captureChartAsBase64(chartElement) {
            return new Promise((resolve, reject) => {
                html2canvas(chartElement, {
                    useCORS: true,
                    scale: 2 // Increase scale to improve resolution
                }).then(canvas => {
                    resolve(canvas.toDataURL().replace(/^data:image\/(png|jpg);base64,/, ""));
                }).catch(error => {
                    reject(error);
                });
            });
        }

        $('#generate-pdf-button').on('click', async function() {
            try {
                const dailyRevenueChartElement = document.getElementById('dailyRevenueChart');
                const weeklyGrowthChartElement = document.getElementById('weeklyGrowthChart');
                const dailyWeekdayRevenueChartElement = document.getElementById('dailyWeekdayRevenueChart');
                const reportType = $('#report-type-selector').val(); // Get the selected report type

                Swal.fire({
                    title: 'Generating PDF',
                    text: 'Please wait while your report is being generated.',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                const dailyRevenueChartImage = await captureChartAsBase64(dailyRevenueChartElement);
                const weeklyGrowthChartImage = await captureChartAsBase64(weeklyGrowthChartElement);
                const dailyWeekdayRevenueChartImage = await captureChartAsBase64(dailyWeekdayRevenueChartElement);

                $.ajax({
                    url: "{{ route('hotspotstats.pdf', ['month' => $month]) }}",
                    type: "POST",
                    data: JSON.stringify({
                        _token: '{{ csrf_token() }}',
                        dailyRevenueChart: dailyRevenueChartImage,
                        weeklyGrowthChart: weeklyGrowthChartImage,
                        dailyWeekdayRevenueChart: dailyWeekdayRevenueChartImage,
                        report_type: reportType // Pass the selected report type
                    }),
                    contentType: 'application/json; charset=utf-8',
                    xhrFields: {
                        responseType: 'blob'
                    },
                    success: function(blob) {
                        Swal.close();
                        var link = document.createElement('a');
                        link.href = window.URL.createObjectURL(blob);
                        link.download = "revenue_report.pdf";
                        link.click();
                    },
                    error: function(xhr, status, error) {
                        Swal.close();
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'An error occurred while generating the PDF. Please try again.',
                        });
                        console.error(error);
                    }
                });
            } catch (error) {
                Swal.close();
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while generating the PDF. Please try again.',
                });
                console.error(error);
            }
        });
   
       // Daily Revenue Bar Chart
       var dailyRevenueData = @json($chartData);
   
       if (dailyRevenueData.data && dailyRevenueData.data.length > 0) {
           var ctxDaily = document.getElementById('dailyRevenueChart').getContext('2d');
           dailyRevenueChart = new Chart(ctxDaily, {
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
                                   return 'Ksh ' + tooltipItem.raw.toLocaleString(undefined, {
                                       minimumFractionDigits: 2,
                                       maximumFractionDigits: 2
                                   });
                               }
                           }
                       }
                   }
               }
           });
       } else {
           console.error('No daily revenue data available for chart rendering.');
       }
   
       // Weekly Growth Pie Chart
       var weeklyGrowthData = @json($weeklyGrowthChartData);
   
       if (weeklyGrowthData.data && weeklyGrowthData.data.length > 0) {
           var weekLabels = weeklyGrowthData.labels.map(function(label, index) {
               return 'Week ' + (index + 1);
           });
   
           var totalRevenue = weeklyGrowthData.data.reduce(function(acc, value) {
               return acc + value;
           }, 0);
   
           var daysInWeek = weeklyGrowthData.daysInWeek;
   
           var ctxWeekly = document.getElementById('weeklyGrowthChart').getContext('2d');
           weeklyGrowthChart = new Chart(ctxWeekly, {
               type: 'pie',
               data: {
                   labels: weekLabels,
                   datasets: [{
                       data: weeklyGrowthData.data,
                       backgroundColor: [
                           'rgba(255, 99, 132, 0.2)', // Week 1
                           'rgba(54, 162, 235, 0.2)', // Week 2
                           'rgba(255, 206, 86, 0.2)', // Week 3
                           'rgba(75, 192, 192, 0.2)', // Week 4
                           'rgba(153, 102, 255, 0.2)', // Week 5
                           'rgba(255, 159, 64, 0.2)'  // Week 6 (if needed)
                       ],
                       borderColor: [
                           'rgba(255, 99, 132, 1)',
                           'rgba(54, 162, 235, 1)',
                           'rgba(255, 206, 86, 1)',
                           'rgba(75, 192, 192, 1)',
                           'rgba(153, 102, 255, 1)',
                           'rgba(255, 159, 64, 1)'
                       ],
                       borderWidth: 1
                   }]
               },
               options: {
                   responsive: true,
                   maintainAspectRatio: false,
                   plugins: {
                       legend: {
                           position: 'top',
                       },
                       title: {
                           display: true,
                           text: 'Weekly Growth Distribution'
                       },
                       datalabels: {
                           formatter: function(value, context) {
                               var label = context.chart.data.labels[context.dataIndex];
                               var days = daysInWeek[context.dataIndex];
                               var percentage = ((value / totalRevenue) * 100).toFixed(2);
                               return `${label}\nDays: ${days}\nKsh ${value.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}\n(${percentage}%)`;
                           },
                           color: '#000',
                           font: {
                               weight: 'bold'
                           },
                           align: 'center',
                           anchor: 'center'
                       }
                   }
               },
               plugins: [ChartDataLabels]
           });
       } else {
           console.error('No weekly growth data available for chart rendering.');
       }
   
       // Daily Totals by Weekday Chart
       var dailyTotalsByWeekdayData = @json($dailyTotalsByWeekdayData);
   
       if (dailyTotalsByWeekdayData.data && dailyTotalsByWeekdayData.data.length > 0) {
           var ctxDailyWeekday = document.getElementById('dailyWeekdayRevenueChart').getContext('2d');
           dailyWeekdayRevenueChart = new Chart(ctxDailyWeekday, {
               type: 'bar',
               data: {
                   labels: dailyTotalsByWeekdayData.labels,
                   datasets: [{
                       label: 'Total Revenue by Weekday',
                       data: dailyTotalsByWeekdayData.data,
                       backgroundColor: 'rgba(75, 192, 192, 0.2)',
                       borderColor: 'rgba(75, 192, 192, 1)',
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
                                   return 'Ksh ' + tooltipItem.raw.toLocaleString(undefined, {
                                       minimumFractionDigits: 2,
                                       maximumFractionDigits: 2
                                   });
                               }
                           }
                       }
                   }
               }
           });
       } else {
           console.error('No daily totals by weekday data available for chart rendering.');
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