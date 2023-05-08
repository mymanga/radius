@extends('layouts.master') @section('title') hotspot settings @endsection
@section('css')
@endsection
@section('content') 
<div class="page-title-box d-sm-flex align-items-center justify-content-between">
   <h4 class="mb-sm-0 font-size-18">Settings</h4>
   <div class="page-title-right">
      <ol class="breadcrumb m-0">
         <li class="breadcrumb-item"><a href="{{ route('hotspot.index') }}">Hotspot</a></li>
         <li class="breadcrumb-item active"><a href="{{ route('hotspot.settings') }}">Settings</a></li>
      </ol>
   </div>
</div>
<div class="row justify-content-center">
   <div class="col-lg-8">
      @if (session('status'))
      <div class="alert alert-success alert-dismissible alert-label-icon label-arrow fade show" role="alert">
         <i class="ri-check-double-line label-icon"></i><strong>Success</strong> - {{session('status')}}
         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      @endif @if (session('error'))
      <div class="alert alert-danger alert-dismissible alert-label-icon label-arrow fade show mb-xl-0" role="alert">
         <i class="ri-error-warning-line label-icon"></i><strong>Failed</strong>
         - {{session('error')}}
         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      <br />
      @endif
      <div class="d-flex align-items-center mb-3">
         <div class="flex-grow-1">
         </div>
         <div class="flexshrink-0"> <a href="{{route('hotspot.generateMikrotikFiles')}}" class="btn btn-soft-info btn-md"><i class="ri-download-2-line align-bottom me-1"></i> Download template</a> </div>
      </div>
      <div class="card">
         <div class="card-header border-bottom-dashed">
            <div class="d-flex align-items-center">
               <h5 class="card-title mb-0 flex-grow-1"><i class="ri-wifi-fill"></i> Hotspot Config</h5>
               <div class="flex-shrink-0">
               </div>
            </div>
         </div>
         <div class="card-body">
            <form class="form-margin" action="{{route('settings.general_save')}}" Method="POST" enctype="multipart/form-data">
               @csrf
               <div class="row mb-3">
                  <div class="col-lg-3">
                     <label for="nameInput" class="form-label">Hotspot name</label>
                  </div>
                  <div class="col-lg-9">
                     <input type="text" name="hotspotName" value="{{Setting::get('hotspotName')}}" class="form-control" id="hotspotName" placeholder="Enter hotspot name">
                  </div>
               </div>
               <div class="mb-3">
                  <ul class="list-unstyled mb-0">
                     <li class="d-flex">
                        <div class="flex-grow-1">
                           <label for="Theme" class="form-check-label fs-14">Automatic SMS {!! setting('autoSms') == 'enabled' ? '<i class="ri-checkbox-circle-fill text-success"></i>' : '' !!}</label>
                           <p class="text-muted d-none d-md-block">Enable automatic sms without prompt</p>
                        </div>
                        <div class="flex-shrink-0">
                           <div class="form-check form-switch">
                              <div class="form-check form-switch form-switch-md mb-3" dir="ltr">
                                 <input type="checkbox" name="autoSms" {{setting('autoSms') == 'enabled' ? 'checked' : ''}} class="form-check-input" id="customSwitchsizemd">
                                 <label class="form-check-label" for="customSwitchsizemd">
                                 </label>
                              </div>
                           </div>
                        </div>
                     </li>
                  </ul>
               </div>
               <div class="mb-3">
                  <ul class="list-unstyled mb-0">
                     <li class="d-flex">
                        <div class="flex-grow-1">
                           <label for="Theme" class="form-check-label fs-14">Payment Method</label>
                           <p class="text-muted d-none d-md-block">Choose prefered payment for hotspot</p>
                        </div>
                        <div class="flex-shrink-0">
                           <select name="hotspotPaymentMethod" class="form-control">
                           <option value="mpesa" {{setting('hotspotPaymentMethod')=='mpesa' ? 'selected' : ''}}>M-Pesa</option>
                           <option value="kopokopo" {{setting('hotspotPaymentMethod')=='kopokopo' ? 'selected' : ''}}>Kopokopo</option>
                           </select>
                        </div>
                     </li>
                  </ul>
               </div>
               <div class="mb-3">
                  <ul class="list-unstyled mb-0">
                     <li class="d-flex">
                        <div class="flex-grow-1">
                           <label for="voucherExpiration" class="form-check-label fs-14">Voucher Expiration</label>
                           <p class="text-muted d-none d-md-block">Choose whether vouchers should expire after creation or login</p>
                        </div>
                        <div class="flex-shrink-0">
                           <select name="voucherExpiration" class="form-control">
                           <option value="creation" {{setting('voucherExpiration')=='creation' ? 'selected' : ''}}>Expire after creation</option>
                           <option value="login" {{setting('voucherExpiration')=='login' ? 'selected' : ''}}>Expire after login</option>
                           </select>
                        </div>
                     </li>
                  </ul>
               </div>
               <div class="row mb-3">
                  <div class="col-lg-3">
                     <label for="linkInput" class="form-label">Contact us Link</label>
                  </div>
                  <div class="col-lg-9">
                     <input type="url" name="hotspotContactLink" value="{{Setting::get('hotspotContactLink')}}" class="form-control" id="hotspotContactLink" placeholder="Enter contact us">
                  </div>
               </div>
               <div class="row mb-3">
                  <div class="col-lg-3">
                     <label for="cover" class="form-label">Cover image</label>
                  </div>
                  <div class="col-lg-9">
                     <input type="file" name="hotspot_cover" id="HotspotCover" class="form-control" accept="image/*">
                     <img id="preview-image" class="img-thumbnail" src="{{ asset('images/' . setting('hotspot_cover')) }}" alt="Preview Image" style="max-width: 100%; height: auto; margin-top: 10px;">
                  </div>
               </div>
               <div class="row mb-3">
                  <div class="col-lg-12">
                     <label for="hotspotInfo" class="form-label">Hotspot Info</label>
                  </div>
                  <div class="col-lg-12">
                     <textarea class="form-control" name="hotspot_info" id="editor" rows="4" placeholder="Give details how to get vouchers">{{Setting::get('hotspot_info')}}</textarea>
                  </div>
               </div>
               <div class="col-12 text-end">
                  <div class="hstack gap-2 justify-content-end">
                     <button type="submit" class="btn btn-soft-success"
                        id="add-btn"><i class="las la-save"></i> Save</button>
                  </div>
               </div>
            </form>
            <!--end modal -->
         </div>
      </div>
   </div>
