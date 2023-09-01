@extends('layouts.master') @section('title') edit template @endsection @section('css') @endsection @section('content') 
@component('components.breadcrumb') @slot('li_1') Edit @endslot @slot('title') {{$template->type}} Template @endslot
@endcomponent
<!-- .card-->
<div class="row">
   <div class="col-lg-7">
      <div class="card">
         <div class="card-header border-bottom-dashed">
            <div class="d-flex align-items-center">
               <h5 class="card-title mb-0 flex-grow-1"> {{$template->title}}</h5>
               <div class="flex-shrink-0"></div>
            </div>
         </div>
         <div class="card-body pt-0">
            <form action="{{route('template.update',[$template->id])}}" method="POST">
               @csrf
               @method('patch')
               <div class="modal-body">
                  <div class="mb-3" id="modal-id">
                     <label for="title" class="form-label">Title</label>
                     <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" placeholder="Template title" value="{{old('title') ? old('title') : $template->title}}" />
                     @error('title')
                     <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                     </span>
                     @enderror
                  </div>
                  <div class="mb-3" id="modal-id">
                     <label for="description" class="form-label">Description</label>
                     <input type="text" name="description" id="description" class="form-control @error('description') is-invalid @enderror" placeholder="Template description" value="{{old('description') ? old('description') : $template->description}}" />
                     @error('description')
                     <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                     </span>
                     @enderror
                  </div>
                  <div class="mb-3">
                     <label for="content" class="form-label">Content </label>
                     <textarea name="content" id="editor" cols="30" rows="10" spellcheck="false" class="form-control @error('content') is-invalid @enderror">{{old('content') ? old('content') : $template->content}}</textarea>
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
                     <button type="submit" class="btn btn-soft-success" id="add-btn"><i class="las la-save"></i> Update</button>
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
<script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
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
{{-- <script>
   ClassicEditor
       .create(document.querySelector('#editor'), {
          removePlugins: ['CKFinderUploadAdapter', 'CKFinder', 'EasyImage', 'Image', 'ImageCaption', 'ImageStyle', 'ImageToolbar', 'ImageUpload', 'MediaEmbed'],
       })
       .catch( error => {
           console.error( error );
       } );     
</script> --}}
@endsection