@extends('layouts.master') @section('title') hotspot @endsection @section('css')
<link href="{{URL::asset('assets/js/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{URL::asset('assets/css/datatable-custom.css')}}" rel="stylesheet" type="text/css" />
@endsection @section('content') 
{{-- @component('components.breadcrumb') @slot('li_1') Networking @endslot @slot('title') Hotspot @endslot @endcomponent --}}
<div class="page-title-box d-sm-flex align-items-center justify-content-between">
   <h4 class="mb-sm-0 font-size-18">Hotspot</h4>
   <div class="page-title-right">
      <ol class="breadcrumb m-0">
         <li class="breadcrumb-item"><a href="#">Networking</a></li>
         <li class="breadcrumb-item active"><a href="{{ route('hotspot.index') }}">Hotspot</a></li>
      </ol>
   </div>
</div>
<div class="row">
   <div class="col">
      <div class="h-100">
         <div class="row">
            <div class="col-xl-12">
               <div class="card crm-widget">
                  <div class="card-body p-0">
                     <div class="row row-cols-xxl-3 row-cols-md-3 row-cols-1 g-0">
                        <div class="col col-small">
                           <div class="py-4 px-3">
                              <h5 class="text-muted text-uppercase fs-13">Active Vouchers<i class="ri-user-2-fill text-info fs-18 float-end align-middle"></i></h5>
                              <div class="d-flex align-items-center">
                                 <div class="flex-shrink-0">
                                    <i class="ri-team-fill display-6 text-info"></i>
                                 </div>
                                 <div class="flex-grow-1 ms-3">
                                    <h2 class="mb-0"><span id="activevouchers">{{$active_vouchers}}</span></h2>
                                 </div>
                                 <a href="{{route('voucher.index')}}" class="text-muted d-none d-md-block">View Vouchers</a>
                                 <a href="{{route('voucher.index')}}" class="text-muted d-md-none">Vouchers</a>
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
                                 <a href="#" class="text-muted d-none d-md-block">Total Connected</a>
                                 <a href="#" class="text-muted d-md-none">Connected</a>
                              </div>
                           </div>
                        </div>
                        <!-- end col -->
                        <div class="col col-small no-bottom">
                           <div class="mt-md-0 py-4 px-3">
                              <h5 class="text-muted text-uppercase fs-13">Consumed data <small>[24h]</small> <i class="ri-database-2-fill text-warning fs-18 float-end align-middle"></i></h5>
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
                     </div>
                     <!-- end row -->
                  </div>
                  <!-- end card body -->
               </div>
               <!-- end card -->
            </div>
            <!-- end col -->
         </div>
      </div>
   </div>
</div>
<div class="row">
   <div class="col-lg-12">
      <div class="card" id="orderList">
         <div class="card-header border-bottom-dashed">
            <div class="d-flex align-items-center">
               <h5 class="card-title mb-0 flex-grow-1"><i class="ri-notification-badge-fill text-success"></i> Online Users</h5>
            </div>
         </div>
         <div class="card-body pt-0">
            <div>
               @if(count($sessions) > 0)
               <div class="table-responsive table-card mb-1" id="session-table">
                  <table class="table table-nowrap align-middle" id="datatable" style="width: 100%;">
                     <thead class="text-muted table-light">
                        <tr class="text-uppercase">
                           @foreach(['', 'Voucher', 'Ip address', 'Start Time', 'Download', 'Upload', 'Time online'] as $cell)
                           <th>{{ $cell }}</th>
                           @endforeach
                        </tr>
                     </thead>
                     <tbody class="list form-check-all">
                        @foreach($sessions as $session) 
                        @php
                        $voucher = \App\Models\Voucher::where('code', $session->username)->first();
                        $countdownDate = Carbon\Carbon::parse($voucher->expiration_time)->format('d M Y H:i');
                        @endphp
                        <tr class="no-border">
                           <td><span class="badge badge-soft-success text-uppercase">online</span></td>
                           <td>{{ $session->username }}</td>
                           <td>{{ $session->framedipaddress }}</td>
                           <td>{{ $session->acctstarttime ? Carbon\Carbon::parse($session->acctstarttime)->format('d M Y H:i') : 'Unknown' }}</td>
                           <td><i class="ri-download-2-fill text-info"></i> {{ formatSizeUnits($session->acctoutputoctets) }}</td>
                           <td><i class="ri-upload-2-fill text-info"></i> {{ formatSizeUnits($session->acctinputoctets) }}</td>
                           <td>{{ calculateSessionTime($session->acctsessiontime) }}</td>
                           {{-- 
                           <td style="font-size: 1.2em; font-weight: bold; color: #299cdb;"><span id="countdown"></span></td>
                           --}}
                        </tr>
                        @endforeach
                     </tbody>
                  </table>
               </div>
               @else
               <div class="noresult" style="display: block;">
                  <div class="text-center">
                     <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop" colors="primary:#121331,secondary:#08a88a" style="width: 75px; height: 75px;"> </lord-icon>
                     <h5 class="mt-2 text-danger">Sorry! No service Online at the moment</h5>
                  </div>
               </div>
               @endif
            </div>
            <!--end modal -->
         </div>
      </div>
   </div>
   <!--end col-->
