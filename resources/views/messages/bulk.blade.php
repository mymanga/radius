@extends('layouts.master') @section('title') send bulk message @endsection 
@section('css') 
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.3/css/selectize.min.css">
<style>
   #the-count {
   float: right;
   padding: 0.1rem 0 0 0;
   font-size: 0.875rem;
   }
   .ri-close-fill {
   cursor: pointer;
   margin-left: 5px;
   font-size: 12px;
   color: #ffff;
   } 
   .selectize-control.multi .selectize-input > div {
   cursor: pointer;
   margin: 0 3px 3px 0;
   padding: 2px 6px;
   background: #299cdb;
   color: #fff;
   border: 1px solid #299cdb;
   border-radius: 4px;
   transition: background-color 0.3s ease;
   }
   .selectize-control.multi .selectize-input > div:hover {
   background: #0056b3;
   }
   .selectize-control.multi .selectize-input > div:active {
   background: #003080;
   }
   [data-layout-mode=dark] .selectize-input {
   background-color: var(--vz-input-bg);
   background-clip: padding-box;
   border: 1px solid var(--vz-input-border);
   color: #fff;
   }
   [data-layout-mode=dark] .selectize-input > input {
   color: #fff;
   }
   [data-layout-mode=dark] .selectize-control.multi .selectize-input > div {
   cursor: pointer;
   color: #299cdb;
   background-color: rgba(41,156,219,.1);
   border-color: transparent;
   }
</style>
@endsection 
@section('content') 
{{-- @component('components.breadcrumb') @slot('li_1') Messages @endslot @slot('title') Create @endslot
@endcomponent --}}
<div class="page-title-box d-sm-flex align-items-center justify-content-between">
   <h4 class="mb-sm-0 font-size-18">Bulk</h4>
   <div class="page-title-right">
      <ol class="breadcrumb m-0">
         <li class="breadcrumb-item"><a href="{{ route('message.index') }}">Messages</a></li>
         <li class="breadcrumb-item active"><a href="{{ route('message.bulk') }}">Bulk</a></li>
      </ol>
   </div>
</div>
<div class="row">
   <div class="col-xl-7">
      <div class="card card-height-100">
         <div class="card-header align-items-center d-flex border-bottom-dashed">
            <h4 class="card-title mb-0 flex-grow-1"><i class="ri-discuss-line"></i> Send message</h4>
         </div>
         <!-- end card header -->
         <div class="card-body pt-0">
            <form action="{{ route('message.bulk.send') }}" method="POST">
               @csrf
               <div class="modal-body">
                   
                   <div class="mb-3">
                       <label for="tags" class="form-label">Group tags <span class="text-muted">[search and select]</span></label>
                       <select id="tags" name="tags[]" multiple>
                           <!-- Options will be added dynamically -->
                       </select>
                       <small class="text-muted">Tags are a way of grouping clients. To add a new tag just type and press enter or Tab</small>
                   </div>
                   <div class="mb-3">
                     <label for="phone" class="form-label">Client status <span class="text-danger">*</span></label>
                     <select name="client" class="form-control @error('client') is-invalid @enderror" data-choices>
                         <option value="1">All clients</option>
                         <option value="2">Active clients</option>
                         <option value="3">Inactive clients</option>
                     </select>
                     @error('client')
                     <span class="invalid-feedback" role="alert">
                         <strong>{{ $message }}</strong>
                     </span>
                     @enderror
                 </div>
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
                       <label for="message" class="form-label">Message</label>
                       <div id="the-count">
                           <span class="badge badge-soft-info badge-border fs-12" id="current">0</span>
                           <span class="badge badge-soft-info badge-border fs-12" id="maximum">320</span>
                       </div>
                       <textarea name="message" id="message" cols="30" rows="5" maxlength="320" class="form-control @error('message') is-invalid @enderror"></textarea>
                       @error('message')
                       <span class="invalid-feedback" role="alert">
                           <strong>{{ $message }}</strong>
                       </span>
                       @enderror
                   </div>
                   <!-- Checkbox for strict search -->
                   <div class="mb-3 form-check form-switch form-switch-md">
                        <input type="checkbox" class="form-check-input" id="strict" name="strict">
                        <label class="form-check-label" for="strict">Strict Filter</label><br>
                        <small class="text-muted">When strict filter is enabled, a user has to match all the filters applied, if not, a user can have any of them</small>
                  </div>
                 
               </div>
               <div class="modal-footer">
                   <div class="hstack gap-2 justify-content-end">
                       <a href="{{ route('message.index') }}" class="btn btn-light">Cancel</a>
                       <button type="submit" class="btn btn-primary" id="add-btn"><i class="ri-send-plane-2-fill"></i> Send</button>
                   </div>
               </div>
           </form>
           
            <!--end modal -->
         </div>
         <!-- end cardbody -->
      </div>
      <!-- end card -->
   </div>
   <!-- end col -->
   <div class="col-xl-5">
      <div class="card card-height-100">
         <div class="card-header align-items-center d-flex border-bottom-dashed">
            <h4 class="card-title mb-0 flex-grow-1">Placeholders</h4>
         </div>
         <div class="card-body pt-0">
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
               </div>
            </div>
            <!--end modal -->
         </div>
         <!-- end card body -->
      </div>
      <!-- end card -->
   </div>
</div>
@endsection @section('script')
<script src="{{ URL::asset('/assets/js/jquery-3.6.1.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.3/js/standalone/selectize.min.js"></script>
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
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
<script>
   $(document).ready(function() {
       $('#tags').selectize({
           delimiter: ',',
           persist: false,
           create: function(input) {
               return {
                   value: input,
                   text: input
               };
           },
           load: function(query, callback) {
               if (!query.length) return callback();
               $.ajax({
                   url: '{{ route("fetch.tags") }}',
                   type: 'GET',
                   dataType: 'json',
                   data: {
                       q: query
                   },
                   success: function(response) {
                       // Format response as an array of objects with 'value' and 'text' properties
                       var formattedTags = response.tags.map(function(tag) {
                           return { value: tag, text: tag };
                       });
                       callback(formattedTags);
                   }
               });
           },
           render: {
               item: function(item, escape) {
                   return '<div>' +
                       (item.text ? '<span class="tag">' + escape(item.text) + '</span>' : '') +
                       '<i class="ri-close-fill" data-value="' + escape(item.value) + '"></i>' +
                   '</div>';
               },
               option_create: function(data, escape) {
                   return '<div class="create">Add <strong>' + escape(data.input) + '</strong>&hellip;</div>';
               }
           },
           onItemRemove: function(value) {
               // Handle tag removal logic here
               console.log('Tag removed:', value);
           }
       });
   
       // Event delegation to handle click events on cancel icons
       $(document).on('click', '.ri-close-fill', function(e) {
           e.preventDefault();
           var value = $(this).data('value');
           var selectize = $('#tags')[0].selectize;
           selectize.removeItem(value);
       });
   });
</script>
@endsection