<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg">
   <head>
      <meta charset="utf-8" />
      <title>{{setting('company')}} hotspot</title>
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
      <meta content="Themesbrand" name="author" />
      <!-- App favicon -->
      <link rel="shortcut icon" href="assets/images/favicon.ico">
      <!-- Layout config Js -->
      <!-- Bootstrap Css -->
      <link href="{{ URL::asset('assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
      <!-- Icons Css -->
      <link href="{{ URL::asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
      <!-- App Css-->
      <link href="{{ URL::asset('assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
      <!-- custom Css-->
      <link href="{{ URL::asset('assets/css/custom.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
   </head>
   <body data-bs-spy="scroll" data-bs-target="#navbar-example">
      <!-- Begin page -->
      <div class="layout-wrapper landing">
         <nav class="navbar navbar-expand-lg navbar-landing fixed-top" id="navbar">
            <div class="container">
               <a class="navbar-brand" href="#">
               {{strtoupper(setting('hotspotName'))}}
               </a>
               <button class="navbar-toggler py-0 fs-20 text-body" type="button" data-bs-toggle="collapse"
                  data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                  aria-expanded="false" aria-label="Toggle navigation">
               <i class="mdi mdi-menu"></i>
               </button>
               <div class="collapse navbar-collapse" id="navbarSupportedContent">
                  <ul class="navbar-nav mx-auto mt-2 mt-lg-0" id="navbar-example">
                     @if (null !== setting('hotspotContactLink') && setting('hotspotContactLink') !== '')
                     <li class="nav-item">
                        <a class="nav-link" href="{{setting('hotspotContactLink')}}">Contact</a>
                     </li>
                     @endif
                  </ul>
               </div>
            </div>
         </nav>
         <!-- start plan -->
         <section class="section">
            <div style="margin-top:40px" class="container">
               <div class="row align-items-center gy-4">
                  <div class="col-lg-8 col-md-12 col-sm-7 col-12 ms-auto order-1 order-lg-2">
                     <div>
                        <img src="{{ asset('images/' . setting('hotspot_cover')) }}" alt="" class="img-fluid img-thumbnail">
                     </div>
                  </div>
                  <div class="col-lg-4 col-md-12 order-2 order-lg-1">
                     <!-- information section -->
                     @include('hotspot.login.partials.info')
                     <!-- Hotspot login codes form -->
                     @if(session()->has('common_data'))
                     @php
                     $common_data = session()->get('common_data');
                     @endphp
                     <div>
                        <!--$(if chap-id)-->
                        <form name="sendin" action="{{$common_data['link_login_only']}}" method="post" style="display:none">
                           <input type="hidden" name="username" />
                           <input type="hidden" name="password" />
                           <!-- <input type="hidden" name="dst" value="link_orig" /> -->
                           <input type="hidden" name="popup" value="true" />
                        </form>
                        <!--$(endif)-->
                        <div class="ie-fixMinHeight">
                           <div class="main">
                              <div class="wrap animated fadeIn">
                                 <form name="login" id="login-form" action="{{$common_data['link_login_only']}}" method="post" onSubmit="return doLogin()">
                                    <!-- <input type="hidden" name="dst" value="link_orig" /> -->
                                    <input type="hidden" name="dst" value="/status" />
                                    <input type="hidden" name="popup" value="true" />
                                    <p class="info">
                                       <!--$(if error == "")-->Please log in to use the internet hotspot service 
                                       <!--$(if trial == 'yes')--><br />Free trial available, <a href="{{$common_data['link_login_only']}}?dst={{$common_data['link_orig_esc']}}&amp;username=T-{{$common_data['mac_esc']}}">click here</a>.<!--$(endif)-->
                                       <!--$(endif)-->
                                       <!-- $(if error) -->
                                       <br />
                                    <div class="text-danger"><?php echo $common_data['error']; ?></div>
                                    <!-- $(endif) -->
                                    </p>
                                    <div class="input-group input-group-lg">
                                       <input name="username" type="text" value="{{$common_data['username']}}" placeholder="Voucher code" class="form-control" id="code" onkeyup="return forceLower(this);" onblur="this.value=removeSpaces(this.value);" />
                                       <input name="password" type="hidden" placeholder="Password" />
                                       <button class="btn btn-outline-success btn-submit" type="submit"><i class="ri-login-circle-line"></i> Connect</button>
                                    </div>
                                    <script>
                                       function forceLower(strInput)
                                       {
                                         strInput.value=strInput.value.toUpperCase();
                                       }
                                       function removeSpaces(string) {
                                        return string.split(' ').join('');
                                       }
                                    </script>
                                 </form>
                              </div>
                           </div>
                        </div>
                        <!-- login template -->
                     </div>
                     @endif
                     <!-- end hotspot login section -->
                  </div>
                  <!-- end col -->
               </div>
            </div>
            <!-- end container -->
         </section>
         <section class="section bg-light" id="plans">
            <div class="bg-overlay bg-overlay-pattern"></div>
            <div class="container">
               <div class="row justify-content-center">
                  <div class="col-lg-8">
                     <div class="text-center mb-5">
                        <h3 class="mb-3 fw-semibold">Choose the plan that's right for you </h3>
                        <p class="text-muted mb-4">Simple pricing. No hidden fees. Fast connection
                        </p>
                     </div>
                  </div>
                  <!-- end col -->
               </div>
               <!-- end row -->
               <div class="row gy-4">
                  @forelse($plans as $plan)
                  <div class="col-md-4">
                     <div class="card plan-box mb-0">
                        <div class="card-body p-4 m-2">
                           <div class="d-flex align-items-center">
                              <div class="flex-grow-1">
                                 <h5 class="mb-1 fw-semibold">{{$plan->title}}</h5>
                              </div>
                              <div class="avatar-sm">
                                 <div class="avatar-title bg-light rounded-circle text-primary">
                                    <i class="ri-book-mark-line fs-20"></i>
                                 </div>
                              </div>
                           </div>
                           <div class="py-4 text-center">
                              <h1 class="month">
                              <sup><small>Ksh</small></sup><span class="ff-secondary fw-bold">{{$plan->price}}</span> 
                           </div>
                           <div>
                              <ul class="list-unstyled text-muted vstack gap-3 ff-secondary">
                                 <li>
                                    <div class="d-flex">
                                       <div class="flex-shrink-0 text-success me-1">
                                          <i class="ri-checkbox-circle-fill fs-15 align-middle"></i>
                                       </div>
                                       <div class="flex-grow-1">
                                          Upto <b>{{$plan->speed_limit}}</b> Mbps
                                       </div>
                                    </div>
                                 </li>
                                 <li>
                                    <div class="d-flex">
                                       <div class="flex-shrink-0 text-success me-1">
                                          <i class="ri-checkbox-circle-fill fs-15 align-middle"></i>
                                       </div>
                                       <div class="flex-grow-1">
                                          simultaneous device use <b>{{$plan->simultaneous_use_limit}}</b>
                                       </div>
                                    </div>
                                 </li>
                                 <li>
                                    <div class="d-flex">
                                       <div class="flex-shrink-0 text-success me-1">
                                          <i class="ri-checkbox-circle-fill fs-15 align-middle"></i>
                                       </div>
                                       <div class="flex-grow-1">
                                          Validity <b>{{ formatDuration($plan->duration) }}</b>
                                       </div>
                                    </div>
                                 </li>
                                 <li>
                                    <div class="d-flex">
                                       <div class="flex-shrink-0 text-success me-1">
                                          <i class="ri-checkbox-circle-fill fs-15 align-middle"></i>
                                       </div>
                                       <div class="flex-grow-1">
                                          Description <b>{{ $plan->description }}</b>
                                       </div>
                                    </div>
                                 </li>
                                 <li>
                                    <div class="d-flex">
                                       <div class="flex-shrink-0 text-success me-1">
                                          <i class="ri-checkbox-circle-fill fs-15 align-middle"></i>
                                       </div>
                                       <div class="flex-grow-1">
                                          Downloads: <b>Unlimited</b>
                                       </div>
                                    </div>
                                 </li>
                              </ul>
                              <div class="mt-4">
                                 <div class="mt-4">
                                    <button type="button" class="btn btn-soft-success w-100" data-bs-toggle="modal" data-bs-target="#purchaseVoucherModal" data-amount="{{ $plan->price }}" data-title="{{ $plan->title }}">Purchase</button>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <!--end col-->
                  @empty
                  <h2>No plans available.</h2>
                  @endforelse
               </div>
               <!--end row-->
            </div>
            <!-- end container -->
         </section>
         <!-- end plan -->
         <!-- start contact -->
         <section class="section" id="contact">
            <div class="container">
               <div class="row justify-content-center">
                  <div class="col-lg-8">
                     <div class="text-center mb-5">
                        <h3 class="mb-3 fw-semibold">Get In Touch</h3>
                     </div>
                  </div>
               </div>
               <!-- end row -->
               <div class="row gy-4">
                  <div class="col-lg-4">
                     <div>
                        <div class="mt-4">
                           <div class="ff-secondary fw-semibold">{{setting('company')}}, <br/><b>Phone:</b> {{setting('company_phone')}}<br/><b>Email:</b> {{setting('company_email')}}</div>
                        </div>
                     </div>
                  </div>
                  <!-- end col -->
                  <div class="col-lg-8">
                     <div>
                        <form id="contact-form" action="{{ route('contact.post') }}" method="POST">
                           @csrf
                           <div class="row">
                              <div class="col-lg-6">
                                 <div class="mb-4">
                                    <label for="name" class="form-label fs-13">Name</label>
                                    <input name="name" id="name" type="text" class="form-control bg-light border-light" placeholder="Your name*">
                                 </div>
                              </div>
                              <div class="col-lg-6">
                                 <div class="mb-4">
                                    <label for="email" class="form-label fs-13">Email</label>
                                    <input name="email" id="email" type="email" class="form-control bg-light border-light" placeholder="Your email*">
                                 </div>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-lg-12">
                                 <div class="mb-4">
                                    <label for="subject" class="form-label fs-13">Subject</label>
                                    <input type="text" name="subject" class="form-control bg-light border-light" id="subject" placeholder="Your Subject.." />
                                 </div>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-lg-12">
                                 <div class="mb-3">
                                    <label for="message" class="form-label fs-13">Message</label>
                                    <textarea name="message" id="message" rows="3" class="form-control bg-light border-light" placeholder="Your message..."></textarea>
                                 </div>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-lg-12 text-end">
                                 <button type="submit" id="submit" name="send" class="submitBnt btn btn-primary">Send Message</button>
                              </div>
                           </div>
                        </form>
                     </div>
                  </div>
               </div>
               <!-- end row -->
            </div>
            <!-- end container -->
         </section>
         <!-- end contact -->
      </div>
      <!-- Modal -->
      <div class="modal fade" id="purchaseVoucherModal" tabindex="-1" aria-labelledby="purchaseVoucherModalLabel" aria-hidden="true">
         <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title" id="purchaseVoucherModalLabel">Purchase <span class="voucher_title"></span> Voucher</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                  <div class="modal-footer">
                     {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> --}}
                     <button type="submit" class="btn btn-primary">Purchase Voucher</button>
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
                  <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
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
                  <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
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
      <!-- end layout wrapper -->
      <script src="{{ URL::asset('/assets/js/jquery-3.6.1.js')}}"></script>
      <script src="{{URL::asset('assets/libs/bootstrap/bootstrap.min.js')}}"></script>
      <script src="{{ URL::asset('/assets/js/hotspotlogin.js')}}"></script>
      <script src="{{URL::asset('assets/js/md5.js')}}"></script>
      <script >
         // Modal pass package data
            $('#purchaseVoucherModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var title = button.data('title') // Extract info from data-* attributes
            var amount = button.data('amount')
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this)
            modal.find('.voucher_title').text(title)
            // Set the value of the #amount input field
            modal.find('#amount').val(amount);
            })
         
         
         const loginForm = document.getElementById('login-form');
         const submitButton = loginForm ? loginForm.querySelector('button[type="submit"]') : null;
         const errorModal = $('#errorModal');
         const chap_id = '<?php echo isset($common_data["chap_id"]) ? $common_data["chap_id"] : "" ?>';
         const chap_challenge = '<?php echo isset($common_data["chap_challenge"]) ? $common_data["chap_challenge"] : "" ?>';
         
         if (submitButton) {
         submitButton.addEventListener('click', function(event) {
         event.preventDefault(); // Prevent the form from submitting
         
         // Get the values of the username and password fields
         const username = loginForm.elements['username'].value;
         const password = loginForm.elements['password'].value;
         
         // Make an AJAX request to the Laravel controller
         const xhr = new XMLHttpRequest();
         xhr.open('POST', '{{ route("hotspotlogincheck") }}', true);
         xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');
         xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
         xhr.onreadystatechange = function() {
         if (xhr.readyState === XMLHttpRequest.DONE) {
          if (xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);
            if (response.success) {
              // Call the doLogin function to submit the form
              document.login.username.value = username;
              document.login.password.value = hexMD5(chap_id + username + chap_challenge);
              document.login.submit();
            } else {
              // Otherwise, display an error message in the modal
              const errorMessage = response.message || 'An error occurred';
              errorModal.find('#errorMessage').text(errorMessage);
              errorModal.modal('show');
            }
          } else {
            // Show error message in the modal
            const errorMessage = document.getElementById('errorMessage');
             errorMessage.innerText = response.message;
             $('#errorModal').modal('show');
          }
         }
         };
         xhr.send(JSON.stringify({
         username: username,
         password: password
         }));
         });
         }
      </script>
   </body>
</html>