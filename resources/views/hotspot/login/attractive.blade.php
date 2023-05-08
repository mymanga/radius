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
               <!--<div class="panel panel-info">
                  <div class="panel-heading">
                  <h4><font color="white">Top Up Existing User Account</font></h4>
                  </div>
                  <p color="white">1. Go to the Top Up page on the menu above and follow instructions</p>
                  </div>-->
               <!--Login-->
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
                  <div class="ie-fixMinHeight">
                     <div class="main">
                        <div class="wrap animated fadeIn">
                           <form name="login" id="login-form" action="{{$common_data['link_login_only']}}" method="post" id="login-form" onSubmit="return doLogin()">
                              <!-- <input type="hidden" name="dst" value="link_orig" /> -->
                              <input type="hidden" name="dst" value="/status" />
                              <input type="hidden" name="popup" value="true" />
                              <p class="info login-text">
                                 <!--$(if error == "")-->Please log in to use the internet hotspot service 
                                 <!--$(if trial == 'yes')--><br />Free trial available, <a href="{{$common_data['link_login_only']}}?dst={{$common_data['link_orig_esc']}}&amp;username=T-{{$common_data['mac_esc']}}">click here</a>.<!--$(endif)-->
                                 <!--$(endif)-->
                                 <!-- $(if error) -->
                                 <br />
                              <div class="text-danger error-text"><?php echo $common_data['error']; ?></div>
                              <!-- $(endif) -->
                              </p>
                              <div class="form-group">
                                 <div class="input-group">
                                    <input type="text" class="form-control" style="height: 54px;" name="username" value="{{$common_data['username']}}" placeholder="Voucher code" id="code" onkeyup="return forceUpper(this);" onblur="this.value=removeSpaces(this.value);" />
                                    <span class="input-group-btn">
                                    <button class="btn btn-info btn-lg btn-buy btn-block btn-submit" type="submit">Connect</button>
                                    </span>
                                 </div>
                              </div>
                              <input name="password" type="hidden" placeholder="Password" />
                              <script>
                                 function forceUpper(strInput)
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
                  <p  color="white">Upto <b>{{$plan->speed_limit}}</b> Mbps</p>
                  <p  color="white">simultaneous device use <b>{{$plan->simultaneous_use_limit}}</b></p>
                  <p  color="white">Validity <b>{{ formatDuration($plan->duration) }}</b></p>
                  <p  color="white"><b>Description</b> {{$plan->description}}</p>
                  <p  color="white">Downloads : Unlimited*</p>
                  <h3>KSH {{$plan->price}}</h3>
                  <div>
                     <button type="button" class="btn btn-warning btn-buy" data-toggle="modal" data-target="#purchaseVoucherModal" data-title="{{$plan->title}}" data-amount="{{$plan->price}}">PURCHASE</button>
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
   <footer>
      <div align="center" class="footer-text">
         Copyright &copy {{ date('Y') }} {{setting('hotspotName')}} 
      </div>
   </footer>
   </div>
   <script src="{{ URL::asset('/assets/js/hotspotlogin.js')}}"></script>
   <script src="{{URL::asset('assets/js/md5.js')}}"></script>
   <script >
      // Modal pass package data
      $('#purchaseVoucherModal').on('show.bs.modal', function (event) {
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

      // Ajax submit form data
      setTimeout(function () {
         $("#loader-wrapper").hide();
      }, 200);


      const loginForm = document.getElementById('login-form');
      const submitButton = loginForm ? loginForm.querySelector('button[type="submit"]') : null;
      const errorModal = $('#errorModal');
      const chap_id = '<?php echo isset($common_data["chap_id"]) ? $common_data["chap_id"] : "" ?>';
      const chap_challenge = '<?php echo isset($common_data["chap_challenge"]) ? $common_data["chap_challenge"] : "" ?>';

      if (submitButton) {
         submitButton.addEventListener('click', function (event) {
            event.preventDefault(); // Prevent the form from submitting

            // Get the values of the username and password fields
            const username = loginForm.elements['username'].value;
            const password = loginForm.elements['password'].value;

            // Make an AJAX request to the Laravel controller
            const xhr = new XMLHttpRequest();
            xhr.open('POST', '{{ route("hotspotlogincheck") }}', true);
            xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');
            xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
            xhr.onreadystatechange = function () {
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
</html>