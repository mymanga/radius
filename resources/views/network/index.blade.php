@extends('layouts.master') @section('title') network @endsection @section('css')
<link href="{{URL::asset('assets/js/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{URL::asset('assets/css/datatable-custom.css')}}" rel="stylesheet" type="text/css" />
@endsection @section('content') @component('components.breadcrumb') @slot('li_1') IPv4 @endslot @slot('title') Network @endslot @endcomponent 
<div class="row justify-content-center">
   <div class="col-lg-12">
      @if (session('status'))
      <div class="alert alert-success alert-dismissible alert-label-icon label-arrow fade show" role="alert">
         <i class="ri-check-double-line label-icon"></i><strong>Success</strong> - {{session('status')}}
         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      @endif @if (session('error'))
      <div class="alert alert-danger alert-dismissible alert-label-icon label-arrow fade show mb-xl-0" role="alert">
         <i class="ri-error-warning-line label-icon"></i><strong>Failed</strong>
         - {!!session('error')!!}
         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      <br />
      @endif
      <div class="card">
         <div style="margin-bottom:-10px; border-bottom:none" class="card-header">
            <div class="d-flex align-items-center">
               <h5 class="card-title mb-0 flex-grow-1"><i class="ri-notification-badge-fill text-success"></i> IPv4 Network</h5>
            </div>
         </div>
         <div class="card-body">
            <div>
               @if(isset($network))
               <div class="table-responsive table-card mb-1">
                  <table class="table align-middle" id="datatable-online" style="width: 100%;">
                     <thead class="table-light text-muted">
                        <tr>
                           <th>ID</th>
                           <th>Network</th>
                           <th>Subnet</th>
                           <th>Title</th>
                           <th>Comment</th>
                           <th>Actions</th>
                        </tr>
                     </thead>
                     <tbody class="list form-check-all">
                        <tr class="no-border">
                           <td>{{$network->id}}</td>
                           <td>
                              <h4 style="margin-top:5px"><code class="text-muted">{{$network->network}}</code></h4>
                           </td>
                           <td>{{$network->subnet}}</td>
                           <td>{{$network->title}}</td>
                           <td>{{$network->comment}}</td>
                           <td class="no-padding">
                              @can('update network')
                                 <ul class="list-inline hstack gap-2 mb-0">
                                    <li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Edit">
                                       <a href="" class="text-info d-inline-block edit-item-btn" data-bs-toggle="modal" data-bs-target="#editModal" 
                                          data-title="{{$network->title}}" 
                                          data-comment="{{$network->comment}}"
                                          data-network="{{$network->network}}"
                                          data-subnet="{{$network->subnet}}"
                                          >
                                       <i class="ri-pencil-fill fs-16"></i>
                                       </a>
                                    </li>
                                 </ul>
                              @endcan
                           </td>
                        </tr>
                     </tbody>
                  </table>
               </div>
               @else
               <div class="noresult" style="display: block;">
                  <div class="text-center">
                     <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop" colors="primary:#121331,secondary:#08a88a" style="width: 75px; height: 75px;"> </lord-icon>
                     <h5 class="mt-2 text-danger">Sorry! No network setup</h5>
                     s
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
                           <p class="text-muted fs-15 mb-4">Deleting a whole network is not recomended. Proceed with caution</p>
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
         </div>
      </div>
   </div>
   <!--end col-->
