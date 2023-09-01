@extends('layouts.master') @section('title') billing @endsection @section('css')
<link href="{{URL::asset('assets/js/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{URL::asset('assets/css/datatable-custom.css')}}" rel="stylesheet" type="text/css" />
<style>
   .striped {
   background-color: rgba(247,184,75,.18)!important;
   }
   .credit-note-details {
   padding: 20px;
   }
   .credit-note-number {
   font-weight: bold;
   font-size: 18px;
   margin-bottom: 10px;
   }
   .credit-note-info {
   border-top: 1px solid #ddd;
   padding-top: 10px;
   }
   .credit-note-detail {
   margin-bottom: 5px;
   }
</style>
@endsection @section('content') 
{{-- @component('components.breadcrumb') @slot('li_1') Dashboard @endslot @slot('title') Finance @endslot @endcomponent --}}
<!-- start page title -->
<div class="row">
   <div class="col-12">
      <div class="page-title-box d-sm-flex align-items-center justify-content-between">
         <h4 class="mb-sm-0 font-size-18">Invoices</h4>
         <div class="page-title-right">
            <ol class="breadcrumb m-0">
               <li class="breadcrumb-item"><a href="{{ route('billing.index') }}">Finance</a></li>
               <li class="breadcrumb-item active"><a href="{{ route('invoice.index') }}">Invoices</a></li>
            </ol>
         </div>
      </div>
   </div>
