@extends('layouts.master') @section('title') hotspot design @endsection
@section('css')
<!-- Lightbox2 CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" />
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
   <div class="col-lg-10 col-md-10">
      @if (session('status'))
      <div class="alert alert-primary alert-dismissible alert-label-icon label-arrow fade show" role="alert">
         <i class="ri-check-double-line label-icon"></i><strong>Success</strong> - {{ session('status') }}
         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      @endif
      @if (session('error'))
      <div class="alert alert-danger alert-dismissible alert-label-icon label-arrow fade show mb-xl-0" role="alert">
         <i class="ri-error-warning-line label-icon"></i><strong>Failed</strong> - {{ session('error') }}
         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      <br />
      @endif
      <form class="form-margin" action="{{route('settings.general_save')}}" method="POST" enctype="multipart/form-data">
         @csrf
         <div class="row mb-3">
            @if (count($files) > 0)
            @foreach ($files as $file)
            <div class="col-md-4 mb-4">
               @php
               $fileName = $file->getFilename();
               $templateName = str_replace('.blade.php', '', $fileName);
               $isSelected = (setting('hotspot_template') == $templateName);
               $imageUrl = asset('images/' . $templateName . '-template.png');
               @endphp
               <div class="card border rounded shadow-sm">
                  <div class="card-header border-bottom-dashed">
                     <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">{{ strtoupper($templateName) }}</h5>
                     </div>
                  </div>
                  <div class="card-body">
                     <div class="form-check form-switch form-switch-md mb-3" dir="ltr">
                        <input type="checkbox" name="hotspot_template" class="form-check-input" id="{{ $templateName }}" {{ $isSelected ? 'checked' : '' }} value="{{ $templateName }}">
                        <label class="form-check-label" for="{{ $templateName }}">
                           <a href="{{ $imageUrl }}" data-lightbox="{{ $templateName }}" data-title="{{ strtoupper($templateName) }} Preview" style="text-decoration: none; color: #000;">
                              <img src="{{ $imageUrl }}" alt="{{ $templateName }}" class="img-fluid rounded" style="max-height: 200px;">
                              <div class="text-center text-info mt-2">Preview Image</div>
                           </a>
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
         <div class="col-12 text-end mb-3">
            <div class="hstack gap-2 justify-content-end">
               <button type="submit" class="btn btn-soft-info" id="add-btn"><i class="las la-save"></i> Save settings</button>
            </div>
         </div>
      </form>
   </div>
</div>

@php
$latitude = setting('latitude') ?? 0;
$longitude = setting('longitude') ?? 0;
@endphp
@endsection
@section('script')
<script src="{{ URL::asset('/assets/js/jquery-3.6.1.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
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