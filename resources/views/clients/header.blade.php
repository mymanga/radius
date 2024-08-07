<div class="card-body pb-0 px-4">
   <div class="row mb-3">
      <div class="col-md">
         <div class="row align-items-center g-3">
            @php
             $unpaidInvoicesTotal = $client->invoices()->where('status', 'unpaid')->sum('amount');   
            @endphp
            {{-- 
            <div class="col-md-auto">
               <div class="avatar-md">
                  <div class="avatar-title bg-white rounded">
                     <img src="{{asset('assets/images/brands/slack.png')}}" alt="" class="avatar-xs">
                  </div>
               </div>
            </div>
            --}}
            <div class="col-md">
               <ol class="breadcrumb m-0 float-end">
                  <li class="breadcrumb-item"><a href="{{route('client.index')}}" class="text-info">Clients</a></li>
                  <li class="breadcrumb-item active">{{$client->username}}</li>
               </ol>
               <div>
                  <h4 class="fw-bold">{{$client->firstname}} {{$client->lastname}}  <a href="{{route('client.edit', [$client->username])}}" class="edit-wallet-btn text-info">
                     <i class="ri-edit-box-fill fs-16"></i>
                     </a>
                  </h4>
                  <div class="hstack gap-3 flex-wrap">
                     <div><i class="ri-building-line align-bottom me-1"></i> {{$client->username}}</div>
                     <div class="vr"></div>
                     <div><i class="ri-time-fill"></i> <span class="text-muted text-uppercase fs-13">Create Date :</span> <span class="fw-medium">{{$client->created_at->format('d M, Y')}}</span></div>
                     <div class="vr"></div>
                     <div><span class="text-muted text-uppercase fs-13">Last Modified :</span> <span class="fw-medium">{{$client->updated_at->format('d M, Y')}}</span></div>
                     <div class="vr"></div>
                     @if(!empty($client->location))
                     <div><i class="ri-map-pin-user-fill"></i> <span class="fw-medium">{{$client->location}}</span> 
                        @if(!empty($client->latitude) && !empty($client->longitude))
                        <a href="#" class="get-directions-link badge badge-soft-info badge-border fs-12"
                           data-latitude="{{ $client->latitude }}" data-longitude="{{ $client->longitude }}">Get Directions</a>
                        @endif
                     </div>
                     <div class="vr"></div>
                     @endif
                     <div>
                        <span class="text-muted text-uppercase fs-13">User status</span>
                        {!! $client->status() !!}
                     </div>
                     <div class="vr"></div>
                     <div>
                        <span class="text-muted text-uppercase fs-13">Wallet</span>
                        <span class="fw-medium">
                           <div class="badge badge-soft-info badge-border fs-12">
                              Ksh <span id="walletBalance" data-wallet-id="{{ $client->wallet->id }}">{{ $client->balance }}</span>
                           </div>
                        </span>
                        <a href="#" class="edit-wallet-btn text-info" onclick="editWalletBalance()">
                        <i class="ri-edit-box-fill fs-16"></i>
                        </a>
                     </div>
                     @if($unpaidInvoicesTotal && $unpaidInvoicesTotal > 0)
                     <div class="vr"></div>
                     <div>
                        <span class="text-muted text-uppercase fs-13">Total Unpaid Invoices</span>
                        <span class="fw-medium">
                           <div class="badge badge-soft-danger badge-border fs-12">
                              Ksh <span id="totalUnpaidInvoices">{{ number_format($unpaidInvoicesTotal) }}</span>
                           </div>
                        </span>
                     </div>
                     @endif
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <ul class="nav nav-tabs-custom border-bottom-0" role="tablist">
      <li class="nav-item">
         <a class="nav-link fw-semibold {{request()->routeIs('client.edit') ? 'active':''}}" href="{{route('client.edit',[$client->username])}}">
         CLIENT-INFO
         </a>
      </li>
      <li class="nav-item">
         <a class="nav-link fw-semibold {{request()->routeIs('client.service') ? 'active':''}}" href="{{route('client.service',[$client->username])}}">
         SERVICES
         </a>
      </li>
      @can('manage finance')
      <li class="nav-item">
         <a class="nav-link fw-semibold {{request()->routeIs('client.billing') ? 'active':''}}" href="{{route('client.billing',[$client->username])}}">
         BILLING
         </a>
      </li>
      <li class="nav-item">
         <a class="nav-link fw-semibold {{request()->routeIs('client.invoices') ? 'active':''}}" href="{{route('client.invoices',[$client->username])}}">
         INVOICES
         </a>
      </li>
      @endcan
      <li class="nav-item">
         <a class="nav-link fw-semibold {{request()->routeIs(['client.statistics','view_stats']) ? 'active':''}}" href="{{route('client.statistics',[$client->username])}}">
         STATISTICS
         </a>
      </li>
      <li class="nav-item">
         <a class="nav-link fw-semibold {{request()->routeIs('client.livedata') ? 'active':''}}" href="{{route('client.livedata',[$client->username])}}">
         LIVE-DATA
         </a>
      </li>
      <li class="nav-item">
         <a class="nav-link fw-semibold {{ request()->routeIs('clients.communication') ? 'active' : '' }}" href="{{ route('clients.communication', [$client->username]) }}">
         COMMUNICATION
         </a>
      </li>
      <li class="nav-item">
         <a class="nav-link fw-semibold {{ request()->routeIs('clients.logs') ? 'active' : '' }}" href="{{ route('clients.logs', [$client->username]) }}">
         ACTIVITY-LOGS
         </a>
      </li>
   </ul>
