@extends('layouts.master') @section('title') {{ ucFirst($gateway) }} @endsection
@section('css')
@endsection
@section('content') 
{{-- 
<div class="row">
   <div class="col-lg-12">
      <div class="card mt-n4 mx-n4">
         <div class="bg-soft-light">
            @include('settings.sms.header')
            <!-- end card body -->
         </div>
      </div>
      <!-- end card -->
   </div>
   <!-- end col -->
</div>
--}}
@component('components.breadcrumb')
@slot('li_1') Gateway @endslot
@slot('title') {{ ucFirst($gateway) }} @endslot
@endcomponent
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
      <div class="card">
         {{-- 
         <div class="card-header border-bottom-dashed">
            <div class="d-flex align-items-center">
               <h5 class="card-title mb-0 flex-grow-1"> {{ ucFirst($gateway) }}</h5>
               <div class="flex-shrink-0">
               </div>
            </div>
         </div>
         --}}
         <div class="card-body">
            <form class="form-margin" action="{{route('settings.sms_save')}}" Method="POST">
               @csrf
               @php
               $gatewayClass = '\App\Gateways\UserDefined\\' . ucfirst($gateway) . 'SmsGateway';
               $configParameters = $gatewayClass::getConfigParameters();
               @endphp
               @foreach ($configParameters as $name => $config)
               @if (isset($config['name']) && $config['type'] !== 'hidden')
               <div class="row mb-3">
                  <div class="col-lg-3">
                     <label for="{{ $name }}" class="form-label">{{ $config['label'] }}</label>
                  </div>
                  <div class="col-lg-9">
                     @if ($config['type'] === 'select' && isset($config['options']))
                     <select name="{{ $config['name'] }}" class="form-control" id="{{ $name }}">
                     @foreach ($config['options'] as $optionValue => $optionLabel)
                     <option value="{{ $optionValue }}" {{ $config['value'] == $optionValue ? 'selected' : '' }}>
                     {{ $optionLabel }}
                     </option>
                     @endforeach
                     </select>
                     @else
                     <input type="{{ $config['type'] }}" name="{{ $config['name'] }}" value="{{ $config['value'] }}" class="form-control{{ $config['value'] === null ? ' is-invalid' : '' }}" id="{{ $name }}" placeholder="{{ $config['label'] }}">
                     @if ($config['value'] === null)
                     <div class="invalid-feedback">Parameter is missing</div>
                     @endif
                     @endif
                  </div>
               </div>
               @endif
               @endforeach
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
@endsection
@section('script')
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection