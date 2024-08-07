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
@endsection 
@section('content') 
{{-- @component('components.breadcrumb') @slot('li_1') Account @endslot @slot('title') settings @endslot @endcomponent --}}
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
<div class="row">
     @include('layouts.partials.flash')
      <div class="card" id="orderList">
         <div class="card-header border-bottom-dashed">
            <div class="d-flex align-items-center">
               <h5 class="card-title mb-0 flex-grow-1"><i class="ri-exchange-dollar-line text-info"></i> Invoices</h5>
               <div class="flex-shrink-0">
                  <a href="{{route('invoice.create', ['client' => $client->id])}}" class="btn btn-soft-info add-btn" id="create-invoice-button"><i class="ri-add-line align-bottom me-1"></i> Add Invoice</a>
               </div>
            </div>
         </div>
         <div class="card-body pt-0">
            @if(count($invoices))
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
                     <tbody class="list form-check-all">
                        @foreach($invoices as $invoice)
                        <tr class="no-border @if ($invoice->creditnotes->count() > 0) striped @endif">
                           <td>{{ $invoice->id }}</td>
                           <td class="invoice-number"><a href="{{ route('invoice.show', [$invoice->invoice_number]) }}" class="text-info" target="_blank">{{$invoice->invoice_number}}</a></td>
                           <td class="amount">
                              <div class="original-amount" style="{{$invoice->creditnotes->count() > 0 ? 'text-decoration: line-through;' : ''}}">
                                 Ksh {{$invoice->amount}}
                              </div>
                              @if($invoice->creditnotes->count() > 0)
                              <div class="adjusted-amount">
                                 Ksh {{$invoice->adjusted_amount}}
                              </div>
                              @endif
                           </td>
                           <td class="status"><span class="badge badge-label {{ $invoice->status_class }}"><i class="mdi mdi-circle-medium"></i> {{ ucfirst($invoice->status) }}</span></td>
                           <td class="due-date">{{$invoice->status == 'paid' ? '' : $invoice->due_date}}</td>
                           <td>
                              <!-- Credit Note column -->
                              @if ($invoice->creditnotes->count() > 0)
                              <ul>
                                 @foreach ($invoice->creditnotes as $creditNote)
                                 <li>
                                    <a href="#" class="text-info view-credit-note-btn" data-id="{{$creditNote->id}}">{{$creditNote->credit_note_number}}</a>
                                 </li>
                                 @endforeach
                              </ul>
                              @else
                              <span>No credit notes</span>
                              @endif
                           </td>
                           <td>
                              <ul class="list-inline hstack gap-2 mb-0">
                                 @if ($invoice->status !== 'paid' && $invoice->status !== 'canceled')
                                 <li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Edit">
                                    <a href="{{ route('invoice.edit', [$invoice->id]) }}" class="text-primary d-inline-block edit-item-btn">
                                    <i class="ri-pencil-fill fs-16"></i>
                                    </a>
                                 </li>
                                 <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Delete">
                                    <a class="text-danger d-inline-block remove-item-btn" data-bs-toggle="modal" data-id="{{$invoice->id}}" data-title="{{$invoice->invoice_number}}" href="#deleteItem">
                                    <i class="ri-delete-bin-5-fill fs-16"></i>
                                    </a>
                                 </li>
                                 @endif
                                 @if($invoice->status == 'paid')
                                 <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Create Credit Note">
                                    <a class="text-success d-inline-block create-creditnote-btn" data-bs-toggle="modal" data-id="{{$invoice->id}}" data-user-id="{{$invoice->user_id}}" data-invoice-number="{{$invoice->invoice_number}}" href="#createCreditNoteModal">
                                    <i class="ri-file-fill fs-16"></i>
                                    </a>
                                 </li>
                                 @endif
                                 <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="View invoice">
                                    <a class="text-info d-inline-block" href="{{ route('invoice.show', [$invoice->invoice_number]) }}" target="_blank">
                                    <i class="ri-search-eye-line fs-16"></i>
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
                     <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop" colors="primary:#121331,secondary:#08a88a" style="width: 75px; height: 75px;"> </lord-icon>
                     <h5 class="mt-2 text-danger">Sorry! No invoices found</h5>
                     <p class="text-muted mb-0">You don't have any invoices yet</p>
                  </div>
               </div>
               @endif

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
<!--end row-->
@endsection @section('script')
<script src="{{ URL::asset('/assets/js/jquery-3.6.1.js')}}"></script>
<script src="{{ URL::asset('/assets/js/datatables/datatables.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.9/dist/sweetalert2.all.min.js"></script>
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
{{-- <script src="{{ URL::asset('/assets/js/datatable.js') }}"></script> --}}
<script>
   $(document).ready(function () {
    $('#datatable').DataTable({
        responsive: true,
        deferRender: true,
        "lengthMenu": [20, 50, 100],
        "pageLength": 50,
        "order": [[0, 'desc']], // Order by the fourth column (index 3) in descending order
        language: {
            paginate: {
                next: '&#8594;', // or '→'
                previous: '&#8592;' // or '←'
            }
        },
    });
});
</script>
<script>
   $(document).ready(function() {
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
   $(document).ready(function() {
      // Attach click event listener to the parent <td> element
      $('td.amount').on('click touchstart', function(e) {
         e.preventDefault(); // Prevent default behavior of scrolling to the top
      });

      // Attach click event listener to the credit note link
      $('.view-credit-note-btn').on('click touchstart', function(e) {
         e.preventDefault(); // Prevent default behavior of the link

         var creditNoteId = $(this).data('id');
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
   });
</script>
@endsection