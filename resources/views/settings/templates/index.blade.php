@extends('layouts.master') @section('title') templates @endsection @section('css')
<link href="{{URL::asset('assets/js/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{URL::asset('assets/css/datatable-custom.css')}}" rel="stylesheet" type="text/css" />
@endsection @section('content') 
{{-- @component('components.breadcrumb') @slot('li_1') Crm @endslot @slot('title') leads @endslot @endcomponent  --}}
<div class="row">
   <div class="col-lg-12">
      <div class="card mt-n4 mx-n4">
         <div class="bg-soft-light">
            @include('settings.templates.header')
            <!-- end card body -->
         </div>
      </div>
      <!-- end card -->
   </div>
   <!-- end col -->
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
         - {{session('error')}}
         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      <br />
      @endif
      <div class="d-flex align-items-center mb-3">
         <div class="flex-grow-1">
            {{-- 
            <h5 class="mb-0 text-uppercase text-muted">All templates</h5>
            --}}
         </div>
         <div class="flexshrink-0">
            <a href="{{route('template.createsmstemplate')}}" class="btn btn-soft-info btn-md"><i class="ri-add-line align-bottom me-1"></i> SMS Template</a>
            <a href="{{route('template.createmailtemplate')}}" class="btn btn-soft-success btn-md"><i class="ri-add-line align-bottom me-1"></i> Email Template</a>
         </div>
      </div>
      <div class="card">
         <div class="card-body">
            <div>
               @if(count($templates))
               <div class="table-responsive table-card mb-1">
                  <table class="table align-middle" id="datatable" style="width: 100%;">
                     <thead class="table-light text-muted">
                        <tr>
                           <th>#</th>
                           <th>Title</th>
                           <th>Type</th>
                           <th>Description</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody class="list form-check-all">
                        @foreach($templates as $template)
                        <tr class="no-border">
                           <td>{{$template->id}}</td>
                           <td>{{$template->title}}</td>
                           <td>{{$template->type}}</td>
                           <td>{{$template->description}}</td>
                           <td>
                              <ul class="list-inline hstack gap-2 mb-0">
                                 <li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Edit">
                                    <a href="{{route('template.edit',[$template->id])}}" class="text-primary d-inline-block edit-item-btn">
                                    <i class="ri-pencil-fill fs-16"></i>
                                    </a>
                                 </li>
                                 <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Remove">
                                    <a class="text-danger d-inline-block remove-item-btn" data-bs-toggle="modal" data-id="{{$template->id}}" data-title="{{$template->title}}" href="#deleteItem">
                                    <i class="ri-delete-bin-5-fill fs-16"></i>
                                    </a>
                                 </li>
                                 @if(isset($client))
                                 <li class="list-inline-item" data-bs-toggle="tooltip"
                                    data-bs-trigger="hover" data-bs-placement="top"
                                    title="Preview">
                                    <a class="text-default d-inline-block view-item-btn" data-bs-toggle="modal" data-content="{{ message($client,$template->content) }}" data-title="{{$template->title}}" href="#previewitem">
                                    <i class="ri-search-eye-line fs-16"></i>
                                    </a>
                                 </li>
                                 @endif
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
                     <h5 class="mt-2 text-danger">Sorry! No templates found</h5>
                     <p class="text-muted mb-0">You dont have any custom templates</p>
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
                           <p class="text-muted fs-15 mb-4">Deleting a template remove will revert to default template.</p>
                           <div class="hstack gap-2 justify-content-center remove">
                              <button class="btn btn-link link-success fw-medium text-decoration-none" data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i> Close</button>
                              <form action="{{route('template.delete')}}" method="POST">
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
            <div id="previewitem" class="modal fade flip" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
               <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                     <div class="modal-header">
                        <h5 class="modal-title text-muted text-uppercase fs-13" id="myModalLabel"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
                     </div>
                     <div class="modal-body">
                        <p class="content"></p>
                     </div>
                     <div class="modal-footer">
                        <small class="text-muted">Preview is based on a random selected client</small>
                     </div>
                  </div>
                  <!-- /.modal-content -->
               </div>
               <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->
         </div>
      </div>
   </div>
   <!--end col-->
</div>
@endsection
@section('script')
<script src="{{ URL::asset('/assets/js/jquery-3.6.1.js')}}"></script>
<script src="{{ URL::asset('/assets/js/datatables/datatables.min.js') }}"></script>
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
<script src="{{ URL::asset('/assets/js/datatable.js') }}"></script>
<script>
   // Modal pass package data
   $('#previewitem').on('show.bs.modal', function(event) {
       var button = $(event.relatedTarget) // Button that triggered the modal
       var title = button.data('title') // Extract info from data-* attributes
       var content = button.data('content')
       // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
       // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
       var modal = $(this)
       modal.find('.modal-title').text(title)
       modal.find('.modal-body .content').html(content)
   })
</script>
@endsection