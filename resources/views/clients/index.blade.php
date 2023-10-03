@extends('layouts.master') @section('title') clients @endsection @section('css')
<link href="{{URL::asset('assets/js/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{URL::asset('assets/css/datatable-custom.css')}}" rel="stylesheet" type="text/css" />
@endsection @section('content') 
@component('components.breadcrumb') @slot('li_1') Crm @endslot @slot('title') clients @endslot @endcomponent
<div class="row">
   <div class="col-lg-12">
      <div class="row">
         <div class="col-xl-3 col-sm-6 col-6">
            <div class="card card-animate">
               <div class="card-body">
                  <div class="d-flex">
                     <div class="flex-grow-1">
                        <h6 class="text-muted mb-3 d-none d-md-block">Total Clients</h6>
                        <h6 class="text-muted mb-3 d-md-none">Total</h6>
                        <h4 class="mb-0">
                           <span class="counter-value" data-target="{{$totalclients}}">{{$totalclients}}</span>
                           <small class="text-muted fs-13"></small>
                        </h4>
                     </div>
                     <div class="flex-shrink-0 avatar-sm d-none d-md-block">
                        <div class="avatar-title bg-soft-info text-info fs-22 rounded"> <i class="ri-team-fill"></i> </div>
                     </div>
                     <div class="flex-shrink-0 avatar-xs d-md-none">
                        <div class="avatar-title bg-soft-info text-info fs-22 rounded"> <i class="ri-team-fill"></i> </div>
                     </div>
                  </div>
               </div>
            </div>
            <!--end card-->
         </div>
         <!--end col-->
         <div class="col-xl-3 col-sm-6 col-6">
            <div class="card card-animate">
               <div class="card-body">
                  <div class="d-flex">
                     <div class="flex-grow-1">
                        <h6 class="text-muted mb-3 d-none d-md-block">Active services</h6>
                        <h6 class="text-muted mb-3 d-md-none">Active</h6>
                        <h4 class="mb-0">
                           @if(isset($activesum) && $activesum != '')
                           <span class="counter-value" data-target="{{$activesum}}">{{$activesum}}</span>
                           @else
                           <span class="counter-value" data-target="0">0</span>
                           @endif
                           <small class="text-muted fs-13"> Ksh</small>
                        </h4>
                     </div>
                     <div class="flex-shrink-0 avatar-sm d-none d-md-block">
                        <div class="avatar-title bg-soft-warning text-warning fs-22 rounded"> <i class="ri-funds-line"></i> </div>
                     </div>
                     <div class="flex-shrink-0 avatar-xs d-md-none">
                        <div class="avatar-title bg-soft-warning text-warning fs-22 rounded"> <i class="ri-funds-line"></i> </div>
                     </div>
                  </div>
               </div>
            </div>
            <!--end card-->
         </div>
         <!--end col-->
         <div class="col-xl-3 col-sm-6 col-6">
            <div class="card card-animate">
               <div class="card-body">
                  <div class="d-flex">
                     <div class="flex-grow-1">
                        <h6 class="text-muted mb-3 d-none d-md-block">Online revenue</h6>
                        <h6 class="text-muted mb-3 d-md-none">Online</h6>
                        <h4 class="mb-0">
                           @if(isset($onlinesum) && $onlinesum != '')
                           <span class="counter-value" data-target="{{$onlinesum}}">{{$onlinesum}}</span>
                           @else
                           <span class="counter-value" data-target="0">0</span>
                           @endif
                           <small class="text-muted fs-13"> Ksh</small>
                        </h4>
                     </div>
                     <div class="flex-shrink-0 avatar-sm d-none d-md-block">
                        <div class="avatar-title bg-soft-success text-success fs-22 rounded"> <i class="ri-exchange-dollar-line"></i> </div>
                     </div>
                     <div class="flex-shrink-0 avatar-xs d-md-none">
                        <div class="avatar-title bg-soft-success text-success fs-22 rounded"> <i class="ri-exchange-dollar-line"></i> </div>
                     </div>
                  </div>
               </div>
            </div>
            <!--end card-->
         </div>
         <!--end col-->
         <div class="col-xl-3 col-sm-6 col-6">
            <div class="card card-animate">
               <div class="card-body">
                  <div class="d-flex">
                     <div class="flex-grow-1">
                        <h6 class="text-muted mb-3 d-none d-md-block">Inactive services</h6>
                        <h6 class="text-muted mb-3 d-md-none">Inactive</h6>
                        <h4 class="mb-0">
                           @if(isset($inactivesum) && $inactivesum != '')
                           <span class="counter-value" data-target="{{$inactivesum}}">{{$inactivesum}}</span>
                           @else
                           <span class="counter-value" data-target="0">0</span>
                           @endif
                           <small class="text-muted fs-13"> Ksh</small>
                        </h4>
                     </div>
                     <div class="flex-shrink-0 avatar-sm d-none d-md-block">
                        <div class="avatar-title bg-soft-danger text-danger fs-22 rounded"> <i class="ri-arrow-left-down-fill"></i> </div>
                     </div>
                     <div class="flex-shrink-0 avatar-xs d-md-none">
                        <div class="avatar-title bg-soft-danger text-danger fs-22 rounded"> <i class="ri-arrow-left-down-fill"></i> </div>
                     </div>
                  </div>
               </div>
            </div>
            <!--end card-->
         </div>
         <!--end col-->
      </div>
      @include('layouts.partials.flash')
      <div class="d-flex align-items-center mb-3">
         <div class="flex-grow-1">
            <h5 class="mb-0 text-uppercase text-muted">Client List</h5>
         </div>
         @can('create client')
         <div class="flexshrink-0"> <a href="{{route('client.create')}}" class="btn btn-soft-info btn-md"><i class="ri-add-line align-bottom me-1"></i> Add Client</a> </div>
         @endcan
      </div>
      <div class="card">
         <div class="card-body">
            <div>
               <div class="table-responsive table-card mb-1">
                  <table class="table table-nowrap align-middle table-striped" id="datatable" style="width: 100%;">
                     <thead class="table-light text-muted">
                        <tr class="text-uppercase">
                           <th>#</th>
                           <th>A/C No</th>
                           <th>Client</th>
                           <th>Email</th>
                           <th>Services</th>
                           <th>Phone</th>
                           <th>Registered</th>
                           <th>Status</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody class="list form-check-all">
                     </tbody>
                  </table>
               </div>
            </div>
            <!-- Delete Modal -->
            <div class="modal fade flip" id="deleteItem" tabindex="-1" aria-hidden="true">
               <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                     <div class="modal-body p-5 text-center">
                        <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#405189,secondary:#f06548" style="width: 90px; height: 90px;"></lord-icon>
                        <div class="mt-4 text-center">
                           <h4>You are about to delete <span class="modal-title"></span>!</h4>
                           <p class="text-muted fs-15 mb-4">Deleting a client user will remove all of the information from the database.</p>
                           <div class="hstack gap-2 justify-content-center remove">
                              <button class="btn btn-link link-success fw-medium text-decoration-none" data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i> Close</button>
                              <form action="{{route('client.delete')}}" method="POST"> @csrf
                                 <input type="hidden" name="id" id="id" />
                                 <button type="submit" class="btn btn-danger">Yes delete</button>
                              </form>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <!--end modal -->
         </div>
      </div>
   </div>
   <!--end col-->
</div>
<!--end row-->@endsection @section('script')
<script src="{{ URL::asset('/assets/js/jquery-3.6.1.js')}}"></script>
<script src="{{ URL::asset('/assets/js/datatables/datatables.min.js') }}"></script>
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
<script src="{{ URL::asset('/assets/js/servertable.js') }}"></script>
<script>
    // DataTable initialization
    var url = '{{ route("client.index") }}';
    var columns = [
        { data: 'id', name: 'id' },
        { data: 'username', name: 'username' },
        { data: 'name', name: 'name', orderable: false },
        { data: 'email', name: 'email' },
        { data: 'services', name: 'services', orderable: false },
        { data: 'phone', name: 'phone', orderable: false },
        { data: 'registered', name: 'created_at' },
        { data: 'status', name: 'status', orderable: false },
        { data: 'action', name: 'action', orderable: false },
    ];
    renderTable(url, columns);

    // Modal pass user data
    $('#deleteItem').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var title = button.data('title'); // Extract info from data-* attributes
        var id = button.data('id');
        var modal = $(this);
        modal.find('.modal-title').text(title);
        modal.find('.modal-body #id').val(id);
    });
</script>

@endsection