@extends('layouts.master')
@section('title') nas @endsection
@section('css')
<link href="{{URL::asset('assets/js/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{URL::asset('assets/css/datatable-custom.css')}}" rel="stylesheet" type="text/css" />

@endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Networking @endslot
@slot('title') Nas @endslot
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
      <div class="card">
         <div class="card-header border-bottom-dashed">
            <div class="d-flex align-items-center">
               <h5 class="card-title mb-0 flex-grow-1"><i class="ri-router-line text-info"></i> Nas devices</h5>
               <div class="flex-shrink-0">
               @can('create nas')
                  <a href="{{route('nas.create')}}" class="btn btn-soft-info add-btn"><i
                     class="ri-add-line align-bottom me-1"></i> Create Nas</a>
               @endcan
               </div>
            </div>
         </div>
         <div class="card-body pt-0">
            <div>
               @if(count($nas))
               <div class="table-responsive table-card mb-1">
                  <table class="table table-nowrap align-middle table-stripped" id="datatable" style="width:100%;">
                     <thead class="text-muted table-light">
                        <tr class="text-uppercase">
                           <th class="sort" data-sort="ip">Nas IP</th>
                           <th class="sort" data-sort="shortname">Shortname</th>
                           <th class="sort" data-sort="type">Type</th>
                           <th class="sort" data-sort="secret">Secret</th>
                           <th class="sort" data-sort="username">Username</th>
                           <th class="sort" data-sort="password">Password</th>
                           @can('configure nas')
                              @if(setting('simpleconfig') == 'enabled')
                                 <th class="sort" data-sort="configure">Configure</th>
                              @endif
                           @endcan
                           <th class="sort" data-sort="services">Services</th>
                           <th class="sort" data-sort="description">Description</th>
                           <th class="sort" data-sort="actions">Action</th>
                        </tr>
                     </thead>
                     <tbody class="list form-check-all">
                        @foreach($nas as $n)
                        <tr class="no-border">
                           <td><a href="#" class="fw-medium link-info">{{ $n->nasname }}</a></td>
                           <td>{{ $n->shortname }}</td>
                           <td>{{ $n->type }}</td>
                           <td>{{ preg_replace("/./", "*", $n->secret) }}</td>
                           <td>{{ $n->nasprofile->username }}</td>
                           <td>{{ preg_replace("/./", "*", $n->nasprofile->password) }}</td>
                           @can('configure nas')
                              @if(setting('simpleconfig') == 'enabled')
                                 <td>
                                       @php
                                          $configEnabled = $n->nasprofile->config == 1 && setting('nasreconfig') == 'enabled';
                                          $configDisabled = $n->nasprofile->config == 0;
                                          $route = route('nas.configLogin', ['nas' => $n->id]);
                                       @endphp

                                       @if($configEnabled)
                                          <a class="btn btn-success btn-sm" href="{{ $route }}">Reconfigure</a>
                                       @elseif($configDisabled)
                                          <a class="btn btn-primary btn-sm" href="{{ $route }}">Configure</a>
                                       @else
                                          <h3><i class="ri-checkbox-circle-fill text-success"></i></h3>
                                       @endif
                                 </td>
                              @endif
                           @endcan
                           <td><a href="{{route('nas.services',[$n->id])}}">{{count($n->services)}}&nbsp; &nbsp; <i class="ri-external-link-fill text-info"></i></a> </td>
                           <td>{{ $n->description }}</td>
                           <td>
                              <ul class="list-inline hstack gap-2 mb-0">
                                 {{-- 
                                 <li class="list-inline-item" data-bs-toggle="tooltip"
                                    data-bs-trigger="hover" data-bs-placement="top"
                                    title="View">
                                    <a href="javascript:;"
                                       class="text-primary d-inline-block" data-toggle="modal" data-id='{{$n->id}}' data-target="#deleteNas">
                                    <i class="ri-eye-fill fs-16"></i>
                                    </a>
                                 </li>
                                 --}}
                                 @can('update nas')
                                 <li class="list-inline-item edit"
                                    data-bs-toggle="tooltip" data-bs-trigger="hover"
                                    data-bs-placement="top" title="Edit">
                                    <a href="{{ route('nas.edit',['id'=>$n->id]) }}"
                                       class="text-primary d-inline-block edit-item-btn">
                                    <i class="ri-pencil-fill fs-16"></i>
                                    </a>
                                 </li>
                                 @endcan
                                 @can('delete nas')
                                 <li class="list-inline-item" data-bs-toggle="tooltip"
                                    data-bs-trigger="hover" data-bs-placement="top"
                                    title="Remove">
                                    <a class="text-danger d-inline-block remove-item-btn" data-bs-toggle="modal" data-id='{{$n->id}}' data-title='{{$n->shortname}}' href="#deleteItem">
                                    <i class="ri-delete-bin-5-fill fs-16"></i>
                                    </a>
                                 </li>
                                 @endcan
                                 <li class="list-inline-item" data-bs-toggle="tooltip"
                                    data-bs-trigger="hover" data-bs-placement="top"
                                    title="Nas details">
                                    <a href="#" class="text-info d-inline-block view-item-btn" data-bs-toggle="modal" data-bs-target="#nasModal{{$n->id}}">
                                    <i class="ri-eye-fill fs-16"></i>
                                    </a>
                                 </li>
                                 <li class="list-inline-item" data-bs-toggle="tooltip"
                                    data-bs-trigger="hover" data-bs-placement="top"
                                    title="Login">
                                    <a href="{{ route('nas.view',['id'=>$n->id]) }}" class="text-success d-inline-block view-item-btn" onclick="spinner()" >
                                    <i class="ri-login-circle-line fs-16"></i>
                                    </a>
                                 </li>
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
                     <h5 class="mt-2 text-danger">Sorry! No Nas device Found</h5>
                     <p class="text-muted mb-0">You have not added any nas device. You need atleast one to proceed</p>
                  </div>
               </div>
               @endif
            </div>
            <div class="modal fade" id="showModal" tabindex="-1"
               aria-labelledby="exampleModalLabel" aria-hidden="true">
               <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                     <div class="modal-header bg-light p-3">
                        <h5 class="modal-title" id="exampleModalLabel">New Nas</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                           aria-label="Close" id="close-modal"></button>
                     </div>
                     <form action="{{route('nas.create')}}" method="POST">
                        @csrf
                        <div class="modal-body">
                           <input type="hidden" id="id-field" />
                           <div class="mb-3" id="modal-id">
                              <label for="nasname" class="form-label">Nas Ip Address</label>
                              <input type="text" name="nasname" id="nasname" class="form-control @error('nasname') is-invalid @enderror"
                                 placeholder="Ip address" value="{{old('nasname')}}"/>
                              @error('nasname')
                              <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                           </div>
                           <div class="mb-3">
                              <label for="secret" class="form-label">Nas Secret
                              </label>
                              <input type="text" name="secret" id="secret"
                                 class="form-control @error('secret') is-invalid @enderror" placeholder="Nas secret" value="{{old('secret')}}"
                                 />
                              @error('secret')
                              <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                           </div>
                           <div class="mb-3">
                              <label for="secret" class="form-label">Nas Shortname
                              </label>
                              <input type="text" name="shortname" id="shortname"
                                 class="form-control @error('shortname') is-invalid @enderror" placeholder="Nas Shortname" value="{{old('shortname')}}"
                                 />
                              @error('shortname')
                              <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                           </div>
                        </div>
                        <div class="modal-footer">
                           <div class="hstack gap-2 justify-content-end">
                              <button type="button" class="btn btn-light"
                                 data-bs-dismiss="modal">Close</button>
                              <button type="submit" class="btn btn-success"
                                 id="add-btn">Save</button>
                           </div>
                        </div>
                     </form>
                  </div>
               </div>
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
                           <h4>You are about to delete <span class="modal-title"></span> Router?</h4>
                           <p class="text-muted fs-15 mb-4">Deleting your router will remove
                              all of
                              your information from the database.
                           </p>
                           <div class="hstack gap-2 justify-content-center remove">
                              <button
                                 class="btn btn-link link-success fw-medium text-decoration-none"
                                 data-bs-dismiss="modal"><i
                                 class="ri-close-line me-1 align-middle"></i>
                              Close</button>
                              <form action="{{route('nas.delete')}}" method="POST">
                                 @csrf
                                 <input type="hidden" name="id" id="id">
                                 <button type="submit" class="btn btn-danger">Yes delete it</button>
                              </form>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <!--end modal -->
            <!-- View nas details -->
            @foreach($nas as $n)
            <!-- Modal for NAS details -->
            <div class="modal fade" id="nasModal{{$n->id}}" tabindex="-1" aria-labelledby="nasModalLabel{{$n->id}}" aria-hidden="true">
               <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                    
                     

                     <div class="modal-header">
                        <h5 class="modal-title" id="nasModalLabel{{$n->id}}">NAS Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                     </div>
                     <div class="modal-body">
                        <div class="d-flex align-items-center mb-2">
                           <div class="flex-shrink-0">
                              <p class="text-muted mb-0">Nas Ip Address:</p>
                           </div>
                           <div class="flex-grow-1 ms-2">
                              <h6 class="mb-0">{{$n->nasname}}</h6>
                           </div>
                        </div>
                        <div class="d-flex align-items-center mb-2">
                           <div class="flex-shrink-0">
                              <p class="text-muted mb-0">Short Name:</p>
                           </div>
                           <div class="flex-grow-1 ms-2">
                              <h6 class="mb-0">{{$n->shortname}}</h6>
                           </div>
                        </div>
                        <div class="d-flex align-items-center mb-2">
                           <div class="flex-shrink-0">
                              <p class="text-muted mb-0">Secret:</p>
                           </div>
                           <div class="flex-grow-1 ms-2">
                              <h6 class="mb-0">{{$n->secret}}</h6>
                           </div>
                        </div>
                        <div class="d-flex align-items-center mb-2">
                           <div class="flex-shrink-0">
                              <p class="text-muted mb-0">Username:</p>
                           </div>
                           <div class="flex-grow-1 ms-2">
                              <h6 class="mb-0">{{$n->nasprofile->username}}</h6>
                           </div>
                        </div>
                        <div class="d-flex align-items-center mb-2">
                           <div class="flex-shrink-0">
                              <p class="text-muted mb-0">Password:</p>
                           </div>
                           <div class="flex-grow-1 ms-2">
                              <h6 class="mb-0">{{$n->nasprofile->password}}</h6>
                           </div>
                        </div>
                     </div>
                     {{-- <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                     </div> --}}
                  </div>
               </div>
            </div>
            @endforeach
         </div>
      </div>
   </div>
</div>
<!--end col-->
@if(count($nas))
<div class="row">
   <div class="col-xl-12">
      <div class="card">
         <div class="card-header">
            <h4 class="card-title mb-0">Service distribution</h4>
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
</div>
@endsection
@section('script')
<script src="{{ URL::asset('/assets/js/jquery-3.6.1.js')}}"></script>
<script src="{{ URL::asset('/assets/js/datatables/datatables.min.js') }}"></script>
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
<script src="{{ URL::asset('/assets/js/datatable.js') }}"></script>
<script src="{{ URL::asset('/assets/libs/apexcharts/apexcharts.min.js')}}"></script>
<script type="text/javascript">
    function spinner() {
        var loadingContainer = document.getElementById('loader-wrapper');
        loadingContainer.style.display = 'block';
    }
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
   
   
   var chartPieBasicColors = getChartColorsArray("simple_pie_chart");
   var options = {
     series: <?php echo(json_encode($services)); ?>,
     chart: {
       height: 300,
       type: 'pie'
     },
     labels: <?php echo(json_encode($routers)); ?>,
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