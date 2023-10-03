@extends('layouts.master') @section('title') Application updater @endsection 
@section('css') 
@endsection 
@section('content') 
{{-- @component('components.breadcrumb') @slot('li_1') Messages @endslot @slot('title') Create @endslot
@endcomponent --}}
<div class="page-title-box d-sm-flex align-items-center justify-content-between">
   <h4 class="mb-sm-0 font-size-18">Updater</h4>
   <div class="page-title-right">
      <ol class="breadcrumb m-0">
         <li class="breadcrumb-item"><a>Info</a></li>
         <li class="breadcrumb-item active"><a href="{{ route('updater.index') }}">Updates</a></li>
      </ol>
   </div>
</div>
<!-- .card-->
<div class="row justify-content-center">
   <div class="col-md-8 col-lg-6 col-xl-5">
      <div class="card mt-4">
         <div class="card-body p-4">
            @if(isUpdateAvailable($update_data['version'], env('VERSION_INSTALLED')))
            <div class="avatar-lg mx-auto mt-2">
               <div class="avatar-title bg-light text-muted display-3 rounded-circle">
                  <i class="ri-download-cloud-2-fill"></i>
               </div>
            </div>

            <div class="text-center mt-2">
               <div>
                  @if (session('error'))
                  <div class="alert alert-danger">
                     {{ session('error') }}
                  </div>
                  @endif
               </div>
               {{-- <h5 class="text-primary">Simple ISP Updater</h5> --}}
               
               <h5 class="card-title text-info">{{ $update_data['message'] }}</h5>
            </div>
            <div class="p-2 mt-4">
               @if($update_data['status'])
               <code style="font-size:16px" class="text-muted">{!! $update_data['changelog'] !!}</code>
               @if(!empty($update_id))
               {{-- <progress id="prog" value="0" max="100.0" class="progress is-success" style="margin-bottom: 10px;"></progress> --}}
               @else
               <form id="update-form" method="POST">
                  @csrf
                  <input type="hidden" class="form-control" value="{{ $update_data['update_id'] }}" name="update_id">
                  <input type="hidden" class="form-control" value="{{ $update_data['has_sql'] }}" name="has_sql">
                  <input type="hidden" class="form-control" value="{{ $update_data['version'] }}" name="version">
                  <center>
                     <button type="submit" id="update-button" class="btn btn-soft-success w-100">Download & Install Update</button>
                  </center>
               </form>
               @endif
               @endif
               <!-- Prgress xl -->
               <div class="progress progress-xl" style="display: none;">
                  <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" id="prog" aria-valuemin="0" aria-valuemax="100"></div>
               </div>
               <br>
               {{-- <progress id="prog" value="0" max="100.0" class="progress is-success" style="margin-bottom: 10px;"></progress> --}}
               <code style="font-size:16px">
                  <div id="progress-container"></div>
               </code>
            </div>
            @else
            <div class="avatar-lg mx-auto mt-2">
               <div class="avatar-title bg-light text-success display-3 rounded-circle">
                  <i class="ri-checkbox-circle-fill"></i>
               </div>
            </div>
            <div class="mt-4 pt-2">
               <h4 class="text-center">Congrats !</h4>
               <p class="text-muted mx-4 text-center">You have the latest version of the app.</p>
            </div>
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
<script>
   $(document).ready(function() {
     $('#update-form').on('submit', function(event) {
       event.preventDefault();
   
       var formData = $(this).serialize();
   
       // Hide the submit button
       $('#update-button').hide();
   
       // Show the progress bar
       $('.progress').show();
   
       $.ajax({
         type: 'POST',
         url: '{{ route('updater.update') }}',
         data: formData,
         dataType: 'json',
         beforeSend: function() {
           $('#progress-container').html('Requesting update...<br>');
         },
         success: function(response) {
           console.log(response);
           let progressText = response.progress.split(/<script>.*?<\/script>/gi);
           let progressBarValues = response.progress.match(/<script>document.getElementById\('prog'\).value = (\d+);<\/script>/gi);
           let updateSteps = response.steps;
   
           if (progressBarValues) {
             progressBarValues = progressBarValues.map(function(value) {
               return value.match(/<script>document.getElementById\('prog'\).value = (\d+);<\/script>/)[1];
             });
           }
   
           displayProgress(0, progressText, progressBarValues, updateSteps);
   
           setTimeout(function() {
             // Redirect to the dashboard after 20 seconds
             $('#progress-container').html('Update successful, redirecting in 5 seconds...');
             setTimeout(function() {
               window.location.replace('{{ route('updater.index') }}');
             }, 5000); // Adjust the delay (in milliseconds) as needed
           }, 2000); // Wait for the update to finish before starting the redirection
         },
         error: function(xhr, status, error) {
           console.error(xhr.responseText);
           $('#progress-container').html('Error: ' + xhr.responseText);
   
           // Show the submit button and hide the progress bar in case of an error
           $('#update-button').show();
           $('.progress').hide();
         }
       });
     });
   
     // Hide the progress bar initially
     $('.progress').hide();
   });
   
   function displayProgress(index, progressText, progressBarValues, updateSteps) {
     if (index < progressText.length) {
       $('#progress-container').append(progressText[index]);
       if (progressBarValues && index < progressBarValues.length) {
         var value = progressBarValues[index];
         var max = $('#prog').attr('aria-valuemax');
         var percentage = (value / max) * 100;
         $('#prog').css('width', percentage + '%');
         $('#prog').attr('aria-valuenow', value);
       }
   
       if (updateSteps && index < updateSteps.length) {
         $('#update-steps').append('<li>' + updateSteps[index] + '</li>');
       }
   
       setTimeout(function() {
         displayProgress(index + 1, progressText, progressBarValues, updateSteps);
       }, 100); // Adjust the interval (in milliseconds) as needed
     }
   }
</script>
@endsection