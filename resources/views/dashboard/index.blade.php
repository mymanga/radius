@extends('layouts.master') @section('title') @lang('translation.dashboard') @endsection @section('css')
<link href="assets/libs/jsvectormap/jsvectormap.min.css" rel="stylesheet" type="text/css" />
<link href="assets/libs/swiper/swiper.min.css" rel="stylesheet" type="text/css" />
<!-- Include SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.css">
<style>
   #loader-wrapper {
   position: fixed;
   top: 0;
   left: 0;
   right: 0;
   bottom: 0;
   background-color: rgba(0, 0, 0, 0.5);
   z-index: 9999;
   justify-content: center;
   align-items: center;
   }
   #loader {
   display: block;
   position: relative;
   left: 50%;
   top: 50%;
   width: 150px;
   height: 150px;
   margin: -75px 0 0 -75px;
   border-radius: 50%;
   border: 3px solid transparent;
   border-top-color: #3498db;
   -webkit-animation: spin 2s linear infinite;
   /* Chrome, Opera 15+, Safari 5+ */
   animation: spin 2s linear infinite;
   /* Chrome, Firefox 16+, IE 10+, Opera */
   }
   #loader:before {
   content: "";
   position: absolute;
   top: 5px;
   left: 5px;
   right: 5px;
   bottom: 5px;
   border-radius: 50%;
   border: 3px solid transparent;
   border-top-color: #e74c3c;
   -webkit-animation: spin 3s linear infinite;
   /* Chrome, Opera 15+, Safari 5+ */
   animation: spin 3s linear infinite;
   /* Chrome, Firefox 16+, IE 10+, Opera */
   }
   #loader:after {
   content: "";
   position: absolute;
   top: 15px;
   left: 15px;
   right: 15px;
   bottom: 15px;
   border-radius: 50%;
   border: 3px solid transparent;
   border-top-color: #f9c922;
   -webkit-animation: spin 1.5s linear infinite;
   /* Chrome, Opera 15+, Safari 5+ */
   animation: spin 1.5s linear infinite;
   /* Chrome, Firefox 16+, IE 10+, Opera */
   }
   @-webkit-keyframes spin {
   0% {
   -webkit-transform: rotate(0deg);
   /* Chrome, Opera 15+, Safari 3.1+ */
   -ms-transform: rotate(0deg);
   /* IE 9 */
   transform: rotate(0deg);
   /* Firefox 16+, IE 10+, Opera */
   }
   100% {
   -webkit-transform: rotate(360deg);
   /* Chrome, Opera 15+, Safari 3.1+ */
   -ms-transform: rotate(360deg);
   /* IE 9 */
   transform: rotate(360deg);
   /* Firefox 16+, IE 10+, Opera */
   }
   }
   @keyframes spin {
   0% {
   -webkit-transform: rotate(0deg);
   /* Chrome, Opera 15+, Safari 3.1+ */
   -ms-transform: rotate(0deg);
   /* IE 9 */
   transform: rotate(0deg);
   /* Firefox 16+, IE 10+, Opera */
   }
   100% {
   -webkit-transform: rotate(360deg);
   /* Chrome, Opera 15+, Safari 3.1+ */
   -ms-transform: rotate(360deg);
   /* IE 9 */
   transform: rotate(360deg);
   /* Firefox 16+, IE 10+, Opera */
   }
   }
</style>
@endsection @section('content') 
{{-- @component('components.breadcrumb') @slot('li_1') Dashboards @endslot @slot('title') Dashboard @endslot @endcomponent --}}
<div class="row">
   <div class="col">
      <div class="h-100">
         <!--end row-->
         @include('dashboard.stats')
         @include('dashboard.widgets')
         @include('dashboard.smsbalance')
         <br>
         <div class="row">
            <div class="col-12">
               <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                  <h4 class="mb-sm-0 font-size-16 text-muted">System resources</h4>
                  <div class="page-title-right">
                     <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">Server status</li>
                     </ol>
                  </div>
               </div>
            </div>
         </div>
         <!--end row-->
         @include('dashboard.server_resources')
         <br>
         <!-- Financial overview -->
         <div class="row">
            <div class="col-12">
               <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                  <h4 class="mb-sm-0 font-size-16 text-muted">Financial overview</h4>
                  <div class="page-title-right">
                     <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">Last 3 months</li>
                     </ol>
                  </div>
               </div>
            </div>
         </div>
         @include('dashboard.revenue_overview')
         {{config('mail.host')}}
      </div>
      <!-- end .h-100-->
   </div>
   <!-- end col -->
</div>
<div class="row">
   <div class="col-md-6">
      <div class="card">
         <div class="card-header">
            <h4 class="card-title mb-0">3 months revenue</h4>
         </div>
         <!-- end card header -->
         <div class="card-body">
            <div id="revenue_pie_chart" data-colors='["--vz-primary", "--vz-success", "--vz-warning", "--vz-danger", "--vz-info", "--vz-dark"]' class="apex-charts" dir="ltr"></div>
         </div>
         <!-- end card-body -->
      </div>
      <!-- end card -->
   </div>
   <div class="col-md-6">
      <div class="card">
         <div class="card-header">
            <h4 class="card-title mb-0">Service Utilization</h4>
         </div>
         <!-- end card header -->
         <div class="card-body">
            <div id="service_pie_chart" data-colors='["--vz-primary", "--vz-success", "--vz-warning", "--vz-danger", "--vz-info", "--vz-dark"]' class="apex-charts" dir="ltr"></div>
         </div>
         <!-- end card-body -->
      </div>
      <!-- end card -->
   </div>
