@extends('layouts.master') @section('title') admin @endsection @section('css')
<link href="{{URL::asset('assets/js/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{URL::asset('assets/css/datatable-custom.css')}}" rel="stylesheet" type="text/css" />
@endsection @section('content') @component('components.breadcrumb') @slot('li_1') Admin @endslot @slot('title') users @endslot @endcomponent 

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
            <h5 class="mb-0 text-uppercase text-muted">Management</h5>
         </div>
         <div class="flexshrink-0">
            @can('create admin')
               <a href="{{route('admin.user.create')}}" class="btn btn-soft-info btn-md"><i class="ri-add-line align-bottom me-1"></i> Add User</a>
            @endcan
         </div>
      </div>
      <div class="card">
         <div class="card-body">
            <div>
               <div class="table-responsive table-card mb-1">
                  <table class="table table-nowrap align-middle table-striped" id="datatable" style="width: 100%;">
                     <thead class="table-light text-muted">
                        <tr class="text-uppercase">
                           <th>Name</th>
                           <th>Email</th>
                           <th>Phone</th>
                           <th>Role</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody class="list form-check-all">
                        @if(isset($users) && count($users) > 0)
                           @foreach($users as $user)
                              @if(null !== $user->id && null !== auth()->user() && $user->id == 1 && auth()->user() != $user)
                                    @continue
                              @endif
                              <tr class="no-border">
                                    <td>{{$user->fullName() ?? ''}}</td>
                                    <td class="date">{{$user->email ?? ''}}</td>
                                    <td class="date">{{$user->phone ?? ''}}</td>
                                    <td>
                                       @foreach($user->roles as $role)
                                          <span class="badge badge-outline-success">{{$role->name}}</span>
                                       @endforeach
                                    </td>
                                    <td class="no-padding">
                                       <ul class="list-inline hstack gap-2 mb-0">
                                          @if(null !== $user->phone && !empty($user->phone))
                                                <li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="" data-bs-original-title="Call">
                                                   <a href="tel:{{$user->phone}}" class="text-muted d-inline-block">
                                                      <i class="ri-phone-line fs-16"></i>
                                                   </a>
                                                </li>
                                          @endif
                                          {{-- <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="View">
                                                <a href="{{route('client.service',[$user->username])}}" class="text-info d-inline-block">
                                                   <i class="ri-eye-fill fs-16"></i>
                                                </a>
                                          </li> --}}
                                          @can('edit admin')
                                                <li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Edit">
                                                   <a href="{{route('admin.user.edit',[$user->username])}}" class="text-warning d-inline-block edit-item-btn">
                                                      <i class="ri-pencil-fill fs-16"></i>
                                                   </a>
                                                </li>
                                          @endcan
                                          @can('delete admin')
                                                @if(null !== $user->id && $user->id != 1)
                                                   <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Remove">
                                                      <a class="text-danger d-inline-block remove-item-btn" data-bs-toggle="modal" data-id="{{$user->id}}" data-title="{{$user->firstname}}" href="#deleteItem">
                                                            <i class="ri-delete-bin-5-fill fs-16"></i>
                                                      </a>
                                                   </li>
                                                @endif
                                          @endcan
                                       </ul>
                                    </td>
                              </tr>
                           @endforeach
                        @else
                           <tr>
                              <td colspan="5">No users found.</td>
                           </tr>
                        @endif
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
                           <p class="text-muted fs-15 mb-4">Deleting a client will remove all of the information from the database.</p>
                           <div class="hstack gap-2 justify-content-center remove">
                              <button class="btn btn-link link-success fw-medium text-decoration-none" data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i> Close</button>
                              <form action="{{route('admin.user.delete')}}" method="POST">
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
         </div>
      </div>
   </div>
   <!--end col-->
</div>
@endsection @section('script')
<script src="{{ URL::asset('/assets/js/jquery-3.6.1.js')}}"></script>
<script src="{{ URL::asset('/assets/js/datatables/datatables.min.js') }}"></script>
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
<script src="{{ URL::asset('/assets/js/datatable.js') }}"></script>
@endsection