@extends('layouts.master') @section('title') messages @endsection @section('css')
<link href="{{URL::asset('assets/js/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />

<link href="{{URL::asset('assets/css/datatable-custom.css')}}" rel="stylesheet" type="text/css" />

<style>
   .message-cell {
   max-width: 200px; /* or any other value that suits your layout */
   white-space: normal;
   word-break: break-word; /* This will break the word at the last possible place */
   overflow: hidden; 
   }  
</style>
@endsection @section('content')
<div class="row">
   <div class="col-12">
      <div class="page-title-box d-sm-flex align-items-center justify-content-between">
         <h4 class="mb-sm-0">Tickets List</h4>
         <div class="page-title-right">
            <ol class="breadcrumb m-0">
               <li class="breadcrumb-item"><a href="{{ route('support.index') }}">Tickets</a></li>
               <li class="breadcrumb-item active">Tickets List</li>
            </ol>
         </div>
      </div>
   </div>
</div>
<div class="row">
   <!-- Total Tickets -->
   <div class="col-xxl-3 col-sm-6">
      <div class="card card-animate">
         <div class="card-body">
            <div class="d-flex justify-content-between">
               <div>
                  <p class="fw-medium text-muted mb-0">Total Tickets</p>
                  <h2 class="mt-4 ff-secondary fw-semibold">
                     <span class="counter-value" data-target="{{ $totalTickets }}" id="totalTickets">{{ $totalTickets }}</span>
                  </h2>
                  <p class="mb-0 text-muted">
                     <span class="badge badge-soft-secondary badge-border">Last month: {{ $lastMonthTotalTickets }}</span> 
                     <span class="badge badge-soft-info badge-border">This month: <span id="thisMonthTotalTickets">{{ $thisMonthTotalTickets }}</span></span> 
                     <span class="badge bg-light {{ $totalTicketsChange >= 0 ? 'text-success' : 'text-danger' }} mb-0" id="totalTicketsChangeBadge">
                     <i class="ri-arrow-{{ $totalTicketsChange >= 0 ? 'up' : 'down' }}-line align-middle" id="totalTicketsChangeIcon"></i> 
                     <span id="totalTicketsChange">{{ abs($totalTicketsChange) }} %</span>
                     </span> vs. previous month
                  </p>
               </div>
               <div>
                  <div class="avatar-sm flex-shrink-0">
                     <span class="avatar-title bg-soft-primary text-primary rounded-circle fs-4">
                     <i class="ri-ticket-2-line"></i>
                     </span>
                  </div>
               </div>
            </div>
         </div>
         <!-- end card body -->
      </div>
      <!-- end card-->
   </div>
   <!--end col-->
   <!-- Solved Tickets -->
   <div class="col-xxl-3 col-sm-6">
      <div class="card card-animate">
         <div class="card-body">
            <div class="d-flex justify-content-between">
               <div>
                  <p class="fw-medium text-muted mb-0">Solved Tickets</p>
                  <h2 class="mt-4 ff-secondary fw-semibold">
                     <span class="counter-value" data-target="{{ $solvedTickets }}" id="solvedTickets">{{ $solvedTickets }}</span>
                  </h2>
                  <p class="mb-0 text-muted">
                     <span class="badge badge-soft-secondary badge-border">Last month: {{ $lastMonthSolvedTickets }}</span> 
                     <span class="badge badge-soft-info badge-border">This month: <span id="thisMonthSolvedTickets">{{ $thisMonthSolvedTickets }}</span></span> 
                     <span class="badge bg-light {{ $solvedTicketsChange >= 0 ? 'text-success' : 'text-danger' }} mb-0" id="solvedTicketsChangeBadge">
                     <i class="ri-arrow-{{ $solvedTicketsChange >= 0 ? 'up' : 'down' }}-line align-middle" id="solvedTicketsChangeIcon"></i> 
                     <span id="solvedTicketsChange">{{ abs($solvedTicketsChange) }} %</span>
                     </span> vs. previous month
                  </p>
               </div>
               <div>
                  <div class="avatar-sm flex-shrink-0">
                     <span class="avatar-title bg-soft-success text-success rounded-circle fs-4">
                     <i class="ri-check-double-fill"></i>
                     </span>
                  </div>
               </div>
            </div>
         </div>
         <!-- end card body -->
      </div>
      <!-- end card-->
   </div>
   <!-- New Tickets -->
   <div class="col-xxl-3 col-sm-6">
      <div class="card card-animate">
         <div class="card-body">
            <div class="d-flex justify-content-between">
               <div>
                  <p class="fw-medium text-muted mb-0">New Tickets</p>
                  <h2 class="mt-4 ff-secondary fw-semibold">
                     <span class="counter-value" data-target="{{ $newTickets }}" id="newTickets">{{ $newTickets }}</span>
                  </h2>
                  <p class="mb-0 text-muted">
                     <span class="badge bg-light {{ $newTicketsChange >= 0 ? 'text-success' : 'text-danger' }} mb-0" id="newTicketsChangeBadge">
                     <i class="ri-arrow-{{ $newTicketsChange >= 0 ? 'up' : 'down' }}-line align-middle" id="newTicketsChangeIcon"></i> 
                     <span id="newTicketsChange">{{ abs($newTicketsChange) }} %</span>
                     </span> vs. previous month
                  </p>
               </div>
               <div>
                  <div class="avatar-sm flex-shrink-0">
                     <span class="avatar-title bg-soft-info text-info rounded-circle fs-4">
                     <i class="ri-question-answer-fill"></i>
                     </span>
                  </div>
               </div>
            </div>
         </div>
         <!-- end card body -->
      </div>
      <!-- end card-->
   </div>
   <!--end col-->
   <!-- Pending Tickets -->
   <div class="col-xxl-3 col-sm-6">
      <div class="card card-animate">
         <div class="card-body">
            <div class="d-flex justify-content-between">
               <div>
                  <p class="fw-medium text-muted mb-0">Pending Tickets</p>
                  <h2 class="mt-4 ff-secondary fw-semibold">
                     <span class="counter-value" data-target="{{ $pendingTickets }}" id="pendingTickets">{{ $pendingTickets }}</span>
                  </h2>
                  <p class="mb-0 text-muted">
                     <span class="badge bg-light {{ $pendingTicketsChange >= 0 ? 'text-success' : 'text-danger' }} mb-0" id="pendingTicketsChangeBadge">
                     <i class="ri-arrow-{{ $pendingTicketsChange >= 0 ? 'up' : 'down' }}-line align-middle" id="pendingTicketsChangeIcon"></i> 
                     <span id="pendingTicketsChange">{{ abs($pendingTicketsChange) }} %</span>
                     </span> vs. previous month
                  </p>
               </div>
               <div>
                  <div class="avatar-sm flex-shrink-0">
                     <span class="avatar-title bg-soft-warning text-warning rounded-circle fs-4">
                     <i class="mdi mdi-timer-sand"></i>
                     </span>
                  </div>
               </div>
            </div>
         </div>
         <!-- end card body -->
      </div>
      <!-- end card-->
   </div>
   <!--end col-->
   <!--end col-->
