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
               <a class="nav-link menu-link {{request()->routeIs('customer.dashboard') ? 'active':''}}" href="{{route('customer.dashboard')}}">
               <i class="ri-dashboard-2-line"></i> <span>Dashboard</span>
               </a>
            </li>
            <li class="nav-item">
               <a class="nav-link menu-link {{request()->routeIs('customer.invoices') ? 'active':''}}" href="{{route('customer.invoices')}}">
                  <i class="ri-exchange-dollar-line display-6 text-info"></i> <span>Invoices</span>
               </a>
            </li>
            <li class="nav-item">
               <a class="nav-link menu-link {{request()->routeIs('customer.statistics') ? 'active':''}}" href="{{route('customer.statistics')}}">
                  <i class="ri-stack-fill display-6 text-warning"></i> <span>Usage Statistics</span>
               </a>
            </li>
            <li class="nav-item">
               <a class="nav-link menu-link {{request()->routeIs('customer.livedata') ? 'active':''}}" href="{{route('customer.livedata')}}">
                  <i class="ri-pulse-line display-6 text-success"></i> <span>Real time usage</span>
               </a>
            </li>
            <li class="nav-item">
               <a class="nav-link menu-link {{request()->routeIs('customer.company.info') ? 'active':''}}" href="{{route('customer.company.info')}}">
                  <i class="ri-contacts-book-fill text-info"></i> <span>Company Info</span>
               </a>
            </li>
         </ul>
      </div>
      <!-- Sidebar -->
   </div>
</div>
<!-- Left Sidebar End -->
<!-- Vertical Overlay-->
<div class="vertical-overlay"></div>