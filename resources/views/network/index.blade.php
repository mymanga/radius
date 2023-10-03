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
         <div class="card-header bg-soft-warning">
            <div class="d-flex align-items-center">
               <h5 class="card-title mb-0 flex-grow-1"><i class="ri-notification-badge-fill text-success"></i> IPv4 Networks</h5>
               <div class="flex-shrink-0">
                  <button class="btn btn-soft-info btn-sm add-btn" data-bs-toggle="modal" data-bs-target="#createModal"><i class="ri-gps-line align-bottom me-1"></i> Add Network</button>
               </div>
            </div>
         </div>
         <div class="card-body">
            <div>
               @if(isset($networks))
               <div class="table-responsive table-card mb-1">
                  <table class="table align-middle" id="datatable-online" style="width: 100%;">
                     <thead class="table-light text-muted">
                        <tr>
                           <th>ID</th>
                           <th>Network</th>
                           <th>Subnet</th>
                           <th>Title</th>
                           <th>Comment</th>
                           <th>Nas</th>
                           <th>Total IP Addresses</th>
                           <th>Clients Host Range</th>
                           <th>Netmask</th>
                           <th>Actions</th>
                        </tr>
                     </thead>
                     <tbody class="list form-check-all">
                        @foreach($networks as $network)
                        <tr class="no-border">
                           <td>{{$network->id}}</td>
                           <td>
                              <h5 style="margin-top:5px"><code class="text-muted">{{$network->network}}</code></h5>
                           </td>
                           <td>{{$network->subnet}}</td>
                           <td>{{$network->title}}</td>
                           <td>{{$network->comment}}</td>
                           <td>{{ optional($network->nas)->shortname }}</td>
                           @php
                           $subnetDetails = new \IPv4\SubnetCalculator($network->network, $network->subnet);
                           @endphp
                           <td>{{$subnetDetails->getNumberIPAddresses()}}</td>
                           <td>[{{$subnetDetails->getMinHost()}} - {{$subnetDetails->getMaxHost()}}]</td>
                           <td>{{$subnetDetails->getSubnetMask()}}</td>
                           <td class="no-padding">
                              @can('update network')
                              <ul class="list-inline hstack gap-2 mb-0">
                                 <li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Edit">
                                    <a href="{{ route('network.edit',[$network->id]) }}" class="text-info d-inline-block edit-item-btn">
                                    <i class="ri-pencil-fill fs-16"></i>
                                    </a>
                                 </li>
                                 @can('delete network')
                                 <li class="list-inline-item delete" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Delete">
                                    <a href="#" class="text-danger d-inline-block delete-item-btn" onclick="confirmDeletion('{{ route('network.destroy', ['networkId' => $network->id]) }}');" data-id="{{ $network->id }}">
                                    <i class="ri-delete-bin-5-fill fs-16"></i>
                                    </a>
                                 </li>
                                 @endcan
                                 <form id="deleteForm" action="" method="POST" style="display:none;">
                                    @csrf
                                    @method('DELETE')
                                 </form>
                              </ul>
                              @endcan
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
            <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
               <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                     <div class="modal-header p-3 bg-soft-info">
                        <h5 class="modal-title" id="exampleModalLabel">Create Network</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                     </div>
                     <form action="{{ route('network.store') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                           @foreach ([
                           ['type' => 'text', 'name' => 'network', 'label' => 'NETWORK', 'placeholder' => 'xxx.xxx.xxx.xxx', 'example' => '(192.168.0.0)', 'value' => old('network')],
                           ['type' => 'text', 'name' => 'title', 'label' => 'TITLE', 'placeholder' => 'title', 'example' => null, 'value' => old('title')],
                           ['type' => 'textarea', 'name' => 'comment', 'label' => 'COMMENT', 'placeholder' => null, 'example' => null, 'value' => old('comment')],
                           ] as $field)
                           <div class="mb-3">
                              <label for="{{ $field['name'] }}" class="form-label text-muted">{{ $field['label'] }} @if($field['example'])<code>Example:{{ $field['example'] }}</code>@endif</label>
                              <div class="input-group">
                                 @if($field['type'] === 'textarea')
                                 <textarea name="{{ $field['name'] }}" id="{{ $field['name'] }}" cols="30" rows="3" class="form-control @error($field['name']) is-invalid @enderror">{{ $field['value'] }}</textarea>
                                 @else
                                 <input type="{{ $field['type'] }}" name="{{ $field['name'] }}" id="{{ $field['name'] }}" class="form-control @error($field['name']) is-invalid @enderror" aria-label="{{ $field['name'] }}" placeholder="{{ $field['placeholder'] }}" value="{{ $field['value'] }}" />
                                 @endif
                                 @error($field['name'])
                                 <span class="invalid-feedback" role="alert">
                                 <strong>{{ $message }}</strong>
                                 </span>
                                 @enderror
                              </div>
                           </div>
                           @endforeach
                           <div class="mb-3">
                              <label for="subnet" class="form-label text-muted">SUBNET</label>
                              <select class="form-control @error('subnet') is-invalid @enderror" id="subnet" name="subnet">
                                 <option value="">Choose a subnet</option>
                                 @foreach ($subnets as $class => $values)
                                 <optgroup label="{{ $class }}">
                                    @foreach ($values as $subnet => $hosts)
                                    <option value="{{ $subnet }}" {{ old('subnet') == $subnet ? 'selected' : '' }}>{{ $subnet }} ({{ $hosts }})</option>
                                    @endforeach
                                 </optgroup>
                                 @endforeach
                              </select>
                              @error('subnet')
                              <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                           </div>
                           <div class="mb-3">
                              <label for="nas" class="form-label text-muted">NAS</label>
                              <select class="form-control @error('nas') is-invalid @enderror" id="nas" name="nas">
                                 <option value="">Choose a NAS</option>
                                 @foreach ($nases as $nas)
                                 <option value="{{ $nas->id }}" {{ old('nas') == $nas->id ? 'selected' : '' }}>{{ $nas->shortname }} - <code>{{ $nas->nasname }}</code></option>
                                 @endforeach
                              </select>
                              @error('nas')
                              <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                           </div>
                        </div>
                        <div class="modal-footer">
                           <div class="hstack gap-2 justify-content-end">
                              <a href="{{ route('network.index') }}" class="btn btn-light">Cancel</a>
                              <button type="submit" class="btn btn-soft-info" id="create-btn"><i class="las la-save"></i> Create</button>
                           </div>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!--end col-->
</div>
@endsection @section('script')
<script src="{{ URL::asset('/assets/js/jquery-3.6.1.js')}}"></script>
<script src="{{ URL::asset('/assets/js/datatables/datatables.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.9/dist/sweetalert2.all.min.js"></script>
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
<script src="{{ URL::asset('/assets/js/datatable.js') }}"></script>
<script type="text/javascript">
   $(document).ready(function () {
       // Show modal if there are validation errors
       @if (count($errors) > 0 && ($errors->has('network') || $errors->has('subnet') || $errors->has('nas')))
           $("#createModal").modal("show");
       @endif
   
       // Initialize DataTable
       $('#datatable-online').DataTable({
           responsive: true,
           deferRender: true,
       });
   });
</script>
<script>
   function confirmDeletion(url) {
       Swal.fire({
           title: 'Are you sure?',
           text: 'You will not be able to recover this data!',
           icon: 'warning',
           showCancelButton: true,
           confirmButtonText: 'Yes, delete it!',
           cancelButtonText: 'No, keep it'
       }).then((result) => {
           if (result.isConfirmed) {
               document.getElementById('deleteForm').action = url;
               document.getElementById('deleteForm').submit();
           }
       });
   }
</script>
@endsection