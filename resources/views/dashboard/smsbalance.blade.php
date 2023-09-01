@php
    $smsBalance = getSmsBalance(setting("smsgateway"));
@endphp

@if (function_exists(setting("smsgateway") . 'SmsBalance'))
    @if ($smsBalance && isset($smsBalance['value']))
        @php
            $smsBalanceValue = $smsBalance['value'];
            $alertType = 'success';
            if ($smsBalanceValue < 200) {
                $alertType = 'danger';
                $iconClass = 'ri-error-warning-line text-danger';
            } elseif ($smsBalanceValue >= 200 && $smsBalanceValue <= 500) {
                $alertType = 'warning';
                $iconClass = ' ri-alert-line text-warning';
            } else {
                $iconClass = 'ri-check-double-line text-success';
            }
        @endphp

        <div class="alert alert-{{ $alertType }} alert-top-border fade show text-center" role="alert">
            <i class="{{ $iconClass }} me-3 align-middle fs-16"></i>
            <strong class="text-{{ $alertType }}">{{ ucfirst($alertType) }}</strong> - Your {{ ucfirst(setting("smsgateway")) }} SMS balance is <strong>{{ $smsBalanceValue }}</strong> {{ $smsBalance['currency'] }}.
        </div>
    @else
        <div class="alert alert-danger alert-top-border fade show text-center" role="alert">
            <i class="ri-error-warning-line me-3 align-middle fs-16 text-danger"></i>
            <strong>Failed</strong> - Unable to fetch {{ ucfirst(setting("smsgateway")) }} SMS balance.
        </div>
    @endif
@endif



