@extends('layouts.master') 
@section('title') @lang('translation.leads') @endsection 
@section('css')
<link href="{{URL::asset('assets/js/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{URL::asset('assets/css/datatable-custom.css')}}" rel="stylesheet" type="text/css" />
@endsection 
@section('content') 
{{-- @component('components.breadcrumb') @slot('li_1') Plan @endslot @slot('title') Edit @endslot @endcomponent  --}}
<div class="page-title-box d-sm-flex align-items-center justify-content-between">
   <h4 class="mb-sm-0 font-size-18">Edit</h4>
   <div class="page-title-right">
      <ol class="breadcrumb m-0">
         <li class="breadcrumb-item"><a href="{{ route('hotspot.index') }}">Hotspot</a></li>
         <li class="breadcrumb-item active"><a href="{{ route('plan.index') }}">Plans</a></li>
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
         - {!! session('error') !!}
         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      <br />
      @endif
      <div class="card">
         <div class="card-body">
            <div>
               <form action="{{ route('plan.update', $plan->id) }}" method="POST">
                  @csrf
                  @method('PUT')
                  <div class="mb-3">
                     <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                     <input type="text" name="title" value="{{ old('title', $plan->title) }}" id="title" class="form-control @error('title') is-invalid @enderror" aria-label="title" placeholder="title" />
                     @error('title')
                        <div class="text-danger">{{ $message }}</div>
                     @enderror
                  </div>
                  <div class="mb-3">
                     <label for="description" class="form-label">Description</label>
                     <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" aria-label="description" placeholder="description">{{ old('description', $plan->description) }}</textarea>
                     @error('description')
                        <div class="text-danger">{{ $message }}</div>
                     @enderror
                  </div>
                  <div class="mb-3">
                     <label for="duration" class="form-label">Duration <small>(at least 5 minutes)</small> </label>
                     <div class="input-group">
                        <input type="number" name="duration" value="{{ old('duration', $plan->duration) }}" id="duration" class="form-control @error('duration') is-invalid @enderror" aria-label="duration" />
                        <select name="duration_unit" id="duration_unit" class="form-select">
                        <option {{ old('duration_unit') == 'minutes' ? 'selected' : '' }} value="minutes">Minutes</option>
                        <option {{ old('duration_unit') == 'hours' ? 'selected' : '' }} value="hours">Hours</option>
                        <option {{ old('duration_unit') == 'days' ? 'selected' : '' }} value="days">Days</option>
                        </select>
                     </div>
                     @error('duration')
                        <div class="text-danger">{{ $message }}</div>
                     @enderror
                  </div>
                  <div class="mb-3">
                     <label for="price" class="form-label">Price</label>
                     <input type="number" name="price" value="{{ old('price', $plan->price) }}" step="0.01" id="price" class="form-control @error('price') is-invalid @enderror" aria-label="price" />
                     @error('price')
                        <div class="text-danger">{{ $message }}</div>
                     @enderror
                  </div>
                  <div class="mb-3">
                     <label for="simultaneous_use_limit" class="form-label">Simultaneous Use Limit</label>
                     <input type="number" name="simultaneous_use_limit" value="{{ $plan->simultaneous_use_limit }}" id="simultaneous_use_limit" class="form-control @error('simultaneous_use_limit') is-invalid @enderror" aria-label="simultaneous_use_limit" />
                     @error('simultaneous_use_limit')
                        <div class="text-danger">{{ $message }}</div>
                     @enderror
                  </div>
                  <div class="mb-3">
                     <label for="speed_limit" class="form-label">Speed Limit <small> - (Mbps)</small></label>
                     <input type="number" name="speed_limit" value="{{ $plan->speed_limit }}" id="speed_limit" class="form-control @error('speed_limit') is-invalid @enderror" aria-label="speed_limit" />
                     @error('speed_limit')
                        <div class="text-danger">{{ $message }}</div>
                     @enderror
                  </div>
                  <div class="mb-3">
                     <div class="form-check form-switch form-switch-md mb-3" dir="ltr">
                        <input type="checkbox" name="public" class="form-check-input" id="customSwitchsizemd" {{ old('public') ? 'checked' : ($plan->public ? 'checked' : '') }}>
                        <label class="form-check-label" for="customSwitchsizemd">Public hotspot plan?</label>
                     </div>
                  </div>
                  <div class="modal-footer">
                     {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> --}}
                     <button type="submit" class="btn btn-primary">Update Plan</button>
                  </div>
               </form>
            </div>
            <!-- Create plan modal -->
         </div>
      </div>
   </div>
   <!--end col-->
</div>
<!--end row-->
@endsection @section('script')
<script src="{{ URL::asset('/assets/js/jquery-3.6.1.js')}}"></script>
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection