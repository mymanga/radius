<div class="card-body pb-0 px-4">
   <div class="row mb-3">
      <div class="col-md">
         <div class="row align-items-center g-3">
            {{-- 
            <div class="col-md-auto">
               <div class="avatar-md">
                  <div class="avatar-title bg-white rounded">
                     <img src="{{asset('assets/images/brands/slack.png')}}" alt="" class="avatar-xs">
                  </div>
               </div>
            </div>
            --}}
            
            <div class="col-md">
            <ol class="breadcrumb m-0 float-end">
                    <li class="breadcrumb-item"><a href="{{route('client.index')}}" class="text-info">Clients</a></li>
                        <li class="breadcrumb-item active">{{$client->username}}</li>
                </ol>
               <div>
                  <h4 class="fw-bold">{{$client->firstname}} {{$client->lastname}}</h4> 
                  
                  <div class="hstack gap-3 flex-wrap">
                     <div><i class="ri-building-line align-bottom me-1"></i> {{$client->username}}</div>
                     <div class="vr"></div>
                     <div><i class="ri-time-fill"></i> <span class="text-muted text-uppercase fs-13">Create Date :</span> <span class="fw-medium">{{$client->created_at->format('d M, Y')}}</span></div>
                     <div class="vr"></div>
                     <div><span class="text-muted text-uppercase fs-13">Last Modified :</span> <span class="fw-medium">{{$client->updated_at->format('d M, Y')}}</span></div>
                     <div class="vr"></div>
                     @if(!empty($client->location))
                        <div><i class="ri-map-pin-user-fill"></i> <span class="fw-medium">{{$client->location}}</span></div>
                     <div class="vr"></div>
                     @endif
                     <div>
                        <span class="text-muted text-uppercase fs-13">User status</span>
                        {!! $client->status() !!}
                     </div>
                     <div class="vr"></div>
                     <div>
                        <span class="text-muted text-uppercase fs-13">Wallet</span> 
                        <span class="fw-medium">
                           <div class="badge badge-soft-info badge-border fs-12">Ksh {{$client->balance}}</div>
                        </span>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <ul class="nav nav-tabs-custom border-bottom-0" role="tablist">
      <li class="nav-item">
         <a class="nav-link fw-semibold {{request()->routeIs('client.service') ? 'active':''}}" href="{{route('client.service',[$client->username])}}">
         SERVICES
         </a>
      </li>
      @can('manage finance')
      <li class="nav-item">
         <a class="nav-link fw-semibold {{request()->routeIs('client.billing') ? 'active':''}}" href="{{route('client.billing',[$client->username])}}">
         BILLING
         </a>
      </li>
      @endcan
      <li class="nav-item">
         <a class="nav-link fw-semibold {{request()->routeIs('client.statistics') ? 'active':''}}" href="{{route('client.statistics',[$client->username])}}">
         STATISTICS
         </a>
      </li>
   </ul>
</div>