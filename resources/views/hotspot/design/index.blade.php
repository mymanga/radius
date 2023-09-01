@extends('layouts.master') @section('title') hotspot design @endsection
@section('css')
@endsection
@section('content') 
{{-- @component('components.breadcrumb') @slot('li_1') Settings @endslot @slot('title') General @endslot @endcomponent  --}}
<div class="row">
   <div class="col-lg-12">
      <div class="card mt-n4 mx-n4">
         <div class="bg-soft-light">
            @include('hotspot.design.header')
            <!-- end card body -->
         </div>
      </div>
      <!-- end card -->
   </div>
   <!-- end col -->
</div>
<div class="row justify-content-center">
   <div class="col-lg-8 col-md-10">
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
      {{-- <div class="d-flex align-items-center mb-3">
         <div class="flex-grow-1">
         </div>
         <div class="flexshrink-0">
            <button id="refresh-btn" class="btn btn-soft-info btn-md" data-bs-toggle="modal" data-bs-target="#uploadModal">
            <i class="ri-upload-line align-bottom me-1"></i> Upload template
            </button>
         </div>
      </div> --}}
      <form class="form-margin" action="{{route('settings.general_save')}}" Method="POST" enctype="multipart/form-data">
         @csrf
         <div class="row mb-3">
            @if (count($files) > 0)
            @foreach ($files as $file)
            <div class="col-md-6">
               @php
               $fileName = $file->getFilename();
               $templateName = str_replace('.blade.php', '', $fileName);
               $isSelected = (setting('hotspot_template') == $templateName);
               @endphp
               <div class="card">
                  <div class="card-header border-bottom-dashed">
                     <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1"> {{ strtoupper($templateName) }}</h5>
                        <div class="flex-shrink-0">
                        </div>
                     </div>
                  </div>
                  <div class="card-body">
                     <!-- checkbox -->
                     <div class="form-check form-switch form-switch-md mb-3" dir="ltr">
                        <input type="checkbox" name="hotspot_template" class="form-check-input" id="{{ $templateName }}" {{ $isSelected ? 'checked' : '' }} value="{{ $templateName }}">
                        <label class="form-check-label" for="{{ $templateName }}">
                        <img class="img-thumbnail" src="{{ asset('images/' . $templateName . '-template.png') }}" alt="{{ ucfirst($templateName) }} Template" width="100%" height="100%">
                        </label>
                     </div>
                  </div>
               </div>
            </div>
            @endforeach
            @else
            <p>No template files found.</p>
            @endif
         </div>
         {{-- 
         <div class="row mb-3">
            <div class="col-lg-3">
               <label for="cover" class="form-label">Cover image</label>
            </div>
            <div class="col-lg-9">
               <input type="file" name="hotspot_cover" class="form-control" id="HotspotCover">
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
         --}}
         <div class="col-12 text-end">
            <div class="hstack gap-2 justify-content-end">
               <button type="submit" class="btn btn-soft-success"
                  id="add-btn"><i class="las la-save"></i> Save settings</button>
            </div>
         </div>
      </form>
      <!-- Modal -->
      <div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
         <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title" id="uploadModalLabel">Upload Zip File</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               </div>
               <div class="modal-body">
                  <form action="{{ route('hotspot.upload_template') }}" method="POST" enctype="multipart/form-data">
                     @csrf
                     <div class="mb-3">
                        <label for="zipFile" class="form-label">Choose Zip File</label>
                        <input type="file" class="form-control" id="zipFile" name="template">
                     </div>
                     <button type="submit" class="btn btn-primary">Upload</button>
                  </form>
               </div>
            </div>
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
<script>
   // the selector will match all input controls of type :checkbox
   // and attach a click event handler 
   $("input:checkbox").on('click', function() {
   // in the handler, 'this' refers to the box clicked on
   var $box = $(this);
   if ($box.is(":checked")) {
   // the name of the box is retrieved using the .attr() method
   // as it is assumed and expected to be immutable
   var group = "input:checkbox[name='" + $box.attr("name") + "']";
   // the checked state of the group/box on the other hand will change
   // and the current value is retrieved using .prop() method
   $(group).prop("checked", false);
   $box.prop("checked", true);
   } else {
   $box.prop("checked", false);
   }
   });
</script>
@endsection