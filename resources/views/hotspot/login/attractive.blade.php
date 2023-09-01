<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <title>Login</title>
      <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
      <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0,user-scalable=0"/>
      <meta name="description" content="">
      <meta name="author" content="">
      <link href="{{URL::asset('assets/hotspot/attractive/bootstrap.css')}}" rel="stylesheet" type="text/css">
      <link rel="stylesheet" href="{{URL::asset('assets/hotspot/attractive/custom.css')}}">
      <script type="text/javascript" src="{{URL::asset('assets/hotspot/attractive/jquery.min.js')}}"></script>
      <script type="text/javascript" src="{{URL::asset('assets/hotspot/attractive/bootstrap.min.js')}}"></script> 
   </head>
   <body class="">
      <div class="content-wrapper">
         <div class="container"></div>
         <div class="navbar navbar-default navbar-static-top">
            <style>
               .body{padding-top:70px}
            </style>
            <div class="container">
               <div class="navbar-header">
                  <button type="button" class="navbar-toggle packages" data-toggle="collapse" data-target=".navbar-collapse">
                  <span class="sr-only">Toggle navigation</span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  </button><a style="font-weight: 400" class="navbar-brand" href="#">{{strtoupper(setting('hotspotName'))}}</a>
               </div>
               <div class="collapse navbar-collapse navbar-ex1-collapse">
                  <ul class="nav navbar-nav navbar-right">
                     <!-- <li class="default"><a href="#">Login</a>
                        </li> -->
                     <!--<li class="active"><a href="/portal/portal/signup" class="btn-info">Sign Up</a>
                        </li>-->
                     @if (null !== setting('hotspotContactLink') && setting('hotspotContactLink') !== '')
                     <li>
                        <a style="font-weight: 400" href="{{ setting('hotspotContactLink') }}">Contact Us</a>
                     </li>
                     @endif
                     </li>
                  </ul>
               </div>
            </div>
         </div>
      </div>
      <div class="container">
         <div class="row">
            <div class="col-md-7">
               <div class="img/banner" class="img-thumbnail">
                  <img src="{{ asset('images/' . setting('hotspot_cover')) }}" class="img-thumbnail" class="img-responsive">
               </div>
            </div>
            <div class="col-md-5">
               <div class="panel panel-info img/banner packages">
                  @if(empty(setting('hotspot_info')))
                  <div class="panel-heading main-panel">
                     <h4><font color="white">How to Access Internet</font></h4>
                  </div>
                  <p style="font-weight: 400;" color="white">1. Choose a package below and click purchase <br>
                     2. Enter your <strong>Mpesa</strong> number & then proceed.<br>
                     3. When prompted enter your Mpesa pin & send <br>
                     4. You will receive an sms with login code/pin<br>
                     5. Enter the <strong>code/pin</strong> below and click connect<br>
                     6. Incase of any query, kindly <a href="{{ setting('hotspotContactLink') }}">CONTACT US</a>
                  </p>
                  @else
                  {!!html_entity_decode(setting('hotspot_info'))!!}
                  @endif
               </div>
               <!--Login-->
               @if(session()->has('common_data'))
               @php
               $common_data = session()->get('common_data');
               @endphp
               <div>
                  <!--$(if chap-id)-->
                  <form name="sendin" action="{{$common_data['link_login_only']}}" method="post" style="display:none" rel="noreferrer">
                     <input type="hidden" name="username" />
                     <input type="hidden" name="password" />
                     <!-- <input type="hidden" name="dst" value="link_orig" /> -->
                     <input type="hidden" name="popup" value="true" />
                  </form>
                  <div class="ie-fixMinHeight">
                     <div class="main">
                        <div class="wrap animated fadeIn">
                           <form name="login" id="login-form" action="{{$common_data['link_login_only']}}" method="post" id="login-form" onSubmit="return doLogin()" rel="noreferrer">
                              <!-- <input type="hidden" name="dst" value="link_orig" /> -->
                              <input type="hidden" name="dst" value="/status" />
                              <input type="hidden" name="popup" value="true" />
                              <p class="info login-text">
                                 <!--$(if error == "")-->Please log in to use the internet hotspot service 
                                 <!--$(endif)-->
                                 <!-- $(if error) -->
                                 <br />
                              <div class="text-danger error-text"><?php echo $common_data['error']; ?></div>
                              <!-- $(endif) -->
                              </p>
                              <div class="form-group">
                                 <div class="input-group">
                                    <input type="text" class="form-control" style="height: 54px;" name="username" value="{{ $voucherCode ?? $common_data['username'] }}" placeholder="Voucher code" id="code" />
                                    <span class="input-group-btn">
                                    <button class="btn btn-info btn-lg btn-buy btn-block btn-submit" type="submit">Connect</button>
                                    </span>
                                 </div>
                              </div>
                              <input name="password" type="hidden" placeholder="Password" />
                              {{-- <script>
                                 function forceUpper(strInput)
                                 {
                                   strInput.value=strInput.value.toUpperCase();
                                 }
                                 function removeSpaces(string) {
                                  return string.split(' ').join('');
                                 }
                              </script> --}}
                           </form>
                        </div>
                     </div>
                  </div>
                  <!-- login template -->
               </div>
               @endif
            </div>
         </div>
         <!--login -->
         <br>   
         <div class="row">
         </div>
         <div class="row">
            @forelse($plans as $plan)
            <div class="col-md-4 col-sm-4">
               <div class="panel panel-info packages text-center">
                  <div class="panel-heading">
                     <h4><font color="white">{{$plan->title}}</font></h4>
                  </div>
                  @if($plan->speed_limit)
                  <p  color="white">Upto <b>{{$plan->speed_limit}}</b> Mbps</p>
                  @endif
                  @if($plan->simultaneous_use_limit)
                  <p  color="white">simultaneous device use <b>{{$plan->simultaneous_use_limit}}</b></p>
                  @endif
                  @if($plan->duration)
                  <p  color="white">Validity <b>{{ formatDuration($plan->duration) }}</b></p>
                  @endif
                  @if($plan->description)
                  <p  color="white"><b>Description</b> {{$plan->description}}</p>
                  @endif
                  <p  color="white">Downloads : Unlimited*</p>
                  @if($plan->offer)
                  <div class="month" style="text-align: center;">
                     <del style="color: #a5a5a5; font-size: 20px; margin-right: 10px;">
                     <sup style="margin-right: 2px;"><small style="font-size: 15px;">Ksh</small></sup>
                     <span class="ff-secondary fw-bold" style="font-size: 26px;">{{$plan->price}}</span>
                     </del>
                     <span style="font-size: 26px; color: #f15a24;">{{ $plan->discounted_price }}</span>
                  </div>
                  @php
                  $discounted_price = $plan->price - ($plan->price * $plan->discount_rate / 100);
                  @endphp
                  <h1 class="month">
                     <sup><small>Ksh</small></sup>
                     <span class="ff-secondary fw-bold">{{ $discounted_price }}</span> 
                  </h1>
                  <div class="text-success">You save {{$plan->discount_rate}}%!</div>
                  @else
                  <h1 class="month">
                     <sup><small>Ksh</small></sup>
                     <span class="ff-secondary fw-bold">{{$plan->price}}</span> 
                  </h1>
                  @endif
                  <br>
                  <div>
                     @if($plan->offer)
                     @php
                     $discounted_price = $plan->price - ($plan->price * $plan->discount_rate / 100);
                     @endphp
                     <button type="button" class="btn btn-warning btn-buy" data-toggle="modal" data-target="#purchaseVoucherModal" data-title="{{$plan->title}}" data-amount="{{$discounted_price}}" data-plan-id="{{$plan->id}}">PURCHASE</button>
                     @else
                     <button type="button" class="btn btn-warning btn-buy" data-toggle="modal" data-target="#purchaseVoucherModal" data-title="{{$plan->title}}" data-amount="{{$plan->price}}" data-plan-id="{{$plan->id}}">PURCHASE</button>
                     @endif
                  </div>
               </div>
            </div>
            <!--end col-->
            @empty
            <h2>No plans available.</h2>
            @endforelse
         </div>
         <div class="modal fade" id="purchaseVoucherModal" tabindex="-1" aria-labelledby="purchaseVoucherModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
               <div class="modal-content">
                  <div class="modal-header">
                     <h6 class="modal-title" id="purchaseVoucherModalLabel"><span class="voucher_title"></span> Voucher</h6>
                  </div>
                  <form action="{{route('voucher.buy')}}" method="POST">
                     @csrf
                     <div class="modal-body">
                        <!-- Add form elements here -->
                        <div class="mb-3">
                           <label for="phone" class="form-label">Phone Number <span class="text-danger">*</span></label>
                           <input type="tel" name="phone" value="{{ old('phone') }}" id="phone" class="form-control @error('phone') is-invalid @enderror" aria-label="phone" placeholder="Enter phone number" required />
                           @error('phone')
                           <div class="text-danger">{{ $message }}</div>
                           @enderror
                        </div>
                     </div>
                     <input type="hidden" name="amount" id="amount">
                     <input type="hidden" name="plan_id" id="plan">
                     <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-info btn-buy">Purchase Voucher</button>
                     </div>
                  </form>
               </div>
            </div>
         </div>
         <!-- Success modal -->
         <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
               <div class="modal-content">
                  <div class="modal-header">
                     <h5 class="modal-title text-success" id="successModalLabel">Success!</h5>
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                     </button>
                  </div>
                  <div class="modal-body">
                     <p id="successMessage"></p>
                  </div>
               </div>
            </div>
         </div>
         <!-- Error Modal -->
         <div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
               <div class="modal-content">
                  <div class="modal-header">
                     <h5 class="modal-title" id="errorModalLabel">Error</h5>
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                     </button>
                  </div>
                  <div class="modal-body">
                     <p id="errorMessage"></p>
                  </div>
                  <div class="modal-footer">
                     <small class="text-danger">An error occured. Ensure you enter correct info</small>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="row">
         <div align="center" class="footer-text">
            * Based on fair usage policy (available bandiwdth)
         </div>
      </div>
      <!-- Loader -->
      <div id="loader-wrapper">
         <div id="loader"></div>
      </div>
   </body>
   </br>
   {!! setting('tawk') !!}
   <footer>
      <div align="center" class="footer-text">
         Copyright &copy {{ date('Y') }} {{setting('hotspotName')}} 
      </div>
   </footer>
   </div>
   <script src="{{ URL::asset('/assets/js/sweetalert2.all.min.js') }}"></script>
   <script src="{{ URL::asset('/assets/js/md5.js') }}"></script>
   <script>
      var hasCommonData = {{ session()->has('common_data') ? 'true' : 'false' }};
   </script>
   <script>
      // Function to handle the "Purchase Voucher" button click
      // Function to show a SweetAlert 2 loading animation
      function showLoadingAnimation() {
         const swalPromise = Swal.fire({
            title: "Processing Data",
            text: "Please wait...",
            icon: "info",
            allowOutsideClick: false,
            allowEscapeKey: false,
            showConfirmButton: false,
            showCancelButton: true,
            showCloseButton: false,
            didOpen: () => {
                  Swal.showLoading();
            },
            customClass: {
                  popup: 'custom-modal-size',
            },
         });

         // Add an event listener to the "Cancel" button
         swalPromise.then((result) => {
            if (result.dismiss === Swal.DismissReason.cancel) {
                  // End the loading animation when the "Cancel" button is clicked
                  Swal.hideLoading();
            }
         });
      }

      
      // Function to hide the SweetAlert 2 loading animation
      function hideLoadingAnimation() {
       Swal.close();
      }
      
      // AJAX function to handle form submission
      function handleFormSubmission(formData) {
       // Show the loading animation using SweetAlert 2
       showLoadingAnimation();
      
       $.ajax({
         type: 'POST',
         url: '{{ route("voucher.buy") }}', // Replace with your route URL
         data: formData,
         success: function(response) {
           hideLoadingAnimation(); // Hide the SweetAlert 2 loading animation
      
           // Close the purchase voucher modal
           $('#purchaseVoucherModal').modal('hide');
      
           // Show either the success modal or the error modal, depending on the value of `success`
           if (response.success) {
             // Show the success modal with the SweetAlert 2 success animation
             Swal.fire({
               title: "Success",
               text: response.message,
               icon: "success",
               showCancelButton: false,
               showCloseButton: false,
               allowOutsideClick: false,
               allowEscapeKey: false,
               timer: 2000, // Display the success message for 2 seconds
               didOpen: () => {
                 Swal.hideLoading();
               },
             });
              if (hasCommonData) {
                showLoadingAnimation();
            }
           } else {
             // Show the error modal with the SweetAlert 2 error animation
             Swal.fire({
               title: "Error",
               text: response.message,
               icon: "error",
               showCancelButton: false,
               showCloseButton: false,
               allowOutsideClick: false,
               allowEscapeKey: false,
             });
           }
         },
         error: function(xhr, status, error) {
           hideLoadingAnimation(); // Hide the SweetAlert 2 loading animation on error
      
           // Handle the error or display an error message if needed
           Swal.fire({
             title: "Error",
             text: "An error occurred while processing your request.",
             icon: "error",
             showCancelButton: false,
             showCloseButton: false,
             allowOutsideClick: false,
             allowEscapeKey: false,
           });
      
           console.log(xhr.responseText);
         }
       });
      }
      
      // Attach form submission event handler
      $(document).ready(function() {
       $('#purchaseVoucherModal form').submit(function(e) {
         e.preventDefault(); // prevent the form from submitting normally
      
         const formData = $(this).serialize(); // serialize the form data
         handleFormSubmission(formData);
       });
      });
      
      // Contact for submission
      $(document).ready(function() {
       $("#contact-form").submit(function(event) {
           // Prevent the form from submitting via the browser.
           event.preventDefault();
      
           // Submit the form via AJAX.
           $.ajax({
               type: "POST",
               url: $(this).attr("action"),
               data: $(this).serialize(),
               success: function(response) {
                   // Show either the success modal or the error modal, depending on the value of `success`
                   if (response.success) {
                       // Remove any existing error messages.
                       $('.alert').remove();
      
                       $("#contact-form")[0].reset();
                       $('#successModal').modal('show');
                       $('#successMessage').text(response.message);
                   } else {
                       // Display the error message in a Bootstrap alert component.
                       var errorMessage = '<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
                           '<strong>Error:</strong> ' + response.message + '</div>';
      
                       $('#contact-form').prepend(errorMessage);
                   }
               },
               error: function(xhr, status, error) {
                   // Remove any existing alert messages.
                   $('.alert').remove();
      
                   // Display a list of validation errors in a Bootstrap alert component.
                   var errorResponse = JSON.parse(xhr.responseText);
                   var errors = errorResponse.errors;
                   var errorMessage = '<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
                       '<strong>Error:</strong><br>';
                   $.each(errors, function(key, value) {
                       errorMessage += '- ' + value + '<br>';
                   });
                   errorMessage += '</div>';
      
                   $('#contact-form').prepend(errorMessage);
               }
           });
       });
      });
      
         // Function to handle the AJAX request and form submission
         // Function to display a SweetAlert 2 success message
      function showSuccessMessage(message) {
       Swal.fire({
         title: "Success",
         text: message,
         icon: "success",
         showCancelButton: false,
         showCloseButton: false,
         allowOutsideClick: false,
         allowEscapeKey: false,
         timer: 2000, // Display the success message for 2 seconds
       });
      }
      
      // Function to display a SweetAlert 2 error message
      function showErrorMessage(errorMessage) {
       Swal.fire({
         title: "Error",
         text: errorMessage,
         icon: "error",
         showCancelButton: false,
         showCloseButton: false,
         allowOutsideClick: false,
         allowEscapeKey: false,
       });
      }
      
      // Function to handle the AJAX request and form submission
      function submitLoginForm(username, password, chap_id, chap_challenge) {
       // Show the loading animation using SweetAlert 2
       showLoadingAnimation();
      
       const xhr = new XMLHttpRequest();
       xhr.open('POST', '{{ route("hotspotlogincheck") }}', true);
       xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');
       xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
       xhr.onreadystatechange = function () {
         if (xhr.readyState === XMLHttpRequest.DONE) {
           hideLoadingAnimation(); // Hide the SweetAlert 2 loading animation
      
           if (xhr.status === 200) {
             const response = JSON.parse(xhr.responseText);
             if (response.success) {
               // Call the doLogin function to submit the form
               document.login.username.value = username;
               document.login.password.value = hexMD5(chap_id + username + chap_challenge);
               document.login.submit();
      
               // Show the success message
               showSuccessMessage(response.message);
             } else {
               // Otherwise, display an error message in the modal
               const errorMessage = response.message || 'An error occurred';
               showErrorMessage(errorMessage);
             }
           } else {
             // Show error message in the modal
             showErrorMessage('An error occurred while processing your request.');
           }
         }
       };
       xhr.send(JSON.stringify({
         username: username,
         password: password
       }));
      }
      
      // Attach form submission event handler
      $(document).ready(function() {
       $('#purchaseVoucherModal form').submit(function(e) {
         e.preventDefault(); // prevent the form from submitting normally
      
         const formData = $(this).serialize(); // serialize the form data
         handleFormSubmission(formData);
       });
      });
         
         // Function to display the error modal with the given error message
         function showErrorModal(errorMessage) {
             const errorModal = $('#errorModal');
             errorModal.find('#errorMessage').text(errorMessage);
             errorModal.modal('show');
         }
         
         // Modal pass package data
         $('#purchaseVoucherModal').on('show.bs.modal', function (event) {
             var button = $(event.relatedTarget); // Button that triggered the modal
             var title = button.data('title'); // Extract info from data-* attributes
             var amount = button.data('amount');
             var planID = button.data('plan-id');
             var modal = $(this);
             modal.find('.voucher_title').text(title);
             modal.find('#amount').val(amount);
             modal.find('#plan').val(planID);
         });
         
         // Ajax submit form data
         setTimeout(function () {
             $("#loader-wrapper").hide();
         }, 200);
         
         // Get common data from PHP variables
         const username = "{{ isset($common_data['username']) ? $common_data['username'] : '' }}";
         const chap_id = "{{ isset($common_data['chap_id']) ? $common_data['chap_id'] : '' }}";
         const chap_challenge = "{{ isset($common_data['chap_challenge']) ? $common_data['chap_challenge'] : '' }}";
         
         // Handle form submission on submit button click
         const loginForm = document.getElementById('login-form');
         const submitButton = loginForm ? loginForm.querySelector('button[type="submit"]') : null;
         
         if (submitButton) {
             submitButton.addEventListener('click', function (event) {
                 event.preventDefault(); // Prevent the form from submitting
         
                 // Get the values of the username and password fields
                 const usernameInput = loginForm.elements['username'].value;
                 const password = loginForm.elements['password'].value;
         
                 // Make an AJAX request to the Laravel controller for login check
                 submitLoginForm(usernameInput, password, chap_id, chap_challenge);
             });
         }
         
         // Auto-submit the form function on page load
         function autoSubmitForm() {
            // Check if the username is present and not empty
            if (username && username.trim() !== "") {
               // Check if the form has already been auto-submitted
               if (!loginForm.getAttribute("data-auto-submitted")) {
                     loginForm.setAttribute("data-auto-submitted", "true");
      
                     // Call the checkVoucherIssuance function periodically (every 5 seconds in this example)
                     setInterval(checkVoucherIssuance, 5000); // Adjust the interval as needed
               }
            }
         }
      
         // Initial delay of 5 seconds before running the function
         setTimeout(function () {
            checkVoucherIssuance(); // Call the function immediately on page load
      
            // Now, set the interval to run every 10 seconds
            setInterval(function () {
               checkVoucherIssuance(); // Call the function every 10 seconds
            }, 10000); // 10000 milliseconds = 10 seconds
         }, 5000); // 5000 milliseconds = 5 seconds gap before starting the setInterval
      
         // AJAX function to check voucher issuance
         function checkVoucherIssuance() {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', '{{ route("checkVoucherIssuance") }}', true);
            xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');
            xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
            xhr.onreadystatechange = function () {
               if (xhr.readyState === XMLHttpRequest.DONE) {
               if (xhr.status === 200) {
                  const response = JSON.parse(xhr.responseText);
                  if (response.voucher) {
                     // Voucher value found, use it as the username and auto-submit the form
                     submitLoginForm(response.voucher, '', chap_id, chap_challenge);
                  }
               } else {
                  // Handle the error or display an error message if needed
               }
               }
            };
      
            const sessionId = '{{ isset($common_data['session_id']) ? $common_data['session_id'] : '' }}'; // Get the session_id from the cache
            xhr.send(JSON.stringify({
               session_id: sessionId
            }));
         }
         
         // Call the autoSubmitForm() function when the page loads
         //window.onload = autoSubmitForm;
      
   </script>
</html>