@extends('layouts.master') @section('title') create sms template @endsection @section('css') @endsection @section('content') 
{{-- @component('components.breadcrumb') @slot('li_1') Create @endslot @slot('title') SMS Template @endslot
@endcomponent --}}
<div class="page-title-box d-sm-flex align-items-center justify-content-between">
   <h4 class="mb-sm-0 font-size-18">Sms Template</h4>
   <div class="page-title-right">
      <ol class="breadcrumb m-0">
         <li class="breadcrumb-item"><a href="{{ route('templates.index') }}">Templates</a></li>
         <li class="breadcrumb-item active"><a href="{{ route('template.createsmstemplate') }}">Sms</a></li>
      </ol>
   </div>
</div>

<!-- .card-->
<div class="row">
   <div class="col-lg-7">
      <div class="card">
         <div class="card-header border-bottom-dashed">
            <div class="d-flex align-items-center">
               <h5 class="card-title mb-0 flex-grow-1"><i class="ri-message-line"></i> Create SMS Template</h5>
               <div class="flex-shrink-0"></div>
            </div>
         </div>
         <div class="card-body pt-0">
            <form action="{{route('template.smsstore')}}" method="POST">
               @csrf
               <div class="modal-body">
                  <div class="mb-3" id="modal-id">
                     <label for="title" class="form-label">Title</label>
                     <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" placeholder="Template title" value="{{old('title')}}" />
                     @error('title')
                     <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                     </span>
                     @enderror
                  </div>
                  <div class="mb-3" id="modal-id">
                     <label for="description" class="form-label">Description</label>
                     <input type="text" name="description" id="description" class="form-control @error('description') is-invalid @enderror" placeholder="Template description" value="{{old('description')}}" />
                     @error('description')
                     <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                     </span>
                     @enderror
                  </div>
                  <div class="mb-3">
                     <label for="editor" class="form-label">Content </label>
                     <textarea name="content" id="editor" cols="30" rows="10" spellcheck="false" class="form-control @error('content') is-invalid @enderror"">{{old('content')}}</textarea>
                     @error('content')
                     <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                     </span>
                     @enderror
                  </div>
               </div>
               <div class="modal-footer">
                  <div class="hstack gap-2 justify-content-end">
                     <a href="{{route('templates.index')}}" class="btn btn-light">Cancel</a>
                     <button type="submit" class="btn btn-soft-success" id="add-btn"><i class="las la-save"></i> Save</button>
                  </div>
               </div>
            </form>
            <!--end modal -->
         </div>
      </div>
   </div>
   @include('settings.templates.placeholders')
</div>
@endsection @section('script')
<script src="{{ URL::asset('/assets/js/jquery-3.6.1.js')}}"></script>
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
<script>
   $('button[type=button]').on('click', function() {
     var cursorPos = $('#editor').prop('selectionStart');
     var v = $('#editor').val();
     var textBefore = v.substring(0, cursorPos);
     var textAfter = v.substring(cursorPos, v.length);
     $('#editor').val(textBefore + $(this).val() + textAfter);
   });
</script>

<script>
$("textarea").each(function () {
  this.setAttribute("style", "height:" + (this.scrollHeight) + "px;overflow-y:hidden;");
}).on("input", function () {
  this.style.height = 0;
  this.style.height = (this.scrollHeight) + "px";
})
</script>
@endsection