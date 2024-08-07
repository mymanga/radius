@extends('layouts.master') @section('title') Customer - Usage stats @endsection @section('css')
<link href="{{URL::asset('assets/js/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{URL::asset('assets/css/datatable-custom.css')}}" rel="stylesheet" type="text/css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/highcharts/10.0.0/highcharts.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/highcharts/10.0.0/modules/exporting.min.js"></script>
<style>
div.dt-buttons {
  float: left;
  padding-top: 10px;
}
</style>
@endsection @section('content') 
@component('components.breadcrumb') @slot('li_1') Customer @endslot @slot('title') Statistics @endslot @endcomponent

<div class="d-flex align-items-center justify-content-center mb-3">
   <div class="d-flex flex-column align-items-center">
      @if(count(auth()->user()->services))
      <form method="get" action="{{ route('customer.statistics') }}">
         <div class="input-group">
            <select class="form-select" name="interface" id="interface">
            @foreach(auth()->user()->services as $service)
            <option value='{{ $service->username }}' {{ $selectedService == $service->username ? 'selected' : '' }}>
            {{ $service->username }} - {{ $service->package->name }}
            </option>
            @endforeach
            </select>
            <button type="submit" class="btn btn-info">View</button>
         </div>
      </form>
      @else
      <p>No service found.</p>
      @endif
      <span class="text-muted"><i>Note: data is only kept for 365 days</i></span>
   </div>
</div>
<div class="row h-100">
   <!-- end col -->
   <div class="col-lg-6 col-md-6">
      <div class="card">
         <div class="card-body">
            <div class="d-flex align-items-center">
               <div class="avatar-sm flex-shrink-0">
                  <span class="avatar-title bg-light text-primary rounded-circle fs-3">
                  <i class="ri-download-cloud-2-fill align-middle"></i>
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
   <div class="col-lg-6 col-md-6">
      <div class="card">
         <div class="card-body">
            <div class="d-flex align-items-center">
               <div class="avatar-sm flex-shrink-0">
                  <span class="avatar-title bg-light text-primary rounded-circle fs-3">
                  <i class="ri-upload-cloud-2-fill align-middle"></i>
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
            <canvas id="monthlyChart" width="800" height="300"></canvas>
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
                           <th>Period</th>
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
<script src="{{ URL::asset('/assets/js/datatable.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
<script>
   $(document).ready(function () {
       $('#datatable-online').DataTable({
           responsive: true,
           deferRender: true,
           paging: true,
           searching: true,
           info: false,
           "pageLength": 20, // Set the default page length to 20
           "lengthMenu": [10, 20, 50, 100], // Specify available page length options
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
                     title: '{{$selectedPeriod}} data usage for account {{$selectedService}}',
                     exportOptions: {
                        columns: ':not(:last-child)' // Exclude the last column
                     }
                  },
                  {
                     extend: 'pdfHtml5', // Export to PDF
                     title: '{{$selectedPeriod}} data usage for account {{$selectedService}}', // Modify PDF title as needed
                     text: 'PDF',
                     exportOptions: {
                        columns: ':not(:last-child)' // Exclude the last column
                     }
                  },
                  {
                     extend: 'print', // Print button
                     title: '{{$selectedPeriod}} data usage for account {{$selectedService}}',
                     exportOptions: {
                        columns: ':not(:last-child)' // Exclude the last column
                     }
                  }
            ]
       });
   });
</script>
<script>
   // Get the data from PHP and parse it to JavaScript
   var periodData = {!! json_encode($period) !!};
   
   // Extract labels (months) from the PHP data
   var labels = periodData.map(function(item) {
       return item.month;
   });
   
   // Extract download and upload data for each month
   var downloadData = periodData.map(function(item) {
       return parseFloat(item.GB_out); // Parse the download value as a float
   });
   var uploadData = periodData.map(function(item) {
       return parseFloat(item.GB_in); // Parse the upload value as a float
   });
   
   // Get the canvas element
   var ctx = document.getElementById('monthlyChart').getContext('2d');
   
   // Check if the selected period is "monthly" before creating the chart
   var monthlyChart = new Chart(ctx, {
       type: 'bar',
       data: {
           labels: labels,
           datasets: [
               {
                   label: 'Download (GB)',
                   data: downloadData,
                   backgroundColor: 'rgba(75, 192, 192, 0.5)', // Bar color for download
                   borderColor: 'rgba(75, 192, 192, 1)', // Border color for download
                   borderWidth: 1
               },
               {
                   label: 'Upload (GB)',
                   data: uploadData,
                   backgroundColor: 'rgba(255, 99, 132, 0.5)', // Bar color for upload
                   borderColor: 'rgba(255, 99, 132, 1)', // Border color for upload
                   borderWidth: 1
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
           maintainAspectRatio: false
       }
   });
</script>
<script>
   function monthNameToNumber(monthName) {
       var months = [
           "January", "February", "March", "April", "May", "June",
           "July", "August", "September", "October", "November", "December"
       ];
       return months.indexOf(monthName) + 1;
   }
   
   // Populate the table with data
   var dataTableBody = document.getElementById('data-table-body');
   
   labels.forEach(function(month, index) {
       var download = downloadData[index];
       var upload = uploadData[index];
   
       var monthParts = month.split('-');
       var year = monthParts[0];
       var monthName = monthParts[1];
       var monthNumber = monthNameToNumber(monthName); // Get numeric month value
   
       // Format the date as "YYYY-MM" for sorting
       var sortableDate = `${year}-${monthNumber.toString().padStart(2, '0')}`;
   
       var row = document.createElement('tr');
       row.innerHTML = `
           <td data-order="${sortableDate}">${month}</td>
           <td>${download.toFixed(3)}</td>
           <td>${upload.toFixed(3)}</td>
           <td>
               <a href="{{ route('customer.view_stats') }}?service={{ $selectedService }}&month=${month}" class="btn btn-soft-info btn-sm"><i class="ri-eye-2-line"></i> View Daily Stats</a>
           </td>
       `;
   
       dataTableBody.appendChild(row);
   });
   
</script>
@endsection