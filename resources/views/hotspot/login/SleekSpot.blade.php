<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <title>SleekSpot - Hotspot Login</title>
    <link href="{{ URL::asset('assets/hotspot/clean/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/hotspot/clean/all.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/hotspot/clean/fonts.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/hotspot/clean/sleekspot.css') }}" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 class="navbar-brand">{{ strtoupper(setting('hotspotName')) }}</h1>
        </div>
        @if(session()->has('common_data'))
        @php
        $common_data = session()->get('common_data');
        @endphp
        <div class="form-input">
            <form name="login" id="login-form" action="{{$common_data['link_login_only']}}" method="post" onsubmit="return doLogin()" rel="noreferrer">
                <input type="hidden" name="dst" value="/status">
                <input type="hidden" name="popup" value="true">
                @if(!empty($common_data['error']))
                <div class="text-danger text-center">{{ $common_data['error'] }}</div>
                @endif
                <input type="text" class="form-control" name="username" value="{{ $voucherCode ?? $common_data['username'] }}" placeholder="Voucher code" id="code" required>
                <input name="password" type="hidden">
                <button class="btn-custom" type="submit">Connect</button>
            </form>
        </div>
        @endif
        <div class="voucher-list">
            @forelse($plans as $plan)
            <div class="voucher-item">
                <span>{{ $plan->title }}</span>
                <span>
                    @if($plan->offer)
                    @php
                    $discounted_price = $plan->price - ($plan->price * $plan->discount_rate / 100);
                    @endphp
                    <del>Ksh {{ number_format($plan->price, 0, ',', '.') }}</del>
                    <span style="color: #ffaf7b;">Ksh {{ number_format($discounted_price, 0, ',', '.') }}</span>
                    <div class="text-success">You save {{$plan->discount_rate}}%!</div>
                    @else
                    Ksh {{ number_format($plan->price, 0, ',', '.') }}
                    @endif
                </span>
                <button type="button" class="btn btn-warning btn-buy" data-bs-toggle="modal" data-bs-target="#purchaseVoucherModal" data-title="{{ $plan->title }}" data-amount="{{ $plan->offer ? $discounted_price : $plan->price }}" data-plan-id="{{ $plan->id }}">Buy</button>
            </div>
            @empty
            <div class="voucher-item">
                <span colspan="3">No plans available.</span>
            </div>
            @endforelse
        </div>
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
                        <button type="submit" class="btn-custom">Purchase Voucher</button>
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
