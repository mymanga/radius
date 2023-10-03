@extends('layouts.master') @section('title') online @endsection @section('css')
<link href="{{URL::asset('assets/js/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{URL::asset('assets/css/datatable-custom.css')}}" rel="stylesheet" type="text/css" />
@endsection @section('content') @component('components.breadcrumb') @slot('li_1') Services @endslot @slot('title') Online @endslot @endcomponent
<div class="row">
   <div class="col-lg-12">
      <div class="card" id="orderList">
         <div class="card-header border-bottom-dashed">
            <div class="d-flex align-items-center">
               <h5 class="card-title mb-0 flex-grow-1"><i class="ri-notification-badge-fill text-success"></i> Online Services</h5>
            </div>
         </div>
         <div class="card-body pt-0">
            <div>
               <div class="table-responsive table-card mb-1">
                  <table class="table table-nowrap align-middle" id="datatable" style="width: 100%;">
                     <thead class="table-light text-muted">
                        <tr>
                           {{-- <th data-name="status">Status</th> --}}
                           <th data-name="client_name">Client Name</th>
                           <th data-name="package">Package</th>
                           <th data-name="username">Username</th>
                           <th data-name="ip_address">IP Address</th>
                           <th data-name="start_time">Start Time</th>
                           <th data-name="output">Download</th>
                           <th data-name="input">Upload</th>
                           <th data-name="session_time">Session Time</th>
                        </tr>
                     </thead>
                     <tbody class="list form-check-all">
                     </tbody>
                  </table>
               </div>
            </div>
            <!--end modal -->
         </div>
      </div>
   </div>
   <!--end col-->
</div>
<!--end row-->
@endsection @section('script')
<script src="{{ URL::asset('/assets/js/jquery-3.6.1.js')}}"></script>
<script src="{{ URL::asset('/assets/js/datatables/datatables.min.js') }}"></script>
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
<script src="{{ URL::asset('/assets/js/servertable.js') }}"></script>
<script>
   var url = '{{ route("client.online") }}';
   var columns = [
      { data: 'client_name', orderable: false },
      { data: 'package', orderable: false },
      { data: 'username', orderable: false },
      { data: 'ip_address', orderable: false },
      { data: 'start_time', orderable: false },
      { data: 'output', orderable: false },
      { data: 'input', orderable: false },
      { data: 'session_time', orderable: false },
   ];
   renderTable(url, columns);
</script>
@endsection