</div>
<div class="row">
   <div class="col-lg-12">
      <div class="card crm-widget">
         <div class="card-body p-0">
            <div class="row row-cols-xxl-4 row-cols-md-2 row-cols-1 g-0">
               <div class="col">
                  <div class="py-4 px-3">
                     <h5 class="text-muted text-uppercase fs-13">IP Addresses </h5>
                     <div class="d-flex align-items-center">
                        <div class="flex-grow-1 ms-3">
                           <h4 class="mb-0"><code class="text-muted">{{calculateSubnet()->getIPAddress()}}</code></h4>
                        </div>
                     </div>
                  </div>
               </div>
               <!-- end col -->
               <div class="col">
                  <div class="py-4 px-3">
                     <h5 class="text-muted text-uppercase fs-13">Total IP Addresses </h5>
                     <div class="d-flex align-items-center">
                        <div class="flex-grow-1 ms-3">
                           <h5 class="mb-0"><span class="counter-value" data-target="{{calculateSubnet()->getNumberIPAddresses()}}">{{calculateSubnet()->getNumberIPAddresses()}}</span></h5>
                        </div>
                     </div>
                  </div>
               </div>
               <!-- end col -->
               <div class="col">
                  <div class="mt-3 mt-md-0 py-4 px-3">
                     <h5 class="text-muted text-uppercase fs-13">Clients host range </h5>
                     <div class="d-flex align-items-center">
                        <div class="flex-grow-1 ms-3">
                           <h4 class="mb-0"><code class="text-muted">[{{calculateSubnet()->getMinHost()}} - {{calculateSubnet()->getMaxHost()}}]</code></h4>
                        </div>
                     </div>
                  </div>
               </div>
               <!-- end col -->
               <div class="col">
                  <div class="mt-3 mt-md-0 py-4 px-3">
                     <h5 class="text-muted text-uppercase fs-13">Netmask</h5>
                     <div class="d-flex align-items-center">
                        <div class="flex-grow-1 ms-3">
                           <h4 class="mb-0"><code class="text-muted">{{calculateSubnet()->getSubnetMask()}}</code></h4>
                        </div>
                     </div>
                  </div>
               </div>
               <!-- end col -->
            </div>
            <!-- end row -->
         </div>
         <!-- end card body -->
      </div>
      <!-- end card -->
   </div>
   <!-- end col -->