</div>
@php
$sumpaid = [];
$months = [];
foreach($transactions as $transaction){
$months[] = $transaction->months;
$sumpaid[] = $transaction->sum;
}
@endphp
@endsection @section('script')
<!-- apexcharts -->
<script src="{{ URL::asset('/assets/libs/apexcharts/apexcharts.min.js') }}"></script>
<script src="{{ URL::asset('/assets/libs/jsvectormap/jsvectormap.min.js') }}"></script>
<script src="{{ URL::asset('assets/libs/swiper/swiper.min.js')}}"></script>
<!-- dashboard init -->
{{-- <script src="{{ URL::asset('/assets/js/pages/dashboard-ecommerce.init.js') }}"></script> --}}
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
<script src="{{ URL::asset('/assets/js/jquery-3.6.1.js')}}"></script>
<script src="{{ URL::asset('/assets/libs/apexcharts/apexcharts.min.js')}}"></script>
<script>
   $(document).ready(function () {
       setInterval(function () {
           $.ajax({
               url: "{{route('dashboard')}}",
               type: "GET",
               dataType: "json",
               success: function (response) {
                   // Get and set variables for use
                   var totaldata = response.totaldata;
                   var onlinesessions = response.onlinesessions;
                   var cpuload = response.cpuload;
                   var services = response.services;
                   var upload = response.totalupload;
                   var download = response.totaldownload;
                   var payments = response.payments;
                   var monthpayments = response.monthpayments;
                   var loadtime = response.loadtime;
                   var inactive = response.inactive;
                   var totalclients = response.totalclients;
                   // auto update total clients
                   $("#totalclients").empty();
                   $("#totalclients").append(totalclients);
                   // Auto update consumed data section
                   $("#consumed_data").empty();
                   $("#consumed_data").append(totaldata);
                   // Auto update onlinesessions data sections
                   $("#onlinesessions").empty();
                   $("#onlinesessions").append(onlinesessions);
                   $("#online").empty();
                   $("#online").append(onlinesessions);
                   // Auto update cpu usage data section
                   $("#cpuload").empty();
                   $("#cpuload").append(cpuload);
                   document.getElementById('cpu_progress').style.width = cpuload+'%';
                   // Auto update active services data section
                   $("#activeservices").empty();
                   $("#activeservices").append(services);
                   // Auto update upload and download section
                   $("#upload").empty();
                   $("#upload").append(upload);
                   $("#download").empty();
                   $("#download").append(download);
                   // Auto update the payments
                   $("#payments").empty();
                   $("#payments").append(payments);
                   $("#monthpayments").empty();
                   $("#monthpayments").append(monthpayments);
                   // Auto update load time
                   $("#loadtime").empty();
                   $("#loadtime").append(loadtime);
                   // auto update inactive clients
                   $("#inactiveservices").empty();
                   $("#inactiveservices").append(inactive);
   
               },
               error: function (err) {},
           });
       }, 5000);
   });
</script>
<script>
   var _options;
   
   function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }
   
   // get colors array from the string
   function getChartColorsArray(chartId) {
     if (document.getElementById(chartId) !== null) {
       var colors = document.getElementById(chartId).getAttribute("data-colors");
       colors = JSON.parse(colors);
       return colors.map(function (value) {
         var newValue = value.replace(" ", "");
   
         if (newValue.indexOf(",") === -1) {
           var color = getComputedStyle(document.documentElement).getPropertyValue(newValue);
           if (color) return color;else return newValue;
           ;
         } else {
           var val = value.split(',');
   
           if (val.length == 2) {
             var rgbaColor = getComputedStyle(document.documentElement).getPropertyValue(val[0]);
             rgbaColor = "rgba(" + rgbaColor + "," + val[1] + ")";
             return rgbaColor;
           } else {
             return newValue;
           }
         }
       });
     }
   } //  Simple Pie Charts
   
   
   var chartPieBasicColors = getChartColorsArray("revenue_pie_chart");
   var options = {
     series: <?php echo (json_encode($sumpaid, JSON_NUMERIC_CHECK)); ?>,
     chart: {
       height: 300,
       type: 'pie'
     },
     labels: <?php echo(json_encode($months)); ?>,
     legend: {
       position: 'bottom'
     },
     dataLabels: {
       dropShadow: {
         enabled: false
       }
     },
     colors: chartPieBasicColors
   };
   var chart = new ApexCharts(document.querySelector("#revenue_pie_chart"), options);
   chart.render(); 
   
   var chartPieBasicColors = getChartColorsArray("service_pie_chart");
   var options = {
     series: <?php echo(json_encode($packageservices)); ?>,
     chart: {
       height: 300,
       type: 'pie'
     },
     labels: <?php echo(json_encode($packagenames)); ?>,
     legend: {
       position: 'bottom'
     },
     dataLabels: {
       dropShadow: {
         enabled: false
       }
     },
     colors: chartPieBasicColors
   };
   var chart = new ApexCharts(document.querySelector("#service_pie_chart"), options);
   chart.render(); 
</script>
@endsection