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
      <div class="card">
         {{-- 
         <div class="card-header border-bottom-dashed">
            <div class="d-flex align-items-center">
               <h5 class="card-title mb-0 flex-grow-1"><i class="ri-mail-line"></i> Preferences</h5>
               <div class="flex-shrink-0">
               </div>
            </div>
         </div>
         --}}
         <div class="card-body">
            <form class="form-margin" action="{{route('settings.preferences_save')}}" Method="POST">
               @csrf
               <div class="tab-pane active" id="privacy" role="tabpanel">
                  <div class="mb-3">
                     <ul class="list-unstyled mb-0">
                        <li class="d-flex">
                           <div class="flex-grow-1">
                              <label for="Theme" class="form-check-label fs-14">Dark Theme {!! setting('theme') == 'dark' ? '<i class="ri-checkbox-circle-fill text-success"></i>' : '' !!}</label>
                              <p class="text-muted d-none d-md-block">Enable system dark theme</p>
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
                  <div class="mb-3">
                     <ul class="list-unstyled mb-0">
                        <li class="d-flex">
                           <div class="flex-grow-1">
                              <label for="Theme" class="form-check-label fs-14">Enable SMS {!! setting('sms') == 'enabled' ? '<i class="ri-checkbox-circle-fill text-success"></i>' : '' !!}</label>
                              <p class="text-muted d-none d-md-block">Enable sending of sms messages to clients</p>
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
                     </ul>
                  </div>
                  <div class="mb-3">
                     <ul class="list-unstyled mb-0">
                        <li class="d-flex">
                           <div class="flex-grow-1">
                              <label for="Theme" class="form-check-label fs-14">Sms gateway</label>
                              <p class="text-muted d-none d-md-block">Select default sms gateway</p>
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
                  <div class="mb-3">
                     <ul class="list-unstyled mb-0">
                        <li class="d-flex">
                           <div class="flex-grow-1">
                              <label for="nas" class="form-check-label fs-14">Simple config {!! setting('simpleconfig') == 'enabled' ? '<i class="ri-checkbox-circle-fill text-success"></i>' : '' !!}</label>
                              <p class="text-muted d-none d-md-block">Enable simple auto configuration of mikrotik</p>
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
                     </ul>
                  </div>
                  <div class="mb-3">
                     <ul class="list-unstyled mb-0">
                        <li class="d-flex">
                           <div class="flex-grow-1">
                              <label for="nas" class="form-check-label fs-14">Nas reconfig {!! setting('nasreconfig') == 'enabled' ? '<i class="ri-checkbox-circle-fill text-success"></i>' : '' !!}</label>
                              <p class="text-muted d-none d-md-block">Enable reconfiguring of Nas devices</p>
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
                     </ul>
                  </div>
                  <div class="mb-3">
                     <ul class="list-unstyled mb-0">
                        <li class="d-flex">
                           <div class="flex-grow-1">
                              <label for="nas" class="form-check-label fs-14">M-Pesa Validation {!! setting('validation') == 'enabled' ? '<i class="ri-checkbox-circle-fill text-success"></i>' : '' !!}</label>
                              <p class="text-muted d-none d-md-block">Enable Validation of mpesa transactions <code>[For this to work external validation must be enabled for your paybill. Contact Safaricom]</code></p>
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
                  <div class="mb-3">
                     <ul class="list-unstyled mb-0">
                        <li class="d-flex">
                           <div class="flex-grow-1">
                              <label for="googlemap" class="form-check-label fs-14">Use Google Map {!! setting('googlemap') == 'enabled' ? '<i class="ri-checkbox-circle-fill text-success"></i>' : '' !!}</label>
                              <p class="text-muted d-none d-md-block">Enable displaying of maps in the system</p>
                           </div>
                           <div class="flex-shrink-0">
                              <div class="form-check form-switch">
                                 <div class="form-check form-switch form-switch-md mb-3" dir="ltr">
                                    <input type="checkbox" name="googlemap" {{setting('googlemap') == 'enabled' ? 'checked' : ''}} class="form-check-input" id="customSwitchsizemd">
                                    <label class="form-check-label" for="customSwitchsizemd">
                                    </label>
                                 </div>
                              </div>
                           </div>
                        </li>
                     </ul>
                  </div>
                  <div class="mb-3">
                     <ul class="list-unstyled mb-0">
                        <li class="d-flex">
                           <div class="flex-grow-1">
                              <label for="dormancy" class="form-check-label fs-14">Dormant Services</label>
                              <p class="text-muted d-none d-md-block">Select after how many days services should be considered dormant</p>
                           </div>
                           <div class="flex-shrink-0">
                              <input style="max-width:100px" type="text" max="1" name="dormancy" class="form-control" value="{{setting('dormancy')}}">
                           </div>
                        </li>
                     </ul>
                  </div>
                  {{-- <div class="mb-3">
                     <ul class="list-unstyled mb-0">
                        <li class="d-flex">
                           <div class="flex-grow-1">
                              <label for="installation_fee" class="form-check-label fs-14">Installation fee {!! setting('installation_fee') == 'enabled' ? '<i class="ri-checkbox-circle-fill text-success"></i>' : '' !!}</label>
                              <p class="text-muted d-none d-md-block">Enable creation of installation fee invoice for new clients</p>
                           </div>
                           <div class="flex-shrink-0">
                              <div class="form-check form-switch">
                                 <div class="form-check form-switch form-switch-md mb-3" dir="ltr">
                                    <input type="checkbox" name="enable_installation_fee" {{setting('enable_installation_fee') == 'enabled' ? 'checked' : ''}} class="form-check-input" id="customSwitchsizemd">
                                    <label class="form-check-label" for="customSwitchsizemd">
                                    </label>
                                 </div>
                              </div>
                           </div>
                        </li>
                     </ul>
                  </div> --}}
                  <div class="mb-3">
                     <ul class="list-unstyled mb-0">
                        <li class="d-flex">
                           <div class="flex-grow-1">
                              <label for="dormancy" class="form-check-label fs-14">Installation fee amount</label>
                              <p class="text-muted d-none d-md-block">How much do you charge for installation</p>
                           </div>
                           <div class="flex-shrink-0">
                              <input style="max-width:100px" type="text" max="1" name="installation_fee" class="form-control" value="{{setting('installation_fee')}}">
                           </div>
                        </li>
                     </ul>
                  </div>
                  <div class="col-12 text-end">
                     <div class="hstack gap-2 justify-content-end">
                        <button type="submit" class="btn btn-soft-success"
                           id="add-btn"><i class="las la-save"></i> Save settings</button>
                     </div>
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