</div>
<!-- Modal for errors -->
<div class="modal fade" id="error-modal" tabindex="-1" role="dialog" aria-labelledby="error-modal-title" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="error-modal-title">Error</h5>
         </div>
         <div class="modal-body">
            <p class="text-danger" id="error-modal-message"></p>
         </div>
         <div class="modal-footer">
            <button class="btn btn-link link-success fw-medium text-decoration-none" data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i>
            Close</button>
         </div>
      </div>
   </div>
</div>
@php
$latitude = setting('latitude') ?? 0;
$longitude = setting('longitude') ?? 0;
@endphp
@endsection
@section('script')
<script src="{{ URL::asset('/assets/js/jquery-3.6.1.js')}}"></script>
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
<script src="https://unpkg.com/compressorjs@1.1.0/dist/compressor.min.js"></script>
<script>
   ClassicEditor
   .create(document.querySelector('#editor'), {
      removePlugins: ['CKFinderUploadAdapter', 'CKFinder', 'EasyImage', 'Image', 'ImageCaption', 'ImageStyle', 'ImageToolbar', 'ImageUpload', 'MediaEmbed'],
      toolbar: {
         items: [
            // list the toolbar items you want to keep here
            'heading', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote'
         ]
      }
   })
   .catch( error => {
       console.error( error );
   } );
   
</script>
<script>
   $(document).ready(function() {
     $('#HotspotCover').change(function() {
       var fileInput = $('#HotspotCover')[0];
       var file = fileInput.files[0];
   
       // Check if file is an image
       if (!file.type.startsWith('image/')) {
         $('#error-modal-message').text('Please select an image file');
         $('#error-modal').modal('show');
         return;
       }
   
       // Check if image has minimum dimensions of 800x400
       var img = new Image();
       img.onload = function() {
         if (this.width < 800 || this.height < 450) {
           $('#error-modal-message').text('Please select an image with minimum dimensions of 800x450');
           $('#error-modal').modal('show');
           return;
         }
   
         // Create a canvas element and draw the image on it
         var canvas = document.createElement('canvas');
         canvas.width = 800;
         canvas.height = 450;
         var ctx = canvas.getContext('2d');
         ctx.drawImage(img, 0, 0, 800, 450);
   
         // Compress canvas using Compressor.js
         canvas.toBlob(function(blob) {
           new Compressor(blob, {
             quality: 0.6,
             success: function(result) {
               // Convert compressed Blob to File object and append to FormData
               var compressedFile = new File([result], file.name, { type: result.type });
               var formData = new FormData();
               formData.append('hotspot_cover', compressedFile);
   
               // Send FormData using AJAX
               $.ajax({
                 url: "{{ route('hotspotcover.upload') }}",
                 type: 'POST',
                 headers: {
                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                 },
                 data: formData,
                 processData: false,
                 contentType: false,
                 success: function (response) {
                   $('#preview-image').attr('src', response.url);
                 },
                 error: function (xhr) {
                   $('#error-modal-message').text(xhr.responseText);
                   $('#error-modal').modal('show');
                 }
               });
             },
             error: function(err) {
               $('#error-modal-message').text(err.message);
               $('#error-modal').modal('show');
             }
           });
         }, file.type);
       };
   
       img.src = URL.createObjectURL(file);
     });
   });
</script>
@endsection