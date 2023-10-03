<tr class="no-border">
   {{-- <td>{{ $service->id }}</td> --}}
   <td><a href="{{route('client.service',[$service->client->username])}}">{{ $service->client->fullName() }} <i class="ri-links-line text-info"></i></a></td>
   <td>
      <span class="service-status" data-service-id="{{ $service->id }}">
         <span class="status-text">{!! $service->status() !!}</span>
         <span class="online-status">{!! $service->getOnlineStatus() !!}</span>
      </span>
   </td>
   <td>{{ $service->description }}</td>
   <td>{{ $service->package->name }}</td>
   <td>{{ $service->price }} ksh</td>
   <td style="font-size:17px"><code class="text-muted">{{$service->ipaddress}}</code></td>
   <td>{{ $service->username }}</td>
   <td>{{ $service->cleartextpassword }}</td>
   <td>
      @php
      $displayExpiry = $service->grace_expiry && Carbon\Carbon::parse($service->grace_expiry) > Carbon\Carbon::parse($service->expiry) && Carbon\Carbon::parse($service->grace_expiry) > Carbon\Carbon::now() ? Carbon\Carbon::parse($service->grace_expiry) : Carbon\Carbon::parse($service->expiry);
      @endphp
      @if($displayExpiry->isPast())
      <div class="badge badge-soft-danger badge-border fs-12">Expired</div>
      @else
      @if($displayExpiry->lte(\Carbon\Carbon::now()->addWeek()))
      <div class="badge badge-soft-info badge-border fs-12">{{$displayExpiry->diffForHumans()}}</div>
      @else
      <div class="badge badge-soft-info badge-border fs-12">{{ $displayExpiry->format('d F Y') }}</div>
      @endif
      @endif
   </td>
</tr>