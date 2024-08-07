@extends('layouts.master') @section('title') Sms Gateways @endsection
@section('css')
<link href="{{URL::asset('assets/js/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{URL::asset('assets/css/datatable-custom.css')}}" rel="stylesheet" type="text/css" />
<style>
   /* Adjust the white-space property for the message cell */
   .message-cell {
   white-space: normal;
   overflow: hidden;
   }
</style>
@endsection
@section('content') 
@component('components.breadcrumb')
@slot('li_1') SMS @endslot
@slot('title') Gateways @endslot
@endcomponent
<div class="row">
   <div class="col-lg-12">
      <div class="d-flex align-items-center mb-3">
         <div class="flex-grow-1">
         </div>
         <div class="flexshrink-0">
            <button type="button" class="btn btn-soft-info add-btn" onclick="selectAndUploadFile()">
            <i class="ri-add-line align-bottom me-1"></i> Upload Gateway
            </button>
         </div>
      </div>
      @if (session('error'))
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
               <h5 class="card-title mb-0 flex-grow-1"></h5>
               <div class="flex-shrink-0">
                  <a href="#" class="btn btn-soft-info add-btn" data-bs-toggle="modal" data-bs-target="#uploadGatewayModal">
                  <i class="ri-add-line align-bottom me-1"></i> Upload Gateway
                  </a>
               </div>
            </div>
         </div>
         --}}
         <div class="card-body">
            <div class="table-responsive table-card mb-1">
               <table class="table table-nowrap align-middle table-stripped" id="datatable" style="width:100%;">
                  <thead class="text-muted table-light">
                     <tr class="text-uppercase">
                        <th class="sort" data-sort="gatewayName">Gateway Name</th>
                        <th class="sort" data-sort="description">Description</th>
                        <th class="sort" data-sort="author">Author</th>
                        <th class="sort" data-sort="website">Website</th>
                        <th class="sort" data-sort="actions">Actions</th>
                     </tr>
                  </thead>
                  <tbody class="list form-check-all">
                     @php
                     $userDefinedGatewayPath = app_path('Gateways/UserDefined');
                     // Initialize an array to store gateway information
                     $gatewayInfoArray = [];
                     // Loop through user-defined gateway files in the directory
                     foreach (scandir($userDefinedGatewayPath) as $file) {
                     $filePath = $userDefinedGatewayPath . DIRECTORY_SEPARATOR . $file;
                     // Check if it's a PHP file
                     if (is_file($filePath) && pathinfo($file, PATHINFO_EXTENSION) === 'php') {
                     // Extract gateway name from the file name and remove "SmsGateway" prefix
                     $gatewayName = strtolower(str_replace('SmsGateway', '', pathinfo($file, PATHINFO_FILENAME)));
                     // Load the gateway class dynamically
                     $gatewayClass = "App\\Gateways\\UserDefined\\" . ucfirst($gatewayName) . "SmsGateway";
                     // Initialize error flag and gatewayInfo array
                     $hasSyntaxError = false;
                     $gatewayInfo = [];
                     // Try to include the file and handle ParseError
                     try {
                     if (class_exists($gatewayClass) && method_exists($gatewayClass, 'getGatewayInfo')) {
                     // Call the method only if it exists
                     $gatewayInfo = $gatewayClass::getGatewayInfo();
                     $gatewayFunctionName = lcfirst($gatewayName);
                     }
                     } catch (\ParseError $parseError) {
                     // Set the error flag to true
                     $hasSyntaxError = true;
                     // Read the file content to extract description and author
                     $phpFileContents = file_get_contents($filePath);
                     // Use regex to extract description and author
                     preg_match('/\* Description:(.*?)\* Author:(.*?)\*/s', $phpFileContents, $matches);
                     // Extract description and author from regex matches
                     $description = isset($matches[1]) ? trim($matches[1]) : '';
                     $author = isset($matches[2]) ? trim($matches[2]) : '';
                     // Store additional information in the gatewayInfo array
                     $gatewayInfo = [
                     'description' => $description,
                     'author' => $author,
                     ];
                     }
                     // Store gateway information and error status in the array
                     $gatewayInfoArray[] = [
                     'name' => $hasSyntaxError ? "⚠ $gatewayName" : $gatewayName,
                     'description' => $gatewayInfo['description'] ?? '',
                     'author' => $gatewayInfo['author'] ?? '',
                     'website' => $gatewayInfo['website'] ?? '',
                     'hasSyntaxError' => $hasSyntaxError,
                     'gatewayFunctionName' => lcfirst($gatewayName),
                     ];
                     }
                     }
                     @endphp
                     @foreach($gatewayInfoArray as $gatewayInfo)
                     <tr class="no-border {{ $gatewayInfo['hasSyntaxError'] ? 'table-danger' : '' }}">
                        <td>{{ $gatewayInfo['name'] }}</td>
                        <td>{{ $gatewayInfo['description'] }}</td>
                        <td>{{ $gatewayInfo['author'] }}</td>
                        <td>
                           @if (isset($gatewayInfo['website']))
                           <a href="{{ $gatewayInfo['website'] }}" target="_blank">{{ $gatewayInfo['website'] }}</a>
                           @endif
                        </td>
                        <td>
                           <ul class="list-inline hstack gap-2 mb-0">
                              @if (!$gatewayInfo['hasSyntaxError'])
                              <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Configure">
                                 <a href="{{ route('settings.sms.gateway', ['gateway' => $gatewayInfo['gatewayFunctionName']]) }}" class="text-primary d-inline-block">
                                 <i class="ri-settings-3-fill fs-16"></i>
                                 </a>
                              </li>
                              @endif
                              <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Delete">
                                 <a href="#" class="text-danger d-inline-block" onclick="confirmDelete('{{ $gatewayInfo['gatewayFunctionName'] }}')">
                                 <i class="ri-delete-bin-5-fill fs-16"></i>
                                 </a>
                              </li>
                           </ul>
                        </td>
                     </tr>
                     @endforeach
                  </tbody>
               </table>
            </div>
         </div>
      </div>
      <!-- Modal for Uploading Gateways -->
      <!-- Modal for Uploading Gateways -->
      <div class="modal fade" id="uploadGatewayModal" tabindex="-1" aria-labelledby="uploadGatewayModalLabel" aria-hidden="true">
         <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
               <div class="modal-header p-3 bg-soft-info">
                  <h5 class="modal-title" id="uploadGatewayLabel">Upload Gateway</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-upload-modal"></button>
               </div>
               <div class="modal-body">
                  <form action="{{ route('sms.gateway.upload') }}" method="post" enctype="multipart/form-data" id="uploadForm">
                     @csrf
                     <div class="mb-3">
                        <label for="gatewayFile" class="form-label">Select Gateway File</label>
                        <input type="file" class="form-control" id="gatewayFile" name="gatewayFile" required>
                        @error('gatewayFile')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                     </div>
                     <div class="modal-footer">
                        <div class="hstack gap-2 justify-content-end">
                           <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                           <button type="button" class="btn btn-soft-info" id="uploadButton">
                           <i class="las la-upload"></i> Upload
                           </button>
                        </div>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection
