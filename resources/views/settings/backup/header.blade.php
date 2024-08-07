
<div class="card-body pb-0 px-4">
    {{-- <ol class="breadcrumb m-0 float-end">
       <li class="breadcrumb-item"><a href="{{route('settings.general')}}" class="text-info">Config</a></li>
       <li class="breadcrumb-item active">general</li>
    </ol> --}}
    <ul class="nav nav-tabs-custom border-bottom-0" role="tablist">
       <li class="nav-item">
          <a class="nav-link fw-semibold {{request()->Is('dashboard/settings/data/backup') ? 'active':''}}" href="/dashboard/settings/data/backup">
          All BACKUPS
          </a>
       </li>
       {{-- <li class="nav-item">
          <a class="nav-link fw-semibold {{request()->routeIs('settings.s3') ? 'active':''}}" href="{{route('settings.s3')}}">
          S3 STORAGE CONFIG 
          </a>
       </li> --}}
    </ul>
 </div>