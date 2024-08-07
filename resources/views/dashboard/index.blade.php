@extends('layouts.master') @section('title') @lang('translation.dashboard') @endsection @section('css')
<link href="assets/libs/jsvectormap/jsvectormap.min.css" rel="stylesheet" type="text/css" />
<link href="assets/libs/swiper/swiper.min.css" rel="stylesheet" type="text/css" />
<!-- Include SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.css">
@endsection @section('content') 
{{-- @component('components.breadcrumb') @slot('li_1') Dashboards @endslot @slot('title') Dashboard @endslot @endcomponent --}}
<div class="row">
   <div class="col">
      <div class="h-100">
      
         {{-- {{ Carbon\Carbon::now()->addMonth()->format("Y-m-d") }} --}}
         <!--end row-->
         @include('dashboard.stats')
         @include('dashboard.widgets')
         @include('dashboard.smsbalance')
         @if(isset($updateData['version']) && isUpdateAvailable($updateData['version'], env('VERSION_INSTALLED')))
            @include('dashboard.update')
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
         @include('dashboard.server_resources')
         @can('view financial statistics')
         <br>
         <!-- Financial overview -->
         <div class="row">
            <div class="col-12">
               <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                  <h4 class="mb-sm-0 font-size-16 text-muted">Financial overview</h4>
                  <div class="page-title-right">
                     <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">Last 4 months</li>
                     </ol>
                  </div>
               </div>
            </div>
         </div>
         @include('dashboard.revenue_overview')
         @endcan
      </div>
      <!-- end .h-100-->
   </div>
   <!-- end col -->
</div>
<div class="row">
   @can('view financial statistics')
   <div class="col-md-6">
      <div class="card card-height-100">
         <div class="card-header">
            <h4 class="card-title mb-0">4 months revenue</h4>
         </div>
         <!-- end card header -->
         <div class="card-body">
            <div id="revenue_bar_chart" data-colors='["--vz-primary", "--vz-success", "--vz-warning", "--vz-danger", "--vz-info", "--vz-dark"]' class="apex-charts" dir="ltr"></div>
         </div>
         <!-- end card-body -->
      </div>
      <!-- end card -->
   </div>
   @endcan

   <div class="{{ auth()->user()->can('view financial statistics') ? 'col-md-6' : 'col-md-12' }}">
      <div class="card card-height-100">
         <div class="card-header">
            <h4 class="card-title mb-0">Service Utilization</h4>
         </div>
         <!-- end card header -->
         <div class="card-body">
         <div id="service_pie_chart" data-colors='["--vz-primary", "--vz-success", "--vz-warning", "--vz-danger", "--vz-info", "--vz-purple", "--vz-pink", "--vz-gray"]' class="apex-charts" dir="ltr"></div>
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
<!-- <script src="{{ URL::asset('/assets/libs/apexcharts/apexcharts.min.js') }}"></script> -->
<script src="{{ URL::asset('/assets/libs/jsvectormap/jsvectormap.min.js') }}"></script>
<script src="{{ URL::asset('assets/libs/swiper/swiper.min.js')}}"></script>
<!-- dashboard init -->
{{-- <script src="{{ URL::asset('/assets/js/pages/dashboard-ecommerce.init.js') }}"></script> --}}
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
<script src="{{ URL::asset('/assets/js/jquery-3.6.1.js')}}"></script>
<script src="{{ URL::asset('/assets/libs/apexcharts/apexcharts.min.js')}}"></script>
<script src="{{ URL::asset('/assets/js/dashboard/dashboard.js')}}"></script>
<script>
   fetchDashboardStats("{{route('dashboard.stats')}}");
</script>
<script src="{{ URL::asset('/assets/js/dashboard/dashboardCharts.js') }}"
   data-sumpaid="{{ json_encode($sumpaid, JSON_NUMERIC_CHECK) }}"
   data-months="{{ json_encode($months) }}"
   data-packageservices="{{ json_encode($packageservices) }}"
   data-packagenames="{{ json_encode($packagenames) }}"></script>
@endsection