</div>
@php
function countdown($date){
$seconds = strtotime($date) - time(); // Calculate the remaining seconds
$days = floor($seconds / 86400); // Calculate the remaining days
$hours = floor(($seconds % 86400) / 3600); // Calculate the remaining hours
$minutes = floor(($seconds % 3600) / 60); // Calculate the remaining minutes
$seconds = ($seconds % 60); // Calculate the remaining seconds
// Output the countdown
echo "Days: $days, Hours: $hours, Minutes: $minutes, Seconds: $seconds";
}
@endphp
<!--end row-->@endsection @section('script')
<script src="{{ URL::asset('/assets/js/jquery-3.6.1.js')}}"></script>
<script src="{{ URL::asset('/assets/js/datatables/datatables.min.js') }}"></script>
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
<script src="{{ URL::asset('/assets/js/datatable.js') }}"></script> 
<script>
   $(document).ready(function () {
       setInterval(function () {
           $.ajax({
               url: "{{route('hotspot.index')}}",
               type: "GET",
               dataType: "json",
               success: function (response) {
                   // Get and set variables for use
                   var totaldata = response.totaldata;
                   var onlinesessions = response.onlinesessions;
                   var upload = response.totalupload;
                   var download = response.totaldownload;
                   var activevouchers = response.activevouchers;
                   // auto update total clients
                   $("#activevouchers").empty();
                   $("#activevouchers").append(activevouchers);
                   // Auto update consumed data section
                   $("#consumed_data").empty();
                   $("#consumed_data").append(totaldata);
                   // Auto update onlinesessions data sections
                   $("#onlinesessions").empty();
                   $("#onlinesessions").append(onlinesessions);
                   $("#online").empty();
                   $("#online").append(onlinesessions);
                   // Auto update upload and download section
                   $("#upload").empty();
                   $("#upload").append(upload);
                   $("#download").empty();
                   $("#download").append(download);
               
               },
               error: function (err) {},
           });
       }, 5000);
   });
</script>
<script>
   // function to format bytes to a human-readable format
   function formatSizeUnits(bytes) {
     if (bytes < 1024) {
       return bytes + " bytes";
     } else if (bytes < 1048576) {
       return (bytes / 1024).toFixed(2) + " KB";
     } else if (bytes < 1073741824) {
       return (bytes / 1048576).toFixed(2) + " MB";
     } else {
       return (bytes / 1073741824).toFixed(2) + " GB";
     }
   }
   
   // function to calculate session time in human-readable format
   function calculateSessionTime(seconds) {
     var hours = Math.floor(seconds / 3600);
     var minutes = Math.floor((seconds - (hours * 3600)) / 60);
     var seconds = seconds - (hours * 3600) - (minutes * 60);
   
     if (hours < 10) { hours = "0" + hours; }
     if (minutes < 10) { minutes = "0" + minutes; }
     if (seconds < 10) { seconds = "0" + seconds; }
   
     return hours + ":" + minutes + ":" + seconds;
   }
   
   function updateTable() {
     $.ajax({
       url: "{{route('hotspot.index')}}",
       type: "GET",
       dataType: 'json',
       success: function(data) {
         var sessions = data.sessions;
         var table = $('#datatable').DataTable();
         table.clear(); // clear existing rows before adding new ones
         if (sessions.length > 0) {
           for (var i = 0; i < sessions.length; i++) {
             var session = sessions[i];
             table.row.add([
               '<span class="badge badge-soft-success text-uppercase">online</span>',
               session.username,
               session.framedipaddress,
               session.acctstarttime ? new Date(session.acctstarttime).toLocaleString('en-US', {year: 'numeric', month: 'short', day: '2-digit', hour: 'numeric', minute: 'numeric', second: 'numeric', hour12: true}) : 'Unknown',
               formatSizeUnits(session.acctoutputoctets),
               formatSizeUnits(session.acctinputoctets),
               calculateSessionTime(session.acctsessiontime)
             ]);
           }
         } else {
           table.row.add([
             'Sorry, no sessions found',
             '',
             '',
             '',
             '',
             '',
             ''
           ]);
         }
         table.draw(false); // redraw the table without shifting child rows
         
         $('#totaldata').html(data.totaldata);
         $('#onlinesessions').html(data.onlinesessions);
         $('#totaldownload').html(formatSizeUnits(data.totaldownload));
         $('#totalupload').html(formatSizeUnits(data.totalupload));
         $('#activevouchers').html(data.activevouchers);
       },
       error: function(jqXHR, textStatus, errorThrown) {
         console.log(textStatus, errorThrown);
       }
     });
   }
   
   $(document).ready(function() {
     // Check if DataTables plugin is already initialized
     if (!$.fn.DataTable.isDataTable('#datatable')) {
       // Initialize DataTables plugin if it is not already initialized
       $('#datatable').DataTable({
         paging: false, // Disable pagination
         searching: false, // Disable search bar
         info: false // Disable "Showing x of y entries" information
       });
     }
     
     updateTable();
     setInterval(updateTable, 30 * 1000); // Call updateTable() every 30 seconds
   });
   
     
</script>
{{-- <script>
   // Set the countdown date
   var countdownDate = new Date("{{ $countdownDate ?? 'Unknown' }}").getTime();
   
   // Update the countdown timer every second
   var countdownTimer = setInterval(function() {
     // Get the current time
     var now = new Date().getTime();
   
     // Calculate the remaining time in milliseconds
     var remainingTime = countdownDate - now;
   
     // Calculate the remaining time in days, hours, minutes, and seconds
     var days = Math.floor(remainingTime / (1000 * 60 * 60 * 24));
     var hours = Math.floor((remainingTime % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
     var minutes = Math.floor((remainingTime % (1000 * 60 * 60)) / (1000 * 60)).toString().padStart(2, "0");
     var seconds = Math.floor((remainingTime % (1000 * 60)) / 1000).toString().padStart(2, "0");
   
     // Update the countdown timer
     document.getElementById("countdown").innerHTML = hours + ":" + minutes + ":" + seconds;
   
     // If the countdown is over, stop the timer
     if (remainingTime < 0) {
       clearInterval(countdownTimer);
       document.getElementById("countdown").innerHTML = "EXPIRED";
     }
   }, 1000);
   
</script> --}}
@endsection