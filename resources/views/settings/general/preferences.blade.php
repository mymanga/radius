@extends('layouts.master') @section('title') preferences settings @endsection
@section('css')
@endsection
@section('content') 
{{-- @component('components.breadcrumb') @slot('li_1') Settings @endslot @slot('title') General @endslot @endcomponent  --}}
<div class="row">
   <div class="col-lg-12">
      <div class="card mt-n4 mx-n4">
         <div class="bg-soft-light">
            @include('settings.general.header')
            <!-- end card body -->
         </div>
      </div>
      <!-- end card -->
   </div>
   <!-- end col -->
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
      <form class="form-margin" action="{{ route('settings.preferences_save') }}" method="POST">
         @csrf
         <!-- Running mode selector Card -->
         <div class="card mb-3">
            <div class="card-header">
               Mode Selector
            </div>
            <div class="card-body">
               <ul class="list-unstyled mb-0">
                  <li class="d-flex">
                     <div class="flex-grow-1">
                        <label for="mode" class="form-check-label fs-14">Running mode</label>
                        <p class="text-muted">Select default system running mode</p>
                     </div>
                     <div class="flex-shrink-0">
                        <select name="mode" class="form-control">
                        <option value="isp" {{ setting('mode') == 'isp' ? 'selected' : '' }}>Full ISP</option>
                        <option value="ppp" {{ setting('mode') == 'ppp' ? 'selected' : '' }}>PPPOE</option>
                        <option value="hotspot" {{ setting('mode') == 'hotspot' ? 'selected' : '' }} >Hotspot</option>
                        </select>
                     </div>
                  </li>
               </ul>
            </div>
         </div>
         <!-- Theme Settings Card -->
         <div class="card mb-3">
            <div class="card-header">
               Theme Settings
            </div>
            <div class="card-body">
               <ul class="list-unstyled mb-0">
                  <li class="d-flex">
                     <div class="flex-grow-1">
                        <label for="Theme" class="form-check-label fs-14">Dark Theme {!! setting('theme') == 'dark' ? '<i class="ri-checkbox-circle-fill text-success"></i>' : '' !!}</label>
                        <p class="text-muted">Enable system dark theme</p>
                     </div>
                     <div class="flex-shrink-0">
                        <div class="form-check form-switch">
                           <div class="form-check form-switch form-switch-md mb-3" dir="ltr">
                              <input type="checkbox" name="theme" {{setting('theme') == 'dark' ? 'checked' : ''}} class="form-check-input" id="customSwitchsizemd">
                              <label class="form-check-label" for="customSwitchsizemd">
                              </label>
                           </div>
                        </div>
                     </div>
                  </li>
               </ul>
            </div>
         </div>
         <!-- SMS Settings Card -->
         <div class="card mb-3">
            <div class="card-header">
               SMS Settings
            </div>
            <div class="card-body">
               <ul class="list-unstyled mb-0">
                  <li class="d-flex">
                     <div class="flex-grow-1">
                        <label for="Theme" class="form-check-label fs-14">Enable SMS {!! setting('sms') == 'enabled' ? '<i class="ri-checkbox-circle-fill text-success"></i>' : '' !!}</label>
                        <p class="text-muted">Enable sending of sms messages to clients</p>
                     </div>
                     <div class="flex-shrink-0">
                        <div class="form-check form-switch">
                           <div class="form-check form-switch form-switch-md mb-3" dir="ltr">
                              <input type="checkbox" name="sms" {{setting('sms') == 'enabled' ? 'checked' : ''}} class="form-check-input" id="customSwitchsizemd">
                              <label class="form-check-label" for="customSwitchsizemd">
                              </label>
                           </div>
                        </div>
                     </div>
                  </li>
                  <li class="d-flex">
                     <div class="flex-grow-1">
                        <label for="gateway" class="form-check-label fs-14">Sms gateway</label>
                        <p class="text-muted">Select default sms gateway</p>
                     </div>
                     <div class="flex-shrink-0">
                        @php
                        $gatewayFunctions = getSmsGatewayFunctions();
                        @endphp
                        <select name="smsgateway" class="form-control">
                        @foreach ($gatewayFunctions as $functionName => $displayName)
                        <option value="{{ $functionName }}" {{ setting('smsgateway') == $functionName ? 'selected' : '' }}>
                        {{ $displayName }}
                        </option>
                        @endforeach
                        </select>
                     </div>
                  </li>
               </ul>
            </div>
         </div>
         <!-- Simple nas Config Settings Card -->
         <div class="card mb-3">
            <div class="card-header">
               Nas settings
            </div>
            <div class="card-body">
               <ul class="list-unstyled mb-0">
                  <li class="d-flex">
                     <div class="flex-grow-1">
                        <label for="nas" class="form-check-label fs-14">Simple config {!! setting('simpleconfig') == 'enabled' ? '<i class="ri-checkbox-circle-fill text-success"></i>' : '' !!}</label>
                        <p class="text-muted d-md-block">Enable simple auto configuration of mikrotik</p>
                     </div>
                     <div class="flex-shrink-0">
                        <div class="form-check form-switch">
                           <div class="form-check form-switch form-switch-md mb-3" dir="ltr">
                              <input type="checkbox" name="simpleconfig" {{setting('simpleconfig') == 'enabled' ? 'checked' : ''}} class="form-check-input" id="customSwitchsizemd">
                              <label class="form-check-label" for="customSwitchsizemd">
                              </label>
                           </div>
                        </div>
                     </div>
                  </li>
                  <li class="d-flex">
                     <div class="flex-grow-1">
                        <label for="nas" class="form-check-label fs-14">Nas reconfig {!! setting('nasreconfig') == 'enabled' ? '<i class="ri-checkbox-circle-fill text-success"></i>' : '' !!}</label>
                        <p class="text-muted d-md-block">Enable reconfiguring of Nas devices</p>
                     </div>
                     <div class="flex-shrink-0">
                        <div class="form-check form-switch">
                           <div class="form-check form-switch form-switch-md mb-3" dir="ltr">
                              <input type="checkbox" name="nasreconfig" {{setting('nasreconfig') == 'enabled' ? 'checked' : ''}} class="form-check-input" id="customSwitchsizemd">
                              <label class="form-check-label" for="customSwitchsizemd">
                              </label>
                           </div>
                        </div>
                     </div>
                  </li>
                  <li class="d-flex">
                     <div class="flex-grow-1">
                        <label for="nas" class="form-check-label fs-14">Nas Notifications {!! setting('nasNotification') == 'enabled' ? '<i class="ri-checkbox-circle-fill text-success"></i>' : '' !!}</label>
                        <p class="text-muted d-md-block">Get notified when a nas becomes unreachable</p>
                     </div>
                     <div class="flex-shrink-0">
                        <div class="form-check form-switch">
                           <div class="form-check form-switch form-switch-md mb-3" dir="ltr">
                              <input type="checkbox" name="nasNotification" {{setting('nasNotification') == 'enabled' ? 'checked' : ''}} class="form-check-input" id="customSwitchsizemd">
                              <label class="form-check-label" for="customSwitchsizemd">
                              </label>
                           </div>
                        </div>
                     </div>
                  </li>
                  <li class="d-flex">
                     <div class="flex-grow-1">
                        <label for="dormancy" class="form-check-label fs-14">Unreachable Duration <small>(Minutes)</small> </label>
                        <p class="text-muted">After how many minutes should you be notified once a nas becomes unreachable?</p>
                     </div>
                     <div class="flex-shrink-0">
                        <input style="max-width:100px" type="number" name="nasUnreachableDuration" class="form-control" value="{{ old('nasUnreachableDuration', setting('nasUnreachableDuration', 5)) }}">
                     </div>
                  </li>
                  <li class="d-flex">
                     <div class="flex-grow-1">
                        <label for="dormancy" class="form-check-label fs-14">Notification Phone </label>
                        <p class="text-muted">Phone number to be notified once nas becomes unreachable</p>
                     </div>
                     <div class="flex-shrink-0">
                        <input style="max-width:150px" type="text" name="nasNotificationPhone" class="form-control" value="{{ old('nasNotificationPhone', setting('nasNotificationPhone')) }}">
                     </div>
                  </li>
               </ul>
            </div>
         </div>
         <!-- M-Pesa Validation Settings Card -->
         <div class="card mb-3">
            <div class="card-header">
               M-Pesa Settings
            </div>
            <div class="card-body">
               <ul class="list-unstyled mb-0">
                  <li class="d-flex">
                     <div class="flex-grow-1">
                        <label for="nas" class="form-check-label fs-14">M-Pesa Validation {!! setting('validation') == 'enabled' ? '<i class="ri-checkbox-circle-fill text-success"></i>' : '' !!}</label>
                        <p class="text-muted">Enable Validation of mpesa transactions <code>[For this to work external validation must be enabled for your paybill. Contact Safaricom]</code></p>
                     </div>
                     <div class="flex-shrink-0">
                        <div class="form-check form-switch">
                           <div class="form-check form-switch form-switch-md mb-3" dir="ltr">
                              <input type="checkbox" name="validation" {{setting('validation') == 'enabled' ? 'checked' : ''}} class="form-check-input" id="customSwitchsizemd">
                              <label class="form-check-label" for="customSwitchsizemd">
                              </label>
                           </div>
                        </div>
                     </div>
                  </li>
               </ul>
            </div>
         </div>
         <!-- Calendar Validity Check Settings Card -->
         <div class="card mb-3">
            <div class="card-header">
               Calendar Settings
            </div>
            <div class="card-body">
               <ul class="list-unstyled mb-0">
                  <li class="d-flex">
                     <div class="flex-grow-1">
                        <label for="nas" class="form-check-label fs-14">Calender vality check {!! setting('calender_vality_check') == 'enabled' ? '<i class="ri-checkbox-circle-fill text-success"></i>' : '' !!}</label>
                        <p class="text-muted">If disabled ppoe account dates can be altered without validity check</p>
                     </div>
                     <div class="flex-shrink-0">
                        <div class="form-check form-switch">
                           <div class="form-check form-switch form-switch-md mb-3" dir="ltr">
                              <input type="checkbox" name="calender_vality_check" {{setting('calender_vality_check') == 'enabled' ? 'checked' : ''}} class="form-check-input" id="customSwitchsizemd">
                              <label class="form-check-label" for="customSwitchsizemd">
                              </label>
                           </div>
                        </div>
                     </div>
                  </li>
               </ul>
            </div>
         </div>
         <!-- Customer Portal Settings Card -->
         <div class="card mb-3">
            <div class="card-header">
               Customer Portal Settings
            </div>
            <div class="card-body">
               <ul class="list-unstyled mb-0">
                  <li class="d-flex">
                     <div class="flex-grow-1">
                        <label for="customerPortal" class="form-check-label fs-14">Enable customer Portal {!! setting('customerPortal') == 'enabled' ? '<i class="ri-checkbox-circle-fill text-success"></i>' : '' !!}</label>
                        <p class="text-muted">Allow customers to access their portal
                        <p>
                     </div>
                     <div class="flex-shrink-0">
                        <div class="form-check form-switch">
                           <div class="form-check form-switch form-switch-md mb-3" dir="ltr">
                              <input type="checkbox" name="customerPortal" {{setting('customerPortal') == 'enabled' ? 'checked' : ''}} class="form-check-input" id="customerPortal">
                              <label class="form-check-label" for="customerPortal"></label>
                           </div>
                        </div>
                     </div>
                  </li>
                  <li class="d-flex">
                     <div class="flex-grow-1">
                        <label for="nas" class="form-check-label fs-14">Allow customers to change the services {!! setting('customerServiceChange') == 'enabled' ? '<i class="ri-checkbox-circle-fill text-success"></i>' : '' !!}</label>
                        <p class="text-muted">Allow customers to change their services in the customer portal</p>
                     </div>
                     <div class="flex-shrink-0">
                        <div class="form-check form-switch">
                           <div class="form-check form-switch form-switch-md mb-3" dir="ltr">
                              <input type="checkbox" name="customerServiceChange" {{setting('customerServiceChange') == 'enabled' ? 'checked' : ''}} class="form-check-input" id="customSwitchsizemd">
                              <label class="form-check-label" for="customSwitchsizemd"></label>
                           </div>
                        </div>
                     </div>
                  </li>
                  <li class="d-flex">
                     <div class="flex-grow-1">
                        <label for="dormancy" class="form-check-label fs-14">Days between service change <small>(days)</small> </label>
                        <p class="text-muted">Number of days before a customer is allowed to change service using their portal (Default is 30 days) <code>[Set 0 to allow changing anytime]</code> </p>
                     </div>
                     <div class="flex-shrink-0">
                        <input style="max-width:100px" type="number" name="change_days" class="form-control" value="{{ old('change_days', setting('change_days', 30)) }}">
                     </div>
                  </li>
               </ul>
            </div>
         </div>
         <!-- Expiration Compensation Settings Card -->
         <div class="card mb-3">
            <div class="card-header">
               Expiration Compensation Settings
            </div>
            <div class="card-body">
               <ul class="list-unstyled mb-0">
                  <li class="d-flex">
                     <div class="flex-grow-1">
                        <label for="dormancy" class="form-check-label fs-14">Expiration compensation <small>(days)</small> </label>
                        <p class="text-muted">Compensate expiration difference. Default is one day</p>
                     </div>
                     <div class="flex-shrink-0">
                        <input style="max-width:100px" type="number" name="expire_compensation" class="form-control" value="{{ old('expire_compensation', setting('expire_compensation', 1)) }}">
                     </div>
                  </li>
               </ul>
            </div>
         </div>
         <!-- Map Provider Settings Card -->
         <div class="card mb-3">
            <div class="card-header">
               Map Provider Settings
            </div>
            <div class="card-body">
               <ul class="list-unstyled mb-0">
                  <li class="d-flex">
                     <div class="flex-grow-1">
                        <label for="gateway" class="form-check-label fs-14">Map provider</label>
                        <p class="text-muted">Select default map system</p>
                     </div>
                     <div class="flex-shrink-0">
                        <select name="map" class="form-control">
                        <option value="openstreet" {{ setting('map') == 'openstreet' ? 'selected' : '' }} >Open Street</option>
                        <option value="google" {{ setting('map') == 'google' ? 'selected' : '' }}>Google Map</option>
                        </select>
                     </div>
                  </li>
               </ul>
            </div>
         </div>
         <!-- Dormant Services Settings Card -->
         <div class="card mb-3">
            <div class="card-header">
               Services Settings
            </div>
            <div class="card-body">
               <ul class="list-unstyled mb-0">
                  <li class="d-flex">
                     <div class="flex-grow-1">
                        <label for="dormancy" class="form-check-label fs-14">Dormant Services</label>
                        <p class="text-muted">Select after how many days services should be considered dormant</p>
                     </div>
                     <div class="flex-shrink-0">
                        <input style="max-width:100px" type="text" max="1" name="dormancy" class="form-control" value="{{setting('dormancy')}}">
                     </div>
                  </li>
                  <li class="d-flex">
                     <div class="flex-grow-1">
                        <label for="dormancy" class="form-check-label fs-14">Block recurring clients</label>
                        <p class="text-muted">Block recurring clients how many days after issuing invoice? (default 14)</p>
                     </div>
                     <div class="flex-shrink-0">
                        <input style="max-width:100px" type="text" max="1" name="block_recurring_clients_days" class="form-control" value="{{setting('block_recurring_clients_days')}}">
                     </div>
                  </li>
                  <li class="d-flex">
                     <div class="flex-grow-1">
                        <label for="dormancy" class="form-check-label fs-14">Installation fee amount</label>
                        <p class="text-muted">How much do you charge for installation</p>
                     </div>
                     <div class="flex-shrink-0">
                        <input style="max-width:100px" type="text" max="1" name="installation_fee" class="form-control" value="{{setting('installation_fee')}}">
                     </div>
                  </li>
               </ul>
            </div>
         </div>

         <!-- Backup code -->
         <div class="card mb-3">
            <div class="card-header">
               System Backup Code
            </div>
            <div class="card-body">
               <ul class="list-unstyled mb-0">
                  <li class="d-flex">
                     <div class="flex-grow-1">
                        <label for="gateway" class="form-check-label fs-14">Backup code</label>
                        <p class="text-muted">If you are reinstalling the system, use the old backup code to find your backups. If you forget the backup code, you wont be able to recover your backups. Also note if you change the backup code, you loose current backups. Current Code: <code class="text-info" style="font-size: 14px"><strong>{{ env('BACKUP_CODE') }}</strong></code></p>
                     </div>
                     <div class="flex-shrink-0">
                        <input style="max-width:200px" type="text" name="backup_code" class="form-control" value="{{ old('backup_code', env('BACKUP_CODE')) }}">
                     </div>
                  </li>
               </ul>
            </div>
         </div>

         <div class="col-12 text-end mb-3">
            <div class="hstack gap-2 justify-content-end">
               <button type="submit" class="btn btn-soft-success" id="add-btn"><i class="las la-save"></i> Save settings</button>
            </div>
         </div>
      </form>
   </div>
</div>
@endsection
@section('script')
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
<script>
   // Get the checkbox for customer portal
   var customerPortalCheckbox = document.getElementById('customerPortal');
   
   // Get the div for changing services
   var changeServicesDiv = document.getElementById('changeServicesDiv');
   
   // Add event listener to the customer portal checkbox
   customerPortalCheckbox.addEventListener('change', function() {
       if (this.checked) {
           changeServicesDiv.style.display = 'block'; // Show the div for changing services
       } else {
           changeServicesDiv.style.display = 'none'; // Hide the div for changing services
       }
   });
</script>
@endsection