@section('script')
<script src="{{ URL::asset('/assets/js/jquery-3.6.1.js')}}"></script>
<script src="{{ URL::asset('/assets/js/datatables/datatables.min.js') }}"></script>
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
<script src="{{ URL::asset('/assets/js/datatable.js') }}"></script>
<!-- Include SweetAlert script -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
   function selectAndUploadFile() {
    // Fetch the CSRF token from the meta tag
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
   
    // Show disclaimer dialog with explicit risks
    Swal.fire({
        title: 'Disclaimer',
        html: 'Please make sure you trust the source of the gateway file. Uploading a malicious gateway can compromise your system and data security. We do not offer support for issues arising from third-party gateways.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'I Understand',
        cancelButtonText: 'Cancel',
    }).then((result) => {
        if (result.isConfirmed) {
            // If the user confirms the disclaimer, proceed to file selection
            Swal.fire({
                title: 'Select Gateway File',
                input: 'file',
                inputAttributes: {
                    accept: '.zip',
                },
                showCancelButton: true,
                confirmButtonText: 'Upload',
                showLoaderOnConfirm: true,
                preConfirm: (file) => {
                    // Check if a file is selected
                    if (!file) {
                        Swal.showValidationMessage('Please select a gateway file');
                        return;
                    }
   
                    // Check if the selected file is a ZIP file
                    if (!file.name.toLowerCase().endsWith('.zip')) {
                        Swal.showValidationMessage('Only ZIP files are accepted');
                        return;
                    }
   
                    return new Promise((resolve) => {
                        const formData = new FormData();
                        formData.append('gatewayFile', file);
   
                        // Include the CSRF token in the headers
                        fetch("{{ route('sms.gateway.upload') }}", {
                            method: "POST",
                            body: formData,
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                            },
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            // Handle the response
                            if (data.status === 'success') {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: data.message,
                                }).then(() => {
                                    // Wait for a few seconds and then reload the page
                                    setTimeout(() => {
                                        location.reload();
                                    }, 3000);
                                });
                            } else if (data.status === 'error') {
                                // Display error message using SweetAlert
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: data.message,
                                });
   
                                // Handle validation errors if present
                                if (data.errors) {
                                    // Assume that the errors are an array of strings
                                    const errorMessage = data.errors.join('<br>');
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Validation Error',
                                        html: errorMessage,
                                    });
                                }
                            } else if (data.status === 'warning') {
                                // Display warning message using SweetAlert
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Warning',
                                    text: data.message,
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        })
                        .finally(() => {
                            resolve();
                        });
                    });
                },
                allowOutsideClick: () => !Swal.isLoading(),
            });
        }
    });
   } 
</script>
<script>
   function confirmDelete(gatewayFunctionName) {
       // Show SweetAlert confirmation dialog with a loading spinner
       Swal.fire({
           title: 'Are you sure?',
           text: 'You won\'t be able to revert this!',
           icon: 'warning',
           showCancelButton: true,
           confirmButtonColor: '#d33',
           cancelButtonColor: '#3085d6',
           confirmButtonText: 'Yes, delete it!',
           showLoaderOnConfirm: true,  // Display loading spinner
           preConfirm: () => {
               // Return a Promise to handle the asynchronous deletion
               return fetch("{{ url('dashboard/settings/sms/delete-gateway') }}/" + gatewayFunctionName, {
                   method: 'POST',
                   headers: {
                       'X-CSRF-TOKEN': '{{ csrf_token() }}',
                   },
               })
               .then(response => response.json())
               .then(data => {
                   // Display SweetAlert message based on the response
                   Swal.fire({
                       icon: data.success ? 'success' : 'error',
                       title: data.success ? 'Success' : 'Error',
                       text: data.message,
                       didClose: () => {
                           // Optional: Reload the page or update the UI
                           if (data.success) {
                               location.reload();
                           }
                       }
                   });
               })
               .catch(error => {
                   console.error('Error:', error);
               });
           }
       });
   
       return false; // Prevent the default action (following the link)
   }
   
</script>
@endsection