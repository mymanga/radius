<div class="col-lg-5">
      <div class="card">
         <div class="card-header border-bottom-dashed">
            <div class="d-flex align-items-center">
               <h5 class="card-title mb-0 flex-grow-1"> Customer placeholders</h5>
               <div class="flex-shrink-0"></div>
            </div>
         </div>
         <div class="card-body pt-0">
            <div class="modal-body">
               <div class="mb-3">
                  <!-- Soft Buttons -->
                  <span class="tag">
                     <button type="button" class="btn btn-soft-info waves-effect waves-light mb-2" value="@{{ $client_username }}">Username</button>
                  </span>
                  <span class="tag">
                     <button type="button" class="btn btn-soft-info waves-effect waves-light mb-2" value="@{{ $client_password }}">Password</button>
                  </span>
                  @if (setting('lb_url') && setting('lb_url') != '')
                  <span class="tag">
                     <button type="button" class="btn btn-soft-info waves-effect waves-light mb-2" value="@{{ $customer_portal }}">Customer Portal</button>
                  </span>
                  @endif
                  <span class="tag">
                     <button type="button" class="btn btn-soft-info waves-effect waves-light mb-2" value="@{{ $first_name }}">First Name</button>
                  </span>
                  <span class="tag">
                     <button type="button" class="btn btn-soft-info waves-effect waves-light mb-2" value="@{{ $last_name }}">Last Name</button>
                  </span>
                  <span class="tag">
                     <button type="button" class="btn btn-soft-info waves-effect waves-light mb-2" value="@{{ $client_name }}">Full name</button>
                  </span>
                  <span class="tag">
                     <button type="button" class="btn btn-soft-info waves-effect waves-light mb-2" value="@{{ $acc_number }}">Acc Number</button>
                  </span>
                  <span class="tag">
                     <button type="button" class="btn btn-soft-info waves-effect waves-light mb-2" value="@{{ $client_phone }}">Phone Number</button>
                  </span>
                  <span class="tag">
                     <button type="button" class="btn btn-soft-info waves-effect waves-light mb-2" value="@{{ $client_email }}">Email Address</button>
                  </span>
                  <span class="tag">
                     <button type="button" class="btn {{ setting('reminderdays') ? 'btn-soft-info' : 'btn-soft-danger disabled' }} waves-effect waves-light mb-2" value="@{{ $days_to_expiry }}" {{ setting('reminderdays') ?: 'disabled' }}>
                         Days before expiry
                     </button>
                 </span>
                  <span class="tag">
                     <button type="button" class="btn btn-soft-info waves-effect waves-light mb-2" value="@{{ $service_name }}">Service name</button>
                  </span>
                  <span class="tag">
                     <button type="button" class="btn btn-soft-info waves-effect waves-light mb-2" value="@{{ $service_price }}">Service Price</button>
                  </span>
                  <span class="tag">
                     <button type="button" class="btn btn-soft-info waves-effect waves-light mb-2" value="@{{ $service_expiry }}">Expiry date</button>
                  </span>
                  {{-- <input type="button" value="[tag_label]" /> --}}
               </div>

            </div>
            <!--end modal -->
         </div>
      </div>
      <div class="card">
         <div class="card-header border-bottom-dashed">
            <div class="d-flex align-items-center">
               <h5 class="card-title mb-0 flex-grow-1"> Company placeholders</h5>
               <div class="flex-shrink-0"></div>
            </div>
         </div>
         <div class="card-body pt-0">
            <div class="modal-body">
               <div class="mb-3">
                  <!-- Soft Buttons -->
                  <span class="tag">
                     <button type="button" class="btn btn-soft-info waves-effect waves-light mb-2" value="@{{ $company_name }}">Company name</button>
                  </span>
                  <span class="tag">
                     <button type="button" class="btn btn-soft-info waves-effect waves-light mb-2" value="@{{ $company_email }}">Company email</button>
                  </span>
                  <span class="tag">
                     <button type="button" class="btn btn-soft-info waves-effect waves-light mb-2" value="@{{ $company_phone }}">Company phone</button>
                  </span>
                  <span class="tag">
                     <button type="button" class="btn btn-soft-info waves-effect waves-light mb-2" value="@{{ $company_city }}">Company location</button>
                  </span>
                  {{-- <input type="button" value="[tag_label]" /> --}}
               </div>
            </div>
            <!--end modal -->
         </div>
      </div>
   </div>