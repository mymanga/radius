<div class="card-body pb-0 px-4">
   {{-- <ol class="breadcrumb m-0 float-end">
      <li class="breadcrumb-item"><a href="{{route('settings.general')}}" class="text-info">Dashboard</a></li>
   </ol> --}}
   <ul class="nav nav-tabs-custom border-bottom-0" role="tablist">
      <li class="nav-item">
         <a class="nav-link fw-semibold {{request()->routeIs('settings.sms.africastalking') ? 'active':''}}" href="{{route('settings.sms.africastalking')}}">
         AFRICASTALKING
         </a>
      </li>
      <li class="nav-item">
         <a class="nav-link fw-semibold {{request()->routeIs('settings.sms.pasha') ? 'active':''}}" href="{{route('settings.sms.pasha')}}">
         PASHA 
         </a>
      </li>
   </ul>
</div>