@extends('layouts.master') @section('title') permissions @endsection @section('css')
<link href="{{URL::asset('assets/js/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{URL::asset('assets/css/datatable-custom.css')}}" rel="stylesheet" type="text/css" />
@endsection @section('content') 
{{-- @component('components.breadcrumb') @slot('li_1') Clients @endslot @slot('title') Messages @endslot @endcomponent  --}}
<div class="page-title-box d-sm-flex align-items-center justify-content-between">
   <h4 class="mb-sm-0 font-size-18">Permissions</h4>
   <div class="page-title-right">
      <ol class="breadcrumb m-0">
         <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Admin</a></li>
         <li class="breadcrumb-item active"><a href="{{ route('admin.role.index') }}">Permissions</a></li>
      </ol>
   </div>
</div>
<div class="row">
   <div class="col-lg-12">
      @if (session('status'))
      <div class="alert alert-success alert-dismissible alert-label-icon label-arrow fade show" role="alert">
         <i class="ri-check-double-line label-icon"></i><strong>Success</strong> - {{session('status')}}
         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      @endif @if (session('error'))
      <div class="alert alert-danger alert-dismissible alert-label-icon label-arrow fade show mb-xl-0" role="alert">
         <i class="ri-error-warning-line label-icon"></i><strong>Failed</strong>
         - {!! session('error') !!}
         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      <br />
      @endif
      <div class="card">
         <form action="{{ route('admin.permission.update') }}" method="POST">
            @csrf
            <div class="card-body">
               <div class="table-responsive table-card mb-1">
                  <table class="table table-nowrap align-middle table-striped" id="datatable" style="width: 100%;">
                     <thead>
                        <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
                           <th class="min-w-125px">Permission Name</th>
                           @foreach ($roles as $role)
                           <th class="min-w-125px">{{$role->name}}</th>
                           @endforeach
                        </tr>
                     </thead>
                     <tbody class="text-gray-600">
                        @foreach ($permissions as $permission)
                        <tr>
                           <td>
                              <div class="d-flex align-items-center">
                                 <span class="bullet bg-primary me-3"></span>{{$permission->name}}
                              </div>
                           </td>
                           @foreach ($roles as $role)
                           <td>
                              <div class="d-flex align-items-center">
                                 <input class="form-check-input" 
                                 @if ($role->hasPermissionTo($permission->name))
                                 checked
                                 @endif 
                                 name="roles[{{$role->id}}][]"
                                 value="{{$permission->id}}"
                                 name="communication[]" type="checkbox" value="1">
                              </div>
                           </td>
                           @endforeach
                        </tr>
                        @endforeach
                     </tbody>
                  </table>
               </div>
            </div>
            <div class="card-footer">
               <div class="text-center">
                  <button type="submit" class="btn btn-soft-info">
                     <span class="svg-icon svg-icon-primary svg-icon-2x">
                        <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo8/dist/../src/media/svg/icons/General/Save.svg-->
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                           <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                              <polygon points="0 0 24 0 24 24 0 24"/>
                              <path d="M17,4 L6,4 C4.79111111,4 4,4.7 4,6 L4,18 C4,19.3 4.79111111,20 6,20 L18,20 C19.2,20 20,19.3 20,18 L20,7.20710678 C20,7.07449854 19.9473216,6.94732158 19.8535534,6.85355339 L17,4 Z M17,11 L7,11 L7,4 L17,4 L17,11 Z" fill="#000000" fill-rule="nonzero"/>
                              <rect fill="#000000" opacity="0.3" x="12" y="4" width="3" height="5" rx="0.5"/>
                           </g>
                        </svg>
                        <!--end::Svg Icon-->
                     </span>
                     Update Permissions
                  </button>
               </div>
            </div>
         </form>
      </div>
   </div>
   <!--end col-->
</div>
<!--end row-->
@endsection @section('script')
<script src="{{ URL::asset('/assets/js/jquery-3.6.1.js')}}"></script>
<script src="{{ URL::asset('/assets/js/datatables/datatables.min.js') }}"></script>
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
{{-- <script src="{{ URL::asset('/assets/js/datatable.js') }}"></script> --}}
<script>
   $(document).ready(function () {
       $('#datatable').DataTable({
           responsive: true,
           deferRender: true,
           paging: false,
           searching: false,
           info: false,
           ordering: false,
       });
   });
</script>
@endsection