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
               @if(count($services) > 0)
               <div class="table-responsive table-card mb-1">
                  <table class="table table-nowrap align-middle" id="datatable" style="width: 100%;">
                     <thead class="text-muted table-light">
                        <tr class="text-uppercase">
                           @foreach(['', 'Client', 'Package', 'Service', 'Ip address', 'Start Time', 'Download', 'Upload', 'Time online'] as $cell)
                           <th>{{ $cell }}</th>
                           @endforeach
                        </tr>
                     </thead>
                     <tbody class="list form-check-all">
                        @foreach($services as $service) 
                        @php
                        $info_service = App\Models\Service::with('client')
                        ->where('username', $service->username)
                        ->first();
                        if ($info_service) {
                        $client = $info_service->client;
                        } else {
                        $client = null;
                        }
                        @endphp
                        <tr class="no-border">
                           <td><span class="badge badge-soft-success text-uppercase">online</span></td>
                           <td>{{ $client ? $client->firstname . ' ' . $client->lastname : 'Hotspot' }}</td>
                           <td>{{ $info_service ? $info_service->package->name : 'N/A' }}</td>
                           <td>{{ $info_service ? $info_service->username : $service->username }}</td>
                           <td>{{ $service->framedipaddress }}</td>
                           <td>{{ $service->acctstarttime ? Carbon\Carbon::parse($service->acctstarttime)->format('d M Y H:i') : 'Unknown' }}</td>
                           <td><i class="ri-download-2-fill text-info"></i> {{ formatSizeUnits($service->acctoutputoctets) }}</td>
                           <td><i class="ri-upload-2-fill text-info"></i> {{ formatSizeUnits($service->acctinputoctets) }}</td>
                           <td>{{ calculateSessionTime($service->acctsessiontime) }}</td>
                        </tr>
                        @endforeach
                     </tbody>
                  </table>
               </div>
               @else
               <div class="noresult" style="display: block;">
                  <div class="text-center">
                     <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop" colors="primary:#121331,secondary:#08a88a" style="width: 75px; height: 75px;"> </lord-icon>
                     <h5 class="mt-2 text-danger">Sorry! No service Online at the moment</h5>
                  </div>
               </div>
               @endif
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
<script src="{{ URL::asset('/assets/js/datatable.js') }}"></script>
@endsection