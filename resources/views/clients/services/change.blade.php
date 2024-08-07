@extends('layouts.master')
@section('title', 'Change Service')
@section('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.css">
@endsection 
@section('content')
@component('components.breadcrumb')
@slot('li_1')
Service
@endslot
@slot('title')
Change Service
@endslot
@endcomponent
<div class="row">
   <div class="col-lg-12">
      @if (session('error'))
      <div class="alert alert-danger" role="alert">
         {{session('error')}}
      </div>
      @endif
   </div>
   <div class="col-xl-8">
      <div class="card card-height-100">
         <div class="card-body position-relative">
            <form id="updateServiceForm" action="{{ route('client.service.update', [$service->id]) }}" method="POST">
               @csrf 
               @method('put')
               <h5 class="mb-3">Select New Service</h5>
               <div class="vstack gap-2">
                  @foreach ($packages as $package)
                  <div class="form-check card-radio">
                     <input id="package_{{ $package->id }}" name="package" type="radio" class="form-check-input" value="{{ $package->id }}" data-price="{{ $package->price }}" {{ old('package', $service->package->id) == $package->id ? 'checked' : '' }}>
                     <label class="form-check-label" for="package_{{ $package->id }}">
                        <div class="d-flex align-items-center">
                           <div class="flex-shrink-0">
                              <div class="avatar-xs">
                                 <div class="avatar-title bg-soft-info text-info fs-18 rounded">
                                    <i class="ri-stack-line"></i>
                                 </div>
                              </div>
                           </div>
                           <div class="flex-grow-1 ms-3">
                              <h6 class="mb-1">{{ $package->name }}</h6>
                              <b class="pay-amount">KES {{ $package->price }}</b>
                           </div>
                        </div>
                     </label>
                  </div>
                  @endforeach
               </div>
               <div class="modal-footer">
                  <div class="hstack gap-2 justify-content-end">
                     <a href="{{ route('client.service', [$service->client->username]) }}" class="btn btn-light">Cancel</a>
                  </div>
               </div>
            </form>
            <!-- Add your notification warning here if needed -->
         </div>
         <!-- end card body -->
      </div>
      <!-- end card -->
   </div>
   <!-- end col -->
   <div class="col-xl-4">
      <div class="card card-height-100">
         <div class="card-header align-items-center d-flex">
            <h4 class="card-title mb-0 flex-grow-1">Current Service Info</h4>
         </div>
         <!-- end card header -->
         <div class="card-body p-0">
            <ul class="list-group list-group-flush border-dashed mb-0">
                <li class="list-group-item d-flex align-items-center">
                    <div class="flex-shrink-0 fs-18">
                       <i class="ri-stack-line text-success"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                       <h6 class="fs-14 mb-1">Service</h6>
                       <p class="text-muted mb-0">{{ $service->package->name }}</p>
                    </div>
                 </li>
               <li class="list-group-item d-flex align-items-center">
                  <div class="flex-shrink-0 fs-18">
                     <i class="ri-calendar-event-line text-success"></i>
                  </div>
                  <div class="flex-grow-1 ms-3">
                     <h6 class="fs-14 mb-1">Remaining Days</h6>
                     <p class="text-muted mb-0">{{ number_format($daysRemaining) }}</p>
                  </div>
               </li>
               <li class="list-group-item d-flex align-items-center">
                  <div class="flex-shrink-0 fs-18">
                     <i class="ri-coins-line text-success"></i>  
                  </div>
                  <div class="flex-grow-1 ms-3">
                     <h6 class="fs-14 mb-1">Equal to</h6>
                     <p class="text-muted mb-0">KES {{ number_format($remainingAmount) }}</p>
                  </div>
               </li>
               <li class="list-group-item d-flex align-items-center">
                  <div class="flex-shrink-0 fs-18">
                     <i class="ri-coins-line text-success"></i>                     
                  </div>
                  <div class="flex-grow-1 ms-3">
                     <h6 class="fs-14 mb-1">Wallet balance</h6>
                     <p class="text-muted mb-0">KES {{ $balance }}</p>
                  </div>
               </li>
               <li class="list-group-item d-flex align-items-center">
                  <div class="flex-shrink-0 fs-18">
                     <i class="ri-coins-line text-success"></i>
                  </div>
                  <div class="flex-grow-1 ms-3">
                     <h6 class="fs-14 mb-1">Total available</h6>
                     <p class="text-muted mb-0">KES <span id="totalAvailable">{{ number_format($remainingAmount + $balance) }}</span></p>
                  </div>
               </li>
            </ul>
         </div>
         <!-- end card body -->
      </div>
      <!-- end card -->
   </div>
   <!-- end col -->
</div>
@endsection 
@section('script')
<script src="{{ URL::asset('/assets/js/jquery-3.6.1.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.9/dist/sweetalert2.all.min.js"></script>
<script>
    const packageCheckboxes = document.querySelectorAll('input[name="package"]');
    const totalAvailable = parseFloat(document.getElementById('totalAvailable').textContent.replace(/,/g, '')); // Extracting total available amount and removing commas
    const form = document.getElementById('updateServiceForm');
    const daysInput = document.createElement('input'); // Create input element for number of days
    daysInput.type = 'hidden';
    daysInput.name = 'number_of_days'; // Set the name attribute to 'number_of_days'

    packageCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            if (this.checked) {
                const packageName = this.parentElement.querySelector('.form-check-label').textContent; // Get the text content of the checkbox label, which represents the package name
                const packagePrice = parseFloat(this.dataset.price);
                const pricePerDay = packagePrice / 30;
               const daysCovered = Math.floor(totalAvailable / pricePerDay) || 0; // Calculating days covered, default to zero instead of NaN
                const today = new Date();
                const expirationDate = new Date(today.getTime() + daysCovered * 24 * 60 * 60 * 1000); // Adding daysCovered to today's date

                // Format expiration date
                const options = { year: 'numeric', month: 'long', day: 'numeric' };
                const formattedExpirationDate = expirationDate.toLocaleDateString('en-US', options);

                // Displaying result using SweetAlert
                Swal.fire({
                    icon: 'info',
                    title: 'Days Covered',
                    text: `With the available amount, you can cover the new ${packageName} package for ${daysCovered} days, until ${formattedExpirationDate}.`,
                    showCancelButton: true,
                    confirmButtonText: 'Proceed',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // If user proceeds, set the expiry date, new package price, and package ID directly in the form
                        const packageIdInput = document.createElement('input');
                        packageIdInput.type = 'hidden';
                        packageIdInput.name = 'package_id';
                        packageIdInput.value = this.value;

                        const expiryDateInput = document.createElement('input');
                        expiryDateInput.type = 'hidden';
                        expiryDateInput.name = 'expiry_date';
                        expiryDateInput.value = expirationDate.toISOString().split('T')[0]; // Format as YYYY-MM-DD

                        const newPackagePriceInput = document.createElement('input');
                        newPackagePriceInput.type = 'hidden';
                        newPackagePriceInput.name = 'new_package_price';
                        newPackagePriceInput.value = packagePrice;

                        daysInput.value = daysCovered; // Set the value of the number of days input field

                        form.appendChild(packageIdInput);
                        form.appendChild(expiryDateInput);
                        form.appendChild(newPackagePriceInput);
                        form.appendChild(daysInput); // Append the number of days input field to the form

                        // Submit the form
                        form.submit();
                    } else {
                        // Uncheck the checkbox if user cancels
                        this.checked = false;
                    }
                });
            }
        });
    });
</script>

<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection