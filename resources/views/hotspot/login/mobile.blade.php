<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
      <title>Hotspot Login</title>
      <link href="{{ URL::asset('assets/hotspot/clean/bootstrap.min.css') }}" rel="stylesheet">
      <link href="{{ URL::asset('assets/hotspot/clean/all.css') }}" rel="stylesheet">
      <link href="{{ URL::asset('assets/hotspot/clean/fonts.css') }}" rel="stylesheet">
      <link href="{{ URL::asset('assets/hotspot/clean/mobile.css') }}" rel="stylesheet">
   </head>
   <body>
      <nav class="navbar navbar-expand-lg">
         <div class="container">
            <a class="navbar-brand" href="#">{{ strtoupper(setting('hotspotName')) }}</a>
         </div>
      </nav>
      <div class="container">
         <div class="card-custom text-center">
            <img src="{{ asset('images/' . setting('hotspot_cover')) }}" alt="Banner" class="img-thumbnail">
            <p>Log in to use the hotspot service</p>
            @if(session()->has('common_data'))
            @php
            $common_data = session()->get('common_data');
            @endphp
            <form name="login" id="login-form" action="{{$common_data['link_login_only']}}" method="post" onsubmit="return doLogin()" rel="noreferrer">
               <input type="hidden" name="dst" value="/status">
               <input type="hidden" name="popup" value="true">
               @if(!empty($common_data['error']))
               <div class="text-danger text-center">{{ $common_data['error'] }}</div>
               @endif
               <div class="form-group">
                  <input type="text" class="form-control" name="username" value="{{ $voucherCode ?? $common_data['username'] }}" placeholder="Voucher code" id="code" required>
               </div>
               <button class="btn-custom mt-3" type="submit">Connect</button>
               <input name="password" type="hidden" placeholder="Password">
               <script>
                  function forceUpper(strInput) {
                      strInput.value = strInput.value.toUpperCase();
                  }
                  function removeSpaces(string) {
                      return string.split(' ').join('');
                  }
               </script>
            </form>
            @endif
         </div>
         <div class="plans-section">
            <h4 class="text-center mb-4">Available Plans</h4>
            <div class="row">
               @forelse($plans as $plan)
               <div class="col-12 mb-3">
                  <div class="card plan-card">
                     <div class="card-body text-center">
                        <h5 class="card-title">{{ $plan->title }}</h5>
                        <div class="card-pricing">
                           @if($plan->offer)
                           @php
                           $discounted_price = $plan->price - ($plan->price * $plan->discount_rate / 100);
                           @endphp
                           <p class="price"><del class="text-muted">Ksh {{$plan->price}}</del> <span class="text-danger">Ksh {{$discounted_price}}</span></p>
                           <p class="text-success">You save {{$plan->discount_rate}}%!</p>
                           @else
                           <p class="price"><span class="text-primary">Ksh {{$plan->price}}</span></p>
                           @endif
                        </div>
                        <div class="card-details">
                           @if($plan->speed_limit)
                           <p>Upto <b>{{$plan->speed_limit}}</b> Mbps</p>
                           @endif
                           @if($plan->simultaneous_use_limit)
                           <p>Simultaneous device use <b>{{$plan->simultaneous_use_limit}}</b></p>
                           @endif
                        </div>
                        <button type="button" class="btn btn-custom" data-bs-toggle="modal" data-bs-target="#purchaseVoucherModal" data-title="{{$plan->title}}" data-amount="{{ $discounted_price ?? $plan->price }}" data-plan-id="{{$plan->id}}">
                        PURCHASE
                        </button>
                     </div>
                  </div>
               </div>
               @empty
               <h2 class="text-center">No plans available.</h2>
               @endforelse
            </div>
         </div>
         <div class="footer-text">
            <p><b>Phone:</b> {{setting('company_phone')}}<br/>
               <b>Email:</b> {{setting('company_email')}}<br>
         </div>
      </div>
      <div class="modal fade" id="purchaseVoucherModal" tabindex="-1" aria-labelledby="purchaseVoucherModalLabel" aria-hidden="true">
         <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
               <div class="modal-header">
                  <h6 class="modal-title" id="purchaseVoucherModalLabel"><span class="voucher_title"></span> Voucher</h6>
                  <button type="button" class="btn-close custom-close" data-bs-dismiss="modal" aria-label="Close"></button>
               </div>
               <form action="{{route('voucher.buy')}}" method="POST">
                  @csrf
                  <div class="modal-body">
                     <div class="form-group">
                        <label for="phone" class="form-label">Phone Number <span class="text-danger">*</span></label>
                        <input type="tel" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" placeholder="Enter phone number" required>
                        @error('phone')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                     </div>
                     <input type="hidden" name="amount" id="amount">
                     <input type="hidden" name="plan_id" id="plan">
                  </div>
                  <div class="modal-footer">
                     <button type="submit" class="btn btn-custom">Purchase Voucher</button>
                  </div>
               </form>
            </div>
         </div>
      </div>
      <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
         <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title text-success" id="successModalLabel">Success!</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               </div>
               <div class="modal-body">
                  <p id="successMessage"></p>
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-custom" data-bs-dismiss="modal">OK</button>
               </div>
            </div>
         </div>
      </div>
      <script src="{{ URL::asset('assets/hotspot/clean/jquery.min.js') }}"></script>
      <script src="{{ URL::asset('assets/hotspot/clean/popper.min.js') }}"></script>
      <script src="{{ URL::asset('assets/hotspot/clean/bootstrap.min.js') }}"></script>
      @include('hotspot.login.js.js')
   </body>
</html>