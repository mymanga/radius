<div class="avatar-lg mx-auto mt-2 mb-3">
   <div class="avatar-title bg-light text-success display-3 rounded-circle">
      <i class="ri-checkbox-circle-fill"></i>
   </div>
</div>
<div class="alert alert-success alert-additional fade show" role="alert">
   <div class="alert-body">
      <div class="d-flex">
         <div class="flex-shrink-0 me-3">
            <i class="ri-checkbox-circle-fill fs-16 align-middle"></i>
         </div>
         <div class="flex-grow-1">
            <h5 class="alert-heading">Activated</h5>
            <p class="mb-0">Aww yeah, your license information is up to date. </p>
         </div>
      </div>
   </div>
   <div class="alert-content">
      <div class="item">
         <div class="d-flex align-items-center mb-2">
            <div class="flex-shrink-0">
               <p class="mb-0"><b>Product:</b></p>
            </div>
            <div class="flex-grow-1 ms-2">
               <p class="mb-0">{{$license['product_name'] ?? 'Simple ISP'}}</p>
            </div>
         </div>
      </div>
      <div class="item">
         @php
         $value = $license['license_type'] ?? 'N/A';
         // Check if the value contains 'pppoe' (case-insensitive)
         if (stripos($value, 'pppoe') !== false) {
         // Split the string by the hyphen
         $parts = explode('-', $value);
         // Get the value after the hyphen (the second element in the array)
         $type = $parts[1].' '.'Users license';
         } else {
         $type = $value;
         }
         @endphp
         <div class="d-flex align-items-center mb-2">
            <div class="flex-shrink-0">
               <p class="mb-0"><b>License Type:</b></p>
            </div>
            <div class="flex-grow-1 ms-2">
               <p class="mb-0">{{$type ?? 'N/A'}}</p>
            </div>
         </div>
      </div>
      <div class="item">
         <div class="d-flex align-items-center mb-2">
            <div class="flex-shrink-0">
               <p class="mb-0"><b>Registered to:</b></p>
            </div>
            <div class="flex-grow-1 ms-2">
               <p class="mb-0">{{$license['client_name'] ?? 'N/A'}}</p>
            </div>
         </div>
      </div>
   </div>
</div>