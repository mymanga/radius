@extends('layouts.master')
@section('title') templates @endsection
@section('css')
<link href="{{URL::asset('assets/js/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{URL::asset('assets/css/datatable-custom.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Company @endslot
@slot('title') Tarrifs @endslot
@endcomponent
<!-- .card-->
<div class="row">
   <div class="col-lg-12">
      @if (session('status'))
        <div class="alert alert-success alert-dismissible alert-label-icon label-arrow fade show" role="alert">
            <i class="ri-check-double-line label-icon"></i><strong>Success</strong> - {{session('status')}}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif @if (session('error'))
        <div class="alert alert-danger alert-dismissible alert-label-icon label-arrow fade show mb-xl-0" role="alert">
            <i class="ri-error-warning-line label-icon"></i><strong>Failed</strong>
            - {{session('error')}}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <br />
        @endif
      <div class="card" id="orderList">
         <div class="card-header border-bottom-dashed">
            <div class="d-flex align-items-center">
               <h5 class="card-title mb-0 flex-grow-1"><i class="ri-gps-line"></i> Internet tariffs</h5>
               <div class="flex-shrink-0">
                  @can('create tariff')
                     <a href="{{route('tariff.create')}}" class="btn btn-soft-info add-btn"><i
                        class="ri-add-line align-bottom me-1"></i> Create tariff</a>
                  @endcan
               </div>
            </div>
         </div>
         <div class="card-body pt-0">
            <div>
               @if(count($packages))
               <div class="table-responsive table-card mb-1">
                  <table class="table align-middle table-striped" id="datatable" style="width:100%;">
                     <thead class="text-muted table-light">
                        <tr class="text-uppercase">
                           <th>ID</th>
                           <th>Title</th>
                           <th>Agg</th>
                           <th>Price</th>
                           <th>Download</th>
                           <th>Upload</th>
                           <th>Services</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody class="list form-check-all">
                        @foreach($packages as $package)
                        <tr class="no-border">
                           <td>{{ $package->id }}</td>
                           <td><a class="fw-medium link-info">{{ $package->name }}</a></td>
                           <td> 1 : {{$package->aggregation}}</td>
                           <td>{{ number_format($package->price, 2) }} Ksh</td>
                           <td>{{ number_format($package->download) }} kbps</td>
                           <td>{{ number_format($package->upload) }} kbps</td>
                           <td><a class="fw-medium link-info">{{ count($package->services->where('is_active',1)) }} </a></td>
                           <td>
                              <ul class="list-inline hstack gap-2 mb-0">
                                 @can('update tariff')
                                    <li class="list-inline-item edit"
                                       data-bs-toggle="tooltip" data-bs-trigger="hover"
                                       data-bs-placement="top" title="Edit">
                                       <a href="{{ route('tariff.edit',[$package->id]) }}"
                                          class="text-primary d-inline-block edit-item-btn">
                                       <i class="ri-pencil-fill fs-16"></i>
                                       </a>
                                    </li>
                                 @endcan
                                 @can('delete tariff')
                                    <li class="list-inline-item" data-bs-toggle="tooltip"
                                       data-bs-trigger="hover" data-bs-placement="top"
                                       title="Remove">
                                       <a class="text-danger d-inline-block remove-item-btn" data-bs-toggle="modal" data-id='{{$package->id}}' data-title='{{$package->name}}' href="#deleteItem">
                                       <i class="ri-delete-bin-5-fill fs-16"></i>
                                       </a>
                                       </a>
                                    </li>
                                 @endcan
                              </ul>
                           </td>
                        </tr>
                        @endforeach
                     </tbody>
                  </table>
               </div>
               @else
               <div class="noresult" style="display: block;">
                  <div class="text-center">
                     <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop" colors="primary:#121331,secondary:#08a88a" style="width:75px;height:75px">
                     </lord-icon>
                     <h5 class="mt-2 text-danger">Sorry! No Tariff Found</h5>
                     <p class="text-muted mb-0">You have not added any tariff yet</p>
                  </div>
               </div>
               @endif
            </div>
            <!-- Modal -->
            <div class="modal fade flip" id="deleteItem" tabindex="-1" aria-hidden="true">
               <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                     <div class="modal-body p-5 text-center">
                        <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json"
                           trigger="loop" colors="primary:#405189,secondary:#f06548"
                           style="width:90px;height:90px"></lord-icon>
                        <div class="mt-4 text-center">
                           <h4>You are about to delete <span class="modal-title"></span> package?</h4>
                           <p class="text-muted fs-15 mb-4">Deleting the package will remove
                              all of
                              the information from the database.
                           </p>
                           <div class="hstack gap-2 justify-content-center remove">
                              <button
                                 class="btn btn-link link-success fw-medium text-decoration-none"
                                 data-bs-dismiss="modal"><i
                                 class="ri-close-line me-1 align-middle"></i>
                              Close</button>
                              <form action="{{route('tariff.delete')}}" method="POST">
                                 @csrf
                                 <input type="hidden" name="id" id="id">
                                 <button type="submit" class="btn btn-danger">Yes delete it</button>
                              </form>
                              {{-- <a href="" class="btn btn-danger" id="delete-record">Yes Delete it</a> --}}
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <!--end modal -->
         </div>
      </div>
   </div>
   <!--end col-->
</div>

@if(count($packages))
   <div class="row">
   <div class="col-xl-12">
      <div class="card">
         <div class="card-header">
            <h4 class="card-title mb-0">Service utilization</h4>
         </div>
         <!-- end card header -->
         <div class="card-body">
            <div id="simple_pie_chart" data-colors='["--vz-primary", "--vz-success", "--vz-warning", "--vz-danger", "--vz-info", "--vz-dark"]' class="apex-charts" dir="ltr"></div>
         </div>
         <!-- end card-body -->
      </div>
      <!-- end card -->
   </div>
</div>
@endif

<!-- end col -->
@endsection
@section('script')
<script src="{{ URL::asset('/assets/js/jquery-3.6.1.js')}}"></script>
<script src="{{ URL::asset('/assets/js/datatables/datatables.min.js') }}"></script>
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
<script src="{{ URL::asset('/assets/js/datatable.js') }}"></script>
<script src="{{ URL::asset('/assets/libs/apexcharts/apexcharts.min.js')}}"></script>
{{-- <script src="{{ URL::asset('/assets/js/pages/apexcharts-pie.init.js')}}"></script> --}}
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


var chartPieBasicColors = getChartColorsArray("simple_pie_chart");
var options = {
  series: <?php echo(json_encode($services)); ?>,
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
var chart = new ApexCharts(document.querySelector("#simple_pie_chart"), options);
chart.render(); 
</script>
@endsection