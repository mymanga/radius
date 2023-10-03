@extends('layouts.master')
@section('title') Components @endsection
@section('css')
<link href="{{URL::asset('assets/js/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{URL::asset('assets/css/datatable-custom.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') System @endslot
@slot('title') Components @endslot
@endcomponent
<!-- .card-->
<div class="row">
   <div class="col-lg-12">
   @if (session('status'))
      <div class="alert alert-success alert-dismissible alert-label-icon label-arrow fade show" role="alert">
         <i class="ri-check-double-line label-icon"></i><strong>Success</strong> - {{session('status')}}
         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      <!-- show error message  -->
      @endif
   </div>
   <div class="col-xl-4 col-md-6">
      <div class="card card-height-100">
         <div class="card-body">
            {{-- <div class="dropdown float-end">
               <a class="text-reset dropdown-btn" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
               <span class="text-muted fs-18"><i class="mdi mdi-dots-vertical"></i></span>
               </a>
               <div class="dropdown-menu dropdown-menu-end" style="">
                  <a class="dropdown-item" href="#!">Favorite</a>
                  <a class="dropdown-item" href="#!">Apply Now</a>
               </div>
            </div> --}}
            <div class="mb-4 pb-2">
               <img src="{{ asset('assets/images/vpn.png') }}" alt="" class="avatar-sm">
            </div>
            <a href="#!">
               <h6 class="fs-15 fw-semibold">Vpn server <span class="text-muted fs-13">[{{ $openvpnVersion }}]</span></h6>
            </a>
            <p class="text-muted mb-0">
               @if(isset($openvpnStatus) && !empty($openvpnStatus))
            <ul>
               {{-- Loop through the status information and display each item --}}
               @foreach($openvpnStatus as $key => $value)
               <li><strong>{{ $key }}:</strong> {{ $value }}</li>
               @endforeach
            </ul>
            {{-- Check the "Active" status and display whether the service is running or stopped --}}
            @if(isset($openvpnStatus['Active']) && strpos($openvpnStatus['Active'], 'exited') !== false)
            <b><span class="text-success">Service is running</span></b>
            @if(preg_match("/since (.*?);/", $openvpnStatus['Active'], $matches))
            @php
            // Parse the extracted datetime string using Carbon
            $lastRestart = \Carbon\Carbon::parse($matches[1]);
            // Calculate the difference for humans
            $diffForHumans = $lastRestart->diffForHumans();
            // Format the exact datetime
            $formattedDateTime = $lastRestart->format('Y-m-d H:i:s');
            @endphp
            <p>Last Restart: <b>{{ $formattedDateTime }} <br> ({{ $diffForHumans }})</b></p>
            @endif
            @elseif(isset($openvpnStatus['Active']))
            <b><span class="text-danger">Service is stopped</span></b>
            @else
            <b><span class="text-warning">Service status unknown</span></b>
            @endif
            @else
            <p>Unable to retrieve OpenVPN status information.</p>
            @endif
            </p>
            
         </div>
         <div class="card-footer">
         <!-- Restart OpenVPN -->
            <form id="restartOpenVpnForm" action="{{ route('restart.openvpn') }}" method="POST">
               @csrf
               <button type="button" class="btn btn-warning btn-sm" onclick="confirmRestart('restartOpenVpnForm')">Restart OpenVPN</button>
            </form>
         </div>
      </div>
   </div>
   <div class="col-xl-4 col-md-6">
      <div class="card card-height-100">
         <div class="card-body">
            {{-- <div class="dropdown float-end">
               <a class="text-reset dropdown-btn" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
               <span class="text-muted fs-18"><i class="mdi mdi-dots-vertical"></i></span>
               </a>
               <div class="dropdown-menu dropdown-menu-end">
                  <a class="dropdown-item" href="#!">Favorite</a>
                  <a class="dropdown-item" href="#!">Apply Now</a>
               </div>
            </div> --}}
            <div class="mb-4 pb-2">
               <img src="{{ asset('assets/images/freeradius.png') }}" alt="" class="avatar-sm">
            </div>
            <a href="#!">
               <h6 class="fs-15 fw-semibold">Radius server <span class="text-muted fs-13">[{{ $freeradiusVersion }}]</span></h6>
            </a>
            <p class="text-muted mb-0">
               @if(isset($freeradiusStatus) && !empty($freeradiusStatus))
            <ul>
               {{-- Loop through the status information and display each item --}}
               @foreach($freeradiusStatus as $key => $value)
               <li><strong>{{ $key }}:</strong> {{ $value }}</li>
               @endforeach
            </ul>
            @if(isset($freeradiusStatus['Active']) && strpos($freeradiusStatus['Active'], 'running') !== false)
            <b><span class="text-success">Service is running</span></b>
            @if(preg_match("/since (.*?);/", $freeradiusStatus['Active'], $matches))
            @php
            // Parse the extracted datetime string using Carbon
            $lastRestart = \Carbon\Carbon::parse($matches[1]);
            // Calculate the difference for humans
            $diffForHumans = $lastRestart->diffForHumans();
            // Format the exact datetime
            $formattedDateTime = $lastRestart->format('Y-m-d H:i:s');
            @endphp
            <p>Last Restart: <b>{{ $formattedDateTime }} <br> ({{ $diffForHumans }})</b></p>
            @endif
            @elseif(isset($freeradiusStatus['Active']))
            <b><span class="text-danger">Service is stopped</span></b>
            @else
            <b><span class="text-warning">Service status unknown</span></b>
            @endif
            @else
            <p>Unable to retrieve Radius status information.</p>
            @endif
            </p>
            
         </div>
         <div class="card-footer">
         <!-- Restart FreeRADIUS -->
            <form id="restartFreeRadiusForm" action="{{ route('restart.freeradius') }}" method="POST">
               @csrf
               <button type="button" class="btn btn-warning btn-sm" onclick="confirmRestart('restartFreeRadiusForm')">Restart FreeRADIUS</button>
            </form>
         </div>
      </div>
   </div>
   <div class="col-xl-4 col-md-6">
      <div class="card card-height-100 shadow-none bg-opacity-10">
         <div class="card-body">
            {{-- <div class="dropdown float-end">
               <a class="text-reset dropdown-btn" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
               <span class="text-muted fs-18"><i class="mdi mdi-dots-vertical"></i></span>
               </a>
               <div class="dropdown-menu dropdown-menu-end">
                  <a class="dropdown-item" href="#!">Favorite</a>
                  <a class="dropdown-item" href="#!">Apply Now</a>
               </div>
            </div> --}}
            <div class="mb-4 pb-2">
               <img src="{{ asset('assets/images/supervisor.png') }}" alt="" class="avatar-sm">
            </div>
            <a href="#!">
               <h6 class="fs-15 fw-semibold">Supervisor <span class="text-muted fs-13">[Supervisor version {{ $supervisorVersion }} is installed]</span></h6>
            </a>
            <p class="text-muted mb-0">
               @if(isset($supervisorStatus) && count($supervisorStatus) > 0)
            <ul>
               {{-- Loop through the status information and display each item --}}
               @foreach($supervisorMainStatus as $key => $value)
               <li><strong>{{ $key }}:</strong> {{ $value }}</li>
               @endforeach
            </ul>
            @if(isset($supervisorMainStatus['Active']) && strpos($supervisorMainStatus['Active'], 'running') !== false)
            <b><span class="text-success">Service is running</span></b>
            @if(preg_match("/since (.*?);/", $supervisorMainStatus['Active'], $matches))
            @php
            // Parse the extracted datetime string using Carbon
            $lastRestart = \Carbon\Carbon::parse($matches[1]);
            // Calculate the difference for humans
            $diffForHumans = $lastRestart->diffForHumans();
            // Format the exact datetime
            $formattedDateTime = $lastRestart->format('Y-m-d H:i:s');
            @endphp
            <p>Last Restart: <b>{{ $formattedDateTime }} <br> ({{ $diffForHumans }})</b></p>
            @endif
            @elseif(isset($supervisorMainStatus['Active']))
            <b><span class="text-danger">Service is stopped</span></b>
            @else
            <b><span class="text-warning">Service status unknown</span></b>
            @endif
            @else
            <p>Unable to retrieve Supervisor status information.</p>
            @endif
            </p>
            <button style="margin-bottom:20px" type="button" class="btn btn-soft-info btn-sm" data-bs-toggle="modal" data-bs-target="#supervisorServicesModal">
            View running Services
            </button>
            
         </div>
         <div class="card-footer">
         <!-- Restart Supervisor -->
            <form id="restartSupervisorForm" action="{{ route('restart.supervisor') }}" method="POST">
               @csrf
               <button type="button" class="btn btn-warning btn-sm" onclick="confirmRestart('restartSupervisorForm')">Restart Supervisor</button>
            </form>
         </div>
      </div>
   </div>
