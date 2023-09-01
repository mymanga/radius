@extends('layouts.master') @section('title') License info @endsection 
@section('css') 
@endsection 
@section('content') 
{{-- @component('components.breadcrumb') @slot('li_1') Messages @endslot @slot('title') Create @endslot
@endcomponent --}}
<div class="page-title-box d-sm-flex align-items-center justify-content-between">
   <h4 class="mb-sm-0 font-size-18">License</h4>
   <div class="page-title-right">
      <ol class="breadcrumb m-0">
         <li class="breadcrumb-item"><a>Info</a></li>
         <li class="breadcrumb-item active"><a href="{{ route('license.index') }}">License</a></li>
      </ol>
   </div>
</div>
<!-- .card-->
<div class="row justify-content-center">
   <div class="col-md-8 col-lg-6 col-xl-5">
      <div class="card mt-4">
         <div class="card-body p-4">
            @if(checkLicense())
            @if($license['status'])
            @include('updater.includes.activated')
            @else
            @include('updater.includes.warning')
            @endif
            @elseif($active_license)
            <!-- Danger Alert -->
            @include('updater.includes.notice')
            @else
            @include('updater.includes.activate')
            @endif
         </div>
         <!-- end card body -->
      </div>
      <!-- end card -->
   </div>
</div>
@endsection @section('script')
<script src="{{ URL::asset('/assets/js/jquery-3.6.1.js')}}"></script>
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/sweetalert2.all.min.js') }}"></script>
<script>
   // Get a reference to the button element
const resetLicenseBtn = document.getElementById('resetLicenseBtn');

// Check if the element exists before trying to add an event listener
if (resetLicenseBtn) {
  // Add an event listener to the button
  resetLicenseBtn.addEventListener('click', function(event) {
    // Prevent the default behavior of the button
    event.preventDefault();

    // Show the confirmation dialog
    Swal.fire({
      title: "Are you sure?",
      text: "This will reset your license. Do you want to continue?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, reset it!'
    })
    .then(async (result) => {
      // If the user clicks the confirmation button, reset the license
      if (result.isConfirmed) {
        try {
          const responseJson = await resetLicense(resetLicenseBtn.dataset.url);
          Swal.fire(
            responseJson.success ? 'Reset!' : 'Error!',
            responseJson.message,
            responseJson.success ? 'success' : 'error'
          );
          if (responseJson.success) {
            setTimeout(() => {
              location.reload();
            }, 3000);
          }
        } catch (error) {
          Swal.fire(
            'Error!',
            'An error occurred while resetting your license.',
            'error'
          );
        }
      }
    });
  });
} else {
  console.log('The button with id resetLicenseBtn was not found in the document.');
}

   
   async function resetLicense(url) {
     const response = await fetch(url, {
       method: 'POST',
       headers: {
         'Content-Type': 'application/json',
         'X-CSRF-TOKEN': '{{ csrf_token() }}',
       },
     });
   
     if (response.ok) {
       return await response.json();
     } else {
       throw new Error('Invalid response');
     }
   }
</script>
@endsection