</div>
<!-- Bootstrap Modal for editing wallet balance -->
<div class="modal fade" id="editWalletModal" tabindex="-1" aria-labelledby="editWalletModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="editWalletModalLabel">Edit Wallet Balance</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <form id="editWalletForm" method="post" action="{{ route('update.wallet.balance') }}">
            @csrf
            <div class="modal-body">
               <label for="newWalletBalance">New Wallet Balance:</label>
               <input type="hidden" name="clientID" value="{{ $client->id }}">
               <input type="text" id="newWalletBalance" name="newWalletBalance" value="{{ old('newWalletBalance') ?? $client->balance }}" class="form-control">
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
               <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
         </form>
      </div>
   </div>
</div>
<script>
   const updateWalletBalanceRoute = "{{ route('update.wallet.balance') }}";
   
   function editWalletBalance() {
       const currentBalance = parseFloat(document.getElementById('newWalletBalance').value.replace(/,/g, ''));
   
       // Show SweetAlert input with the current balance value
       Swal.fire({
           title: 'Edit Wallet Balance',
           input: 'number', // Set the input type to "number"
           inputValue: currentBalance,
           inputAttributes: {
               style: 'text-align: center', // Center align the input field
               min: '0', // Minimum value allowed (non-negative)
               step: 'any', // Allow any numeric value (including decimals)
           },
           showCancelButton: true,
           confirmButtonText: 'Save Changes',
           cancelButtonText: 'Cancel',
           inputValidator: (value) => {
               if (value < 0 || isNaN(value)) {
                   return 'Please enter a non-negative numeric value';
               }
           },
       }).then((result) => {
           if (result.isConfirmed) {
               // Update the value of the hidden input field
               document.getElementById('newWalletBalance').value = result.value;
   
               // Prevent the default form submission behavior
               event.preventDefault();
   
               // Submit the form to update the wallet balance
               document.getElementById('editWalletForm').submit();
   
               // Show a success toast after successful form submission
               Swal.fire({
                   icon: 'success',
                   title: 'Success',
                   text: 'Wallet balance updated successfully!',
                   toast: true,
                   position: 'top-end',
                   showConfirmButton: false,
                   timer: 5000, // Set the timer to 5000 milliseconds (5 seconds)
                   timerProgressBar: true,
               });
           } else {
               // Show a cancel message if the user clicks the "Cancel" button
               Swal.fire('Cancelled', 'Edit wallet balance was cancelled.', 'info');
           }
       });
   }
</script>
<script>
   // Add this JavaScript code to your page, preferably within a <script> tag or an external JS file.
   
   document.addEventListener("DOMContentLoaded", function () {
       // Find all elements with the class "get-directions-link"
       const getDirectionsLinks = document.querySelectorAll(".get-directions-link");
   
       // Attach a click event listener to each link
       getDirectionsLinks.forEach(function (link) {
           link.addEventListener("click", function (event) {
               event.preventDefault();
   
               // Get the latitude and longitude from the data attributes
               const latitude = parseFloat(link.getAttribute("data-latitude"));
               const longitude = parseFloat(link.getAttribute("data-longitude"));
   
               // Check if the latitude and longitude are valid numbers
               if (!isNaN(latitude) && !isNaN(longitude)) {
                   // Open a new tab/window with Google Maps directions
                   const directionsUrl = `https://www.google.com/maps/dir/?api=1&destination=${latitude},${longitude}`;
                   window.open(directionsUrl, "_blank");
               } else {
                   // Handle the case where latitude and/or longitude are invalid
                   alert("Invalid location coordinates. Cannot get directions.");
               }
           });
       });
   });
   
</script>