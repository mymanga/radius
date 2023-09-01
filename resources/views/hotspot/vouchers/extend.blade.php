@extends('layouts.master')
@section('title') 
Extend vouchers
@endsection
@section('css')
@endsection
@section('content')
{{-- @component('components.breadcrumb')
@slot('li_1') Finance @endslot
@slot('title') Reports @endslot
@endcomponent --}}
<div class="page-title-box d-sm-flex align-items-center justify-content-between">
   <h4 class="mb-sm-0 font-size-18">Extend</h4>
   <div class="page-title-right">
      <ol class="breadcrumb m-0">
         <li class="breadcrumb-item"><a href="{{ route('voucher.index') }}">Vouchers</a></li>
         <li class="breadcrumb-item active"><a href="{{ route('voucher.extend') }}">Extend</a></li>
      </ol>
   </div>
</div>
<!-- .card-->
<div class="row justify-content-center">
   <div class="col-lg-8">
      <div class="card">
         <div class="card-body p-0">
            <div class="tab-content p-0">
               <div class="tab-pane active" id="report" role="tabpanel">
                  <div class="p-3 bg-soft-warning">
                     <h6 class="mb-0 text-danger text-center">Extend Vouchers Expiration</h6>
                  </div>
                  <form action="{{ route('extend_vouchers') }}" method="POST">
                     @csrf
                     <div class="p-3">
                        <div class="row">
                           <div class="col-md-6">
                              <div class="mb-3">
                                 <label>Start Date :</label>
                                 <input class="form-control @error('start_date') is-invalid @enderror" type="text" id="start_date" name="start_date" data-provider="flatpickr" data-date-format="Y-m-d" data-enable-time placeholder="start date" value="{{old('start_date')}}">
                                 @error('start_date')
                                 <div class="text-danger">{{ $message }}</div>
                                 @enderror
                              </div>
                           </div>
                           <!-- end col -->
                           <div class="col-md-6">
                              <div class="mb-3">
                                 <label>End Date :</label>
                                 <input class="form-control @error('end_date') is-invalid @enderror" type="text" id="end_date" name="end_date" data-provider="flatpickr" data-date-format="Y-m-d" data-enable-time placeholder="end date" value="{{old('end_date')}}">
                                 @error('end_date')
                                 <div class="text-danger">{{ $message }}</div>
                                 @enderror
                              </div>
                           </div>
                           <!-- end col -->
                           <div class="col-md-12">
                              <div class="mb-3">
                                 <label for="plan_id" class="form-label">Select Plan <span class="text-danger">*</span></label>
                                 <select name="plan_id" id="plan_id" class="form-select @error('plan_id') is-invalid @enderror" aria-label="plan_id">
                                    <option value="" selected disabled>Select Plan</option>
                                    @foreach($plans as $plan)
                                    <option value="{{ $plan->id }}" {{ old('plan_id') == $plan->id ? 'selected' : '' }}>{{ $plan->title }}</option>
                                    @endforeach
                                 </select>
                                 @error('plan_id')
                                 <div class="text-danger">{{ $message }}</div>
                                 @enderror
                              </div>
                           </div>
                           <div class="mb-3">
                              <label for="duration" class="form-label">Extend Duration </label>
                              <div class="input-group">
                                 <input type="number" name="duration" value="{{ old('duration', 0) }}" id="duration" class="form-control @error('duration') is-invalid @enderror" aria-label="duration" />
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
                           @if(setting('autoSms') !== 'enabled')
                           <div class="mb-3">
                              <ul class="list-unstyled mb-0">
                                 <li class="d-flex">
                                    <div class="flex-grow-1">
                                       <label for="Theme" class="form-check-label fs-14">Send sms </label>
                                       <p class="text-muted d-none d-md-block">Send sms to customers who purchased vouchers</p>
                                    </div>
                                    <div class="flex-shrink-0">
                                       <div class="form-check form-switch">
                                          <div class="form-check form-switch form-switch-md mb-3" dir="ltr">
                                             <input type="checkbox" name="sms" class="form-check-input" id="customSwitchsizemd">
                                             <label class="form-check-label" for="customSwitchsizemd">
                                             </label>
                                          </div>
                                       </div>
                                    </div>
                                 </li>
                              </ul>
                           </div>
                           @endif
                           <!-- end col -->
                        </div>
                        <!-- end row -->
                        <div class="mt-3 pt-2">
                           <button type="submit" class="btn btn-primary w-100">Extend Vouchers</button>
                        </div>
                     </div>
                  </form>
               </div>
               <!-- end tabpane -->
            </div>
            <!-- end tab pane -->
         </div>
         <!-- end card body -->
      </div>
      <!-- end card -->
   </div>
   <!-- end col -->
</div>
@endsection
@section('script')
<script src="{{asset('assets/js/app.js')}}"></script>
@endsection