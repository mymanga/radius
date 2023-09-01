@extends('layouts.master') @section('title') general settings @endsection
@section('css')
@endsection
@section('content') @component('components.breadcrumb') @slot('li_1') Settings @endslot @slot('title') general @endslot @endcomponent 
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
   <div class="card-header border-bottom-dashed">
      <div class="d-flex align-items-center">
         <h5 class="card-title mb-0 flex-grow-1"><i class="ri-router-line"></i> Company information</h5>
         <div class="flex-shrink-0">
         </div>
      </div>
   </div>
   <div class="card-body">
      <form style="border:1px solid #e9ecef; padding:15px; border-radius:10px" action="{{route('settings.general_save')}}" Method="POST">
         @csrf
         <div class="row mb-3">
            <div class="col-lg-3">
               <label for="nameInput" class="form-label">Company name</label>
            </div>
            <div class="col-lg-9">
               <input type="text" name="company" value="{{Setting::get('company')}}" class="form-control" id="companyname" placeholder="Enter name">
            </div>
         </div>
         <div class="row mb-3">
            <div class="col-lg-3">
               <label for="websiteUrl" class="form-label">Phone number</label>
            </div>
            <div class="col-lg-9">
               <input type="text" name="company_phone" value="{{Setting::get('company_phone')}}" class="form-control" id="companyphone" placeholder="Phone number">
            </div>
         </div>
         <div class="row mb-3">
            <div class="col-lg-3">
               <label for="email" class="form-label">Company email</label>
            </div>
            <div class="col-lg-9">
               <input type="email" name="company_email" value="{{Setting::get('company_email')}}" class="form-control" id="companyemail" placeholder="Email address">
            </div>
         </div>
         <div class="row mb-3">
            <div class="col-lg-3">
               <label for="dateInput" class="form-label">Location</label>
            </div>
            <div class="col-lg-9">
               <input type="text" name="city" value="{{Setting::get('city')}}" class="form-control" id="city" placeholder="Company location">
            </div>
         </div>
         <div class="row mb-3">
            <div class="col-lg-3">
               <label for="meassageInput" class="form-label">About</label>
            </div>
            <div class="col-lg-9">
               <textarea class="form-control" name="about" id="about" rows="4" placeholder="Brief description">{{Setting::get('about')}}</textarea>
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
@endsection
@section('script')
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection