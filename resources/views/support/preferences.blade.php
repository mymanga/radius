@extends('layouts.master') @section('title') preferences settings @endsection
@section('css')
@endsection
@section('content') 
<div class="row">
   <div class="col-lg-12">
      <div class="card mt-n4 mx-n4">
         <div class="bg-soft-light">
            @include('support.header')
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
         
         <div class="card-header border-bottom-dashed">
            <div class="d-flex align-items-center">
               <h5 class="card-title mb-0 flex-grow-1"><i class="ri-mail-line"></i> SMS Notifications</h5>
               <div class="flex-shrink-0">
               </div>
            </div>
         </div>
        
         <div class="card-body">
            <form class="form-margin" action="{{route('support.preferences_save')}}" Method="POST">
               @csrf
               <div class="tab-pane active" id="privacy" role="tabpanel">
                  <div class="mb-3">
                     <ul class="list-unstyled mb-0">
                        <li class="d-flex">
                           <div class="flex-grow-1">
                              <label for="usersms" class="form-check-label fs-14">Reply notification {!! setting('support_reply_notification') == 'enabled' ? '<i class="ri-checkbox-circle-fill text-success"></i>' : '' !!}</label>
                              <p class="text-muted d-none d-md-block">Send the user an sms when ticket is replied to</p>
                           </div>
                           <div class="flex-shrink-0">
                              <div class="form-check form-switch">
                                 <div class="form-check form-switch form-switch-md mb-3" dir="ltr">
                                    <input type="checkbox" name="support_reply_notification" {{setting('support_reply_notification') == 'enabled' ? 'checked' : ''}} class="form-check-input" id="customSwitchsizemd">
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
                              <label for="usersms" class="form-check-label fs-14">Ticket update notification {!! setting('support_update_notification') == 'enabled' ? '<i class="ri-checkbox-circle-fill text-success"></i>' : '' !!}</label>
                              <p class="text-muted d-none d-md-block">Send the user an sms when ticket is updated or closed</p>
                           </div>
                           <div class="flex-shrink-0">
                              <div class="form-check form-switch">
                                 <div class="form-check form-switch form-switch-md mb-3" dir="ltr">
                                    <input type="checkbox" name="support_update_notification" {{setting('support_update_notification') == 'enabled' ? 'checked' : ''}} class="form-check-input" id="customSwitchsizemd">
                                    <label class="form-check-label" for="customSwitchsizemd">
                                    </label>
                                 </div>
                              </div>
                           </div>
                        </li>
                     </ul>
                  </div>
                  {{-- <div class="mb-3">
                     <ul class="list-unstyled mb-0">
                        <li class="d-flex">
                           <div class="flex-grow-1">
                              <label for="usersms" class="form-check-label fs-14">New ticket notification {!! setting('support_admin_notification') == 'enabled' ? '<i class="ri-checkbox-circle-fill text-success"></i>' : '' !!}</label>
                              <p class="text-muted d-none d-md-block">Send the admin an sms when a new ticket is created</p>
                           </div>
                           <div class="flex-shrink-0">
                              <div class="form-check form-switch">
                                 <div class="form-check form-switch form-switch-md mb-3" dir="ltr">
                                    <input type="checkbox" name="support_admin_notification" {{setting('support_admin_notification') == 'enabled' ? 'checked' : ''}} class="form-check-input" id="customSwitchsizemd">
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
                              <label for="dormancy" class="form-check-label fs-14">Admin phone number</label>
                              <p class="text-muted d-none d-md-block">Enter phone number to recieve notification for new tickets</p>
                           </div>
                           <div class="flex-shrink-0">
                              <input style="max-width:150px" type="text" max="15" name="support_admin_phone" class="form-control" value="{{setting('support_admin_phone')}}">
                           </div>
                        </li>
                     </ul>
                  </div> --}}
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