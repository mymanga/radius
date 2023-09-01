<div class="card-body pb-0 px-4">
   {{-- <ol class="breadcrumb m-0 float-end">
      <li class="breadcrumb-item"><a href="{{route('settings.general')}}" class="text-info">Dashboard</a></li>
   </ol> --}}
   <ul class="nav nav-tabs-custom border-bottom-0" role="tablist">
    @php
        $currentGateway = request()->route('gateway'); // Get the current gateway from the route parameter
        $gatewayFunctions = getSmsGatewayFunctions();
    @endphp

    @foreach ($gatewayFunctions as $functionName => $displayName)
        @if (View::exists('settings.sms.' . $functionName)) {{-- Check if the view exists --}}
            <li class="nav-item">
                <a class="nav-link fw-semibold {{ $currentGateway === $functionName ? 'active' : '' }}"
                   href="{{ route('settings.sms.gateway', ['gateway' => $functionName]) }}">
                    {{ $displayName }}
                </a>
            </li>
        @endif
    @endforeach
</ul>



</div>