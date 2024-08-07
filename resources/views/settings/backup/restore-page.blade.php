@extends('layouts.master')
@section('title')
Restore backup
@endsection
@section('css')
<!-- Additional CSS -->
@endsection 
@section('content') 
@component('components.breadcrumb')
@slot('li_1')
Data
@endslot
@slot('title')
Restore
@endslot
@endcomponent
<div class="row">
    <div class="col-xl-6">
        <div class="card">
            <div class="card-body p-0">
                <ul class="list-group list-group-flush border-dashed mb-0">
                    <li class="list-group-item d-flex align-items-center">
                        <div class="flex-grow-1 ms-3">
                            <h6 class="fs-14 mb-1">Backup Name</h6>
                        </div>
                        <div class="flex-shrink-0 text-end">
                            <h6 class="fs-14 mb-1">{{ basename($filename )}}</h6>
                        </div>
                    </li>
                    <li class="list-group-item d-flex align-items-center">
                        <div class="flex-grow-1 ms-3">
                            <h6 class="fs-14 mb-1">Backup Date</h6>
                        </div>
                        <div class="flex-shrink-0 text-end">
                            <h6 class="fs-14 mb-1">{{ $date }}</h6>
                        </div>
                    </li>
                    <li class="list-group-item d-flex align-items-center">
                        <div class="flex-grow-1 ms-3">
                            <h6 class="fs-14 mb-1">Backup Size</h6>
                        </div>
                        <div class="flex-shrink-0 text-end">
                            <h6 class="fs-14 mb-1">{{ $size }}</h6>
                        </div>
                    </li>
                    <!-- Add more backup details as needed -->
                </ul>
            </div>
            <div class="card-footer text-end">
                <a href="#" onclick="restoreBackup('{{ $filename }}', '{{ $disk }}')" class="btn btn-primary">Click here to restore</a>
            </div>
        </div>
    </div>
</div>


<!--end row-->
@endsection 
@section('script')
<script src="{{ URL::asset('/assets/js/jquery-3.6.1.js')}}"></script>
<script src="{{ URL::asset('/assets/js/datatables/datatables.min.js') }}"></script>
<!-- Include SweetAlert CSS and JS files -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
<script>
   function restoreBackup(filename, disk) {
       // Show confirmation dialog using SweetAlert
       Swal.fire({
           title: 'Confirmation',
           text: 'Are you sure you want to restore the backup?',
           icon: 'warning',
           showCancelButton: true,
           confirmButtonColor: '#3085d6',
           cancelButtonColor: '#d33',
           confirmButtonText: 'Yes, restore it!'
       }).then((result) => {
           if (result.isConfirmed) {
               // Call the function to initiate the restoration process
               initiateBackupRestoration(filename, disk);
           }
       });
   }
   
   function initiateBackupRestoration(filename, disk) {
       // Show loading spinner
       Swal.fire({
           title: 'Restoring Backup',
           html: 'Please wait...',
           allowOutsideClick: false,
           onBeforeOpen: () => {
               Swal.showLoading();
           }
       });
   
       // Initiate the restoration process
       fetch('/dashboard/settings/restore', {
           method: 'POST',
           headers: {
               'Content-Type': 'application/json',
               'X-CSRF-TOKEN': '{{ csrf_token() }}' // Add CSRF token if using Laravel's CSRF protection
           },
           body: JSON.stringify({
               filename: filename,
               disk: disk
           })
       })
       .then(response => response.json())
       .then(data => {
           // Hide loading spinner
           Swal.close();
   
           if (data.success) {
               // Show success message using SweetAlert
               Swal.fire({
                   icon: 'success',
                   title: 'Success',
                   text: data.success,
               });
           } else if (data.error) {
               // Show error message using SweetAlert
               Swal.fire({
                   icon: 'error',
                   title: 'Error',
                   text: data.error,
               });
           } else {
               // Show a generic error message if no specific error message is returned
               Swal.fire({
                   icon: 'error',
                   title: 'Error',
                   text: 'An unexpected error occurred.',
               });
           }
       })
       .catch(error => {
           // Hide loading spinner
           Swal.close();
   
           // Show error message using SweetAlert for network errors or exceptions
           Swal.fire({
               icon: 'error',
               title: 'Error',
               text: 'An error occurred: ' + error,
           });
       });
   }
</script>
@endsection