</div>
<!-- end page title -->
<div class="row mb-3 pb-1">
   <div class="col-12">
      @if (session('status'))
      <div class="alert alert-success alert-dismissible alert-label-icon label-arrow fade show" role="alert">
         <i class="ri-check-double-line label-icon"></i><strong>Success</strong> - {{session('status')}}
         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      @endif @if (session('error'))
      <div class="alert alert-danger alert-dismissible alert-label-icon label-arrow fade show mb-xl-0" role="alert">
         <i class="ri-error-warning-line label-icon"></i><strong>Failed</strong>
         - {!! session('error') !!}
         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      <br />
      @endif
      <div class="d-flex align-items-lg-center flex-lg-row flex-column">
         <div class="flex-grow-1">
            <h4 class="fs-16 mb-1">Hello! </h4>
            <p class="text-muted mb-0">Here are invoices for the period.
            </p>
         </div>
         <div class="mt-3 mt-lg-0">
            <form action="{{ route('invoice.index') }}" method="GET" id="filterForm">
               <div class="row g-3 mb-0 align-items-center">
                  <div class="col-sm-auto">
                     <div class="input-group">
                        <input type="text" class="form-control border-0 dash-filter-picker shadow flatpickr-input" 
                           id="dateRange" name="dateRange" data-provider="flatpickr" data-range-date="true" data-date-format="d M, Y" 
                           value="{{ request('dateRange') }}" readonly="readonly">
                        <div class="input-group-text bg-primary border-primary text-white">
                           <i class="ri-calendar-2-line"></i>
                        </div>
                     </div>
                  </div>
                  <!--end col-->
                  <div class="col-auto">
                     <select class="form-control" name="invoiceStatus" id="invoiceStatus">
                     <option value="all" {{ request('invoiceStatus') == 'all' ? 'selected' : '' }}>All</option>
                     <option value="unpaid" {{ request('invoiceStatus') == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                     <option value="paid" {{ request('invoiceStatus') == 'paid' ? 'selected' : '' }}>Paid</option>
                     <option value="canceled" {{ request('invoiceStatus') == 'canceled' ? 'selected' : '' }}>Canceled</option>
                     </select>
                  </div>
                  <!--end col-->
                  <div class="col-auto">
                     <button type="submit" class="btn btn-soft-info waves-effect waves-light layout-rightside-btn"><i class="ri-filter-line"></i> Filter</button>
                  </div>
                  <!--end col-->
                  <div class="col-auto">
                     <button type="button" id="exportBtn" class="btn btn-soft-primary waves-effect waves-light"><i class="ri-download-line"></i> Export</button>
                  </div>
                  <!--end col-->
                  <div class="col-auto">
                     <button type="button" id="printBtn" class="btn btn-soft-success waves-effect waves-light"><i class="ri-printer-line"></i> Print</button>
                  </div>
                  <!--end col-->
               </div>
               <!--end row-->
            </form>
         </div>
      </div>
      <!-- end card header -->
   </div>
   <!--end col-->
</div>
<div class="row">
   <div class="col-xl-3 col-md-6">
      <!-- card -->
      <div class="card card-animate">
         <div class="card-body">
            <div class="d-flex align-items-center">
               <div class="flex-grow-1">
                  <p class="text-uppercase fw-medium text-muted mb-0">All Invoices</p>
               </div>
               <div class="flex-shrink-0">
                  <h5 class="{{ $growth['all'] >= 0 ? 'text-success' : 'text-danger' }} fs-14 mb-0">
                     <i class="{{ $growth['all'] >= 0 ? 'ri-arrow-right-up-line' : 'ri-arrow-right-down-line' }} fs-13 align-middle"></i> 
                     {{ number_format(abs($growth['all'])) }} %
                  </h5>
               </div>
            </div>
            <div class="d-flex align-items-end justify-content-between mt-4">
               <div>
                  <h4 class="fs-18 fw-semibold ff-secondary mb-4">Ksh <span class="counter-value"
                     data-target="{{ $totalInvoices }}">0</span></h4>
                  <span class="badge bg-warning me-1">{{ $countInvoices }}</span> <span class="text-muted">
                  </span>
               </div>
               <div class="avatar-xs flex-shrink-0">
                  <span class="avatar-title bg-light rounded fs-3">
                  <i data-feather="file-text" class="text-success icon-dual-success"></i>
                  </span>
               </div>
            </div>
         </div>
         <!-- end card body -->
      </div>
      <!-- end card -->
   </div>
   <!-- end col -->
   <div class="col-xl-3 col-md-6">
      <!-- card -->
      <div class="card card-animate">
         <div class="card-body">
            <div class="d-flex align-items-center">
               <div class="flex-grow-1">
                  <p class="text-uppercase fw-medium text-muted mb-0">Paid</p>
               </div>
               <div class="flex-shrink-0">
                  <h5 class="{{ $growth['paid'] >= 0 ? 'text-success' : 'text-danger' }} fs-14 mb-0">
                     <i class="{{ $growth['paid'] >= 0 ? 'ri-arrow-right-up-line' : 'ri-arrow-right-down-line' }} fs-13 align-middle"></i> 
                     {{ number_format(abs($growth['paid'])) }} %
                  </h5>
               </div>
            </div>
            <div class="d-flex align-items-end justify-content-between mt-4">
               <div>
                  <h4 class="fs-18 fw-semibold ff-secondary mb-4">Ksh <span class="counter-value"
                     data-target="{{ $totalPaid }}">0</span></h4>
                  <span class="badge bg-warning me-1">{{ $countPaid }}</span> <span class="text-muted">
                  </span>
               </div>
               <div class="avatar-xs flex-shrink-0">
                  <span class="avatar-title bg-light rounded fs-3">
                  <i data-feather="check-square"
                     class="text-success icon-dual-success"></i>
                  </span>
               </div>
            </div>
         </div>
         <!-- end card body -->
      </div>
      <!-- end card -->
   </div>
   <!-- end col -->
   <div class="col-xl-3 col-md-6">
      <!-- card -->
      <div class="card card-animate">
         <div class="card-body">
            <div class="d-flex align-items-center">
               <div class="flex-grow-1">
                  <p class="text-uppercase fw-medium text-muted mb-0">Unpaid</p>
               </div>
               <div class="flex-shrink-0">
                  <h5 class="{{ $growth['unpaid'] >= 0 ? 'text-success' : 'text-danger' }} fs-14 mb-0">
                     <i class="{{ $growth['unpaid'] >= 0 ? 'ri-arrow-right-up-line' : 'ri-arrow-right-down-line' }} fs-13 align-middle"></i> 
                     {{ number_format(abs($growth['unpaid'])) }} %
                  </h5>
               </div>
            </div>
            <div class="d-flex align-items-end justify-content-between mt-4">
               <div>
                  <h4 class="fs-18 fw-semibold ff-secondary mb-4">Ksh <span class="counter-value"
                     data-target="{{ $totalUnpaid }}">0</span></h4>
                  <span class="badge bg-warning me-1">{{ $countUnpaid }}</span> <span class="text-muted">
                  </span>
               </div>
               <div class="avatar-xs flex-shrink-0">
                  <span class="avatar-title bg-light rounded fs-3">
                  <i data-feather="clock" class="text-warning icon-dual-warning"></i>
                  </span>
               </div>
            </div>
         </div>
         <!-- end card body -->
      </div>
      <!-- end card -->
   </div>
   <!-- end col -->
   <div class="col-xl-3 col-md-6">
      <!-- card -->
      <div class="card card-animate">
         <div class="card-body">
            <div class="d-flex align-items-center">
               <div class="flex-grow-1">
                  <p class="text-uppercase fw-medium text-muted mb-0">Canceled</p>
               </div>
               <div class="flex-shrink-0">
                  <h5 class="{{ $growth['canceled'] >= 0 ? 'text-success' : 'text-danger' }} fs-14 mb-0">
                     <i class="{{ $growth['canceled'] >= 0 ? 'ri-arrow-right-up-line' : 'ri-arrow-right-down-line' }} fs-13 align-middle"></i> 
                     {{ number_format(abs($growth['canceled'])) }} %
                  </h5>
               </div>
            </div>
            <div class="d-flex align-items-end justify-content-between mt-4">
               <div>
                  <h4 class="fs-18 fw-semibold ff-secondary mb-4">Ksh <span class="counter-value"
                     data-target="{{ $totalCanceled }}">0</span></h4>
                  <span class="badge bg-warning me-1">{{ $countCanceled }}</span> <span class="text-muted">
                  </span>
               </div>
               <div class="avatar-xs flex-shrink-0">
                  <span class="avatar-title bg-light rounded fs-3">
                  <i data-feather="x-octagon" class="text-danger icon-dual-danger"></i>
                  </span>
               </div>
            </div>
         </div>
         <!-- end card body -->
      </div>
      <!-- end card -->
   </div>
   <!-- end col -->
</div>
<!-- end row-->
<div class="row">
   <div class="col-lg-12">
      <div class="card" id="invoiceList">
         <div class="card-header border-0 mb-0">
            <div class="d-flex align-items-center">
               <h5 class="card-title mb-0 flex-grow-1">Invoices</h5>
               <div class="flex-shrink-0">
                  <button class="btn btn-danger" id="delete-btn" style="display: none;"><i class="ri-delete-bin-2-line"></i></button>
                  <button class="btn btn-soft-info" id="create-invoice-button">
                  <i class="ri-add-line align-bottom me-1"></i> Create Invoice
                  </button>
               </div>
            </div>
         </div>
         <div class="card-body bg-soft-light border border-dashed border-start-0 border-end-0">
            <div>
               <div class="table-responsive table-card mb-1">
                  <table class="table align-middle" id="datatable" style="width: 100%;">
                     <thead class="table-light text-muted">
                        <tr>
                           <th>#</th>
                           <th>Invoice Number</th>
                           <th>Amount</th>
                           <th>Status</th>
                           <th>Due Date</th>
                           <th>Credit Note</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                  </table>
               </div>
            </div>
            <!-- Modal -->
            <!-- Delete Modal -->
            <div class="modal fade flip" id="deleteItem" tabindex="-1" aria-hidden="true">
               <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                     <div class="modal-body p-5 text-center">
                        <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#405189,secondary:#f06548" style="width: 90px; height: 90px;"></lord-icon>
                        <div class="mt-4 text-center">
                           <h4>You are about to delete <span class="modal-title"></span>!</h4>
                           <p class="text-muted fs-15 mb-4">Deleting an invoice will remove all of the information from the database.</p>
                           <div class="hstack gap-2 justify-content-center remove">
                              <button class="btn btn-link link-success fw-medium text-decoration-none" data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i> Close</button>
                              <form action="{{route('invoice.delete')}}" method="POST">
                                 @csrf
                                 <input type="hidden" name="id" id="id" />
                                 <button type="submit" class="btn btn-danger">Yes delete</button>
                              </form>
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
<!-- Create Credit Note Modal -->
<div class="modal fade" id="createCreditNoteModal" tabindex="-1" role="dialog" aria-labelledby="createCreditNoteModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
         <div class="modal-header p-3 bg-soft-info">
            <h5 class="modal-title" id="exampleModalLabel">Create Credit Note</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
         </div>
         <div class="modal-body">
            <form id="creditNoteForm" action="{{ route('creditnote.store') }}" method="POST">
               @csrf
               <input type="hidden" name="user_id" id="userId" value="{{ old('user_id') }}">
               <input type="hidden" name="invoice_id" id="invoiceId" value="{{ old('invoice_id') }}">
               <!-- Removed credit note number field -->
               <div class="form-group mb-3">
                  <label for="description">Description</label>
                  <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                  @error('description')
                  <div class="text-danger">{{ $message }}</div>
                  @enderror
               </div>
               <div class="form-group mb-3">
                  <label for="amount">Amount</label>
                  <input type="number" class="form-control @error('amount') is-invalid @enderror" id="amount" name="amount" value="{{ old('amount') }}" min="0" step="0.01" required>
                  @error('amount')
                  <div class="text-danger">{{ $message }}</div>
                  @enderror
               </div>
            </form>
         </div>
         <div class="modal-footer">
            <button type="submit" class="btn btn-soft-info" form="creditNoteForm">Save creditnote</button>
         </div>
      </div>
   </div>
</div>
<div class="modal" tabindex="-1" id="client-selection-modal">
   <div class="modal-dialog modal-dialog-centered">
      <!-- This class centers the modal vertically -->
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title">Select a Client</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
         </div>
         <div class="modal-body">
            <div class="mb-3">
               <label for="clientSelect" class="form-label">Client <span
                  class="text-danger">*</span></label>
               <select id="clientSelect" name="client" class="form-control @error('client') is-invalid @enderror" data-choices>
                  <option value="">Select a client</option>
                  <!-- Default option -->
                  @isset($clients)
                  @foreach($clients as $client)
                  <option value="{{$client->id}}">{{$client->firstname}} {{$client->lastname}}</option>
                  @endforeach
                  @endisset
               </select>
               @error('client')
               <span class="invalid-feedback" role="alert">
               <strong>{{ $message }}</strong>
               </span>
               @enderror
            </div>
         </div>
         <div class="modal-footer">
            {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> --}}
            <button type="button" class="btn btn-primary" id="proceed-to-invoice" disabled>Proceed</button> <!-- Initially disabled -->
         </div>
      </div>
   </div>
</div>
<div class="modal fade" id="viewCreditNoteModal" tabindex="-1" role="dialog" aria-labelledby="viewCreditNoteModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
         <div class="modal-header p-3 bg-soft-warning">
            <h5 class="modal-title" id="viewCreditNoteModalLabel">Credit Note Details</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            <!-- Credit note details will be dynamically loaded here -->
         </div>
      </div>
   </div>
</div>
@endsection 
@section('script')
<script src="{{ URL::asset('/assets/js/jquery-3.6.1.js')}}"></script>
<script src="{{ URL::asset('/assets/js/datatables/datatables.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/xlsx.full.min.js') }}"></script>
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
<script>
   var deleteMultipleUrl = "{{ route('voucher.delete_multiple') }}";
</script>
<!-- include the deletemultiple.js file using the script tag -->
<script src="{{ URL::asset('/assets/js/deletemultiple.js') }}"></script>
<script>
   var createInvoiceUrl = "{{ route('invoice.create', ['client' => '']) }}";
   
   $(document).ready(function() {
    // Handle the create invoice button click
    $('#create-invoice-button').click(function(e) {
        e.preventDefault(); // Prevent the default action
        // Show the modal
        $('#client-selection-modal').modal('show');
    });
   
    // Enable the 'Proceed' button only when a client is selected
    $('#clientSelect').on('change', function() {
        if($(this).val() === '') {
            $('#proceed-to-invoice').prop('disabled', true);
        } else {
            $('#proceed-to-invoice').prop('disabled', false);
        }
    });
   
    // Handle the 'Proceed' button click
    $('#proceed-to-invoice').click(function() {
        // Get the selected client
        var selectedClient = $('#clientSelect').val();
   
        // Proceed to create invoice with the selected client's details
        window.location.href = createInvoiceUrl + selectedClient;
   
        // Hide the modal
        $('#client-selection-modal').modal('hide');
    });
   });

   // Modal pass user data
    $('#deleteItem').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var title = button.data('title'); // Extract info from data-* attributes
        var id = button.data('id');
        var modal = $(this);
        modal.find('.modal-title').text(title);
        modal.find('.modal-body #id').val(id);
    });
   
   // Get today's date
   let today = new Date();
   
   // Get the first day of the month
   let firstDayOfMonth = new Date(today.getFullYear(), today.getMonth(), 1);
   
   // Get the date range from the URL
   let urlParams = new URLSearchParams(window.location.search);
   let dateRangeParam = urlParams.get('dateRange');
   
   // If there is a date range in the URL, use it
   if (dateRangeParam) {
       let [start, end] = dateRangeParam.split(' to ').map(dateStr => new Date(dateStr));
       var defaultDate = [start, end];
   } else {
       // Otherwise, default to the first day of the month to today
       var defaultDate = [firstDayOfMonth, today];
   }
   
   // Initialize Flatpickr with the default range
   flatpickr("#dateRange", {
       mode: "range",
       dateFormat: "d M, Y",
       defaultDate: defaultDate
   });
   
   document.getElementById('exportBtn').addEventListener('click', function() {
       let table = document.getElementById('invoiceTable');
       let csv = [];
       let rows = table.rows;
   
       for (let i = 0; i < rows.length; i++) {
           let row = [], cols = rows[i].cells;
   
           for (let j = 0; j < cols.length; j++) 
               row.push(cols[j].innerText);
           
           csv.push(row.join(","));        
       }
   
       downloadCSV(csv.join("\n"), 'invoices.csv');
   });
   
   function downloadCSV(csv, filename) {
       let csvFile = new Blob([csv], {type: "text/csv"});
       let downloadLink = document.createElement("a");
   
       downloadLink.download = filename;
       downloadLink.href = window.URL.createObjectURL(csvFile);
       downloadLink.style.display = "none";
   
       document.body.appendChild(downloadLink);
   
       downloadLink.click();
   }
