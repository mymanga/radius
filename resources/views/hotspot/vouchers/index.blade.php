@extends('layouts.master') @section('title') vouchers @endsection @section('css')
<link href="{{URL::asset('assets/js/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{URL::asset('assets/css/datatable-custom.css')}}" rel="stylesheet" type="text/css" />
{{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.css"> --}}
@endsection @section('content') 
{{-- @component('components.breadcrumb') @slot('li_1') Hotspot @endslot @slot('title') Vouchers @endslot @endcomponent  --}}
<div class="page-title-box d-sm-flex align-items-center justify-content-between">
   <h4 class="mb-sm-0 font-size-18">Vouchers</h4>
   <div class="page-title-right">
      <ol class="breadcrumb m-0">
         <li class="breadcrumb-item"><a href="{{ route('hotspot.index') }}">Hotspot</a></li>
         <li class="breadcrumb-item active"><a href="{{ route('voucher.index') }}">Vouchers</a></li>
      </ol>
   </div>
</div>
<div class="row">
   <div class="col-lg-12">
      @if (session('success'))
      <div class="alert alert-success alert-dismissible alert-label-icon label-arrow fade show" role="alert">
         <i class="ri-check-double-line label-icon"></i><strong>Success</strong> - {{session('success')}}
         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      @endif 
      @if($errors->any())
      <div class="alert alert-danger">
         <ul>
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
         </ul>
      </div>
      @endif
      <div class="d-flex align-items-center mb-3">
         <div class="flex-grow-1">
            <h5 class="mb-0 text-uppercase text-muted">Voucher List</h5>
         </div>
         <div class="flexshrink-0">
            <button id="delete-btn" class="btn btn-soft-danger" style="display: none;">Delete selected</button>
            <a href="{{ route('voucher.extend') }}" class="btn btn-soft-success btn-md">Compensate</a>
            <button class="btn btn-soft-info add-btn" data-bs-toggle="modal" data-bs-target="#createVoucherModal"><i class="ri-gps-line align-bottom me-1"></i> Create Voucher</button>
            <button id="refresh-btn" class="btn btn-soft-secondary btn-md"><i class="ri-refresh-line align-bottom me-1"></i> Refresh</button>
         </div>
      </div>
      <div class="card">
         <div class="card-body">
            <div>
               <div class="table-responsive table-card mb-1">
                  <table class="table align-middle table-striped" id="datatable" style="width: 100%;">
                     <thead class="table-light text-muted">
                        <tr>
                           <th>ID</th>
                           <th>
                              <div class="form-check">
                                 <input class="form-check-input" type="checkbox" id="select-all">
                              </div>
                           </th>
                           <th>Voucher</th>
                           <th>Status</th>
                           <th>Type</th>                         
                           <th>Title</th>
                           <th>Expiration</th>
                           <th>Remaining</th>
                           <th>Speed Limit</th>
                           <th>Data Limit</th>
                           <th>Phone</th>
                           <th>Actions</th>
                        </tr>
                     </thead>
                     <tbody class="list form-check-all">
                     </tbody>
                  </table>
               </div>
            </div>
            <!-- Create plan modal -->
            <!-- Modal -->
            <div class="modal fade" id="createVoucherModal" tabindex="-1" aria-labelledby="createPlanModalLabel" aria-hidden="true">
               <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                     <div class="modal-header">
                        <h5 class="modal-title" id="createPlanModalLabel">Create Voucher</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                     </div>
                     <form action="{{ route('voucher.store') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                           <div class="mb-3">
                              <label for="plan_id" class="form-label">Select Plan <span class="text-danger">*</span></label>
                              <select name="plan_id" id="plan_id" class="form-select @error('plan_id') is-invalid @enderror" aria-label="plan_id">
                                 <option value="" selected disabled>Select Plan</option>
                                 @foreach($plans as $plan)
                                 <option value="{{ $plan->id }}" {{ old('plan_id') == $plan->id ? 'selected' : '' }}>{{ $plan->title }}</option>
                                 @endforeach
                              </select>
                              @error('plan_id')
                              <div class="text-danger">{{ $message }}</div>
                              @enderror
                           </div>
                           <div class="mb-3">
                              <label for="num_vouchers" class="form-label">Number of vouchers <span class="text-danger">*</span></label>
                              <input type="number" name="num_vouchers" id="num_vouchers" class="form-control @error('num_vouchers') is-invalid @enderror" value="{{ old('num_vouchers', 1) }}" aria-label="num_vouchers">
                              @error('num_vouchers')
                              <div class="text-danger">{{ $message }}</div>
                              @enderror
                           </div>
                        </div>
                        <div class="modal-footer">
                           {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> --}}
                           <button type="submit" class="btn btn-primary">Save Voucher</button>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
            <!-- Delete Modal -->
            <div class="modal fade flip" id="deleteItem" tabindex="-1" aria-hidden="true">
               <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                     <div class="modal-body p-5 text-center">
                        <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#405189,secondary:#f06548" style="width: 90px; height: 90px;"></lord-icon>
                        <div class="mt-4 text-center">
                           <h4>You are about to delete <span class="modal-title"></span> Voucher!</h4>
                           <p class="text-muted fs-15 mb-4">Deleting a Voucher will remove all of the information from the database.</p>
                           <div class="hstack gap-2 justify-content-center remove">
                              <button class="btn btn-link link-success fw-medium text-decoration-none" data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i> Close</button>
                              <form action="{{route('voucher.delete')}}" method="POST">
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
            <!-- View  modal -->
            <div class="modal fade" id="viewItem" tabindex="-1" aria-labelledby="viewItemLabel" aria-hidden="true">
               <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                     <div class="modal-header">
                        <h5 class="modal-title" id="viewItemLabel">Voucher Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                     </div>
                     <div class="modal-body">
                     </div>
                     <div class="modal-footer">
                     </div>
                  </div>
               </div>
            </div>
            <!-- End modal -->
            <!-- Send voucher modal -->
            <div class="modal fade" id="sendItem" tabindex="-1" role="dialog" aria-labelledby="sendItemLabel" aria-hidden="true">
               <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                     <div class="modal-header">
                        <h5 class="modal-title" id="sendItemLabel">Send Voucher to Phone Number</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                     </div>
                     <div class="modal-body">
                        <form id="sendItemForm" method="POST" action="{{ route('voucher.send') }}">
                           @csrf
                           <div class="mb-3">
                              <label for="phoneNumber" class="form-label">Phone Number</label>
                              <input type="tel" class="form-control @error('phone') is-invalid @enderror" id="phoneField" name="phone" value="{{ old('phone') }}" required>
                              @error('phone')
                              <div class="text-danger">{{ $message }}</div>
                              @enderror
                           </div>
                           <input type="hidden" name="voucher_id" id="voucherId">
                           <div class="text-center">
                              <button type="submit" class="btn btn-primary">Send Voucher</button>
                           </div>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
            <!-- end modal -->
         </div>
      </div>
   </div>
   <!--end col-->
</div>

<!--end row-->
@endsection @section('script')
<script src="{{ URL::asset('/assets/js/jquery-3.6.1.js')}}"></script>
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
<script src="{{ URL::asset('/assets/js/datatables/datatables.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/sweetalert2.all.min.js') }}"></script>

<script>
   var deleteMultipleUrl = "{{ route('voucher.delete_multiple') }}";
</script>
<!-- include the deletemultiple.js file using the script tag -->
<script src="{{ URL::asset('/assets/js/deletemultiple.js') }}"></script>
@if (count($errors) > 0 && ($errors->has('plan_id') || ($errors->has('num_vouchers') && is_numeric(old('num_vouchers')) && old('num_vouchers') > 0)))
    <script type="text/javascript">
       $(document).ready(function () {
           $("#createVoucherModal").modal("show");
       });
    </script>
@endif
@if (count($errors) > 0 && $errors->has('phone'))
<script type="text/javascript">
   $(document).ready(function () {
       $("#sendItem").modal("show");
   });
</script>
@endif

<script>
$(document).ready(function () {
    var table = $('#datatable').DataTable({
    responsive: true,
    processing: true,
    serverSide: true,
    ajax: {
        url: '{{ route("voucher.index") }}',
        type: 'GET'
    },
    columns: [
         { data: 'id', orderable: false },
         { data: 'select', orderable: false, searchable: false },
         { data: 'voucher', orderable: false },
         { data: 'status', orderable: false },
         { data: 'voucher_type', orderable: false },
         { data: 'title', orderable: false },
         { data: 'expiration_time', searchable: false, orderable: false },
         { data: 'remaining', orderable: false, searchable: false },
         { data: 'speed_limit', searchable: false, orderable: false },
         { data: 'data_limit', searchable: false, orderable: false },
         { data: 'phone', orderable: false, searchable: false },
         { data: 'actions', orderable: false }
    ],
    order: [[0, 'desc']],
    lengthMenu: [[20, 35, 50, 100], [20, 35, 50, 100]],
    language: {
        searchPlaceholder: 'Search...',
        paginate: {
            first: 'First',
            last: 'Last',
            next: '&rarr;',
            previous: '&larr;'
        }
    },
    rowCallback: function (row, data) {
        // Update checkbox ID
        var voucherId = data.id;
        var checkbox = $('input[type="checkbox"]', row);
        checkbox.attr('id', 'select-' + voucherId);
        checkbox.siblings('label').attr('for', 'select-' + voucherId);
    }
});


    table.on('draw', function () {
        window.scrollTo(0, 0);
    });

    // Add change event listener to checkboxes using event delegation
    $('#datatable').on('change', '.form-check-input', function () {
        console.log('Checkbox changed');
        var checked = $('.form-check-input:checked');
        console.log('Checked checkboxes:', checked);
        if (checked.length > 0) {
            $('#delete-selected-btn').prop('disabled', false);
        } else {
            $('#delete-selected-btn').prop('disabled', true);
        }
    });

    $('#refresh-btn').on('click', function () {
        table.ajax.reload(null, false);
    });
});

// Modal pass package data
$('#deleteItem').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var title = button.data('title');
    var id = button.data('id');
    var modal = $(this);
    modal.find('.modal-title').text(title);
    modal.find('.modal-body #id').val(id);
});

// Modal pass package data for send item
$(document).ready(function () {
    $('#sendItem').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var title = button.data('title');
        var voucherId = button.data('id');
        var phoneNumber = button.data('phone');
        
        // Replace +254 or 254 with 0
        if (phoneNumber.startsWith('+254')) {
            phoneNumber = '0' + phoneNumber.substring(4);
        } else if (phoneNumber.startsWith('254')) {
            phoneNumber = '0' + phoneNumber.substring(3);
        } else if (phoneNumber.startsWith('+')) {
            phoneNumber = phoneNumber.substring(1);
        }
        
        var modal = $(this);
        modal.find('#sendItemLabel').text('Send Voucher "' + title + '" to Phone Number');
        modal.find('#voucherId').val(voucherId);
        modal.find('#phoneField').val(phoneNumber);
    });
});



// View item js
$(document).on('click', '.view-item-btn', function () {
   var id = $(this).data('id');
   var title = $(this).data('title');
   var url = '{{ route("voucher.show", ":id") }}';
   url = url.replace(':id', id);
   $.ajax({
      type: 'GET',
      url: url,
      success: function (data) {
         var status = data.status;
         var badgeClass = '';
         if (status === 'expired') {
            badgeClass = 'badge-soft-danger badge-border';
         } else if (status === 'used') {
            badgeClass = 'badge-soft-warning badge-border';
         } else {
            badgeClass = 'badge-soft-info badge-border';
         }
         var html = '<h3>' + title + '</h3>' +
            '<div class="d-flex align-items-center mb-2">' +
            '    <div class="flex-shrink-0">' +
            '        <p class="text-muted mb-0">ID:</p>' +
            '    </div>' +
            '    <div class="flex-grow-1 ms-2">' +
            '        <h6 class="mb-0">' + data.id + '</h6>' +
            '    </div>' +
            '</div>' +
            '<div class="d-flex align-items-center mb-2">' +
            '    <div class="flex-shrink-0">' +
            '        <p class="text-muted mb-0">Status:</p>' +
            '    </div>' +
            '    <div class="flex-grow-1 ms-2">' +
            '        <h6 class="mb-0">' +
            '            <span class="badge ' + badgeClass + ' ">' + status + '</span>' +
            '        </h6>' +
            '    </div>' +
            '</div>' +
            '<div class="d-flex align-items-center mb-2">' +
            '    <div class="flex-shrink-0">' +
            '        <p class="text-muted mb-0">Title:</p>' +
            '    </div>' +
            '    <div class="flex-grow-1 ms-2">' +
            '        <h6 class="mb-0">' + data.title + '</h6>' +
            '    </div>' +
            '</div>' +
            '<div class="d-flex align-items-center mb-2">' +
            '    <div class="flex-shrink-0">' +
            '        <p class="text-muted mb-0">Expiration:</p>' +
            '    </div>' +
            '    <div class="flex-grow-1 ms-2">' +
            '        <h6 class="mb-0">' + (data.expiration_time ? new Date(data.expiration_time).toLocaleString('en-US', {
                     month: 'short',
                     day: 'numeric',
                     year: 'numeric',
                     hour: 'numeric',
                     minute: 'numeric',
                     hour12: true
               }) : 'On Login') + '</h6>' +
            '    </div>' +
            '</div>' +
            '<div class="d-flex align-items-center mb-2">' +
            '    <div class="flex-shrink-0">' +
            '        <p class="text-muted mb-0">Use Limit:</p>' +
            '    </div>' +
            '    <div class="flex-grow-1 ms-2">' +
            '        <h6 class="mb-0">' + data.simultaneous_usage_limit + '</h6>' +
            '    </div>' +
            '</div>' +
            '<div class="d-flex align-items-center mb-2">' +
            '    <div class="flex-shrink-0">' +
            '        <p class="text-muted mb-0">Speed Limit:</p>' +
            '    </div>' +
            '    <div class="flex-grow-1 ms-2">' +
            '        <h6 class="mb-0">' + data.speed_limit + '</h6>' +
            '    </div>' +
            '</div>' +
            '<div class="d-flex align-items-center mb-2">' +
            '    <div class="flex-shrink-0">' +
            '        <p class="text-muted mb-0">Phone:</p>' +
            '    </div>' +
            '    <div class="flex-grow-1 ms-2">' +
            '        <h6 class="mb-0">' + data.phone + '</h6>' +
            '    </div>' +
            '</div>' +
            '<div class="d-flex align-items-center mb-2">' +
            '    <div class="flex-shrink-0">' +
            '        <p class="text-muted mb-0">Created At:</p>' +
            '    </div>' +
            '    <div class="flex-grow-1 ms-2">' +
            '        <h6 class="mb-0">' + new Date(data.created_at).toLocaleString('en-US', {
                        month: 'short',
                        day: 'numeric',
                        year: 'numeric',
                        hour: 'numeric',
                        minute: 'numeric',
                        hour12: true
                  }) + '</h6>' +
            '    </div>' +
            '</div>' +
            '<div class="d-flex align-items-center mb-2">' +
            '    <div class="flex-shrink-0">' +
            '        <p class="text-muted mb-0">Updated At:</p>' +
            '    </div>' +
            '    <div class="flex-grow-1 ms-2">' +
            '        <h6 class="mb-0">' + new Date(data.updated_at).toLocaleString('en-US', {
                        month: 'short',
                        day: 'numeric',
                        year: 'numeric',
                        hour: 'numeric',
                        minute: 'numeric',
                        hour12: true
                  }) + '</h6>' +
            '    </div>' +
            '</div>';
         $('#viewItem .modal-body').html(html);
      },
      error: function (data) {
         console.log('Error:', data);
      }
   });
});
</script>
@endsection