</div>
<div class="row">
   <div class="col-lg-12">
      <div class="card" id="ticketsList">
         <div class="card-header border-0 bg-soft-info mb-2">
            <div class="d-flex align-items-center">
               <h5 class="card-title mb-0 flex-grow-1">Tickets</h5>
               <div class="flex-shrink-0">
                  <div class="d-flex flex-wrap gap-2">
                     <button class="btn btn-danger add-btn" data-bs-toggle="modal" data-bs-target="#showModal"><i class="ri-add-line align-bottom me-1"></i> Create Tickets</button>
                     <!-- <button class="btn btn-soft-danger" id="remove-actions" onclick="deleteMultiple()"><i class="ri-delete-bin-2-line"></i></button> -->
                  </div>
               </div>
            </div>
         </div>
         <!--end card-body-->
         <div class="card-body">
            <div class="table-responsive table-card mb-2">
               <table class="table align-middle table-striped" id="tickets" style="width:100%;">
                  <thead class="table-light text-muted">
                     <tr>
                        <th>Status</th>
                        <th>From</th>
                        <th>Subject</th>
                        <th>Date Created</th>
                        <th>Actions</th>
                     </tr>
                  </thead>
                  <tbody>
                  </tbody>
               </table>
            </div>
            <!-- Modal -->
            <div class="modal fade flip" id="deleteOrder" tabindex="-1" aria-hidden="true">
               <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                     <div class="modal-body p-5 text-center">
                        <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#405189,secondary:#f06548" style="width:90px;height:90px"></lord-icon>
                        <div class="mt-4 text-center">
                           <h4>You are about to delete a order ?</h4>
                           <p class="text-muted fs-14 mb-4">Deleting your order will remove all of your information from our database.</p>
                           <div class="hstack gap-2 justify-content-center remove">
                              <button class="btn btn-link link-success fw-medium text-decoration-none" id="deleteRecord-close" data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i> Close</button>
                              <button class="btn btn-danger" id="delete-record">Yes, Delete It</button>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <!--end modal -->
         </div>
         <!--end card-body-->
      </div>
      <!--end card-->
   </div>
   <!--end col-->
