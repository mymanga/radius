<tr class="no-border">
   <td>{{ $service->id }}</td>
   <td><a href="{{route('client.service',[$service->client->username])}}">{{ $service->client->fullName() }} <i class="ri-links-line text-info"></i></a></td>
   <td>
      <span>
         {!! $service->status() !!} {!! $service->getOnlineStatus() !!}
      </span>
   </td>
   <td>{{ $service->package->name }}</td>
   <td>{{ $service->price }} ksh</td>
   <td style="font-size:17px"><code class="text-muted">{{$service->ipaddress}}</code></td>
   <td>{{ $service->username }}</td>
   <td>{{ $service->cleartextpassword }}</td>
   <td>
      @if($service->expiry <= Carbon\Carbon::today())
      <div class="badge badge-soft-danger badge-border fs-12">Expired</div>
      @else
      <div class="badge badge-soft-info badge-border fs-12">{{$service->expiry->diffForHumans()}}</div>
      @endif
   </td>
   {{-- <td class="no-padding">
      <ul class="list-inline hstack gap-2 mb-0">
         <li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Edit">
            <a href="{{ route('service.edit',[$service->id]) }}" class="text-info d-inline-block edit-item-btn">
            <i class="ri-pencil-fill fs-16"></i>
            </a>
         </li>
         <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Remove">
            <a class="text-danger d-inline-block remove-item-btn" data-bs-toggle="modal" data-id="{{$service->id}}" data-title="{{$service->package->name}}" href="#deleteItem">
            <i class="ri-delete-bin-5-fill fs-16"></i>
            </a>
         </li>
         <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Extend expiration">
            <a href="#extendModal" class="text-success d-inline-block" data-bs-toggle="modal" data-id="{{$service->id}}" data-title="{{$service->package->name}}">
            <i class="ri-history-line fs-16"></i>
            </a>
         </li>
      </ul>
   </td> --}}
</tr>