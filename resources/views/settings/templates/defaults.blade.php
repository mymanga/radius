@extends('layouts.master') @section('title') default template settings @endsection
@section('css')
@endsection
@section('content') 
{{-- @component('components.breadcrumb') @slot('li_1') Settings @endslot @slot('title') General @endslot @endcomponent  --}}
<div class="row">
   <div class="col-lg-12">
      <div class="card mt-n4 mx-n4">
         <div class="bg-soft-light">
            @include('settings.templates.header')
            <!-- end card body -->
         </div>
      </div>
      <!-- end card -->
   </div>
   <!-- end col -->
</div>
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
<div class="card">
   {{-- 
   <div class="card-header border-bottom-dashed">
      <div class="d-flex align-items-center">
         <h5 class="card-title mb-0 flex-grow-1"><i class="ri-mail-line"></i> Africas Talking</h5>
         <div class="flex-shrink-0">
         </div>
      </div>
   </div>
   --}}
   <div class="card-body">
      <form class="row g-3" method="POST"
         action="{{ route('settings.defaults.save') }}" enctype="multipart/form-data">
         @csrf
         <div class="col-md-6">
            <label for="welcomesms" class="form-label">Welcome SMS</label>
            <select name="welcomesms" id="welcomesms" class="form-control">
               <option value="" disabled="" selected="">Select template</option>
               @foreach($smsTemplates as $template)
               <option value="{{$template->id}}" @if(setting('welcomesms') == $template->id)
               selected
               @endif>{{$template->title}}</option>
               @endforeach
            </select>
         </div>
         <div class="col-md-6">
            <label for="welcomemail" class="form-label">Welcome Email</label>
            <select name="welcomemail" id="welcomemail" class="form-control">
               <option value="" disabled="" selected="">Select template</option>
               @foreach($emailTemplates as $template)
               <option value="{{$template->id}}" @if(setting('welcomemail') == $template->id)
               selected
               @endif>{{$template->title}}</option>
               @endforeach
            </select>
         </div>
         <div class="col-md-6">
            <label for="remindersms" class="form-label">Expiration reminder SMS</label>
            <select name="remindersms" id="remindersms" class="form-control">
               <option value="" disabled="" selected="">Select template</option>
               @foreach($smsTemplates as $template)
               <option value="{{$template->id}}" @if(setting('remindersms') == $template->id)
               selected
               @endif>{{$template->title}}</option>
               @endforeach
            </select>
         </div>
         <div class="col-md-6">
            <label for="reminderemail" class="form-label">Expiration reminder Email</label>
            <select name="reminderemail" id="reminderemail" class="form-control">
               <option value="" disabled="" selected="">Select template</option>
               @foreach($emailTemplates as $template)
               <option value="{{$template->id}}" @if(setting('reminderemail') == $template->id)
               selected
               @endif>{{$template->title}}</option>
               @endforeach
            </select>
         </div>

         <div class="col-md-6">
            <label for="renewalsms" class="form-label">Service renewal SMS</label>
            <select name="renewalsms" id="renewalsms" class="form-control">
               <option value="" disabled="" selected="">Select template</option>
               @foreach($smsTemplates as $template)
               <option value="{{$template->id}}" @if(setting('renewalsms') == $template->id)
               selected
               @endif>{{$template->title}}</option>
               @endforeach
            </select>
         </div>
         <div class="col-md-6">
            <label for="renewalemail" class="form-label">Service renewal Email</label>
            <select name="renewalemail" id="renewalemail" class="form-control">
               <option value="" disabled="" selected="">Select template</option>
               @foreach($emailTemplates as $template)
               <option value="{{$template->id}}" @if(setting('renewalemail') == $template->id)
               selected
               @endif>{{$template->title}}</option>
               @endforeach
            </select>
         </div>

         <div class="col-md-6">
            <label for="deactivationsms" class="form-label">Deactivation SMS</label>
            <select name="deactivationsms" id="deactivationsms" class="form-control">
               <option value="" disabled="" selected="">Select template</option>
               @foreach($smsTemplates as $template)
               <option value="{{$template->id}}" @if(setting('deactivationsms') == $template->id)
               selected
               @endif>{{$template->title}}</option>
               @endforeach
            </select>
         </div>
         <div class="col-md-6">
            <label for="deactivationemail" class="form-label">Deactivation Email</label>
            <select name="deactivationemail" id="deactivationemail" class="form-control">
               <option value="" disabled="" selected="">Select template</option>
               @foreach($emailTemplates as $template)
               <option value="{{$template->id}}" @if(setting('deactivationemail') == $template->id)
               selected
               @endif>{{$template->title}}</option>
               @endforeach
            </select>
         </div>
         <div class="mt-4">
            <button class="btn btn-soft-info w-100" type="submit"><i class="las la-save"></i> Save settings</button>
         </div>
      </form>
      <!--end modal -->
   </div>
</div>
@endsection
@section('script')
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection