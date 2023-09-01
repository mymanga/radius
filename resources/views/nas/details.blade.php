@extends('layouts.master') @section('title') nas details @endsection @section('css') @endsection @section('content') @component('components.breadcrumb') @slot('li_1') Nas @endslot @slot('title') Create @endslot
@endcomponent
<!-- .card-->
<div class="row justify-content-center">
<div class="col-lg-6">
   <div class="card">
      <div class="card-body p-4">
         <div>
            {{-- 
            <div class="flex-shrink-0 avatar-md mx-auto">
               <div class="avatar-title bg-light rounded">
                  <img src="assets/images/companies/img-2.png" alt="" height="50">
               </div>
            </div>
            --}}
            <div class="mt-4 text-center">
               <h5 class="mb-1">Nas details</h5>
               {{-- 
               <p class="text-muted">Since 1987</p>
               --}}
            </div>
            <div class="table-responsive">
               <table class="table mb-0 table-borderless">
                  <tbody>
                     <tr>
                        <th><span class="fw-medium">IP Address</span></th>
                        <td><a href="#" class="link-primary">{{$nas->nasname}}</a></td>
                     </tr>
                     <tr>
                        <th><span class="fw-medium">ShortName</span></th>
                        <td>{{$nas->shortname}}</td>
                     </tr>
                     <tr>
                        <th><span class="fw-medium">Radius Secret</span></th>
                        <td>{{$nas->secret}}</td>
                     </tr>
                     <tr>
                        <th><span class="fw-medium">Username</span></th>
                        <td>{{$nas->nasprofile->username}}</td>
                     </tr>
                     <tr>
                        <th><span class="fw-medium">Password</span></th>
                        <td>{{$nas->nasprofile->password}}</td>
                     </tr>
                  </tbody>
               </table>
            </div>
         </div>
      </div>
      <!--end card-body-->
   </div>
   <!--end card-->
</div>
<!--end col-->
@endsection @section('script')
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection