
<div class="card-body pb-0 px-4">
   <ul class="nav nav-tabs-custom border-bottom-0" role="tablist">
      <li class="nav-item">
         <a class="nav-link fw-semibold {{request()->routeIs('support.config') ? 'active':''}}" href="{{route('support.config')}}">
         SUPPORT EMAIL
         </a>
      </li>
      <li class="nav-item">
         <a class="nav-link fw-semibold {{request()->routeIs('support.preferences') ? 'active':''}}" href="{{route('support.preferences')}}">
         PREFERENCES 
         </a>
      </li>
   </ul>
</div>