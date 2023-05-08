@extends('layouts.master') @section('title') leads @endsection @section('css')
<link href="{{URL::asset('assets/js/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{URL::asset('assets/css/datatable-custom.css')}}" rel="stylesheet" type="text/css" />
@endsection @section('content') @component('components.breadcrumb') @slot('li_1') Crm @endslot @slot('title') leads @endslot @endcomponent 
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
            - {{session('error')}}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <br />
        @endif

        <div class="d-flex align-items-center mb-3">
         <div class="flex-grow-1">
            <h5 class="mb-0 text-uppercase text-muted">Lead List</h5>
         </div>
         <div class="flexshrink-0">
         @can('create lead')
            <a href="{{route('lead.create')}}" class="btn btn-soft-info btn-md"><i class="ri-add-line align-bottom me-1"></i> Add Lead</a>
        @endcan
         </div>
      </div>

        <div class="card">
            <div class="card-body">
                <div>
                    @if(count($leads))
                        <div class="table-responsive table-card mb-1">
                        <table class="table align-middle" id="datatable" style="width: 100%;">
                            <thead class="table-light text-muted">
                                <tr>
                                    <th>lead</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Created</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody class="list form-check-all">
                                @foreach($leads as $lead)
                                <tr class="no-border">
                                    <td class="lead_name">{{$lead->firstname}} {{$lead->lastname}}</td>
                                    <td class="email">{{$lead->email}}</td>
                                    <td class="phone">{{$lead->phone}}</td>
                                    <td class="date">{{$lead->created_at->format('d M, Y')}}</td>
                                    <td>
                                        <ul class="list-inline hstack gap-2 mb-0">
                                            <li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="" data-bs-original-title="Call">
                                                <a href="tel:{{$lead->phone}}" class="text-muted d-inline-block">
                                                    <i class="ri-phone-line fs-16"></i>
                                                </a>
                                            </li>
                                            @can('update lead')
                                            <li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Edit">
                                                <a href="{{route('lead.edit',[$lead->username])}}" class="text-primary d-inline-block edit-item-btn">
                                                    <i class="ri-pencil-fill fs-16"></i>
                                                </a>
                                            </li>
                                            @endcan
                                            @can('delete lead')
                                            <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Remove">
                                                <a class="text-danger d-inline-block remove-item-btn" data-bs-toggle="modal" data-id="{{$lead->id}}" data-title="{{$lead->firstname}}" href="#deleteItem">
                                                    <i class="ri-delete-bin-5-fill fs-16"></i>
                                                </a>
                                            </li>
                                            @endcan
                                            @can('convert lead')
                                            <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Convert to client">
                                                <a class="text-info d-inline-block remove-item-btn" data-bs-toggle="modal" data-id="{{$lead->id}}" data-title="{{$lead->firstname}}" href="#convertLead">
                                                    <i class="ri-clockwise-2-fill fs-16"></i>
                                                </a>
                                            </li>
                                            @endcan
                                        </ul>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="noresult" style="display: block;">
                        <div class="text-center">
                            <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop" colors="primary:#121331,secondary:#08a88a" style="width: 75px; height: 75px;"> </lord-icon>
                            <h5 class="mt-2 text-danger">Sorry! No lead Found</h5>
                            <p class="text-muted mb-0">You dont have any leads yet</p>
                        </div>
                    </div>
                    @endif
                </div>
                <!-- Delete Modal -->
                <div class="modal fade flip" id="deleteItem" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-body p-5 text-center">
                                <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#405189,secondary:#f06548" style="width: 90px; height: 90px;"></lord-icon>
                                <div class="mt-4 text-center">
                                    <h4>You are about to delete <span class="modal-title"></span>!</h4>
                                    <p class="text-muted fs-15 mb-4">Deleting a lead will remove all of the information from the database.</p>
                                    <div class="hstack gap-2 justify-content-center remove">
                                        <button class="btn btn-link link-success fw-medium text-decoration-none" data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i> Close</button>
                                        <form action="{{route('lead.delete')}}" method="POST">
                                            @csrf
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

                <div class="modal fade flip" id="convertLead" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-body p-5 text-center">
                                <lord-icon
                                    src="https://cdn.lordicon.com/imamsnbq.json"
                                    trigger="hover"
                                    style="width:100px;height:100px">
                                </lord-icon>
                                <div class="mt-4 text-center">
                                    <h4>You are about to convert <span class="modal-title"></span></h4>
                                    <p class="text-muted fs-15 mb-4">To become a permanent customer.</p>
                                    <div class="hstack gap-2 justify-content-center remove">
                                        <button class="btn btn-link link-success fw-medium text-decoration-none" data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i> Close</button>
                                        <form action="{{route('lead.convert')}}" method="POST">
                                            @csrf
                                            <input type="hidden" name="id" id="id" />
                                            <button type="submit" class="btn btn-success">Yes Proceed</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
<script>
// Modal pass package data
$('#convertLead').on('show.bs.modal', function(event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var title = button.data('title') // Extract info from data-* attributes
    var id = button.data('id')
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = $(this)
    modal.find('.modal-title').text(title)
    modal.find('.modal-body #id').val(id)
})
</script>
@endsection
