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
         <div class="row">
            <div class="col-xl-12">
               <div class="card crm-widget">
                  <div class="card-body p-0">
                     <div class="row row-cols-xxl-3 row-cols-md-3 row-cols-2 g-0">
                        <div class="col col-small">
                           <div class="py-4 px-3">
                              <h5 class="text-muted text-uppercase fs-13">All Clients <i class="ri-user-2-fill text-info fs-18 float-end align-middle"></i></h5>
                              <div class="d-flex align-items-center">
                                 <div class="flex-shrink-0">
                                    <i class="ri-team-fill display-6 text-info"></i>
                                 </div>
                                 <div class="flex-grow-1 ms-3">
                                    <h2 class="mb-0"><span id="totalclients">{{$total_clients}}</span></h2>
                                 </div>
                                 <a href="{{route('client.index')}}" class="text-muted d-none d-md-block">View clients</a>
                                 <a href="{{route('client.index')}}" class="text-muted d-md-none">View</a>
                              </div>
                           </div>
                        </div>
                        <!-- end col -->
                        <div class="col">
                           <div class="mt-md-0 py-4 px-3">
                              <h5 class="text-muted text-uppercase fs-13">Online Sessions <i class="ri-wifi-fill text-success fs-18 float-end align-middle"></i></h5>
                              <div class="d-flex align-items-center">
                                 <div class="flex-shrink-0">
                                    <i class="ri-pulse-line display-6 text-success"></i>
                                 </div>
                                 <div class="flex-grow-1 ms-3">
                                    <h2 class="mb-0"><span id="onlinesessions">{{$onlinesessions}}</span></h2>
                                 </div>
                                 <a href="{{route('client.online')}}" class="text-muted d-none d-md-block">View Sessions</a>
                                 <a href="{{route('client.online')}}" class="text-muted d-md-none">View</a>
                              </div>
                           </div>
                        </div>
                        <!-- end col -->
                        <div class="col col-last col-small">
                           <div class="mt-md-0 py-4 px-3">
                              <h5 class="text-muted text-uppercase fs-13">Active Services <i class="ri-shut-down-fill text-primary fs-18 float-end align-middle"></i></h5>
                              <div class="d-flex align-items-center">
                                 <div class="flex-shrink-0">
                                    <i class="ri-space-ship-line display-6 text-primary"></i>
                                 </div>
                                 <div class="flex-grow-1 ms-3">
                                    <h2 class="mb-0"><span id="activeservices">{{$services}}</span></h2>
                                 </div>
                                 <a href="{{route('client.service.active')}}" class="text-muted d-none d-md-block">View all</a>
                                 <a href="{{route('client.service.active')}}" class="text-muted d-md-none">View</a>
                              </div>
                           </div>
                        </div>
                        <!-- end col -->
                        <div class="col">
                           <div class="mt-md-0 py-4 px-3">
                              <h5 class="text-muted text-uppercase fs-13">Inactive Services <i class="ri-shut-down-fill text-danger fs-18 float-end align-middle"></i></h5>
                              <div class="d-flex align-items-center">
                                 <div class="flex-shrink-0">
                                    <i class="ri-arrow-left-down-fill display-6 text-danger"></i>
                                 </div>
                                 <div class="flex-grow-1 ms-3">
                                    <h2 class="mb-0"><span id="inactiveservices">{{$inactiveservices}}</span></h2>
                                 </div>
                                 <a href="{{route('client.service.inactive')}}" class="text-muted d-none d-md-block">View all</a>
                                 <a href="{{route('client.service.inactive')}}" class="text-muted d-md-none">View</a>
                              </div>
                           </div>
                        </div>
                        <!-- end col -->
                        <div class="col col-small no-bottom">
                           <div class="mt-md-0 py-4 px-3">
                              <h5 class="text-muted text-uppercase fs-13">Consumed data [24h] <i class="ri-database-2-fill text-warning fs-18 float-end align-middle"></i></h5>
                              <div class="d-flex align-items-center">
                                 <div class="flex-shrink-0">
                                    <i class="ri-stack-fill display-6 text-warning"></i>
                                 </div>
                                 <div class="flex-grow-1 ms-3">
                                    <h3 class="mb-0"><span id="consumed_data">{{$totaldata}}</span></h3>
                                    <span class="nowrap"> <i class="ri-arrow-up-circle-line text-muted align-middle"></i> <span id="upload" class="text-muted"> {{$totalupload}}</span></span>
                                    <span class="nowrap"> <i class="ri-arrow-down-circle-line text-muted align-middle"></i> <span id="download" class="text-muted"> {{$totaldownload}}</span></span>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <!-- end col -->
                        <div class="col col-last no-bottom">
                           <div class="py-4 px-3">
                              <h5 class="text-muted text-uppercase fs-13">Payments today<i class="ri-money-dollar-circle-line text-info fs-18 float-end align-middle"></i></h5>
                              <div class="d-flex align-items-center">
                                 <div class="flex-shrink-0">
                                    <i class="ri-exchange-dollar-line display-6 text-info"></i>
                                 </div>
                                 <div class="flex-grow-1 ms-3">
                                    <h4 class="mb-0"><span id="payments">{{$payments}}</span></h4>
                                    <span class="text-muted"><span>This month:</span></span>
                                    <span class="text-muted"><span id="monthpayments">{{$monthpayments}}</span></span>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <!-- end col -->
                     </div>
                     <!-- end row -->
                  </div>
                  <!-- end card body -->
               </div>
               <!-- end card -->
            </div>
            <!-- end col -->
         </div>
         @if(setting("smsgateway") == 'africastalking')
         @if ($atsmsbalance)
         <div class="alert alert-success text-center" role="alert">
            Your SMS balance is <strong>{{ $atsmsbalance['value'] }}</strong> {{ $atsmsbalance['currency'] }}.
         </div>
         @else
         <div class="alert alert-danger" role="alert">
            Unable to fetch SMS balance.
         </div>
         @endif
         @endif
         <!-- HTML for the notification -->
         {{-- @php
         $releaseData = checkForUpdates();
         @endphp
         @if($releaseData['available'])
         <div id="update-notification" class="alert alert-warning text-center" role="alert">
            New version available.
            <h3>Release: {{ $releaseData['name'] }}</h3>
            <p>Version: {{ $releaseData['tag_name'] }}</p>
            <p>
               PUBLISHED:
               @if (is_array($releaseData) && array_key_exists('published_at', $releaseData))
               {{ $releaseData['published_at'] }}
               @else
               Release not found or invalid data format.
               @endif
            </p>
            <p>DESCRIPTION:</p>
            <p>{{ nl2br(e($releaseData['body'])) }}</p>
            <br>
            <button class="btn btn-soft-info" id="updateBtn">update</button>
         </div>
         @endif --}}
         <!-- show error message  -->
         @if (session('error'))
         <div class="alert alert-danger alert-dismissible alert-label-icon label-arrow fade show mb-xl-0" role="alert">
            <i class="ri-error-warning-line label-icon"></i><strong>Failed</strong>
            - {{session('error')}}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
         </div>
         <br />
         @endif
         @if (session('info'))
         <div class="alert alert-info alert-dismissible alert-label-icon label-arrow fade show mb-xl-0" role="alert">
            <i class="ri-error-warning-line label-icon"></i><strong>Failed</strong>
            - {{session('info')}}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
         </div>
         <br />
         @endif
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
         <div class="row">
            <div class="col-xl-12">
               <div class="card crm-widget">
                  <div class="card-body p-0">
                     <div class="row row-cols-xxl-4 row-cols-md-2 row-cols-2 g-0">
                        <!-- end col -->
                        <div class="col col-small">
                           <div class="mt-md-0 py-4 px-3">
                              <h5 class="text-muted text-uppercase fs-13">Cpu Usage <i class="ri-cpu-fill text-muted fs-18 float-end align-middle"></i></h5>
                              <div class="d-flex align-items-center">
                                 <div class="flex-shrink-0">
                                    <i class="ri-cpu-line display-6 text-muted"></i>
                                 </div>
                                 <div class="flex-grow-1 ms-3">
                                    <h3 class="mb-0"><span id="cpuload">{{$cpuload}}</span>%</h3>
                                    <div class="progress">
                                       <div id="cpu_progress" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="" aria-valuemax="100" style="width:{{$cpuload}}%"></div>
                                    </div>
                                 </div>
                                 <a class="text-muted">{{$operating_system}}</a>
                              </div>
                           </div>
                        </div>
                        <!-- end col -->
                        <div class="col col-last">
                           <div class="mt-md-0 py-4 px-3">
                              <h5 class="text-muted text-uppercase fs-13">Ram Usage <i class="ri-save-line text-info fs-18 float-end align-middle"></i></h5>
                              <div class="d-flex align-items-center">
                                 <div class="flex-shrink-0">
                                    <i class="ri-save-3-fill display-6 text-muted"></i>
                                 </div>
                                 <div class="flex-grow-1 ms-3">
                                    <h2 class="mb-0"><span id="memoryusage">{{$memused}}</span>GB</h2>
                                    <a class="text-muted">
                                    [Total: {{$memtotal}}Gb]
                                    </a>
                                 </div>
                                 <a  class="d-none d-md-block">Total {{$memtotal}}Gb</a>
                              </div>
                           </div>
                        </div>
                        <!-- end col -->
                        <div class="col col-small no-bottom">
                           <div class="mt-md-0 py-4 px-3">
                              <h5 class="text-muted text-uppercase fs-13">Disk Used  <i class="ri-hard-drive-2-line text-info fs-18 float-end align-middle"></i></h5>
                              <div class="d-flex align-items-center">
                                 <div class="flex-shrink-0">
                                    <i class="ri-hard-drive-2-line display-6 text-primary"></i>
                                 </div>
                                 <div class="flex-grow-1 ms-3">
                                    <h3 class="mb-0"><span id="diskusage">{{$diskused}}</span>GB</h3>
                                    <a class="text-muted">
                                    [{{$diskfree}}Gb free]
                                    </a>
                                 </div>
                                 <a class="d-none d-md-block">Total {{$disktotal}}Gb</a>
                              </div>
                           </div>
                        </div>
                        <!-- end col -->
                        <div class="col col-last no-bottom">
                           <div class="mt-md-0 py-4 px-3">
                              <h5 class="text-muted text-uppercase fs-13">Average Load time <i class="ri-loader-2-line text-info fs-18 float-end align-middle"></i></h5>
                              <div class="d-flex align-items-center">
                                 <div class="flex-shrink-0">
                                    <i class="ri-loader-2-line display-6 text-success"></i>
                                 </div>
                                 <div class="flex-grow-1 ms-3">
                                    <h2 class="mb-0"><span id="loadtime">{{$total_time}}</span>sec</h2>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <!-- end col -->
                        <!-- end col -->
                     </div>
                     <!-- end row -->
                  </div>
                  <!-- end card body -->
               </div>
               <!-- end card -->
            </div>
            <!-- end col -->
         </div>
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
         <div class="row ">
            @php
            // initialize it with 0
            $counter = 0;
            // Loop starts from here
            foreach ($transactions as $item) { 
            // Check condition if count is 0 then
            // it is the first iteration
            // then it is last iteration
            if( $counter == count( $transactions ) - 1) { 
            // Print the array content
            $previous = $item->sum;
            } 
            $counter = $counter + 1;
            }
            @endphp
            @foreach($transactions as $transaction)
            @php
            $percentage = ($transaction->sum - $previous)/$previous *100;
            @endphp
            <div class="col-lg-4 col-md-6">
               <div class="card">
                  <div class="card-body">
                     <div class="d-flex align-items-center">
                        <div class="avatar-sm flex-shrink-0">
                           <span class="avatar-title bg-light text-primary rounded-circle fs-3">
                           <i class="ri-money-dollar-circle-fill align-middle"></i>
                           </span>
                        </div>
                        <div class="flex-grow-1 ms-3">
                           <p class="text-uppercase fw-semibold fs-12 text-muted mb-1">
                              {{$transaction->months}}
                           </p>
                           <h5 class=" mb-0"> Ksh <span class="counter-value" data-target="{{$transaction->sum}}"> {{$transaction->sum}}</span></h5>
                        </div>
                        <div class="flex-shrink-0 align-self-end">
                           @if($transaction->sum == $previous)
                           @elseif($transaction->sum > $previous)
                           <span class="badge badge-soft-success badge-percentage"><i class="ri-arrow-up-s-fill align-middle me-1"></i>{{floor($percentage)}}
                           %<span>
                           @else
                           <span class="badge badge-soft-danger badge-percentage"><i class="ri-arrow-down-s-fill align-middle me-1"></i>{{floor($percentage)}}
                           %<span>
                           @endif
                        </div>
                     </div>
                  </div>
                  <!-- end card body -->
               </div>
               <!-- end card -->
            </div>
            @endforeach
            <!-- end col -->
         </div>
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