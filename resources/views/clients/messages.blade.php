@extends('layouts.master') @section('title') Client Messages @endsection @section('css')
<link href="{{URL::asset('assets/js/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{URL::asset('assets/css/datatable-custom.css')}}" rel="stylesheet" type="text/css" />
@endsection @section('content') 
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
   <div class="col-lg-12">
      <div class="d-flex align-items-center mb-3">
         <div class="flex-grow-1">
         </div>
         <div class="flexshrink-0">
            <button class="btn btn-primary btn-label waves-effect waves-light btn-sm add-btn" data-bs-toggle="modal" data-bs-target="#sendMessageModal">
            <i class="ri-add-line label-icon align-middle fs-16 me-2"></i> Send Message
            </button>
         </div>
      </div>
      @if($errors->any())
      <div class="alert alert-danger">
         <ul>
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
         </ul>
      </div>
      @endif
      @if(session('success'))
      <div class="alert alert-success alert-dismissible alert-label-icon rounded-label fade show" role="alert">
         <i class="ri-check-line label-icon"></i><strong>Success</strong> - {{ session('success') }}
         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      @endif
      @if(session('error'))
      <div class="alert alert-danger alert-dismissible alert-label-icon rounded-label fade show" role="alert">
         <i class="ri-error-warning-line label-icon"></i><strong>Error</strong> - {{ session('error') }}
         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      @endif
   
   <div class="card">
         <div class="card-body">
            <div>
               <div class="table-responsive table-card mb-1">
                  <table class="table table-nowrap align-middle table-striped" id="messages-table" style="width: 100%;">
                     <thead>
                  <tr class="text-muted">
                     <th></th>
                     <th>Sender</th>
                     <th>Message</th>
                     <th>Gateway</th>
                     <th>Created At</th>
                  </tr>
               </thead>
               <tbody>
                  @if (count($messages) > 0)
                  @foreach($messages as $message)
                  <tr>
                     <td>{{ $message->id }}</td>
                     <td>{{ $message->sender ?? 'N/A' }}</td>
                     <td class="message-cell" style="white-space: normal; min-width: 100px;">{{ $message->message ?? 'N/A' }}</td>
                     <td>{{ $message->gateway ?? 'N/A' }}</td>
                     <td>{{ $message->created_at ? $message->created_at->format('d M Y H:i') : 'N/A' }}</td>
                  </tr>
                  @endforeach
                  @endif
               </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>

   </div>
</div>
<!--end col-->
<!-- Modal for sending a message -->
<!-- Modal for sending a message -->
<div class="modal fade" id="sendMessageModal" tabindex="-1" role="dialog" aria-labelledby="sendMessageModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
         <div class="modal-header p-3 bg-info-subtle">
            <h5 class="modal-title" id="sendMessageModalLabel">Send Message</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
         </div>
         <form action="{{ route('client.message.send',[$client->id]) }}" method="POST">
            @csrf
            <div class="modal-body">
               @if(isset($templates) && count($templates) > 0)
               <div class="mb-3">
                  <label for="templates" class="form-label">Use template</label>
                  <select class="form-control" id="templates">
                     <option value="" disabled selected hidden>Select template</option>
                     @foreach($templates as $template)
                     <option value="{{ $template->content }}">{{ $template->title }}</option>
                     @endforeach
                  </select>
               </div>
               @endif
               <div class="mb-3" id="modal-id">
                  <div class="d-flex justify-content-between align-items-center">
                     <label for="message" class="form-label">Message</label>
                     <div id="the-count" class="d-flex align-items-center">
                        <span class="badge badge-soft-info badge-border fs-12 mr-2" id="current">0</span>
                        <span class="badge badge-soft-info badge-border fs-12" id="maximum">320</span>
                     </div>
                  </div>
                  <textarea name="message" id="message" cols="30" rows="8" maxlength="320" class="form-control @error('message') is-invalid @enderror">{{ old('message') }}</textarea>
                  @error('message')
                  <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                  </span>
                  @enderror
               </div>
            </div>
            <div class="card">
               <div class="card-header border-bottom-dashed mb-3">
                  <div class="d-flex align-items-center">
                     <h5 class="card-title mb-0 flex-grow-1 text-muted"> Placeholders</h5>
                     <div class="flex-shrink-0"></div>
                  </div>
               </div>
               <div class="card-body">
                  <div class="modal-body">
                     <div class="mb-3">
                        <!-- Soft Buttons -->
                        <span class="tag">
                           <button type="button" class="btn btn-soft-info waves-effect waves-light mb-2" value="@{{ $client_username }}">Username</button>
                        </span>
                        <span class="tag">
                           <button type="button" class="btn btn-soft-info waves-effect waves-light mb-2" value="@{{ $client_password }}">Password</button>
                        </span>
                        @if (setting('lb_url') && setting('lb_url') != '')
                        <span class="tag">
                           <button type="button" class="btn btn-soft-info waves-effect waves-light mb-2" value="@{{ $customer_portal }}">Customer Portal</button>
                        </span>
                        @endif
                        <span class="tag">
                           <button type="button" class="btn btn-soft-info waves-effect waves-light mb-2" value="@{{ $first_name }}">First Name</button>
                        </span>
                        <span class="tag">
                           <button type="button" class="btn btn-soft-info waves-effect waves-light mb-2" value="@{{ $last_name }}">Last Name</button>
                        </span>
                        <span class="tag">
                           <button type="button" class="btn btn-soft-info waves-effect waves-light mb-2" value="@{{ $client_name }}">Full name</button>
                        </span>
                        <span class="tag">
                           <button type="button" class="btn btn-soft-info waves-effect waves-light mb-2" value="@{{ $acc_number }}">Acc Number</button>
                        </span>
                        <span class="tag">
                           <button type="button" class="btn btn-soft-info waves-effect waves-light mb-2" value="@{{ $client_phone }}">Phone Number</button>
                        </span>
                        <span class="tag">
                           <button type="button" class="btn btn-soft-info waves-effect waves-light mb-2" value="@{{ $client_email }}">Email Address</button>
                        </span>
                        <span class="tag">
                           <button type="button" class="btn btn-soft-info waves-effect waves-light mb-2" value="@{{ $days_to_expiry }}">Days before expiry</button>
                        </span>
                        <span class="tag">
                           <button type="button" class="btn btn-soft-info waves-effect waves-light mb-2" value="@{{ $service_name }}">Service name</button>
                        </span>
                        <span class="tag">
                           <button type="button" class="btn btn-soft-info waves-effect waves-light mb-2" value="@{{ $service_price }}">Service Price</button>
                        </span>
                        <span class="tag">
                           <button type="button" class="btn btn-soft-info waves-effect waves-light mb-2" value="@{{ $service_expiry }}">Expiry date</button>
                        </span>
                        <span class="tag">
                           <button type="button" class="btn btn-soft-info waves-effect waves-light mb-2" value="@{{ $company_name }}">Company name</button>
                        </span>
                        <span class="tag">
                           <button type="button" class="btn btn-soft-info waves-effect waves-light mb-2" value="@{{ $company_email }}">Company email</button>
                        </span>
                        <span class="tag">
                           <button type="button" class="btn btn-soft-info waves-effect waves-light mb-2" value="@{{ $company_phone }}">Company phone</button>
                        </span>
                        <span class="tag">
                           <button type="button" class="btn btn-soft-info waves-effect waves-light mb-2" value="@{{ $company_city }}">Company location</button>
                        </span>
                        {{-- <span class="tag">
                            <button type="button" class="btn btn-soft-info waves-effect waves-light mb-2" value="@{{ $paybill_number }}">Paybill</button>
                        </span> --}}
                     </div>
                  </div>
                  <!--end modal -->
               </div>
            </div>
            <div class="modal-footer">
               <div class="hstack gap-2 justify-content-end">
                  <a href="{{ route('clients.communication',[$client->username]) }}" class="btn btn-light">Cancel</a>
                  <button type="submit" class="btn btn-soft-info" id="add-btn"><i class="las la-save"></i> Submit</button>
               </div>
            </div>
         </form>
      </div>
   </div>
