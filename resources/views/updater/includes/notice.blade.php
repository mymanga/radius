<div class="alert alert-danger alert-additional fade show" role="alert">
   <div class="alert-body">
      <div class="d-flex">
         <div class="flex-shrink-0 me-3">
            <i class="ri-error-warning-line fs-16 align-middle"></i>
         </div>
         <div class="flex-grow-1">
            <h5 class="alert-heading">Something is very wrong!</h5>
            <p class="mb-0">Your license info needs update </p>
         </div>
      </div>
   </div>
   <div class="alert-content">
      <p class="mb-0">{{ $notice }}</p>
   </div>
</div>
<div class="mt-4">
   <button id="resetLicenseBtn" class="btn btn-danger w-100" data-url="{{ route('license.reset') }}">Reset License</button>
</div>