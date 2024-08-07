@extends('layouts.master') @section('title') statistics @endsection @section('css')
<link href="{{URL::asset('assets/js/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{URL::asset('assets/css/datatable-custom.css')}}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" media="screen" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/themes/base/jquery-ui.min.css">
<link rel="stylesheet" type="text/css" media="screen" href="https://cdnjs.cloudflare.com/ajax/libs/free-jqgrid/4.15.5/css/ui.jqgrid.min.css">
<style>
div.dt-buttons {
  float: left;
  padding-top: 10px;
}
</style>
@endsection @section('content') 
{{-- @component('components.breadcrumb') @slot('li_1') Services @endslot @slot('title') Online @endslot @endcomponent --}}
<div class="row">
   <div class="col-lg-12">
      <div class="card mt-n4 mx-n4">
         <div class="bg-soft-light">
            @include('clients.header')
            <!-- end card body -->
         </div>
      </div>
      <!-- end card -->
   </div>
   <!-- end col -->
</div>

<div class="row h-100">

<div class="col-lg-4 col-md-4">
      <div class="card">
         <div class="card-body">
            <div class="d-flex align-items-center">
               {{-- <div class="avatar-sm flex-shrink-0">
                  <span class="avatar-title bg-light text-primary rounded-circle fs-3">
                  <i class="ri-calendar-2-line align-middle"></i>
                  </span>
               </div> --}}
               <div class="flex-grow-1 ms-3">
                  <p class="text-uppercase fw-semibold fs-12 text-muted mb-1">
                     Statistics for
                  </p>
                  <h5 class="mb-0 text-success">{{ $selectedMonthYear }} </h5>
               </div>
            </div>
         </div>
         <!-- end card body -->
      </div>
      <!-- end card -->
   </div>
   <!-- end col -->
   <div class="col-lg-4 col-md-4">
      <div class="card">
         <div class="card-body">
            <div class="d-flex align-items-center">
               <div class="avatar-sm flex-shrink-0">
                  <span class="avatar-title bg-light text-primary rounded-circle fs-3">
                  <i class="ri-download-cloud-2-fill align-middle text-success text-opacity-50"></i>
                  </span>
               </div>
               <div class="flex-grow-1 ms-3">
                  <p class="text-uppercase fw-semibold fs-12 text-muted mb-1">
                     Total Download
                  </p>
                  <h4 class=" mb-0">{{ isset($download) ? $download : '0' }} GB</h4>
               </div>
            </div>
         </div>
         <!-- end card body -->
      </div>
      <!-- end card -->
   </div>
   <!-- end col -->
   <div class="col-lg-4 col-md-4">
      <div class="card">
         <div class="card-body">
            <div class="d-flex align-items-center">
               <div class="avatar-sm flex-shrink-0">
                  <span class="avatar-title bg-light text-primary rounded-circle fs-3">
                  <i class="ri-upload-cloud-2-fill align-middle text-danger text-opacity-50"></i>
                  </span>
               </div>
               <div class="flex-grow-1 ms-3">
                  <p class="text-uppercase fw-semibold fs-12 text-muted mb-1">Total Upload</p>
                  <h4 class="mb-0">{{ isset($upload) ? $upload : '0' }} GB</h4>
               </div>
            </div>
         </div>
         <!-- end card body -->
      </div>
      <!-- end card -->
   </div>
   <!-- end col -->
</div>
<div class="row chartContainer">
   <div class="col-md-12">
      <div class="card card-height-100">
         <div class="card-header">
            <h4 class="card-title mb-0">{{ ucfirst($selectedPeriod) }} usage</h4>
         </div>
         <!-- end card header -->
         <div class="card-body">
            <!-- Add an empty canvas element for the chart -->
            <canvas id="dailyChart" width="800" height="300"></canvas>
            <!-- Add the table element below the chart -->
         </div>
         <!-- end card-body -->
      </div>
      <!-- end card -->
   </div>
</div>
<div class="row">
   <div class="col-lg-12">
      <div class="card" id="orderList">
         <div class="card-body">
            <div>
               <div class="table-responsive table-card mb-1">
                  <table class="table table-nowrap align-middle" id="datatable-online" style="width: 100%;">
                     <thead class="text-muted table-light">
                        <tr class="text-uppercase">
                           <th>Date</th>
                           <th>Download <small>(GB)</small></th>
                           <th>Upload <small>(GB)</small></th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody id="data-table-body">
                        <!-- Data rows will be added here dynamically -->
                     </tbody>
                  </table>
               </div>
            </div>
            <!--end modal -->
         </div>
      </div>
      {{-- Data usage card --}}
   </div>
   <!--end col-->
</div>
<!--end row-->
@endsection @section('script')
<script src="{{ URL::asset('/assets/js/jquery-3.6.1.js')}}"></script>
<script src="{{ URL::asset('/assets/js/datatables/datatables.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.9/dist/sweetalert2.all.min.js"></script>
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
{{-- <script src="https://cdn.datatables.net/buttons/2.1.2/js/dataTables.buttons.min.js"></script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
{{-- <script src="https://cdn.datatables.net/buttons/2.1.2/js/buttons.html5.min.js"></script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.68/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.68/vfs_fonts.js"></script>
<script>
   $(document).ready(function () {
    // DataTable initialization code with customized PDF export title
    var table = $('#datatable-online').DataTable({
        responsive: true,
        deferRender: true,
        paging: true,
        searching: true,
        info: false,
        "pageLength": 35,
        "lengthMenu": [10, 35, 50, 100],
        dom: 'lBfrtip', // Include both Length Menu (l) and Buttons (B)
        buttons: [
            {
                extend: 'copy', // Copy to clipboard
                exportOptions: {
                    columns: ':not(:last-child)' // Exclude the last column
                }
            },
            {
                extend: 'csv', // Export to CSV
                exportOptions: {
                    columns: ':not(:last-child)' // Exclude the last column
                }
            },
            {
                extend: 'excel', // Export to Excel
                title: 'Account {{$selectedService}} Statistics for {{$selectedMonthYear}}',
                exportOptions: {
                    columns: ':not(:last-child)' // Exclude the last column
                }
            },
            {
                extend: 'pdfHtml5', // Export to PDF
                title: 'Account {{$selectedService}} Data usage for {{$selectedMonthYear}}', // Modify PDF title as needed
                text: 'PDF',
                exportOptions: {
                    columns: ':not(:last-child)' // Exclude the last column
                }
            },
            {
                extend: 'print', // Print button
                title: 'Account {{$selectedService}} Data usage for {{$selectedMonthYear}}',
                exportOptions: {
                    columns: ':not(:last-child)' // Exclude the last column
                }
            }
        ]
    });

    // Customize the button layout if needed
    table.buttons().container()
        .appendTo('#datatable-online_wrapper .col-md-6:eq(0)');

    });
</script>

<script>
   // Get the data from PHP and parse it to JavaScript
   var dailyData = {!! json_encode($period) !!};
   
   // Extract labels (dates) from the PHP data
   var labels = dailyData.map(function(item) {
       return item.date;
   });
   
   // Extract download and upload data for each day
   var downloadData = dailyData.map(function(item) {
       return Math.abs(parseFloat(item.GB_out)); // Get the absolute value of download data
   });
   var uploadData = dailyData.map(function(item) {
       return Math.abs(parseFloat(item.GB_in)); // Get the absolute value of upload data
   });
   
   // Get the canvas element
   var ctx = document.getElementById('dailyChart').getContext('2d');
   
    // Create the chart with a filled area chart type
    // Create the chart with tooltips
    var dailyChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Download (GB)',
                    data: downloadData,
                    fill: true,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1,
                    pointRadius: 0,
                },
                {
                    label: 'Upload (GB)',
                    data: uploadData,
                    fill: true,
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1,
                    pointRadius: 0,
                }
            ]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'GB'
                    }
                }
            },
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                tooltip: {
                    mode: 'index',
                    intersect: false,
                }
            },
            elements: {
                line: {
                    tension: 0.4, // Adjust the line tension for smoother curves
                    borderCapStyle: 'round', // Round line caps for smooth curve tops and bottoms
                }
            }
        }
    });
</script>