</script>
<script>
   $(document).ready(function() {
       var datatable = $('#datatable').DataTable({
           responsive: true,
           processing: true,
           serverSide: true,
           ajax: {
               url: "{{ route('invoice.index') }}",
               data: function (d) {
                   // Pass additional parameters to the server
                   d.dateRange = $('#dateRange').val();
                   d.invoiceStatus = $('#invoiceStatus').val();
               }
           },
           columns: [
               { data: 'id', name: 'id' },
               { data: 'invoice_number', name: 'invoice_number' },
               { data: 'amount', name: 'amount' },
               { data: 'status', name: 'status' },
               { data: 'due_date', name: 'due_date' },
               { data: 'credit_note', name: 'credit_note', orderable: false, searchable: false },
               { data: 'action', name: 'action', orderable: false, searchable: false }
           ],
           drawCallback: function () {
               // Handle view credit note click event
               $('.view-credit-note-btn').on('click', function (e) {
                   e.preventDefault();
                   var creditNoteId = $(this).data('id');
                   // Perform your logic to view the credit note
                   var url = '{{ route("creditnote.show.ajax", ["id" => ":id"]) }}';
                   url = url.replace(':id', creditNoteId);
   
                   // Make an AJAX call to retrieve the credit note details
                   $.ajax({
                       url: url,
                       type: 'GET',
                       success: function(response) {
                           // Update the modal content with the credit note details
                           var creditNote = response.creditNote;
                           var creditNoteNumber = creditNote.credit_note_number;
                           var creditNoteDetails = creditNote.details;
                           var creditNoteAmount = creditNote.amount;
                           var creditNoteDateIssued = creditNote.date_issued;
   
                           // Create the HTML structure for the credit note details
                           var modalContent = '<div class="credit-note-details">';
                           modalContent += '<h4 class="credit-note-number">Credit Note: ' + creditNoteNumber + '</h4>';
                           modalContent += '<div class="credit-note-info">';
                           modalContent += '<p class="credit-note-detail">Details: ' + creditNoteDetails + '</p>';
                           modalContent += '<p class="credit-note-detail">Amount: ' + creditNoteAmount + '</p>';
                           modalContent += '<p class="credit-note-detail">Date Issued: ' + creditNoteDateIssued + '</p>';
                           modalContent += '</div>';
                           modalContent += '</div>';
   
                           // Update the modal content with the retrieved credit note details
                           $('#viewCreditNoteModal .modal-body').html(modalContent);
   
                           // Show the modal
                           $('#viewCreditNoteModal').modal('show');
                       },
                       error: function(xhr, status, error) {
                           // Handle any error that occurs during the AJAX call
                           console.error(error);
                       }
                   });
               });
           }
       });
   
       // Apply search and filter when the 'Search' button is clicked
       $('#searchButton').on('click', function() {
           datatable.search('').draw();
       });
   
       // Reset search and filter when the 'Reset' button is clicked
       $('#resetButton').on('click', function() {
           $('#dateRange').val('');
           $('#invoiceStatus').val('all');
           datatable.search('').draw();
       });
   
       // Check if any validation errors exist
       @if($errors->any())
          // If so, open the modal
          $('#createCreditNoteModal').modal('show');
       @endif
   
       $('#createCreditNoteModal').on('show.bs.modal', function (event) {
           var button = $(event.relatedTarget) // Button that triggered the modal
           var invoiceId = button.data('id') // Extract info from data-* attributes
           var userId = button.data('userId')
           var invoiceNumber = button.data('invoiceNumber')
   
           var modal = $(this)
           modal.find('.modal-body input[name="user_id"]').val(userId)
           modal.find('.modal-body input[name="invoice_id"]').val(invoiceId)
           // And so on...
       })
   });
