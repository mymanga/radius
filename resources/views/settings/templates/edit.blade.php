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
                  <span class="tag"><button type="button" class="btn btn-soft-info waves-effect waves-light mb-2" value="@{{$clientID}}">ID</button></span>
                  <span class="tag"><button type="button" class="btn btn-soft-info waves-effect waves-light mb-2" value="@{{$clientUsername}}">Username</button></span>
                  <span class="tag"><button type="button" class="btn btn-soft-info waves-effect waves-light mb-2" value="@{{$clientPassword}}">Password</button></span>
                  <span class="tag"><button type="button" class="btn btn-soft-info waves-effect waves-light mb-2" value="@{{$firstname}}">First Name</button></span>
                  <span class="tag"><button type="button" class="btn btn-soft-info waves-effect waves-light mb-2" value="@{{$lastname}}">Last name</button></span>
                  <span class="tag"><button type="button" class="btn btn-soft-info waves-effect waves-light mb-2" value="@{{$clientName}}">Full name</button></span>
                  <span class="tag"><button type="button" class="btn btn-soft-info waves-effect waves-light mb-2" value="@{{$AccNumber}}">Acc Number</button></span>
                  <span class="tag"><button type="button" class="btn btn-soft-info waves-effect waves-light mb-2" value="@{{$ClientPhone}}">Phone Number</button></span>
                  <span class="tag"><button type="button" class="btn btn-soft-info waves-effect waves-light mb-2" value="@{{$ClientEmail}}">Email Address</button></span>
                  <span class="tag"><button type="button" class="btn btn-soft-info waves-effect waves-light mb-2" value="@{{$daysToExpiry}}">Days before expiry</button></span>
                  {{-- <input type="button" value="[tag_label]" /> --}}
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
                  <span class="tag"><button type="button" class="btn btn-soft-info waves-effect waves-light mb-2" value="@{{$companyName}}">Company name</button></span>
                  <span class="tag"><button type="button" class="btn btn-soft-info waves-effect waves-light mb-2" value="@{{$companyEmail}}">company email</button></span>
                  <span class="tag"><button type="button" class="btn btn-soft-info waves-effect waves-light mb-2" value="@{{$companyPhone}}">company Phone</button></span>
                  <span class="tag"><button type="button" class="btn btn-soft-info waves-effect waves-light mb-2" value="@{{$companyCity}}">company location</button></span>
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