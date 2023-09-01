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
                     <label for="duration" class="form-label">Duration <code>[Leave blank for unlimited]</code> </label>
                     <div class="input-group">
                        @php
                        $durationValue = old('duration', $plan->duration);
                        $durationUnit = old('duration_unit', 'minutes'); // Default unit
                        if ($durationValue >= 60 * 24) {
                        $durationValue /= 60 * 24;
                        $durationUnit = 'days';
                        $formattedDuration = floor($durationValue);
                        } elseif ($durationValue >= 60) {
                        $durationValue /= 60;
                        $durationUnit = 'hours';
                        $formattedDuration = floor($durationValue);
                        } else {
                        $formattedDuration = ($durationValue == floor($durationValue)) ? $durationValue : sprintf('%.2f', $durationValue);
                        }
                        @endphp
                        <input type="number" name="duration" value="{{ $formattedDuration }}" id="duration" class="form-control @error('duration') is-invalid @enderror" aria-label="duration" />
                        <select name="duration_unit" id="duration_unit" class="form-select">
                        <option {{ $durationUnit == 'minutes' ? 'selected' : '' }} value="minutes">Minutes</option>
                        <option {{ $durationUnit == 'hours' ? 'selected' : '' }} value="hours">Hours</option>
                        <option {{ $durationUnit == 'days' ? 'selected' : '' }} value="days">Days</option>
                        </select>
                     </div>
                     @error('duration')
                     <div class="text-danger">{{ $message }}</div>
                     @enderror
                  </div>
                  <div class="mb-3">
                     <label for="data_limit" class="form-label">Total Data Limit</label>
                     <div class="input-group">
                        @php
                        $dataLimitValue = old('data_limit', $plan->data_limit);
                        $dataLimitUnit = old('data_limit_unit', 'MB'); // Default unit from old input
                        if ($dataLimitValue >= 1024 * 1024 * 1024) {
                        $dataLimitValue /= 1024 * 1024 * 1024;
                        $dataLimitUnit = 'GB';
                        } elseif ($dataLimitValue >= 1024 * 1024) {
                        $dataLimitValue /= 1024 * 1024;
                        $dataLimitUnit = 'MB';
                        }
                        $formattedDataLimit = sprintf('%.2f', $dataLimitValue);
                        @endphp
                        <input type="number" name="data_limit" value="{{ $formattedDataLimit }}" id="data_limit" class="form-control @error('data_limit') is-invalid @enderror" aria-label="data_limit" />
                        <select name="data_limit_unit" id="data_limit_unit" class="form-select">
                        <option {{ $dataLimitUnit == 'MB' ? 'selected' : '' }} value="MB">MB</option>
                        <option {{ $dataLimitUnit == 'GB' ? 'selected' : '' }} value="GB">GB</option>
                        </select>
                     </div>
                     @error('data_limit')
                     <div class="text-danger">{{ $message }}</div>
                     @enderror
                     <div class="text-muted">Current Limit: {{ $plan->data_limit ? formatSizeUnits($plan->data_limit) : 'N/A' }}</div>
                  </div>
                  <!-- Add Valid Time Range fields here -->
                  <div class="row">
                     <div class="col">
                        <div class="mb-3">
                           <label for="valid_from" class="form-label">Valid From <small>(Time)</small></label>
                           <div class="input-group">
                              <input type="text" name="valid_from" id="valid_from" class="form-control @error('valid_from') is-invalid @enderror" data-provider="timepickr" data-default-time="" value="{{ old('valid_from', $plan->valid_from) }}" placeholder="select time" />
                              <button type="button" class="btn btn-soft-info" onclick="document.getElementById('valid_from').value = ''">Clear</button>
                           </div>
                           @error('valid_from')
                           <div class="text-danger">{{ $message }}</div>
                           @enderror
                        </div>
                     </div>
                     <div class="col">
                        <div class="mb-3">
                           <label for="valid_to" class="form-label">Valid To <small>(Time)</small></label>
                           <div class="input-group">
                              <input type="text" name="valid_to" id="valid_to" class="form-control @error('valid_to') is-invalid @enderror" data-provider="timepickr" data-default-time="" value="{{ old('valid_to', $plan->valid_to) }}" placeholder="select time" />
                              <button type="button" class="btn btn-soft-info" onclick="document.getElementById('valid_to').value = ''">Clear</button>
                           </div>
                           @error('valid_to')
                           <div class="text-danger">{{ $message }}</div>
                           @enderror
                        </div>
                     </div>
                  </div>
                  <!-- Add Valid Days field here -->
                  <div class="mb-3">
                     <label for="valid_days" class="form-label">Valid Days <small>(leave blank for all days)</small></label>
                     <div class="row">
                        @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                        <div class="col-md-3">
                              <input type="checkbox" id="valid_days" name="valid_days[]" value="{{ $day }}" {{ in_array($day, old('valid_days', json_decode($plan->valid_days)) ?? []) ? 'checked' : '' }}>
                              <label for="{{ $day }}">{{ $day }}</label>
                        </div>
                        @endforeach
                     </div>
                     @error('valid_days')
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
                  <div class="card bg-soft-warning">
                     <div class="card-body">
                        <div class="mb-3">
                           <div class="form-check form-switch form-switch-md mb-3" dir="ltr">
                              <input type="checkbox" name="offer" class="form-check-input" id="customSwitchoffer" {{ old('offer', $plan->offer) ? 'checked' : '' }}>
                              <label class="form-check-label" for="customSwitchoffer">Is this plan on offer?</label>
                           </div>
                        </div>
                        <div class="mb-3">
                           <label for="offer_details" class="form-label">Offer Details</label>
                           <textarea name="offer_details" id="offer_details" class="form-control @error('offer_details') is-invalid @enderror" aria-label="offer_details" placeholder="offer_details">{{ old('offer_details', $plan->offer_details) }}</textarea>
                           @error('offer_details')
                           <div class="text-danger">{{ $message }}</div>
                           @enderror
                        </div>
                        <div class="mb-3">
                           <label for="discount_rate" class="form-label">Discount Rate (%)</label>
                           <input type="number" name="discount_rate" value="{{ old('discount_rate', $plan->discount_rate) }}" step="0.01" min="0" id="discount_rate" class="form-control @error('discount_rate') is-invalid @enderror" aria-label="discount_rate" />
                           @error('discount_rate')
                           <div class="text-danger">{{ $message }}</div>
                           @enderror
                        </div>
                     </div>
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
                  @foreach($errors->all() as $error)
    {{$error}}
@endforeach

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