</div>
<!--end row-->
@endsection 
@section('script')
<script src="{{ URL::asset('/assets/js/jquery-3.6.1.js')}}"></script>
<script src="{{ URL::asset('/assets/js/datatables/datatables.min.js') }}"></script>
<!-- Include Moment.js library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

<!-- Include DataTables Moment.js plugin -->
<script src="https://cdn.datatables.net/plug-ins/1.10.25/sorting/datetime-moment.js"></script>
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@if (count($errors) > 0)
<script type="text/javascript">
   $(document).ready(function () {
       $("#sendMessageModal").modal("show");
   });
</script>
@endif 
<script>
$(document).ready(function () {
    $('#messages-table').DataTable({
        "order": [[0, "desc"]], 
        "pageLength": 25,
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
   $("textarea").keyup(function () {
     var characterCount = $(this).val().length,
       current = $("#current"),
       maximum = $("#maximum"),
       theCount = $("#the-count");
   
     current.text(characterCount);
   
     /*This isn't entirely necessary, just playin around*/
     if (characterCount < 70) {
       current.css("color", "#666");
     }
     if (characterCount > 70 && characterCount < 90) {
       current.css("color", "#6d5555");
     }
     if (characterCount > 90 && characterCount < 100) {
       current.css("color", "#793535");
     }
     if (characterCount > 100 && characterCount < 120) {
       current.css("color", "#841c1c");
     }
     if (characterCount > 120 && characterCount < 139) {
       current.css("color", "#8f0001");
     }
   
     if (characterCount >= 140) {
       maximum.css("color", "#8f0001");
       current.css("color", "#8f0001");
       theCount.css("font-weight", "bold");
     } else {
       maximum.css("color", "#666");
       theCount.css("font-weight", "normal");
     }
   });
</script>
<script>
   // Get the select dropdown element
   const templatesSelect = document.getElementById('templates');
   
   // Get the message textarea element
   const messageTextarea = document.getElementById('message');
   
   // Add an event listener to the select dropdown to update the message textarea if the select element exists
   if (templatesSelect) {
    templatesSelect.addEventListener('change', (event) => {
        const selectedTemplate = event.target.value;
        messageTextarea.value = selectedTemplate;
    });
   }
</script>

<script>
   $('button[type=button]').on('click', function() {
     var cursorPos = $('#message').prop('selectionStart');
     var v = $('#message').val();
     var textBefore = v.substring(0, cursorPos);
     var textAfter = v.substring(cursorPos, v.length);
     $('#message').val(textBefore + $(this).val() + textAfter);
   });
</script>
@endsection