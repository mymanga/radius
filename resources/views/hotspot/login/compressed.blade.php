<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <title>Hotspot Login</title>
    <link href="{{ URL::asset('assets/hotspot/clean/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/hotspot/clean/all.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/hotspot/clean/fonts.css') }}" rel="stylesheet">
    {{-- <link href="{{ URL::asset('assets/hotspot/clean/minimal.css') }}" rel="stylesheet"> --}}
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #2c2f76;
            color: white;
            margin: 0;
            padding: 20px 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .container {
            width: 100%;
            max-width: 400px;
            padding: 20px;
        }
        .header {
            text-align: center;
        }
        .header img {
            width: 100px;
        }
        .header h1 {
            font-size: 22px;
            margin: 15px 0;
        }
        .voucher-input {
            margin: 20px 0;
            text-align: center;
        }
        .voucher-input input {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 10px;
            margin-bottom: 15px;
            background-color: #fff;
            color: #232155;
            font-size: 16px;
        }
        .voucher-input button {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 10px;
            background: linear-gradient(to right, #ff4081, #ff80ab);
            color: white;
            font-size: 18px;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        .voucher-input button:hover {
            background: linear-gradient(to right, #ff80ab, #ff4081);
        }
        .voucher-list {
            margin: 20px 0;
        }
        .voucher-list table {
            width: 100%;
            border-collapse: collapse;
            background-color: #2c2f76;
        }
        .voucher-list th, .voucher-list td {
            padding: 15px;
            text-align: center;
        }
        .voucher-list th {
            background-color: #ff4081;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            color: white;
            font-size: 16px;
        }
        .voucher-list tr:nth-child(even) {
            background-color: #3b3b98;
        }
        .voucher-list tr:nth-child(odd) {
            background-color: #33337d;
        }
        .voucher-list button {
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            background-color: #ff4081;
            color: white;
            cursor: pointer;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
        }
        .footer p {
            font-size: 14px;
        }
        .modal-content {
            background-color: #2c2f76;
            color: white;
        }
        .modal-header {
            border-bottom: none;
        }
        .modal-footer {
            border-top: none;
        }
        .modal-header .btn-close {
            filter: invert(1);
        }
        .form-control {
            background-color: #fff;
            color: #232155;
        }
        .btn-custom {
            background: linear-gradient(to right, #ff4081, #ff80ab);
            color: white;
            border: none;
            transition: background 0.3s ease;
        }
        .btn-custom:hover {
            background: linear-gradient(to right, #ff80ab, #ff4081);
        }
        /* SweetAlert2 Theming */
        .swal2-container.swal2-center>.swal2-popup {
            font-family: Arial, sans-serif;
            background: #2c2f76;
            color: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <!-- <img src="{{ asset('path_to_your_logo.png') }}" alt="Logo"> -->
            <h1 class="navbar-brand">{{ strtoupper(setting('hotspotName')) }}</h1>
        </div>
        @if(session()->has('common_data'))
        @php
        $common_data = session()->get('common_data');
        @endphp
        <div class="voucher-input">
            <form name="login" id="login-form" action="{{$common_data['link_login_only']}}" method="post" onsubmit="return doLogin()" rel="noreferrer">
                <input type="hidden" name="dst" value="/status">
                <input type="hidden" name="popup" value="true">
                @if(!empty($common_data['error']))
                <div class="text-danger text-center">{{ $common_data['error'] }}</div>
                @endif
                <input type="text" class="form-control" name="username" value="{{ $voucherCode ?? $common_data['username'] }}" placeholder="Voucher code" id="code" required>
                <button class="btn-custom" type="submit">Connect</button>
                <input name="password" type="hidden">
            </form>
        </div>
        @endif
        <div class="voucher-list">
            <table>
                <tr>
                    <th>Plan</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>
                @forelse($plans as $plan)
                <tr>
                    <td>{{ $plan->title }}</td>
                    <td>
                        @if($plan->offer)
                        @php
                        $discounted_price = $plan->price - ($plan->price * $plan->discount_rate / 100);
                        @endphp
                        <del>Ksh {{ number_format($plan->price, 0, ',', '.') }}</del>
                        <span style="color: #f15a24;">Ksh {{ number_format($discounted_price, 0, ',', '.') }}</span>
                        <div class="text-success">You save {{$plan->discount_rate}}%!</div>
                        @else
                        Ksh {{ number_format($plan->price, 0, ',', '.') }}
                        @endif
                    </td>
                    <td>
                        <button type="button" class="btn btn-warning btn-buy" data-bs-toggle="modal" data-bs-target="#purchaseVoucherModal" data-title="{{ $plan->title }}" data-amount="{{ $plan->offer ? $discounted_price : $plan->price }}" data-plan-id="{{ $plan->id }}">BUY</button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3">No plans available.</td>
                </tr>
                @endforelse
            </table>
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
                        <button type="submit" class="btn btn-custom">Purchase Voucher</button>
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