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
                      <div class="row row-cols-xxl-2 row-cols-md-2 row-cols-1 g-0">
                          <div class="col">
                              <div class="py-4 px-3">
                                  <h5 class="text-muted text-uppercase fs-13">Active Vouchers
                                      <i class="ri-user-2-fill text-info fs-18 float-end align-middle"></i>
                                  </h5>
                                  <div class="d-flex align-items-center">
                                      <div class="flex-shrink-0">
                                          <i class="ri-team-fill display-6 text-info"></i>
                                      </div>
                                      <div class="flex-grow-1 ms-3">
                                          <h3 class="mb-0"><span id="activevouchers">{{$active_vouchers}}</span></h3>
                                          <span class="nowrap">
                                             <i class="ri-inbox-line text-primary align-middle"></i> unused
                                             <span id="newVouchers" class="badge rounded-pill bg-info">{{$new_vouchers}}</span>
                                         </span>
                                         <span class="nowrap">
                                             <i class="ri-check-line text-warning align-middle"></i> used
                                             <span id="usedVouchers" class="badge rounded-pill bg-warning">{{$used_vouchers}}</span>
                                         </span>
                                      </div>
                                      <a href="{{route('voucher.index')}}" class="text-muted d-none d-md-block">View Vouchers</a>
                                      <a href="{{route('voucher.index')}}" class="text-muted d-md-none">Vouchers</a>
                                  </div>
                              </div>
                          </div>
                          <!-- end col -->
                          <div style="border-right:none" class="col">
                              <div class="mt-md-0 py-4 px-3">
                                  <h5 class="text-muted text-uppercase fs-13">Online Sessions
                                      <i class="ri-wifi-fill text-success fs-18 float-end align-middle"></i>
                                  </h5>
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
                          <div class="col">
                              <div class="mt-md-0 py-4 px-3">
                                  <h5 class="text-muted text-uppercase fs-13">Consumed data <small>[24h]</small>
                                      <i class="ri-database-2-fill text-warning fs-18 float-end align-middle"></i>
                                  </h5>
                                  <div class="d-flex align-items-center">
                                      <div class="flex-shrink-0">
                                          <i class="ri-stack-fill display-6 text-warning"></i>
                                      </div>
                                      <div class="flex-grow-1 ms-3">
                                          <h3 class="mb-0"><span id="consumed_data">{{$totaldata}}</span></h3>
                                          <span class="nowrap">
                                              <i class="ri-arrow-up-circle-line text-muted align-middle"></i>
                                              <span id="upload" class="text-muted">{{$totalupload}}</span>
                                          </span>
                                          <span class="nowrap">
                                              <i class="ri-arrow-down-circle-line text-muted align-middle"></i>
                                              <span id="download" class="text-muted">{{$totaldownload}}</span>
                                          </span>
                                      </div>
                                  </div>
                              </div>
                          </div>
                          <!-- end col -->
                          <div class="col col-last">
                              <div class="py-4 px-3">
                                  <h5 class="text-muted text-uppercase fs-13">Payments today
                                      <i class="ri-money-dollar-circle-line text-info fs-18 float-end align-middle d-none d-md-block"></i>
                                  </h5>
                                  <div class="d-flex align-items-center">
                                      <div class="flex-shrink-0">
                                          <i class="ri-exchange-dollar-line display-6 text-info"></i>
                                      </div>
                                      <div class="flex-grow-1 ms-3">
                                          <h4 class="mb-0"><span id="payments">{{$totalRevenueTodayFormatted}}</span></h4>
                                          <span class="text-muted"><span>This month:</span></span>
                                          <span class="text-muted"><span id="monthpayments">{{$totalRevenueThisMonthFormatted}}</span></span>
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
                        <!-- Placeholder for session data -->
                     </tbody>
                  </table>
               </div>
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
                   var payments = response.totalRevenueToday;
                   var monthPayments = response.totalRevenueThisMonth;
                   var newVouchers = response.newVouchers;
                   var usedVouchers = response.usedVouchers;
   
                   // Auto update total clients
                   $("#activevouchers").text(activevouchers);
                   // Auto update consumed data section
                   $("#consumed_data").text(totaldata);
                   // Auto update onlinesessions data sections
                   $("#onlinesessions").text(onlinesessions);
                   $("#online").text(onlinesessions);
                   // Auto update upload and download section
                   $("#upload").text(upload);
                   $("#download").text(download);
                   // Auto update payments
                   $("#payments").text(payments);
                   // Auto update this month's payments
                  $("#monthpayments").text(monthPayments);
                  // Auto update new and used vouchers section
                  $("#newVouchers").text(newVouchers);
                  $("#usedVouchers").text(usedVouchers);
               },
               error: function (err) {
                   console.error('Error fetching data:', err);
               },
           });
       }, 5000); // Update every 5 seconds
   });
</script>
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
        url: "{{ route('hotspot.index') }}",
        type: "GET",
        dataType: 'json',
        success: function(data) {
            var sessions = data.sessions;
            var table = $('#datatable').DataTable();
            table.clear(); // clear existing rows before adding new ones
            if (sessions.length > 0) {
                $.each(sessions, function(index, session) {
                    var sessionRow = [
                        '<span class="badge badge-soft-success text-uppercase">online</span>',
                        session.username,
                        session.framedipaddress || 'Unknown',
                        session.acctstarttime ? new Date(session.acctstarttime).toLocaleString('en-US', { year: 'numeric', month: 'short', day: '2-digit', hour: 'numeric', minute: 'numeric', second: 'numeric', hour12: true }) : 'Unknown',
                        formatSizeUnits(session.acctoutputoctets),
                        formatSizeUnits(session.acctinputoctets),
                        calculateSessionTime(session.acctsessiontime)
                    ];
                    table.row.add(sessionRow);
                });
            } else {
                // If no sessions found, add a row indicating so
                table.row.add(['Sorry, no sessions found', '', '', '', '', '', '']);
            }
            table.draw(false); // redraw the table without shifting child rows
   
            // Update other elements with data
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
   
    // Call updateTable initially
    updateTable();
   
    // Set interval to call updateTable every 30 seconds
    setInterval(updateTable, 30 * 1000);
   });
   
   
     
</script>
@endsection