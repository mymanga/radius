
<div class="card-body pb-0 px-4">
   {{-- <ol class="breadcrumb m-0 float-end">
      <li class="breadcrumb-item"><a href="{{route('settings.general')}}" class="text-info">Config</a></li>
      <li class="breadcrumb-item active">general</li>
   </ol> --}}
   <ul class="nav nav-tabs-custom border-bottom-0" role="tablist">
      <li class="nav-item">
         <a class="nav-link fw-semibold {{request()->routeIs('hotspot.design') ? 'active':''}}" href="{{route('hotspot.design')}}">
         DESIGN
         </a>
      </li>
   </ul>
</div>