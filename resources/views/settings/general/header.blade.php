
<div class="card-body pb-0 px-4">
   {{-- <ol class="breadcrumb m-0 float-end">
      <li class="breadcrumb-item"><a href="{{route('settings.general')}}" class="text-info">Config</a></li>
      <li class="breadcrumb-item active">general</li>
   </ol> --}}
   <ul class="nav nav-tabs-custom border-bottom-0" role="tablist">
      <li class="nav-item">
         <a class="nav-link fw-semibold {{request()->routeIs('settings.general') ? 'active':''}}" href="{{route('settings.general')}}">
         COMPANY INFO
         </a>
      </li>
      <li class="nav-item">
         <a class="nav-link fw-semibold {{request()->routeIs('settings.preferences') ? 'active':''}}" href="{{route('settings.preferences')}}">
         PREFERENCES 
         </a>
      </li>
      <li class="nav-item">
         <a class="nav-link fw-semibold {{request()->routeIs('settings.notifications') ? 'active':''}}" href="{{route('settings.notifications')}}">
         NOTIFICATIONS 
         </a>
      </li>
      <li class="nav-item">
         <a class="nav-link fw-semibold {{request()->routeIs('settings.mail') ? 'active':''}}" href="{{route('settings.mail')}}">
         MAIL CONFIG 
         </a>
      </li>
      <li class="nav-item">
         <a class="nav-link fw-semibold {{request()->routeIs('settings.mpesa') ? 'active':''}}" href="{{route('settings.mpesa')}}">
         M-PESA
         </a>
      </li>
      <li class="nav-item">
         <a class="nav-link fw-semibold {{request()->routeIs('settings.kopokopo') ? 'active':''}}" href="{{route('settings.kopokopo')}}">
         KOPOKOPO
         </a>
      </li>
   </ul>
</div>