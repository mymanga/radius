@extends('layouts.master')
@section('title') 
Import customers
@endsection
@section('css')
<style>
#loader-wrapper {
	position: fixed;
	top: 0;
	left: 0;
	right: 0;
	bottom: 0;
	background-color: rgba(0, 0, 0, 0.5);
	z-index: 9999;
	justify-content: center;
	align-items: center;
}

#loader {
	display: block;
	position: relative;
	left: 50%;
	top: 50%;
	width: 150px;
	height: 150px;
	margin: -75px 0 0 -75px;
	border-radius: 50%;
	border: 3px solid transparent;
	border-top-color: #3498db;
	-webkit-animation: spin 2s linear infinite;
	/* Chrome, Opera 15+, Safari 5+ */
	animation: spin 2s linear infinite;
	/* Chrome, Firefox 16+, IE 10+, Opera */
}

#loader:before {
	content: "";
	position: absolute;
	top: 5px;
	left: 5px;
	right: 5px;
	bottom: 5px;
	border-radius: 50%;
	border: 3px solid transparent;
	border-top-color: #e74c3c;
	-webkit-animation: spin 3s linear infinite;
	/* Chrome, Opera 15+, Safari 5+ */
	animation: spin 3s linear infinite;
	/* Chrome, Firefox 16+, IE 10+, Opera */
}

#loader:after {
	content: "";
	position: absolute;
	top: 15px;
	left: 15px;
	right: 15px;
	bottom: 15px;
	border-radius: 50%;
	border: 3px solid transparent;
	border-top-color: #f9c922;
	-webkit-animation: spin 1.5s linear infinite;
	/* Chrome, Opera 15+, Safari 5+ */
	animation: spin 1.5s linear infinite;
	/* Chrome, Firefox 16+, IE 10+, Opera */
}

@-webkit-keyframes spin {
	0% {
		-webkit-transform: rotate(0deg);
		/* Chrome, Opera 15+, Safari 3.1+ */
		-ms-transform: rotate(0deg);
		/* IE 9 */
		transform: rotate(0deg);
		/* Firefox 16+, IE 10+, Opera */
	}

	100% {
		-webkit-transform: rotate(360deg);
		/* Chrome, Opera 15+, Safari 3.1+ */
		-ms-transform: rotate(360deg);
		/* IE 9 */
		transform: rotate(360deg);
		/* Firefox 16+, IE 10+, Opera */
	}
}

@keyframes spin {
	0% {
		-webkit-transform: rotate(0deg);
		/* Chrome, Opera 15+, Safari 3.1+ */
		-ms-transform: rotate(0deg);
		/* IE 9 */
		transform: rotate(0deg);
		/* Firefox 16+, IE 10+, Opera */
	}

	100% {
		-webkit-transform: rotate(360deg);
		/* Chrome, Opera 15+, Safari 3.1+ */
		-ms-transform: rotate(360deg);
		/* IE 9 */
		transform: rotate(360deg);
		/* Firefox 16+, IE 10+, Opera */
	}
}
</style>
@endsection
@section('content')
<div class="page-title-box d-sm-flex align-items-center justify-content-between">
   <h4 class="mb-sm-0 font-size-18">Import</h4>
   <div class="page-title-right">
      <ol class="breadcrumb m-0">
         <li class="breadcrumb-item"><a href="{{ route('client.index') }}">Clients</a></li>
         <li class="breadcrumb-item active"><a href="{{ route('customer.import') }}">Import</a></li>
      </ol>
   </div>
</div>
<!-- .card-->
<div class="row justify-content-center">
   <div class="col-lg-8">
      @if (session('status'))
      <div class="alert alert-success alert-dismissible alert-label-icon label-arrow fade show" role="alert">
         <i class="ri-check-double-line label-icon"></i><strong>Success</strong> - {{session('status')}}
         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      <!-- show error message  -->
      @endif @if (session('error'))
      <div class="alert alert-danger alert-dismissible alert-label-icon label-arrow fade show mb-xl-0" role="alert">
         <i class="ri-error-warning-line label-icon"></i><strong>Failed</strong>
         - {{session('error')}}
         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      <br />
      @endif
      @if (session('info'))
      <div class="alert alert-info alert-dismissible alert-label-icon label-arrow fade show mb-xl-0" role="alert">
         <i class="ri-error-warning-line label-icon"></i><strong>Failed</strong>
         - {{session('info')}}
         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      <br />
      @endif
      <div class="card">
         <div class="card-body p-0">
            <div class="tab-content p-0">
               <div class="tab-pane active" id="report" role="tabpanel">
                  <div class="p-3 bg-soft-warning">
                     <h6 class="mb-0 text-danger text-center">CUSTOMERS IMPORTER MODULE</h6>
                  </div>
                  <!-- resources/views/customers/import.blade.php -->
                  <form id="importForm" action="{{ route('customer.import') }}" method="POST" enctype="multipart/form-data">
                     @csrf
                     <div class="p-3">
                        <div class="form-group">
                           <label for="source">Select import source:</label>
                           <select name="source" id="source" class="form-control" required>
                              <option value="default">Default</option>
                              <option value="splynx">Splynx</option>
                           </select>
                        </div>
                        <div class="form-group">
                           <label for="file">Choose Excel file:</label>
                           <input type="file" name="file" id="file" class="form-control" accept=".xls,.xlsx,.xlsm,.xlsb,.csv" required>
                        </div>
                        @error('file')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                        <div class="mt-3 pt-2">
                           <button type="submit" class="btn btn-primary w-100">Import Customers</button>
                        </div>
                     </div>
                  </form>
               </div>
               <!-- end tabpane -->
            </div>
            <!-- end tab pane -->
         </div>
         <!-- end card body -->
      </div>
      <!-- end card -->
   </div>
   <!-- end col -->
</div>
@endsection
@section('script')
<script src="{{ URL::asset('/assets/js/jquery-3.6.1.js')}}"></script>
<script src="{{asset('assets/js/app.js')}}"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
  // Get a reference to the form element
  const importForm = document.getElementById('importForm');
  const loadingContainer = document.getElementById('loader-wrapper');

  // Add an event listener to the form
  importForm.addEventListener('submit', function(event) {
    // Prevent the default behavior of the form
    event.preventDefault();

    // Show the confirmation dialog
    swal({
      title: "Import Customers",
      text: "This will import customers from the selected file. Do you want to proceed?",
      icon: "info",
      buttons: {
        cancel: "Cancel",
        confirm: {
          text: "Import",
          value: true,
          visible: true,
          className: "",
          closeModal: true
        }
      },
      content: {
        element: "span",
        attributes: {
          style: "display:flex;align-items:center;justify-content:center;"
        },
        html: "<i class='fas fa-file-import fa-3x' style='margin-right:10px'></i><i class='fas fa-arrow-right fa-2x'></i>"
      }
    })
    .then((result) => {
      if (result) {
        // Show the loading container
        loadingContainer.style.display = 'block';

        // If the user confirmed the import, submit the form
        // Simulate an async call with setTimeout to see the loading indicator
        setTimeout(() => {
          importForm.submit();
        }, 1000);
      }
    });
  });
</script>
@endsection