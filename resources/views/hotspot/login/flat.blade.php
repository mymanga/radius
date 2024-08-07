<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <title>Flat - Hotspot Template</title>
    <link href="{{ URL::asset('assets/hotspot/clean/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/hotspot/clean/all.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/hotspot/clean/fonts.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/hotspot/clean/flat.css') }}" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="header navbar-brand">
            <h1>{{ strtoupper(setting('hotspotName')) }}</h1>
        </div>
        <div class="section">
            <h2>Select Package</h2>
            <div class="packages">
                @forelse($plans as $plan)
                <div class="package btn-buy" data-bs-toggle="modal" data-bs-target="#purchaseVoucherModal" data-title="{{ $plan->title }}" data-amount="{{ $plan->offer ? $plan->price - ($plan->price * $plan->discount_rate / 100) : $plan->price }}" data-plan-id="{{ $plan->id }}">
                    <span>{{ $plan->title }}</span>
                    <span>
                        @if($plan->offer)
                        @php
                        $discounted_price = $plan->price - ($plan->price * $plan->discount_rate / 100);
                        @endphp
                        <del>Ksh {{ number_format($plan->price, 0, ',', '.') }}</del>
                        <span style="color: #fff;">Ksh {{ number_format($discounted_price, 0, ',', '.') }}</span>
                        <div class="text-success">You save {{$plan->discount_rate}}%!</div>
                        @else
                        Ksh {{ number_format($plan->price, 0, ',', '.') }}
                        @endif
                    </span>
                </div>
                @empty
                <div class="package">
                    <span>No plans available.</span>
                </div>
                @endforelse
            </div>
        </div>
        @if(session()->has('common_data'))
        @php
        $common_data = session()->get('common_data');
        @endphp
        <div class="section reconnect">
            <h2>Enter voucher code</h2>
            <form name="login" id="login-form" action="{{$common_data['link_login_only']}}" method="post" onsubmit="return doLogin()" rel="noreferrer">
                <input type="hidden" name="dst" value="/status">
                <input type="hidden" name="popup" value="true">
                @if(!empty($common_data['error']))
                <div class="text-danger text-center">{{ $common_data['error'] }}</div>
                @endif
                <input type="text" class="input-field" name="username" value="{{ $voucherCode ?? $common_data['username'] }}" placeholder="Voucher code" id="code" required>
                <input name="password" type="hidden">
                <button class="button reconnect" type="submit">Connect</button>
            </form>
        </div>
        @endif
        <div class="footer">
            <p><b>Phone:</b> {{setting('company_phone')}}<br/>
               <b>Email:</b> {{setting('company_email')}}<br>
            </p>
        </div>
    </div>

    <!-- Purchase Voucher Modal -->
    <div class="modal fade" id="purchaseVoucherModal" tabindex="-1" aria-labelledby="purchaseVoucherModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="purchaseVoucherModalLabel"><span class="voucher_title"></span> Voucher</h6>
                    <button type="button" class="btn-close custom-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('voucher.buy') }}" method="POST">
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
                        <button type="submit" class="button voucher">Purchase Voucher</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="{{ URL::asset('assets/hotspot/clean/jquery.min.js') }}"></script>
    <script src="{{ URL::asset('assets/hotspot/clean/popper.min.js') }}"></script>
    <script src="{{ URL::asset('assets/hotspot/clean/bootstrap.min.js') }}"></script>
    @include('hotspot.login.js.js')
</body>
</html>