<script>
   // Populate the table with data
   var dataTableBody = document.getElementById('data-table-body');
   var selectedService = "{{ $selectedService }}"; // Define selectedService here
   
   labels.forEach(function(date, index) {
       var download = downloadData[index];
       var upload = uploadData[index];

       // Extract month, year, and date from the "date" variable
       var dateObj = new Date(date);
       var month = dateObj.getMonth() + 1; // Months are 0-based, so add 1
       var year = dateObj.getFullYear();
       var day = dateObj.getDate();

       // Format the date as "YYYY-MM-DD" for the AJAX request
       var formattedDate = year + "-" + (month < 10 ? "0" : "") + month + "-" + (day < 10 ? "0" : "") + day;

       var row = document.createElement('tr');
       row.innerHTML = `
           <td>${date}</td>
           <td>${download.toFixed(3)}</td>
           <td>${upload.toFixed(3)}</td>
           <td>
                <a href="#" onclick="loadSessions('${formattedDate}', '${selectedService}')">Sessions</a>
           </td>
       `;
   
       dataTableBody.appendChild(row);
   });

   function formatBytes(bytes) {
    if (bytes <= 0) {
        return "0 bytes";
    }

    var units = ["bytes", "KB", "MB", "GB"];
    var factor = Math.floor(Math.log(bytes) / Math.log(1024));

    if (factor >= units.length) {
        factor = units.length - 1; // Avoid undefined offset
    }

    return (bytes / Math.pow(1024, factor)).toFixed(2) + " " + units[factor];
}
// Function to load sessions via AJAX
function loadSessions(date, selectedService) {
    // Make an AJAX request to load sessions for the selected service and date
    $.ajax({
        url: "{{ route('view_stats.sessions') }}", // Use the correct route name
        method: "GET", // Specify the HTTP method (GET in this case)
        data: {
            service: selectedService,
            month: date
        },
        dataType: "json",
        success: function(data) {
            // Create a modal and DataTable to display the sessions
            var modal = $('<div class="modal fade" tabindex="-1" role="dialog">');
            var modalDialog = $('<div class="modal-dialog modal-lg modal-dialog-centered" role="document">');
            var modalContent = $('<div class="modal-content">');
            var modalHeader = $('<div class="modal-header">');
            var modalTitle = $('<h5 class="modal-title">Sessions</h5>');
            var closeButton = $('<button type="button" class="btn-close text-danger" data-bs-dismiss="modal" aria-label="Close" id="close-modal">');
            closeButton.html('<span aria-hidden="true">&times;</span>');
            modalHeader.append(modalTitle, closeButton);

            var modalBody = $('<div class="modal-body">');
            var sessionsTable = $('<table class="table align-middle" id="sessionsTable">');
            
            // Thead structure matching the original table
            var thead = $('<thead class="text-muted">');
            thead.append('<tr class="text-uppercase"><th>Start</th><th>Stop</th><th>Tx <small>(GB)</small></th><th>Rx <small>(GB)</small></th></tr>');
            sessionsTable.append(thead);

            var sessionsTableBody = $('<tbody>');

            data.forEach(function(session) {
                // Format input octets and output octets using your PHP function
                var formattedInputOctets = formatBytes(session.acctinputoctets);
                var formattedOutputOctets = formatBytes(session.acctoutputoctets);

                // Extract and format the time portion from acctstarttime and acctstoptime
                var startTime = new Date(session.acctstarttime);
                var stopTime = new Date(session.acctstoptime);

                var formattedStartTime = startTime.getHours().toString().padStart(2, '0') + ':' +
                                        startTime.getMinutes().toString().padStart(2, '0') + ':' +
                                        startTime.getSeconds().toString().padStart(2, '0');

                var formattedStopTime = stopTime.getHours().toString().padStart(2, '0') + ':' +
                                    stopTime.getMinutes().toString().padStart(2, '0') + ':' +
                                    stopTime.getSeconds().toString().padStart(2, '0');

                // Append the formatted data to the table
                sessionsTableBody.append('<tr><td>' + formattedStartTime + '</td><td>' + formattedStopTime + '</td><td>' + formattedOutputOctets + '</td><td>' + formattedInputOctets + '</td></tr>');
                // Add other columns as needed
            });

            sessionsTable.append(sessionsTableBody);
            modalBody.append(sessionsTable);
            modalContent.append(modalHeader, modalBody);

            modal.append(modalDialog.append(modalContent));

            // Append the modal to the body
            $('body').append(modal);

            // Show the modal and initialize the DataTable when modal is fully shown
            modal.on('shown.bs.modal', function () {
                var sessionsTable = $('#sessionsTable').DataTable({
                    responsive: true,
                });
                
                // Recalculate the column widths for responsive mode
                sessionsTable.responsive.recalc();
            });

            modal.modal('show');
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            console.error("Status: " + textStatus + " request: " + XMLHttpRequest);
            console.error("Error: " + errorThrown);
        }
    });
}

</script>

@endsection
