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
<div class="row justify-content-center">
   <div class="col-lg-8">
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
                     <label for="phone" class="form-label">Client <span
                        class="text-danger">*</span></label>
                     <select name="client" class="form-control @error('client') is-invalid @enderror" data-choices>
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
                        <span class="badge badge-soft-info badge-border fs-12" id="maximum">160</span>
                     </div>
                     <textarea name="message" id="message" cols="30" rows="5" maxlength="160" id="message" class="form-control @error('message') is-invalid @enderror"></textarea>
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
@endsection