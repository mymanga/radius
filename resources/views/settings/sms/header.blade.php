<div class="card-body pb-0 px-4">
   <ul class="nav nav-tabs-custom border-bottom-0" role="tablist">
    @php
        $currentGateway = request()->route('gateway'); // Get the current gateway from the route parameter
        $gatewayFunctions = getSmsGatewayFunctions();
    @endphp

    @foreach ($gatewayFunctions as $functionName => $displayName)
        <li class="nav-item">
            <a class="nav-link fw-semibold {{ $currentGateway === $functionName ? 'active' : '' }}"
                href="{{ route('settings.sms.gateway', ['gateway' => $functionName]) }}">
                {{ $displayName }}
            </a>
        </li>
    @endforeach
</ul>

</div>