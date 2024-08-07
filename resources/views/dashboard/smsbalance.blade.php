@php
    $smsBalance = getSmsBalance();
    $balanceFunctionAvailable = ($smsBalance !== null);
@endphp

@if ($balanceFunctionAvailable)
    @php
        $smsBalanceValue = $smsBalance['value'];
        $smsBalanceUnits = $smsBalance['units'];
        $alertType = 'success';

        if ($smsBalanceValue < 200) {
            $alertType = 'danger';
            $iconClass = 'ri-error-warning-line text-danger';
        } elseif ($smsBalanceValue >= 200 && $smsBalanceValue <= 500) {
            $alertType = 'warning';
            $iconClass = 'ri-alert-line text-warning';
        } else {
            $iconClass = 'ri-check-double-line text-success';
        }
    @endphp

    <div class="alert alert-{{ $alertType }} alert-top-border fade show text-center" role="alert">
        <i class="{{ $iconClass }} me-3 align-middle fs-16"></i>
        <strong class="text-{{ $alertType }}">{{ ucfirst(setting("smsgateway")) }}</strong> - Your SMS balance is <strong>{{ $smsBalanceValue }}</strong> {{ $smsBalanceUnits }}
    </div>
@endif
