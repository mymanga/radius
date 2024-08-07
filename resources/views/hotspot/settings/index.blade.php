@extends('layouts.master') @section('title') hotspot settings @endsection
@section('css')
<style>
   .file-upload-button {
   display: inline-block;
   padding: 6px 12px;
   background-color: rgba(41,156,219,.1);
   border: none;
   border-radius: 0px;
   color: #299cdb;
   cursor: pointer;
   transition: background-color 0.3s ease;
   text-decoration: none;
   font-weight:400;
   line-height: 1.5;
   text-align: center;
   white-space: nowrap;
   vertical-align: middle;
   }
   .file-upload-button:hover {
   background-color: #6cb5f9;
   color: #ffffff;
   }
   .file-upload-button:active {
   background-color: #004085;
   }
   .file-upload-button input[type="file"] {
   display: none;
   }
</style>
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
   <form class="form-margin" action="{{route('settings.general_save')}}" Method="POST" enctype="multipart/form-data">
      @csrf
      <div class="row">
         <div class="col-lg-8">
            <div class="card">
            <div class="card-header border-bottom-dashed bg-soft-warning">
               <div class="d-flex align-items-center">
                  <h5 class="card-title mb-0 flex-grow-1 text-muted"> General</h5>
                  <div class="flex-shrink-0">
                  </div>
               </div>
            </div>
               <div class="card-body">
                  <div class="mb-3">
                     <label class="form-label" for="hotspot-name">Hotspot name</label>
                     <input type="text" name="hotspotName" value="{{Setting::get('hotspotName')}}" class="form-control" id="hotspot-name" placeholder="Enter hotspot name">
                  </div>
                  <div class="mb-3">
                     <label for="hotspotContactLink" class="form-label">Contact us Link</label>
                     <input type="url" name="hotspotContactLink" value="{{Setting::get('hotspotContactLink')}}" class="form-control" id="hotspotContactLink" placeholder="Enter contact us">
                  </div>
                  <div class="mb-3">
                     <label for="editor" class="form-label">Hotspot Info</label>
                     <textarea class="form-control" name="hotspot_info" id="editor" rows="4" placeholder="Give details how to get vouchers">{{Setting::get('hotspot_info')}}</textarea>
                  </div>
               </div>
               <!-- end card body -->
            </div>
            <!-- end card -->
            <div class="card">
               <div class="card-header mb-0 bg-soft-warning" style="position: relative;">
                  <h5 class="card-title mb-0 text-muted">
                     Banner
                  </h5>
                  <label for="HotspotCover" class="file-upload-button" style="position: absolute; top: 50%; right: 0; transform: translateY(-50%);">
                  <i class="ri-upload-cloud-2-fill"></i> Select image
                  <input type="file" name="hotspot_cover" id="HotspotCover" accept="image/*">
                  </label>
               </div>
               <div class="card-body" style="padding:0px;">
                  <img id="preview-image" src="{{ asset('images/' . setting('hotspot_cover')) }}" alt="Preview Image" style="max-width: 100%; height: auto;">
               </div>
               <!-- end card body -->
            </div>
            <!-- end card -->
         </div>
         <!-- end col -->
         <div class="col-lg-4">
            <div class="card">
               <div class="card-header border-bottom-dashed bg-soft-warning">
               <div class="d-flex align-items-center">
                  <h5 class="card-title mb-0 flex-grow-1 text-muted"> Preferences</h5>
                  <div class="flex-shrink-0">
                  </div>
               </div>
            </div>
               <div class="card-body">
                  <div>
                     <label for="payment-method">Payment Method</label>
                     <select name="hotspotPaymentMethod" class="form-select" data-choices data-choices-search-false id="payment-method">
                     <option value="mpesa" {{setting('hotspotPaymentMethod')=='mpesa' ? 'selected' : ''}}>M-Pesa Paybill</option>
                     <option value="kopokopo" {{setting('hotspotPaymentMethod')=='kopokopo' ? 'selected' : ''}}>Kopokopo</option>
                     </select>
                  </div>
                  <br>
                  <div>
                     <label for="voucher-expiration">Voucher Expiration</label>
                     <select name="voucherExpiration" class="form-select" data-choices data-choices-search-false id="voucher-expiration">
                     <option value="creation" {{setting('voucherExpiration')=='creation' ? 'selected' : ''}}>Expire after creation</option>
                     <option value="login" {{setting('voucherExpiration')=='login' ? 'selected' : ''}}>Expire after login</option>
                     </select>
                  </div>
                  <br>
                  <div>
                     <label for="voucher-expiration">Voucher Code Type</label>
                     <select name="voucherType" class="form-select" data-choices data-choices-search-false id="voucher-type">
                     <option value="mixed" {{setting('voucherType')=='mixed' ? 'selected' : ''}}>Mixed</option>
                     <option value="numeric" {{setting('voucherType')=='numeric' ? 'selected' : ''}}>Numeric</option>
                     <option value="words" {{setting('voucherType')=='words' ? 'selected' : ''}}>Words</option>
                     </select>
                  </div>
                  <br>
                  <div id="custom-length">
                     <label for="voucher-length">Number of characters </label>
                     <input type="number" name="voucherLength" value="{{ setting('voucherLength') }}" id="voucher-length" min="1" class="form-control">
                  </div>
                  <br>
                  {{-- <label for="customSwitchsizemd" class="form-label">Automatic SMS {!! setting('autoSms') == 'enabled' ? '<i class="ri-checkbox-circle-fill text-success"></i>' : '' !!} </label>
                  <div class="form-check form-switch form-switch-md mb-3" dir="ltr">
                     <input type="checkbox" name="autoSms" {{setting('autoSms') == 'enabled' ? 'checked' : ''}} class="form-check-input" id="customSwitchsizemd">
                     <label class="form-check-label" for="customSwitchsizemd">
                     </label>
                  </div> --}}
               </div>
               <!-- end card body -->
            </div>
            
            <!-- end card -->
         </div>
         <!-- end col -->
      </div>
      <div class="text-end mb-4">
         <button type="submit" class="btn btn-soft-success w-sm">Save settings</button>
      </div>
   </form>
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
<script type="text/javascript">
    $(document).ready(function() {
        var voucherType = $('#voucher-type').val();
        if (voucherType === 'mixed' || voucherType === 'numeric') {
            $('#custom-length').show();
        } else {
            $('#custom-length').hide();
        }

        $('#voucher-type').change(function() {
            if ($(this).val() === 'mixed' || $(this).val() === 'numeric') {
                $('#custom-length').slideDown();
            } else {
                $('#custom-length').slideUp();
            }
        });
    });
</script>

@endsection