</script>
<script>
   $('#printBtn').on('click', function() {
       // Make an AJAX call to retrieve the filtered data
       $.ajax({
           url: '{{ route("invoice.exportFilteredData") }}',
           type: 'GET',
           data: {
               dateRange: $('#dateRange').val(),
               invoiceStatus: $('#invoiceStatus').val()
           },
           success: function(response) {
               var filteredData = response.data;
   
               // Calculate the total amount for all invoices
               var totalAmount = 0;
               filteredData.forEach(function(invoice) {
                   totalAmount += parseFloat(invoice.amount);
               });
   
               // Extract unique statuses from the filtered data
               var statuses = [...new Set(filteredData.map(invoice => invoice.status))];
   
               // Process and format the filtered data for printing
               var printContent = '<html><head><title>Invoices - Print</title>';
               printContent += '<style>';
               printContent += 'body { font-family: Arial, sans-serif; margin: 20px; }';
               printContent += 'h1 { font-size: 24px; margin-bottom: 10px; color: #FF3366; }';
               printContent += 'h2 { font-size: 18px; margin-bottom: 10px; color: #565656; }';
               printContent += 'h3 { font-size: 16px; margin-bottom: 10px; color: #565656; }';
               printContent += 'table { width: 100%; border-collapse: collapse; margin-top: 20px; }';
               printContent += 'th { background-color: #F5F5F5; border: 1px solid #DDD; padding: 8px; }';
               printContent += 'td { border: 1px solid #DDD; padding: 8px; }';
               printContent += '</style>';
               printContent += '</head><body>';
               printContent += '<h1>Invoices - Print</h1>';
               printContent += '<h2>Date Range: ' + $('#dateRange').val() + '</h2>';
               printContent += '<h3>Total Amount: ' + totalAmount.toFixed(2) + '</h3>';
               printContent += '<h3>Status: ' + statuses.join(', ') + '</h3>';
               printContent += '<table>';
               printContent += '<tr><th style="background-color: #FF3366; color: #FFF;">Invoice Number</th>';
               printContent += '<th style="background-color: #3366FF; color: #FFF;">Amount</th>';
               printContent += '<th style="background-color: #33CC99; color: #FFF;">Status</th>';
               printContent += '<th style="background-color: #FFCC00; color: #FFF;">Date Created</th></tr>';
   
               // Iterate over the filtered data and build the table rows
               filteredData.forEach(function(invoice) {
                   var createdDate = new Date(invoice.created_at);
                   var formattedDate = createdDate.toLocaleDateString('en-GB', {
                       day: 'numeric',
                       month: 'long',
                       year: 'numeric'
                   });
   
                   printContent += '<tr>';
                   printContent += '<td>' + invoice.invoice_number + '</td>';
                   printContent += '<td>' + invoice.amount + '</td>';
                   printContent += '<td>' + invoice.status + '</td>';
                   printContent += '<td>' + formattedDate + '</td>';
                   printContent += '</tr>';
               });
   
               printContent += '</table>';
               printContent += '</body></html>';
   
               // Create a new window for printing
               var printWindow = window.open('', '_blank');
               printWindow.document.write(printContent);
               printWindow.document.close();
   
               // Trigger the print dialog for the new window
               printWindow.print();
           },
           error: function(xhr, status, error) {
               console.error(error);
           }
       });
   });