</div>
<!-- Supervisor Services Modal -->
<div class="modal fade" id="supervisorServicesModal" tabindex="-1" role="dialog" aria-labelledby="supervisorServicesModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
         <div class="modal-header p-3 bg-soft-info">
            <h5 class="modal-title" id="supervisorServicesModalLabel">Supervisor Services</h5>
             <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
         </div>
         <div class="modal-body">
            <ul class="supervisor-status-list">
               {{-- Loop through the Supervisor status information and display each item --}}
               @foreach($supervisorStatus as $process)
               <li>
                  <strong>Name:</strong> {{ $process['name'] }} <br>
                  <strong>Status:</strong> {{ $process['status'] }} <br>
                  <strong>PID:</strong> {{ $process['pid'] }} <br>
                  <strong>Uptime:</strong> {{ $process['uptime'] }}
               </li>
               @endforeach
            </ul>
         </div>
      </div>
   </div>
</div>
@endsection
@section('script')
<script src="{{ URL::asset('/assets/js/jquery-3.6.1.js')}}"></script>
<script src="{{ URL::asset('/assets/js/datatables/datatables.min.js') }}"></script>
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
<script src="{{ URL::asset('/assets/js/datatable.js') }}"></script>
<script src="{{ URL::asset('/assets/libs/apexcharts/apexcharts.min.js')}}"></script>
<!-- SweetAlert2 -->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
   function confirmRestart(formId) {
       Swal.fire({
           title: 'Are you sure?',
           text: "You are about to restart the service!",
           icon: 'warning',
           showCancelButton: true,
           confirmButtonColor: '#3085d6',
           cancelButtonColor: '#d33',
           confirmButtonText: 'Yes, restart it!'
       }).then((result) => {
           if (result.isConfirmed) {
               Swal.fire({
                   title: 'Restarting...',
                   text: 'Please wait while the service is being restarted.',
                   allowOutsideClick: false,
                   didOpen: () => {
                       Swal.showLoading();
                       document.getElementById(formId).submit();
                   }
               });
           }
       });
   }
</script>
@endsection