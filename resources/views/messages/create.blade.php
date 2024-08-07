@extends('layouts.master') @section('title') send message @endsection 
@section('css') 
<style>
   #the-count {
   float: right;
   padding: 0.1rem 0 0 0;
   font-size: 0.875rem;
   }
</style>
@endsection 
@section('content') 
{{-- @component('components.breadcrumb') @slot('li_1') Messages @endslot @slot('title') Create @endslot
@endcomponent --}}
<div class="page-title-box d-sm-flex align-items-center justify-content-between">
   <h4 class="mb-sm-0 font-size-18">Single</h4>
   <div class="page-title-right">
      <ol class="breadcrumb m-0">
         <li class="breadcrumb-item"><a href="{{ route('message.index') }}">Messages</a></li>
         <li class="breadcrumb-item active"><a href="{{ route('message.create') }}">Single</a></li>
      </ol>
   </div>
</div>
<!-- .card-->
<div class="row">
   <div class="col-lg-7">
      <div class="card">
         <div class="card-header border-bottom-dashed">
            <div class="d-flex align-items-center">
               <h5 class="card-title mb-0 flex-grow-1"><i class="ri-discuss-line"></i> Send message</h5>
               <div class="flex-shrink-0">
               </div>
            </div>
         </div>
         <div class="card-body pt-0">
            <form action="{{route('message.send')}}" method="POST">
               @csrf
               <div class="modal-body">
                  <div class="mb-3">
                     <label for="client" class="form-label">Client <span
                        class="text-danger">*</span></label>
                     <select name="client" id="client" class="form-control @error('client') is-invalid @enderror" data-choices>
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
                     <textarea name="message" id="message" cols="30" rows="8" maxlength="320" id="message" class="form-control @error('message') is-invalid @enderror"></textarea>
                     @error('message')
                     <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                     </span>
                     @enderror
                  </div>
               </div>
               <div class="modal-footer">
                  <div class="hstack gap-2 justify-content-end">
                     <a href="{{route('message.index')}}" class="btn btn-light">Cancel</a>
                     <button type="submit" class="btn btn-primary" id="add-btn"><i class="ri-send-plane-2-fill"></i> Send</button>
                  </div>
               </div>
            </form>
            <!--end modal -->
         </div>
      </div>
   </div>
   <div class="col-lg-5">
      <div class="card">
         <div class="card-header border-bottom-dashed">
            <div class="d-flex align-items-center">
               <h5 class="card-title mb-0 flex-grow-1"> Customer placeholders</h5>
               <div class="flex-shrink-0"></div>
            </div>
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
               </div>

            </div>
            <!--end modal -->
         </div>
      </div>
      <div class="card">
         <div class="card-header border-bottom-dashed">
            <div class="d-flex align-items-center">
               <h5 class="card-title mb-0 flex-grow-1"> Company placeholders</h5>
               <div class="flex-shrink-0"></div>
            </div>
         </div>
         <div class="card-body pt-0">
            <div class="modal-body">
               <div class="mb-3">
                  <!-- Soft Buttons -->
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
                  {{-- <input type="button" value="[tag_label]" /> --}}
               </div>
            </div>
            <!--end modal -->
         </div>
      </div>
   </div>
</div>
@endsection @section('script')
<script src="{{ URL::asset('/assets/js/jquery-3.6.1.js')}}"></script>
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
@endsection