</script>
<script>
   $('#exportBtn').on('click', function() {
       // Make an AJAX call to retrieve the filtered data
       $.ajax({
           url: '{{ route("invoice.exportFilteredData") }}',
           type: 'GET',
           data: {
               dateRange: $('#dateRange').val(),
               invoiceStatus: $('#invoiceStatus').val()
           },
           success: function(response) {
       var filteredData = response.data;
   
       // Modify the filteredData to only include desired fields
       filteredData = filteredData.map(function(invoice) {
       var date = new Date(invoice.created_at);
       var formattedDate = date.toLocaleDateString('en-GB');
       return {
           invoice_number: invoice.invoice_number,
           amount: invoice.amount,
           status: invoice.status,
           date_created: formattedDate
       };
   });
   
       // Create a new workbook
       var workbook = XLSX.utils.book_new();
   
       // Convert the filtered data to a worksheet
       var worksheet = XLSX.utils.json_to_sheet(filteredData);
   
       // Add the worksheet to the workbook
       XLSX.utils.book_append_sheet(workbook, worksheet, 'Filtered Data');
   
       // Generate a binary string from the workbook
       var excelData = XLSX.write(workbook, { type: 'binary', bookType: 'xlsx' });
   
       // Convert the binary string to a Blob object
       var blob = new Blob([s2ab(excelData)], { type: 'application/octet-stream' });
   
       // Create a temporary anchor element to trigger the download
       var anchor = document.createElement('a');
       anchor.href = URL.createObjectURL(blob);
       anchor.download = 'filtered_data.xlsx';
       anchor.style.display = 'none';
       document.body.appendChild(anchor);
   
       // Trigger the download
       anchor.click();
   
       // Cleanup
       document.body.removeChild(anchor);
       URL.revokeObjectURL(anchor.href);
   },
   
           error: function(xhr, status, error) {
               console.error(error);
           }
       });
   });
   
   // Utility function to convert string to ArrayBuffer
   function s2ab(s) {
       var buf = new ArrayBuffer(s.length);
       var view = new Uint8Array(buf);
       for (var i = 0; i < s.length; i++) {
           view[i] = s.charCodeAt(i) & 0xFF;
       }
       return buf;
   }
</script>
@endsection