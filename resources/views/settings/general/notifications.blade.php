@extends('layouts.master') @section('title') notification settings @endsection
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
            <form class="form-margin" action="{{route('settings.notifications_save')}}" Method="POST">
               @csrf
               <div class="tab-pane active" id="privacy" role="tabpanel">
                  <div class="mb-3">
                     <ul class="list-unstyled mb-0">
                        <li class="d-flex">
                           <div class="flex-grow-1">
                              <label for="Theme" class="form-check-label fs-14">Sms notifications {!! setting('smsnotification') == 'enabled' ? '<i class="ri-checkbox-circle-fill text-success"></i>' : '' !!}</label>
                              <p class="text-muted d-none d-md-block">Enable sms notifications to clients</p>
                           </div>
                           <div class="flex-shrink-0">
                              <div class="form-check form-switch">
                                 <div class="form-check form-switch form-switch-md mb-3" dir="ltr">
                                    <input type="checkbox" name="smsnotification" {{setting('smsnotification') == 'enabled' ? 'checked' : ''}} class="form-check-input" id="customSwitchsizemd">
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
                              <label for="Theme" class="form-check-label fs-14">Email notifications {!! setting('emailnotification') == 'enabled' ? '<i class="ri-checkbox-circle-fill text-success"></i>' : '' !!}</label>
                              <p class="text-muted d-none d-md-block">Enable email notifications to clients</p>
                           </div>
                           <div class="flex-shrink-0">
                              <div class="form-check form-switch">
                                 <div class="form-check form-switch form-switch-md mb-3" dir="ltr">
                                    <input type="checkbox" name="emailnotification" {{setting('emailnotification') == 'enabled' ? 'checked' : ''}} class="form-check-input" id="customSwitchsizemd">
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
                              <label for="Theme" class="form-check-label fs-14">Welcome message {!! setting('welcomemessage') == 'enabled' ? '<i class="ri-checkbox-circle-fill text-success"></i>' : '' !!}</label>
                              <p class="text-muted d-none d-md-block">Send welcome message once a client is created</p>
                           </div>
                           <div class="flex-shrink-0">
                              <div class="form-check form-switch">
                                 <div class="form-check form-switch form-switch-md mb-3" dir="ltr">
                                    <input type="checkbox" name="welcomemessage" {{setting('welcomemessage') == 'enabled' ? 'checked' : ''}} class="form-check-input" id="customSwitchsizemd">
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
                              <label for="Theme" class="form-check-label fs-14">Expiration reminder {!! setting('expirationreminder') == 'enabled' ? '<i class="ri-checkbox-circle-fill text-success"></i>' : '' !!}</label>
                              <p class="text-muted d-none d-md-block">Enables reminders to clients before expiration</p>
                           </div>
                           <div class="flex-shrink-0">
                              <div class="form-check form-switch">
                                 <div class="form-check form-switch form-switch-md mb-3" dir="ltr">
                                    <input type="checkbox" name="expirationreminder" {{setting('expirationreminder') == 'enabled' ? 'checked' : ''}} class="form-check-input" id="customSwitchsizemd">
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
                              <label for="Theme" class="form-check-label fs-14">Days before expiration</label>
                              <p class="text-muted d-none d-md-block">Enter number of days to remind clients before expiration</p>
                           </div>
                           <div class="flex-shrink-0">
                              <input style="max-width:60px" type="text" max="1" name="reminderdays" onkeypress='validate(event)' class="form-control" value="{{setting('reminderdays')}}">
                           </div>
                        </li>
                     </ul>
                  </div>
                  <div class="mb-3">
                     <ul class="list-unstyled mb-0">
                        <li class="d-flex">
                           <div class="flex-grow-1">
                              <label for="Theme" class="form-check-label fs-14">Payment Notification {!! setting('paymentnotification') == 'enabled' ? '<i class="ri-checkbox-circle-fill text-success"></i>' : '' !!}</label>
                              <p class="text-muted d-none d-md-block">Enables notifications to clients once payment is made</p>
                           </div>
                           <div class="flex-shrink-0">
                              <div class="form-check form-switch">
                                 <div class="form-check form-switch form-switch-md mb-3" dir="ltr">
                                    <input type="checkbox" name="paymentnotification" {{setting('paymentnotification') == 'enabled' ? 'checked' : ''}} class="form-check-input" id="customSwitchsizemd">
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
                              <label for="Theme" class="form-check-label fs-14">Renewal Notification {!! setting('renewalnotification') == 'enabled' ? '<i class="ri-checkbox-circle-fill text-success"></i>' : '' !!}</label>
                              <p class="text-muted d-none d-md-block">Send notification to client once service is auto renewed</p>
                           </div>
                           <div class="flex-shrink-0">
                              <div class="form-check form-switch">
                                 <div class="form-check form-switch form-switch-md mb-3" dir="ltr">
                                    <input type="checkbox" name="renewalnotification" {{setting('renewalnotification') == 'enabled' ? 'checked' : ''}} class="form-check-input" id="customSwitchsizemd">
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
                              <label for="Theme" class="form-check-label fs-14">Deactivation Notification {!! setting('deactivatenotification') == 'enabled' ? '<i class="ri-checkbox-circle-fill text-success"></i>' : '' !!}</label>
                              <p class="text-muted d-none d-md-block">Send notification to client once service is deactivated</p>
                           </div>
                           <div class="flex-shrink-0">
                              <div class="form-check form-switch">
                                 <div class="form-check form-switch form-switch-md mb-3" dir="ltr">
                                    <input type="checkbox" name="deactivatenotification" {{setting('deactivatenotification') == 'enabled' ? 'checked' : ''}} class="form-check-input" id="customSwitchsizemd">
                                    <label class="form-check-label" for="customSwitchsizemd">
                                    </label>
                                 </div>
                              </div>
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
<script>
   function validate(evt) {
     var theEvent = evt || window.event;
   
     // Handle paste
     if (theEvent.type === 'paste') {
         key = event.clipboardData.getData('text/plain');
     } else {
     // Handle key press
         var key = theEvent.keyCode || theEvent.which;
         key = String.fromCharCode(key);
     }
     var regex = /[0-9]|\./;
     if( !regex.test(key) ) {
       theEvent.returnValue = false;
       if(theEvent.preventDefault) theEvent.preventDefault();
     }
   }
</script>
@endsection