</div>
<!-- Modal -->
<div class="modal fade zoomIn" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered modal-md">
      <div class="modal-content border-0">
         <div class="modal-header p-3 bg-soft-info">
            <h5 class="modal-title" id="exampleModalLabel">Create New Ticket</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
         </div>
         <form class="tablelist-form" action="{{ route('support.store') }}" method="POST">
   @csrf
   <div class="modal-body">
      <div class="row g-3">
         <!-- Additional fields as required -->
         <div class="col-lg-12">
            <div>
               <label for="tasksTitle-field" class="form-label">Subject</label>
               <input type="text" id="tasksTitle-field" name="subject" class="form-control @error('subject') is-invalid @enderror" placeholder="Subject" value="{{ old('subject') }}"/>
               @error('subject')
                  <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                  </span>
               @enderror
            </div>
         </div>
         <div class="col-lg-12">
            <div>
               <label for="body-field" class="form-label">Body</label>
               <textarea id="body-field" name="body" class="form-control @error('body') is-invalid @enderror" placeholder="Body">{{ old('body') }}</textarea>
               @error('body')
                  <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                  </span>
               @enderror
            </div>
         </div>
         <div class="col-lg-12">
            <div>
               <label for="user-field" class="form-label">Select User</label>
               <select class="form-control @error('user') is-invalid @enderror" name="user" id="user-field">
                  <option value="">Select User</option>
                  <!-- Populate this dropdown with user options using AJAX -->
                  <!-- ... -->
               </select>
               @error('user')
                  <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                  </span>
               @enderror
            </div>
         </div>
      </div>
   </div>
   <div class="modal-footer">
      <div class="hstack gap-2 justify-content-end">
         <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
         <button type="submit" class="btn btn-success" id="add-btn">Add Ticket</button>
      </div>
   </div>
</form>

      </div>
   </div>
</div>
@endsection
@section('script')
<script src="{{ URL::asset('/assets/js/jquery-3.6.1.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
<script src="{{ URL::asset('/assets/js/datatables/datatables.min.js') }}"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/34.0.0/classic/ckeditor.js"></script>
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
{{-- <script src="{{ URL::asset('/assets/js/datatable.js') }}"></script> --}}
<script>
@if ($errors->any())
    $(document).ready(function () {
        $('#showModal').modal('show');
    });