</div>
{{-- Edit modal --}}
<!-- Default Modals -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
         <div class="modal-header p-3 bg-soft-info">
            <h5 class="modal-title" id="exampleModalLabel">Edit Network</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
         </div>
         <form action="{{route('network.update',[$network->id])}}" method="POST">
            @csrf
            @method('put')
            <div class="modal-body">
               <div class="mb-3">
                  <label for="network" class="form-label text-muted">NETWORK <code>Example:(192.168.0.0)</code> </label>
                  <div class="input-group">
                     <input type="text" name="network" value="{{ old('network') ? old('network') : $network->network }}" id="network" class="form-control @error('network') is-invalid @enderror" aria-label="network" placeholder="xxx.xxx.xxx.xxx" />
                     @error('network')
                     <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                     </span>
                     @enderror
                  </div>
               </div>
               <div class="mb-3">
                  <label for="subnet" class="form-label text-muted">SUBNET</label>
                  <select class="form-control" id="subnet" data-choices data-choices-groups  data-placeholder="Select Subnet" name="subnet">
                     <option value="">Choose a subnet</option>
                     <optgroup label="Class A">
                        <option {{$network->subnet == 8 ? 'selected' : ''}} value="8">8 (16,777,214 hosts)</option>
                        <option {{$network->subnet == 9 ? 'selected' : ''}} value="9">9 (8,388,606 hosts)</option>
                        <option {{$network->subnet == 10 ? 'selected' : ''}} value="10">10 (4,194,302 hosts)</option>
                        <option {{$network->subnet == 11 ? 'selected' : ''}} value="11">11 (2,097,150 hosts)</option>
                        <option {{$network->subnet == 12 ? 'selected' : ''}} value="12">12 (1,048,574 hosts)</option>
                        <option {{$network->subnet == 13 ? 'selected' : ''}} value="13">13 (524,286 hosts)</option>
                        <option {{$network->subnet == 14 ? 'selected' : ''}} value="14">14 (262,142 hosts)</option>
                        <option {{$network->subnet == 15 ? 'selected' : ''}} value="15">15 (131,070 hosts)</option>
                     </optgroup>
                     <optgroup label="Class B">
                        <option {{$network->subnet == 16 ? 'selected' : ''}} value="16">16 (65,534 hosts)</option>
                        <option {{$network->subnet == 17 ? 'selected' : ''}} value="17">17 (32,766 hosts)</option>
                        <option {{$network->subnet == 18 ? 'selected' : ''}} value="18">18 (16,382 hosts)</option>
                        <option {{$network->subnet == 19 ? 'selected' : ''}} value="19">19 (8,190 hosts)</option>
                        <option {{$network->subnet == 20 ? 'selected' : ''}} value="20">20 (4,094 hosts)</option>
                        <option {{$network->subnet == 21 ? 'selected' : ''}} value="21">21 (2,046 hosts)</option>
                        <option {{$network->subnet == 22 ? 'selected' : ''}} value="22">22 (1,022 hosts)</option>
                        <option {{$network->subnet == 23 ? 'selected' : ''}} value="23">23 (510 hosts)</option>
                     </optgroup>
                     <optgroup label="Class C">
                        <option {{$network->subnet == 24 ? 'selected' : ''}} value="24">24 (254 hosts)</option>
                        <option {{$network->subnet == 25 ? 'selected' : ''}} value="25">25 (126 hosts)</option>
                        <option {{$network->subnet == 26 ? 'selected' : ''}} value="26">26 (62 hosts)</option>
                        <option {{$network->subnet == 27 ? 'selected' : ''}} value="27">27 (30 hosts)</option>
                        <option {{$network->subnet == 28 ? 'selected' : ''}} value="28">28 (14 hosts)</option>
                        <option {{$network->subnet == 29 ? 'selected' : ''}} value="29">29 (6 hosts)</option>
                        <option {{$network->subnet == 30 ? 'selected' : ''}} value="30">30 (2 hosts)</option>
                     </optgroup>
                  </select>
               </div>
               <div class="mb-3">
                  <label for="title" class="form-label text-muted">TITLE</label>
                  <div class="input-group">
                     <input type="text" name="title" value="{{ old('title') ? old('title') : $network->title }}" id="title" class="form-control @error('password') is-invalid @enderror" aria-label="title" placeholder="title" />
                     @error('title')
                     <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                     </span>
                     @enderror
                  </div>
               </div>
               <div class="mb-3">
                  <label for="comment" class="form-label text-muted">COMMENT</label>
                  <div class="input-group">
                     <textarea name="comment" id="comment" cols="30" rows="3" class="form-control @error('comment') is-invalid @enderror">{{$network->comment}}</textarea>
                     @error('comment')
                     <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                     </span>
                     @enderror
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <div class="hstack gap-2 justify-content-end">
                  <a href="{{route('network.index')}}" class="btn btn-light">Cancel</a>
                  <button type="submit" class="btn btn-soft-info" id="add-btn"><i class="las la-save"></i> Save</button>
               </div>
            </div>
         </form>
      </div>
   </div>
</div>
@endsection @section('script')
<script src="{{ URL::asset('/assets/js/jquery-3.6.1.js')}}"></script>
<script src="{{ URL::asset('/assets/js/datatables/datatables.min.js') }}"></script>
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
<script src="{{ URL::asset('/assets/js/datatable.js') }}"></script>
@if (count($errors) > 0 && $errors->has('network') || $errors->has('subnet'))
<script type="text/javascript">
   $(document).ready(function () {
       $("#editModal").modal("show");
   });
</script>
@endif
<script>
   // Modal pass package data
   $('#editModal').on('show.bs.modal', function(event) {
       var button = $(event.relatedTarget) // Button that triggered the modal
       var title = button.data('title') // Extract info from data-* attributes
       var comment = button.data('comment')
       var network = button.data('network');
       var subnet = button.data('subnet');
       // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
       // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
       var modal = $(this)
       modal.find('.modal-name').text(title)
       modal.find('.modal-body #id').val(id)
   })
</script>
<script>
   $(document).ready(function () {
       $('#datatable-online').DataTable({
           responsive: true,
           deferRender: true,
           paging: false,
           searching: false,
           info: false,
       });
   });
</script>
@endsection