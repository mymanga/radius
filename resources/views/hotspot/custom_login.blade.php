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
         <!-- start plan -->
         <section class="section">
            <div class="container">
               <div class="row align-items-center gy-4">
                  <div class="col-md-6 col-sm-7 col-10 ms-auto order-1 order-lg-2">
                     <div>
                        <img src="{{asset('assets/images/landing/features/img-2.png')}}" alt="" class="img-fluid">
                     </div>
                  </div>
                  <div class="col-md-6 order-2 order-lg-1">
                     <div class="text-muted">
                        <h5 class="fs-12 text-uppercase text-success">Wifi Hotspot</h5>
                        <h4 class="mb-3">How to access internet</h4>
                        <p class="mb-4 ff-secondary">Please follow the instructions given to purchase a voucher code for the hotspot.</p>
                        <p class="mb-4 ff-secondary">1. Choose a package below and click purchase <br>
                           2. Enter your <strong>Mpesa</strong> number & then proceed.<br>
                           3. When prompted enter your Mpesa pin & send <br>
                           4. You will receive an sms with login code/pin<br>
                           5. Enter the <strong>code/pin</strong> below and click connect<br>
                        </p>
                     </div>
                     <!-- Hotspot login codes -->
                     <div>
                        <!--$(if chap-id)-->
                        <form name="sendin" action="{{$link_login_only}}" method="post" style="display:none">
                           <input type="hidden" name="username" />
                           <input type="hidden" name="password" />
                           <!-- <input type="hidden" name="dst" value="link_orig" /> -->
                           <input type="hidden" name="popup" value="true" />
                        </form>
                        {{-- <script src="/md5.js"></script> --}}
                        <script src="{{URL::asset('assets/js/md5.js')}}"></script>
                        <script>
                           function doLogin() {
                              var username = document.login.username.value;
                              document.sendin.username.value = username;
                              document.sendin.password.value = hexMD5('<?php echo $chap_id; ?>' + username + '<?php echo $chap_challenge; ?>');
                              document.sendin.submit();
                              return false;
                           }
                        </script>
                        <!--$(endif)-->
                        <div class="ie-fixMinHeight">
                           <div class="main">
                              <div class="wrap animated fadeIn">
                                 <form name="login" action="{{$link_login_only}}" method="post" onSubmit="return doLogin()">
                                    <!-- <input type="hidden" name="dst" value="link_orig" /> -->
                                    <input type="hidden" name="dst" value="/status" />
                                    <input type="hidden" name="popup" value="true" />
                                    <p class="info <!--$(if error)-->alert$<!--(endif)-->">
                                       <!--$(if error == "")-->Please log in to use the internet hotspot service 
                                       <!--$(if trial == 'yes')--><br />Free trial available, <a href="{{$link_login_only}}?dst={{$link_orig_esc}}&amp;username=T-{{$mac_esc}}">click here</a>.<!--$(endif)-->
                                       <!--$(endif)-->
                                       <!--$(if error)--><!--$(error)--><!--$(endif)-->
                                    </p>
                                    <div class="input-group">
                                       <!-- <img class="ico" src="img/user.svg" alt="#" /> -->
                                       <input name="username" type="text" value="{{$username}}" placeholder="Voucher code" class="form-control input-lg" id="code" onkeyup="return forceLower(this);" onblur="this.value=removeSpaces(this.value);" />
                                       <!-- <img class="ico" src="img/password.svg" alt="#" /> -->
                                       <input name="password" type="hidden" placeholder="Password" />
                                       <span class="input-group-btn">
                                       <button  class="btn btn-info btn-lg btn-buy" type="submit">Connect</button>
                                       </span>
                                    </div>
                                    <!-- <script>
                                       function forceLower(strInput)
                                       {
                                         strInput.value=strInput.value.toLowerCase();
                                       }
                                       function removeSpaces(string) {
                                        return string.split(' ').join('');
                                       }
                                       </script> -->
                                 </form>
                                 <!-- $(if error) -->
                                 <br />
                                 <div class="text-danger"><?php echo $error; ?></div>
                                 <!-- $(endif) -->
                              </div>
                           </div>
                        </div>
                        <!-- login template -->
                     </div>
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
                                          <b>Description</b> {{$plan->description}}
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
         <!-- end footer -->
      </div>
      <!-- Modal -->
      <div class="modal fade" id="purchaseVoucherModal" tabindex="-1" aria-labelledby="purchaseVoucherModalLabel" aria-hidden="true">
         <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title" id="purchaseVoucherModalLabel">Purchase <span class="voucher_title"></span> Voucher</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               </div>
               <form action="" method="POST">
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
      @php
      function formatDuration($duration) {
      $minutes = $duration % 60;
      $duration = ($duration - $minutes) / 60;
      $hours = $duration % 24;
      $duration = ($duration - $hours) / 24;
      $days = $duration % 30;
      $duration = ($duration - $days) / 30;
      $months = $duration;
      $durationStr = '';
      if ($months > 0) {
      $durationStr .= $months . ' month' . ($months > 1 ? 's ' : ' ');
      }
      if ($days > 0) {
      $durationStr .= $days . ' day' . ($days > 1 ? 's ' : ' ');
      }
      if ($hours > 0) {
      $durationStr .= $hours . ' hour' . ($hours > 1 ? 's ' : ' ');
      }
      if ($minutes > 0) {
      $durationStr .= $minutes . ' minute' . ($minutes > 1 ? 's ' : ' ');
      }
      return $durationStr;
      }
      @endphp
      <!-- end layout wrapper -->
      <script src="{{ URL::asset('/assets/js/jquery-3.6.1.js')}}"></script>
      <script src="{{URL::asset('assets/libs/bootstrap/bootstrap.min.js')}}"></script>
      <script>
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
      </script>
   </body>
</html>