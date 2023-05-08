<form class="app-search">

  <!-- Search input box -->
  <div class="position-relative">
    <input 
      type="text" 
      id="search-options" 
      class="form-control" 
      wire:model="search" 
      wire:keyup="searchResult" 
      placeholder="Search..." 
      autocomplete="off"
    >
    <span class="mdi mdi-magnify search-widget-icon"></span>
    <span 
      class="mdi mdi-close-circle search-widget-icon search-widget-icon-close d-none" 
      id="search-close-options"
    ></span>
  </div>

  <!-- Search result list -->
  @if($showresult)
    <div class="dropdown-menu dropdown-menu-lg show">
      {{-- <div class="dropdown-header">
        <h6 class="text-overflow text-muted mb-0 text-uppercase">Search results</h6>
      </div> --}}
      @if(!empty($records))
        @if(count($records))
          <div class="dropdown-header mt-2">
            <h6 class="text-overflow text-muted mb-1 text-uppercase"> <i class=" ri-team-fill align-middle fs-18 text-muted me-2"></i> Clients</h6>
          </div>
        @endif
        <!-- Loop through the search results and display each record -->
        @foreach($records as $record)
          <a 
            href="{{ route('client.service', [$record->username]) }}" 
            class="dropdown-item notify-item"
          >
            <span>
              {{ $record->firstname }} {{ $record->lastname }} {!! $record->status() !!}
            </span>
          </a>
        @endforeach
      @endif

      <!-- Show leads from search -->
      @if(!empty($leads))
        @if(count($leads))
          <div class="dropdown-header mt-2">
            <h6 class="text-overflow text-muted mb-1 text-uppercase"><i class="ri-user-shared-line align-middle fs-18 text-muted me-2"></i> Leads</h6>
          </div>
        @endif
        <!-- Loop through the search results and display each record -->
        @foreach($leads as $lead)
          <a 
            href="{{ route('lead.index') }}" 
            class="dropdown-item notify-item"
          >
            <span>{{ $lead->firstname }} {{ $lead->lastname }}</span>
          </a>
        @endforeach
      @endif

      <!-- Show packages from search -->
      @if(!empty($packages))
        @if(count($packages))
          <div class="dropdown-header mt-2">
            <h6 class="text-overflow text-muted mb-1 text-uppercase"><i class="ri-scan-2-line align-middle fs-18 text-muted me-2"></i> Tarrifs</h6>
          </div>
        @endif
        <!-- Loop through the search results and display each record -->
        @foreach($packages as $package)
          <a 
            href="{{ route('tariff.index') }}" 
            class="dropdown-item notify-item"
          >
            <span>{{ $package->name }}</span>
          </a>
        @endforeach
      @endif

      <!-- Show services from search -->
      @if(!empty($services))
        @if(count($services))
          <div class="dropdown-header mt-2">
            <h6 class="text-overflow text-muted mb-1 text-uppercase"><i class="ri-bubble-chart-fill align-middle fs-18 text-muted me-2"></i> Services</h6>
          </div>
        @endif
        <!-- Loop through the search results and display each record -->
        @foreach($services as $service)
          <a 
            href="{{ route('client.service', [$service->client->username]) }}" 
            class="dropdown-item notify-item"
          >
            
            <span><code style="font-size:16px">{{ $service->username }}</code> {!! $service->status() !!} {{$service->client->firstname}}</span>
          </a>
        @endforeach
      @endif

      <!-- Show services from search -->
      @if(!empty($payments))
        @if(count($payments))
          <div class="dropdown-header mt-2">
            <h6 class="text-overflow text-muted mb-1 text-uppercase"><i class="ri-bubble-chart-fill align-middle fs-18 text-muted me-2"></i> Payments</h6>
          </div>
        @endif
        <!-- Loop through the search results and display each record -->
        @foreach($payments as $payment)
          <a 
            href="{{ route('billing.mpesa_transaction',[$payment->transaction_id]) }}" 
            class="dropdown-item notify-item"
          >
            
            <span><code style="font-size:16px">{{ $payment->transaction_id }}</code> - Ksh {{$payment->amount}}</span>
          </a>
        @endforeach
      @endif
      

    </div>
  @endif

</form>
