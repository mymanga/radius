<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu">
   <!-- LOGO -->
   <div class="navbar-brand-box">
      <!-- Dark Logo-->
      <a href="{{ route('dashboard.index') }}" class="logo logo-dark">
      <span class="logo-sm">
      <img src="{{ URL::asset(setting('logo')) }}" alt="" height="22" width="90%">
      </span>
      <span class="logo-lg">
      <img src="{{ URL::asset(setting('logo')) }}" alt="" height="40" width="90%">
      </span>
      </a>
      <!-- Light Logo-->
      <a href="{{ route('dashboard.index') }}" class="logo logo-light">
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
   <?php $user = auth()->user() ?>
   <div id="scrollbar">
      <div class="container-fluid">
         <div id="two-column-menu">
         </div>
         <ul class="navbar-nav" id="navbar-nav">
            <li class="menu-title"><span >Navigation</span></li>
            <li class="nav-item">
               <a class="nav-link menu-link {{request()->is('dashboard') ? 'active':''}}" href="{{route('dashboard')}}">
               <i class="ri-dashboard-2-line"></i> <span>Dashboard</span>
               </a>
            </li>
            @if($user->canAny(['view clients', 'view leads', 'view messages', 'manage finance']))
            <li class="menu-title"><span>Crm</span></li>
            @endif
            @can('view clients')
            <li class="nav-item">
               <a class="nav-link menu-link {{request()->is('dashboard/client*') ? 'active collapsed':''}}" href="#client" data-bs-toggle="collapse" role="button"
                  aria-expanded="false" aria-controls="client">
               <i class="ri-user-3-line"></i> <span >Clients</span>
               </a>
               <div class="collapse menu-dropdown {{request()->is('dashboard/client*') ? 'show':''}}" id="client">
                  <ul class="nav nav-sm flex-column">
                     <li class="nav-item">
                        <a href="{{route('client.index')}}" class="nav-link {{request()->is('dashboard/clients') ? 'active':''}}" >Dashboard</a>
                     </li>
                     @can('create client')
                     <li class="nav-item">
                        <a href="{{route('client.create')}}" class="nav-link {{request()->is('dashboard/client/create') ? 'active':''}}" >Add client</a>
                     </li>
                     @endcan
                     <li class="nav-item">
                        <a href="{{route('customer.import.view')}}" class="nav-link {{request()->is('dashboard/settings/import') ? 'active':''}}" >Import</a>
                     </li>
                  </ul>
               </div>
            </li>
            @endcan
            <!-- end Dashboard Menu -->
            @can('view leads')
            <li class="nav-item">
               <a class="nav-link menu-link {{request()->is('dashboard/leads*') ? 'active collapsed':''}}" href="#leads" data-bs-toggle="collapse"
                  role="button" aria-expanded="false" aria-controls="leads">
               <i class="ri-hand-coin-line"></i> <span >Leads</span>
               </a>
               <div class="collapse menu-dropdown {{request()->is('dashboard/lead*') ? 'show':''}}" id="leads">
                  <ul class="nav nav-sm flex-column">
                     <li class="nav-item">
                        <a href="{{route('lead.index')}}" class="nav-link {{request()->is('dashboard/leads') ? 'active':''}}" >All leads</a>
                     </li>
                     @can('create lead')
                     <li class="nav-item">
                        <a href="{{route('lead.create')}}" class="nav-link {{request()->is('dashboard/lead/create') ? 'active':''}}" >Add lead</a>
                     </li>
                     @endcan
                  </ul>
               </div>
            </li>
            @endcan
            <!-- end Dashboard Menu -->
            @can('view messages')
            <li class="nav-item">
               <a class="nav-link menu-link {{request()->is('dashboard/messages*') ? 'active collapsed':''}}" href="#messages" data-bs-toggle="collapse" role="button"
                  aria-expanded="false" aria-controls="sidebarLayouts">
               <i class="ri-mail-send-line"></i> <span >Messages</span>
               </a>
               <div class="collapse menu-dropdown {{request()->is('dashboard/messages*') ? 'show':''}}" id="messages">
                  <ul class="nav nav-sm flex-column">
                     <li class="nav-item">
                        <a href="{{route('message.index')}}" class="nav-link {{request()->is('dashboard/messages') ? 'active':''}}" >All messages</a>
                     </li>
                     @can('send message')
                     <li class="nav-item">
                        <a href="{{route('message.create')}}" class="nav-link {{request()->is('dashboard/messages/create') ? 'active':''}}" >Simple send</a>
                     </li>
                     @endcan
                     @can('send bulk message')
                     <li class="nav-item">
                        <a href="{{route('message.bulk')}}" class="nav-link" >Bulk messaging</a>
                     </li>
                     @endcan
                  </ul>
               </div>
            </li>
            @endcan
            @can('manage finance')
            <li class="nav-item">
               <a class="nav-link menu-link {{request()->is('dashboard/billing*') ? 'active collapsed':''}}" href="#billing" data-bs-toggle="collapse" role="button"
                  aria-expanded="false" aria-controls="sidebarLayouts">
               <i class="bx bx-dollar"></i> <span >Finance</span>
               </a>
               <div class="collapse menu-dropdown {{request()->is('dashboard/billing*') ? 'show':''}}" id="billing">
                  <ul class="nav nav-sm flex-column">
                     <li class="nav-item">
                        <a href="{{route('billing.index')}}" class="nav-link {{request()->is('dashboard/billing') ? 'active':''}}" >Dashboard</a>
                     </li>
                     <li class="nav-item">
                        <a href="{{route('invoice.index')}}" class="nav-link {{request()->is('dashboard/billing/invoices') ? 'active':''}}" >Invoices</a>
                     </li>
                     @can('view transactions')
                     <li class="nav-item">
                        <a href="{{route('billing.transactions')}}" class="nav-link {{request()->is('dashboard/billing/transactions') ? 'active':''}}" >Transactions</a>
                     </li>
                     <li class="nav-item">
                        <a href="{{route('billing.mpesa')}}" class="nav-link {{request()->is('dashboard/billing/mpesa') ? 'active':''}}" >Mpesa</a>
                     </li>
                     @endcan
                     @can('create report')
                     <li class="nav-item">
                        <a href="{{route('billing.generateReport')}}" class="nav-link {{request()->is('dashboard/billing/report') ? 'active':''}}" >Reports</a>
                     </li>
                     @endcan
                  </ul>
               </div>
            </li>
            @endcan
            <li class="nav-item">
               <a class="nav-link menu-link {{request()->is('dashboard/support*') ? 'active':''}}" href="#sidebarSupport" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarSupport">
                  <i class="ri-customer-service-2-fill"></i> <span>Support</span>
                  @if($unreadCount > 0)
                        <span class="badge bg-danger rounded-circle">{{$unreadCount}}</span>
                  @endif
               </a>
               <div class="collapse menu-dropdown {{request()->is('dashboard/support*') ? 'show':''}}" id="sidebarSupport">
                  <ul class="nav nav-sm flex-column">
                        <li class="nav-item">
                           <a href="{{route('support.index')}}" class="nav-link {{request()->is('dashboard/support') ? 'active':''}}">Dashboard</a>
                        </li>
                        <li class="nav-item">
                           <a href="{{route('support.config')}}" class="nav-link {{request()->is('dashboard/support/config') ? 'active':''}}">Config</a>
                        </li>
                  </ul>
               </div>
            </li>
            <!-- end Dashboard Menu -->
            @if($user->canAny(['manage nas', 'view network', 'view tarrifs', 'manage hotspot']))
            <li class="menu-title"><span>Networking</span></li>
            @endif
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
            <li class="nav-item">
               <a class="nav-link menu-link {{request()->is('dashboard/network/index') ? 'active':''}}" href="{{route('network.index')}}">
               <i class="ri-global-fill"></i> <span>IPv4 Networks</span>
               </a>
            </li>
            @endcan
            <!-- end Dashboard Menu -->
            @can('view tariffs')
            <li class="nav-item">
               <a class="nav-link menu-link {{request()->is('dashboard/tariffs*') ? 'active':''}}" href="#sidebarTariffs" data-bs-toggle="collapse" role="button"
                  aria-expanded="false" aria-controls="sidebarTariffs">
               <i class="ri-gps-line"></i> <span >Internet tariffs</span>
               </a>
               <div class="collapse menu-dropdown {{request()->is('dashboard/tariffs*') ? 'show':''}}" id="sidebarTariffs">
                  <ul class="nav nav-sm flex-column">
                     <li class="nav-item">
                        <a href="{{route('tariff.index')}}"  class="nav-link {{request()->is('dashboard/tariffs') ? 'active':''}}" >All tariffs</a>
                     </li>
                     @can('create tariff')
                     <li class="nav-item">
                        <a href="{{route('tariff.create')}}" class="nav-link {{request()->is('dashboard/tariffs/create') ? 'active':''}}" >Add PPP tariff</a>
                     </li>
                     @endcan
                  </ul>
               </div>
            </li>
            @endcan
            @can('manage hotspot')
            <!-- Hotspot routes -->
            <li class="nav-item">
               <a class="nav-link menu-link {{request()->is('dashboard/hotspot*') ? 'active':''}}" href="#sidebarHotspot" data-bs-toggle="collapse" role="button"
                  aria-expanded="false" aria-controls="sidebarTariffs">
               <i class="ri-wifi-fill"></i> <span >Hotspot</span>
               </a>
               <div class="collapse menu-dropdown {{request()->is('dashboard/hotspot*') ? 'show':''}}" id="sidebarHotspot">
                  <ul class="nav nav-sm flex-column">
                     <li class="nav-item">
                        <a href="{{route('hotspot.index')}}"  class="nav-link {{request()->is('dashboard/hotspot') ? 'active':''}}" >Dashboard</a>
                     </li>
                     @can('create hotspot plan')
                     <li class="nav-item">
                        <a href="{{route('plan.index')}}" class="nav-link {{request()->is('dashboard/hotspot/plans') ? 'active':''}}" >Plans</a>
                     </li>
                     @endcan
                     @can('create hotspot voucher')
                     <li class="nav-item">
                        <a href="{{route('voucher.index')}}" class="nav-link {{request()->is('dashboard/hotspot/vouchers') ? 'active':''}}" >Vouchers</a>
                     </li>
                     @endcan
                     @can('change hotspot design')
                     <li class="nav-item">
                        <a href="{{route('hotspot.design')}}" class="nav-link {{request()->is('dashboard/hotspot/design*') ? 'active':''}}" >Design</a>
                     </li>
                     @endcan
                     @can('view hotspot revenue')
                     <li class="nav-item">
                        <a href="{{route('hotspot.revenue')}}" class="nav-link {{request()->is('dashboard/hotspot/revenue*') ? 'active':''}}" >Revenue</a>
                     </li>
                     @endcan
                     @can('change hotspot settings')
                     <li class="nav-item">
                        <a href="{{route('hotspot.settings')}}" class="nav-link {{request()->is('dashboard/hotspot/settings*') ? 'active':''}}" >Settings</a>
                     </li>
                     @endcan
                  </ul>
               </div>
            </li>
            @endcan
            @if($user->canAny(['view admins', 'manage system settings']))
            <li class="menu-title"><span>System</span></li>
            @endif
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
                        <a href="{{route('settings.sms.gateway', ['africastalking'])}}"  class="nav-link {{request()->is('dashboard/settings/sms*') ? 'active':''}}" >Sms Gateway</a>
                     </li>
                     <li class="nav-item">
                        <a href="{{route('templates.index')}}"  class="nav-link {{request()->is('dashboard/settings/templates*') ? 'active':''}}" >Templates</a>
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
      </div>
      <!-- Sidebar -->
   </div>
</div>
<!-- Left Sidebar End -->
<!-- Vertical Overlay-->
<div class="vertical-overlay"></div>