<!-- resources/views/layouts/menu_hotspot.blade.php -->
<div class="app-menu navbar-menu">
   <!-- LOGO -->
   <div class="navbar-brand-box">
      <!-- Dark Logo-->
      <a href="{{ route('hotspot.index') }}" class="logo logo-dark">
         <span class="logo-sm">
            <img src="{{ URL::asset(setting('logo')) }}" alt="" height="22" width="90%">
         </span>
         <span class="logo-lg">
            <img src="{{ URL::asset(setting('logo')) }}" alt="" height="40" width="90%">
         </span>
      </a>
      <!-- Light Logo-->
      <a href="{{ route('hotspot.index') }}" class="logo logo-light">
         <span class="logo-sm">
            <img src="{{ URL::asset(setting('logo')) }}" alt="" height="22" width="90%">
         </span>
         <span class="logo-lg">
            <img src="{{ URL::asset(setting('logo')) }}" alt="" height="40" width="90%">
         </span>
      </a>
      <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
         <i class="ri-record-circle-line"></i>
      </button>
   </div>
   <div id="scrollbar">
      <div class="container-fluid">
         <div id="two-column-menu"></div>
         @can('manage hotspot')
         <ul class="navbar-nav" id="navbar-nav">
            <li class="menu-title"><span>Navigation</span></li>
            <li class="nav-item">
               <a class="nav-link menu-link {{request()->is('dashboard/hotspot') ? 'active':''}}" href="{{route('hotspot.index')}}">
                  <i class="ri-dashboard-2-line"></i> <span>Dashboard</span>
               </a>
            </li>
            <li class="menu-title"><span>Hotspot Management</span></li>
            <li class="nav-item">
               <a class="nav-link menu-link {{request()->is('dashboard/hotspot/plans*') ? 'active':''}}" href="{{route('plan.index')}}">
                  <i class="ri-price-tag-3-line"></i> <span>Plans</span>
               </a>
            </li>
            <li class="nav-item">
               <a class="nav-link menu-link {{request()->is('dashboard/hotspot/vouchers*') ? 'active':''}}" href="{{route('voucher.index')}}">
                  <i class="ri-ticket-2-line"></i> <span>Vouchers</span>
               </a>
            </li>
            <li class="nav-item">
               <a class="nav-link menu-link {{request()->is('dashboard/hotspot/design*') ? 'active':''}}" href="{{route('hotspot.design')}}">
                  <i class="ri-paint-brush-line"></i> <span>Design</span>
               </a>
            </li>
            <li class="nav-item">
               <a class="nav-link menu-link {{request()->is('dashboard/hotspot/revenue*') ? 'active':''}}" href="{{route('hotspot.revenue')}}">
                  <i class="ri-money-dollar-box-line"></i> <span>Revenue</span>
               </a>
            </li>
            <li class="nav-item">
               <a class="nav-link menu-link {{request()->is('dashboard/hotspot/settings*') ? 'active':''}}" href="{{route('hotspot.settings')}}">
                  <i class="ri-settings-3-line"></i> <span>Settings</span>
               </a>
            </li>

            <li class="menu-title"><span>Networking</span></li>
            @can('manage nas')
            <li class="nav-item">
               <a class="nav-link menu-link{{request()->is('dashboard/nas*') ? 'active':''}}" href="#sidebarNas" data-bs-toggle="collapse" role="button"
                  aria-expanded="false" aria-controls="sidebarNas">
               <i class="ri-router-line"></i> <span >Routers</span>
               </a>
               <div class="collapse menu-dropdown {{request()->is('dashboard/nas*') ? 'show':''}}" id="sidebarNas">
                  <ul class="nav nav-sm flex-column">
                     <li class="nav-item">
                        <a href="{{route('nas.index')}}"  class="nav-link {{request()->is('dashboard/nas') ? 'active':''}}" >List Routers</a>
                     </li>
                     @can('create nas')
                     <li class="nav-item">
                        <a href="{{route('nas.create')}}" class="nav-link {{request()->is('dashboard/nas/create') ? 'active':''}}" >Add Router</a>
                     </li>
                     @endcan
                  </ul>
               </div>
            </li>
            @endcan
            @can('view network')
            {{-- <li class="nav-item">
               <a class="nav-link menu-link {{request()->is('dashboard/network/index') ? 'active':''}}" href="{{route('network.index')}}">
               <i class="ri-global-fill"></i> <span>IPv4 Networks</span>
               </a>
            </li> --}}
            <li class="nav-item">
               <a class="nav-link menu-link{{request()->routeIs('network.*') ? 'active':''}}" href="#sidebarNetwork" data-bs-toggle="collapse" role="button"
                  aria-expanded="false" aria-controls="sidebarNetwork">
               <i class="ri-global-fill"></i> <span >Networks</span>
               </a>
               <div class="collapse menu-dropdown {{request()->routeIs('network.*') ? 'show':''}}" id="sidebarNetwork">
                  <ul class="nav nav-sm flex-column">
                     <li class="nav-item">
                        <a class="nav-link menu-link {{request()->routeIs('network.*') ? 'active':''}}" href="{{route('network.index')}}">IPv4 Networks</a>
                     </li>
                     {{-- <li class="nav-item">
                        <a class="nav-link menu-link" href="{{route('network.index')}}">IPv6 Networks</a>
                     </li> --}}
                  </ul>
               </div>
            </li>
            @endcan
            <li class="menu-title"><span>System</span></li>
            @can('view admins')
            <li class="nav-item">
               <a class="nav-link menu-link {{request()->is('dashboard/admin*') ? 'active':''}}" href="#sidebarAdmin" data-bs-toggle="collapse" role="button"
                  aria-expanded="false" aria-controls="sidebarAdmin">
               <i class="ri-admin-line"></i> <span >Administration</span>
               </a>
               <div class="collapse menu-dropdown {{request()->is('dashboard/admin*') ? 'show':''}}" id="sidebarAdmin">
                  <ul class="nav nav-sm flex-column">
                     <li class="nav-item">
                        <a href="{{route('admin.index')}}"  class="nav-link {{request()->is('dashboard/admin') ? 'active':''}}" >Users</a>
                     </li>
                     @can('manage roles')
                     <li class="nav-item">
                        <a href="{{route('admin.role.index')}}"  class="nav-link {{request()->is('dashboard/admin/roles*') ? 'active':''}}" >Roles</a>
                     </li>
                     @endcan
                     @can('manage permissions')
                     <li class="nav-item">
                        <a href="{{route('admin.permission.index')}}"  class="nav-link {{request()->is('dashboard/admin/permissions*') ? 'active':''}}" >Permissions</a>
                     </li>
                     @endcan
                  </ul>
               </div>
            </li>
            @endcan
            @can('manage system settings')
            <li class="nav-item">
               <a class="nav-link menu-link {{request()->is('dashboard/settings*') ? 'active':''}}" href="#sidebarSettings" data-bs-toggle="collapse" role="button"
                  aria-expanded="false" aria-controls="sidebarSettings">
               <i class="ri-settings-5-line"></i> <span >Config</span>
               </a>
               <div class="collapse menu-dropdown {{request()->is('dashboard/settings*') ? 'show':''}}" id="sidebarSettings">
                  <ul class="nav nav-sm flex-column">
                     <li class="nav-item">
                        <a href="{{route('settings.general')}}"  class="nav-link {{request()->is('dashboard/settings/general') ? 'active':''}}" >Main settings</a>
                     </li>
                     <li class="nav-item">
                        <a href="{{route('settings.sms.smsGateways')}}"  class="nav-link {{request()->is('dashboard/settings/sms*') ? 'active':''}}" >Sms Gateways</a>
                     </li>
                     <li class="nav-item">
                        <a href="{{route('ovpn.index')}}"  class="nav-link {{request()->is('dashboard/settings/ovpn*') ? 'active':''}}" >OpenVpn</a>
                     </li>
                     <li class="nav-item">
                        <a href="{{route('settings.api')}}"  class="nav-link {{request()->is('dashboard/settings/api_keys*') ? 'active':''}}" >Api Keys</a>
                     </li>
                     <li class="nav-item">
                        <a href="{{route('settings.components')}}"  class="nav-link {{request()->is('dashboard/settings/components*') ? 'active':''}}" >Components</a>
                     </li>
                     <li class="nav-item">
                        <a href="/dashboard/settings/data/backup"  class="nav-link {{request()->is('dashboard/settings/data/*') ? 'active':''}}" >Backups</a>
                     </li>
                  </ul>
               </div>
            </li>
            @endcan
            <li class="nav-item">
               <a class="nav-link menu-link {{request()->is('dashboard/info*') ? 'active':''}}" href="#sidebarInfo" data-bs-toggle="collapse" role="button"
                  aria-expanded="false" aria-controls="sidebarInfo">
               <i class="ri-information-line"></i> <span >System Info</span>
               </a>
               <div class="collapse menu-dropdown {{request()->is('dashboard/info*') ? 'show':''}}" id="sidebarInfo">
                  <ul class="nav nav-sm flex-column">
                     <li class="nav-item">
                        <a href="{{route('license.index')}}"  class="nav-link {{request()->is('dashboard/info/license') ? 'active':''}}" >License</a>
                     </li>
                     <li class="nav-item">
                        <a href="{{route('updater.index')}}"  class="nav-link {{request()->is('dashboard/info/updater*') ? 'active':''}}" >Updates</a>
                     </li>
                  </ul>
               </div>
            </li>
         </ul>
         @endcan
      </div>
   </div>
</div>
<!-- Vertical Overlay-->
<div class="vertical-overlay"></div>