@endif
</script>
<script>
   var getTicketStatisticsUrl = "{{ route('tickets.statistics') }}";
   var getSupportUsers = "{{ route('support.users') }}";
   
   $(document).ready(function() {
       var table = $('#tickets').DataTable({
         processing: true,
         serverSide: true,
         responsive: true,
         ajax: '{{ route('support.index') }}',
         order: [[3, "desc"]],
         pageLength: 25,
         columns: [
            { data: 'status', name: 'status', responsivePriority: 1 },
            { data: 'from', name: 'from', responsivePriority: 3 },
            {
               data: 'subject',
               name: 'subject',
               responsivePriority: 2, // Second highest priority
               render: function(data, type, row) {
                  if(window.innerWidth <= 767) {
                        return `<div class="message-cell">${data}</div>`;
                  } else {
                        // Using a makeshift truncation; you'd replace this with server-side truncation for accuracy
                        return `<div class="subject-cell">${data.substring(0, 30)}...</div>`; 
                  }
               }
            },
            { data: 'created_at', name: 'created_at', responsivePriority: 4 },
            { data: 'actions', name: 'actions', orderable: false, searchable: false },
         ]
      });

       setInterval(function() {
           table.ajax.reload(null, false);
       }, 60000);
   
       updateTicketStatistics();
       setInterval(updateTicketStatistics, 60000);
   
       $.ajax({
           url: getSupportUsers,
           method: 'GET',
           dataType: 'json',
           success: function(data) {
               var userDropdown = $('#user-field');
               userDropdown.empty();
               userDropdown.append($('<option>').text('Select User').attr('value', ''));
   
               $.each(data, function(key, value) {
                   var displayName = value.firstname + ' ' + value.lastname + ' (' + value.username + ')';
                   userDropdown.append($('<option>').text(displayName).attr('value', value.id));
               });
   
               var choices = new Choices('#user-field', {
                   removeItemButton: true,
                   searchEnabled: true,
                   allowHTML: true,
               });
           },
           error: function(xhr, status, error) {
               console.error(xhr.responseText);
           }
       });
   });
   
   function updateTicketStatistics() {
       $.ajax({
           url: getTicketStatisticsUrl,
           method: 'GET',
           success: function(data) {
               $('#totalTickets').text(data.totalTickets);
               $('#thisMonthTotalTickets').text(data.thisMonthTotalTickets);
               $('#newTickets').text(data.newTickets);
               $('#pendingTickets').text(data.pendingTickets);
               $('#solvedTickets').text(data.solvedTickets);
               $('#thisMonthSolvedTickets').text(data.thisMonthSolvedTickets);
               $('#totalTicketsChange').text(data.totalTicketsChange.toFixed(2) + ' %');
               $('#newTicketsChange').text(data.newTicketsChange.toFixed(2) + ' %');
               $('#pendingTicketsChange').text(data.pendingTicketsChange.toFixed(2) + ' %');
               $('#solvedTicketsChange').text(data.solvedTicketsChange.toFixed(2) + ' %');
   
               updateBadgeAndIcon('#totalTicketsChangeBadge', '#totalTicketsChangeIcon', data.totalTicketsChange);
               updateBadgeAndIcon('#newTicketsChangeBadge', '#newTicketsChangeIcon', data.newTicketsChange);
               updateBadgeAndIcon('#pendingTicketsChangeBadge', '#pendingTicketsChangeIcon', data.pendingTicketsChange);
               updateBadgeAndIcon('#solvedTicketsChangeBadge', '#solvedTicketsChangeIcon', data.solvedTicketsChange);
           }
       });
   }
   
   function updateBadgeAndIcon(badgeSelector, iconSelector, change) {
       const badge = $(badgeSelector);
       const icon = $(iconSelector);
   
       if (change >= 0) {
           badge.removeClass('text-danger').addClass('text-success');
           icon.removeClass('ri-arrow-down-line').addClass('ri-arrow-up-line');
       } else {
           badge.removeClass('text-success').addClass('text-danger');
           icon.removeClass('ri-arrow-up-line').addClass('ri-arrow-down-line');
       }
   }
   
   ClassicEditor
       .create(document.querySelector('#body-field'), {
           toolbar: {
               items: [
                   'heading',
                   '|',
                   'bold',
                   'italic',
                   'link',
                   'bulletedList',
                   'numberedList',
                   '|',
                   'outdent',
                   'indent',
                   '|',
                   'blockQuote',
                   'insertTable',
                   'undo',
                   'redo'
               ]
           },
           table: {
               contentToolbar: [
                   'tableColumn',
                   'tableRow',
                   'mergeTableCells'
               ]
           },
           language: 'en',
           licenseKey: '',
       })
       .then(editor => {
           window.editor = editor;
       })
       .catch(error => {
           console.error('Oops, something went wrong!');
           console.error('Please, report the following error on the https://github.com/ckeditor/ckeditor5/issues page.');
           console.error(error);
       });
</script>
@endsection