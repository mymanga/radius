@extends('layouts.master') @section('title') roles @endsection @section('css')
<link href="{{URL::asset('assets/js/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{URL::asset('assets/css/datatable-custom.css')}}" rel="stylesheet" type="text/css" />
@endsection @section('content') 
{{-- @component('components.breadcrumb') @slot('li_1') Clients @endslot @slot('title') Messages @endslot @endcomponent  --}}
<div class="page-title-box d-sm-flex align-items-center justify-content-between">
   <h4 class="mb-sm-0 font-size-18">Roles</h4>
   <div class="page-title-right">
      <ol class="breadcrumb m-0">
         <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Admin</a></li>
         <li class="breadcrumb-item active"><a href="{{ route('admin.role.index') }}">Roles</a></li>
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
      <div class="d-flex align-items-center mb-3">
         <div class="flex-grow-1">
         </div>
         <div class="flexshrink-0">
            <button type="button" class="btn btn-soft-info btn-md" data-bs-toggle="modal" data-bs-target="#createRoleModal">
            <i class="ri-add-line align-bottom me-1"></i> Create new role
            </button>
         </div>
      </div>
      <div class="card">
         <div class="card-body">
            <div class="table-responsive table-card mb-1">
               <table class="table table-nowrap align-middle table-striped" id="datatable" style="width: 100%;">
                  <thead>
                     <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
                        <th>#</th>
                        <th>Role</th>
                        <th>Permissions</th>
                        <th>Users</th>
                        <th>Actions</th>
                     </tr>
                  </thead>
                  <tbody class="text-gray-600">
                     @foreach ($roles as $role)
                     <tr>
                        <td>{{ $role->id }}</td>
                        <td>{{ $role->name }}</td>
                        <td>
                           <button type="button" class="btn btn-outline-info btn-sm view-permissions" data-bs-toggle="modal" data-bs-target="#permissionsModal{{ $role->id }}">
                           <i class="bi bi-eye"></i> View Permissions
                           </button>
                        </td>
                        <td>{{ $role->users->count() }}</td>
                        <td class="no-padding">
                           @if ($role->name !== 'super-admin' || $role->id !== 1)
                           <ul class="list-inline hstack gap-2 mb-0">
                              <li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Edit">
                                 <a href="#" class="text-info d-inline-block edit-item-btn" data-bs-toggle="modal" data-bs-target="#editRoleModal{{ $role->id }}">
                                 <i class="ri-pencil-fill fs-16"></i>
                                 </a>
                              </li>
                              <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Remove">
                                 <a class="text-danger d-inline-block remove-item-btn" data-bs-toggle="modal" data-id="{{$role->id}}" data-title="{{$role->name}}" href="#deleteItem">
                                 <i class="ri-delete-bin-5-fill fs-16"></i>
                                 </a>
                              </li>
                           </ul>
                           @endif
                        </td>
                     </tr>
                     <!-- Permissions Modal -->
                     <div class="modal fade" id="permissionsModal{{ $role->id }}" tabindex="-1" aria-labelledby="permissionsModalLabel{{ $role->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                           <div class="modal-content">
                                 <div class="modal-header">
                                    <h5 class="modal-title text-info mx-auto" id="permissionsModalLabel{{ $role->id }}">Permissions for {{ $role->name }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                 </div>
                                 <div class="modal-body">
                                    <div class="container-fluid">
                                       <div class="row">
                                             @php
                                             $permissionsCount = $role->permissions->count();
                                             $permissionsHalf = ceil($permissionsCount / 2);
                                             @endphp
                                             <div class="col-md-6">
                                                <ul class="list-group list-group-flush">
                                                   @foreach($role->permissions->slice(0, $permissionsHalf) as $permission)
                                                   <li class="list-group-item">{{ $permission->name }}</li>
                                                   @endforeach
                                                </ul>
                                             </div>
                                             <div class="col-md-6">
                                                <ul class="list-group list-group-flush">
                                                   @foreach($role->permissions->slice($permissionsHalf) as $permission)
                                                   <li class="list-group-item">{{ $permission->name }}</li>
                                                   @endforeach
                                                </ul>
                                             </div>
                                       </div>
                                    </div>
                                 </div>
                           </div>
                        </div>
                     </div>
                     <!-- Edit Role Modal -->
                     <div class="modal fade" id="editRoleModal{{ $role->id }}" tabindex="-1" aria-labelledby="editRoleModalLabel{{ $role->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                           <div class="modal-content">
                              <div class="modal-header">
                                 <h5 class="modal-title" id="editRoleModalLabel{{ $role->id }}">Edit {{ $role->name }}</h5>
                                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body">
                                 <form method="POST" action="{{ route('admin.role.update',[$role->id]) }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-3">
                                       <label for="name" class="form-label">Name</label>
                                       <input type="text" class="form-control" id="name" name="name" value="{{ $role->name }}" required>
                                    </div>
                                    <div class="mb-3">
                                       <h5 class="text-info">Permissions</h5>
                                       <div class="row">
                                          @foreach ($permissions as $permission)
                                          <div class="col-12 col-md-6">
                                             <div class="form-check">
                                                <input class="form-check-input current-modal-permission role-{{ $role->id }}" type="checkbox" id="{{ $permission->name }}" name="permissions[]" value="{{ $permission->name }}" @if ($role->hasPermissionTo($permission->name)) checked @endif>
                                                <label class="form-check-label" for="{{ $permission->name }}">
                                                {{ $permission->name }}
                                                </label>
                                             </div>
                                          </div>
                                          @endforeach
                                       </div>
                                    </div>
                                    <div class="modal-footer">
                                       <button type="button" class="btn btn-soft-danger" data-bs-dismiss="modal">Close</button>
                                       <button type="submit" class="btn btn-soft-info">Save changes</button>
                                    </div>
                                 </form>
                              </div>
                           </div>
                        </div>
                     </div>
                     @endforeach
                  </tbody>
               </table>
            </div>
         </div>
      </div>
   </div>
   <!--end col-->
</div>
<!-- Create Modal -->
<div class="modal fade" id="createRoleModal" tabindex="-1" aria-labelledby="createRoleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="createRoleModalLabel">Create new role</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <form action="{{ route('admin.role.create') }}" method="POST">
            @csrf
            <div class="modal-body">
               <div class="mb-3">
                  <label for="roleName" class="form-label">Role Name:</label>
                  <input type="text" name="role" class="form-control @error('role') is-invalid @enderror" id="roleName" placeholder="Enter role name" value="{{ old('role') }}">
                  @error('role')
                  <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
               </div>
               <div class="mb-3">
                  <h5 class="text-info mb-3">Permissions</h5>
                  <div class="form-check form-switch mb-3">
                     <input class="form-check-input" type="checkbox" id="select-all-permissions">
                     <label class="form-check-label fw-bold" for="select-all-permissions">Select all</label>
                  </div>
                  <div class="row">
                     @foreach ($permissions as $permission)
                     <div class="col-12 col-md-6">
                        <div class="form-check">
                           <input class="form-check-input current-modal-permission role-{{ $role->id }}" type="checkbox" id="{{ $permission->name }}" name="permissions[]" value="{{ $permission->name }}" @if (is_array(old('permissions')) && in_array($permission->name, old('permissions'))) checked @endif>
                           <label class="form-check-label" for="{{ $permission->name }}">
                           {{ $permission->name }}
                           </label>
                        </div>
                     </div>
                     @endforeach
                  </div>
                  @error('permissions')
                  <div class="text-danger">{{ $message }}</div>
                  @enderror
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-soft-danger" data-bs-dismiss="modal">Close</button>
               <button type="submit" class="btn btn-soft-info">Save role</button>
            </div>
         </form>
      </div>
   </div>
</div>
<!-- Modal delete -->
<div class="modal fade flip" id="deleteItem" tabindex="-1" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
         <div class="modal-body p-5 text-center">
            <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#405189,secondary:#f06548" style="width: 90px; height: 90px;"></lord-icon>
            <div class="mt-4 text-center">
               <h4>You are about to delete <span class="modal-title"></span>!</h4>
               <p class="text-muted fs-15 mb-4">Deleting a role will remove all of the information from the database.</p>
               <div class="hstack gap-2 justify-content-center remove">
                  <button class="btn btn-link link-success fw-medium text-decoration-none" data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i> Close</button>
                  <form action="{{ route('admin.role.destroy') }}" method="POST"> 
                     @csrf
                     @method('delete')
                     <input type="hidden" name="id" id="id" />
                     <button type="submit" class="btn btn-danger">Yes delete</button>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<!--end row-->
@endsection @section('script')
<script src="{{ URL::asset('/assets/js/jquery-3.6.1.js')}}"></script>
<script src="{{ URL::asset('/assets/js/datatables/datatables.min.js') }}"></script>
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
<script>
   $(document).ready(function () {
       // Show modal window when there are validation errors for a role creation form
       @if (count($errors) > 0 && $errors->has('role'))
           $("#createRoleModal").modal("show");
       @endif

       // Initialize DataTable
       $('#datatable').DataTable({
           responsive: true,
           deferRender: true,
           paging: false,
           searching: false,
           info: false,
           ordering: false,
       });

       // Modal pass package data
       $('#deleteItem').on('show.bs.modal', function(event) {
           var button = $(event.relatedTarget) // Button that triggered the modal
           var title = button.data('title') // Extract info from data-* attributes
           var id = button.data('id')
           // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
           // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
           var modal = $(this)
           modal.find('.modal-title').text(title)
           modal.find('.modal-body #id').val(id)
       });

       // Namespace the variables
       const myApp = {
          selectAllCheckbox: document.getElementById('select-all-permissions'),
          permissionCheckboxes: document.querySelectorAll('.current-modal-permission.role-{{ $role->id }}')
       };

       // Listen for a click event on the "select all" checkbox
       myApp.selectAllCheckbox.addEventListener('click', function() {
          // If the "select all" checkbox is checked, check all the other checkboxes
          if (myApp.selectAllCheckbox.checked) {
             myApp.permissionCheckboxes.forEach(function(checkbox) {
                checkbox.checked = true;
             });
          }
          // If the "select all" checkbox is not checked, uncheck all the other checkboxes
          else {
             myApp.permissionCheckboxes.forEach(function(checkbox) {
                checkbox.checked = false;
             });
          }
       });
   });
</script>
@endsection