@extends('layouts.master') @section('title') openvpn settings @endsection @section('css')
<link href="{{URL::asset('assets/js/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{URL::asset('assets/css/datatable-custom.css')}}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.css">
<style>
.dot {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    display: inline-block;
    animation: pulse 1s infinite;
}

.green {
    background-color: green;
}

.red {
    background-color: red;
}

@keyframes pulse {
    0% {
        transform: scale(0.95);
        box-shadow: 0 0 0 0 rgba(0, 128, 0, 0.7);
    }

    70% {
        transform: scale(1);
        box-shadow: 0 0 0 10px rgba(0, 128, 0, 0);
    }

    100% {
        transform: scale(0.95);
        box-shadow: 0 0 0 0 rgba(0, 128, 0, 0);
    }
}
</style>
@endsection @section('content') 
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">OpenVpn &nbsp; {!! isOpenVPNRunning() ? '<div class="dot green"></div>' : '<div class="dot red"></div>' !!} </h4>
        </div>
    </div>
</div>
<!-- end page title -->
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
         - {!!session('error')!!}
         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      <br />
      @endif
      @unless(setting('openvpnconfig'))
      <div class="row justify-content-center">
         <div class="col-lg-8 col-md-8">
               <div class="card">
                  <div class="card-body">
                     <div class="text-center">
                           <div class="row justify-content-center">
                              <div class="col-lg-9">
                                 <h4 class="mt-4 fw-semibold">OpenVpn Notice</h4>
                                 <p class="text-muted mt-3">OpenVpn server is installed but
                                    has not been configured. You need to setup before using it
                                 </p>
                                 <form action="{{route('ovpn.setup_ovpn')}}" method="POST">
                                    @csrf
                                       <div class="mt-4">
                                          <label for="ip" class="form-label">OVPN SERVER NETWORK </label>
                                          <input type="text" name="serverip" id="serverip" class="form-control @error('serverip') is-invalid @enderror" placeholder="Enter ip address" value="{{old('serverip')}}" />
                                          @error('serverip')
                                          <span class="invalid-feedback" role="alert">
                                          <strong>{{ $message }}</strong>
                                          </span>
                                          @enderror
                                       </div>
                                    
                                       <div class="hstack mt-4 justify-content-end">
                                          <button type="submit" class="btn btn-primary" id="loading"><i class="ri-add-line align-bottom me-1"></i> Setup Ovpn Server</button>
                                       </div>
                                    
                                 </form>
                              </div>
                           </div>

                           <div class="row justify-content-center mt-5 mb-2">
                              <div class="col-sm-7 col-8">
                                 <img src="{{asset('assets/images/verification-img.png')}}" alt="" class="img-fluid">
                              </div>
                           </div>
                     </div>
                  </div>
               </div>
               <!--end card-->
         </div>
         <!--end col-->
      </div>
      @endunless
      @if(setting('openvpnconfig'))
      <div class="d-flex align-items-center mb-3">
         <div class="flex-grow-1">
            {{-- 
            <h5 class="mb-0 text-uppercase text-muted">All templates</h5>
            --}}
         </div>
         <div class="flexshrink-0">
            <a href="#newOvpn" data-bs-toggle="modal" class="btn btn-soft-info btn-md"><i class="ri-add-line align-bottom me-1"></i> Add Ovpn Client</a>
            <a href="#" class="btn btn-soft-success btn-md" id="ovpnRestart"><i class="ri-restart-fill align-bottom me-1"></i> Restart Ovpn server</a>
         </div>
      </div>
      <div class="card">
         <div class="card-body">
            <div>
               @if(count($ovpns))
               <div class="table-responsive table-card mb-1">
                  <table class="table align-middle" id="datatable" style="width: 100%;">
                     <thead class="table-light text-muted">
                        <tr>
                           <th>#</th>
                           <th>Name</th>
                           <th>IP</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody class="list form-check-all">
                        @foreach($ovpns as $ovpn)
                        <tr class="no-border">
                           <td>{{$ovpn->id}}</td>
                           <td>{{$ovpn->name}}</td>
                           <td>
                              <h4><code class="text-muted">{{$ovpn->ip}}</code></h4>
                           </td>
                           <td>
                              <ul class="list-inline hstack gap-2 mb-0">
                                 <li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Download config">
                                    <a href="{{route('ovpn.download',[$ovpn->id])}}" class="text-primary d-inline-block download-item-btn">
                                    <i class="ri-download-2-fill fs-16"></i>
                                    </a>
                                 </li>
                                 <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Remove">
                                    <a class="text-danger d-inline-block remove-item-btn" data-bs-toggle="modal" data-id="{{$ovpn->id}}" data-title="{{$ovpn->name}}" href="#deleteItem"> <i class="ri-delete-bin-5-fill fs-16"></i> </a>
                                 </li>
                                 {{-- <li class="list-inline-item" data-bs-toggle="tooltip"
                                    data-bs-trigger="hover" data-bs-placement="top"
                                    title="Preview">
                                    <a class="text-default d-inline-block view-item-btn" data-bs-toggle="modal" data-content="#" data-title="#" href="#previewitem">
                                    <i class="ri-search-eye-line fs-16"></i>
                                    </a>
                                 </li> --}}
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
                     <h5 class="mt-2 text-danger">Sorry! No ovpn client found</h5>
                     <p class="text-muted mb-0">You dont have any ovpn clients setup</p>
                  </div>
               </div>
               @endif
            </div>
            <!-- /.modal -->
         </div>
      </div>
      <div class="float-end"><p class="text-muted">
      {{getOpenVPNVersion()}}
      {!! isOpenVPNRunning() ? '<span class="text-success">running</span>' : '<span class="text-danger">stopped</span>' !!}
      </p></div>
      @endif
      <div class="modal fade" id="newOvpn" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
         <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
               <div class="modal-header p-3 bg-soft-info">
                  <h5 class="modal-title" id="exampleModalLabel">Add Ovpn client</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
               </div>
               <form action="{{route('ovpn.store')}}" method="POST">
                  @csrf
                  <div class="modal-body">
                     <div class="mb-3">
                        <label for="expiry" class="form-label">Client name </label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="Enter Ovpn Client name" value="{{old('name')}}" />
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                     </div>
                     <div class="mb-3" id="modal-id">
                        <label for="ipaddress" class="form-label">IP Address</label>
                        <p class="text-muted"><code>assign ip address to the client</code></p>
                        <select name="ip" class="form-control @error('ip') is-invalid @enderror">
                           <option value="" disabled selected hidden>Select ip address</option>
                           @php
                           $count = 0;
                           $minHost = $sub->getMinHost();  
                           @endphp
                           @foreach($sub->getAllHostIPAddresses() as $address)
                           @if(!in_array($address , $ipaddresses) && $address !== $minHost)
                           <?php if($count == 5) break; ?>
                           <option {{old('ip') == $address ? 'selected' : ''}} value="{{$address}}">{{$address}}</option>
                           <?php $count++; ?>
                           @endif
                           @endforeach
                        </select>
                        @error('ip')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                     </div>
                  </div>
                  <div class="modal-footer">
                     <div class="hstack gap-2 justify-content-end">
                        <a href="{{route('ovpn.index')}}" class="btn btn-light">Cancel</a>
                        <button type="submit" class="btn btn-primary" id="add-btn"><i class="las la-save"></i> Save</button>
                     </div>
                  </div>
               </form>
            </div>
         </div>
      </div>
      {{-- <div class="modal fade" id="ovpnsetup" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
         <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
               <div class="modal-header p-3 bg-soft-info">
                  <h5 class="modal-title" id="exampleModalLabel">Setup OpenVpn Server</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
               </div>
               <form action="{{route('ovpn.setup_ovpn')}}" method="POST">
                  @csrf
                  <div class="modal-body">
                     <div class="mb-3">
                        <label for="ip" class="form-label">IP Address </label>
                        <input type="text" name="serverip" id="serverip" class="form-control @error('serverip') is-invalid @enderror" placeholder="Enter ip address" value="{{old('serverip')}}" />
                        @error('serverip')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                     </div>
                  </div>
                  <div class="modal-footer">
                     <div class="hstack gap-2 justify-content-end">
                        <a href="{{route('ovpn.index')}}" class="btn btn-light">Cancel</a>
                        <button type="submit" class="btn btn-primary" id="add-btn"><i class="las la-save"></i> Save</button>
                     </div>
                  </div>
               </form>
            </div>
         </div>
      </div> --}}
      <!-- Delete Modal -->
      <div class="modal fade flip" id="deleteItem" tabindex="-1" aria-hidden="true">
         <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
               <div class="modal-body p-5 text-center">
                  <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#405189,secondary:#f06548" style="width: 90px; height: 90px;"></lord-icon>
                  <div class="mt-4 text-center">
                     <h4>You are about to delete <span class="modal-title"></span>!</h4>
                     <p class="text-muted fs-15 mb-4">Deleting ovpn client will remove all of the information from the database.</p>
                     <div class="hstack gap-2 justify-content-center remove">
                        <button class="btn btn-link link-success fw-medium text-decoration-none" data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i> Close</button>
                        <form action="{{route('ovpn.delete')}}" method="POST"> @csrf
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
   <!--end col-->
</div>

<form id="restartOvpn" method="POST" action="{{ route('ovpn.restart') }}">
    @csrf
    <!-- form fields here -->
</form>


@endsection
@section('script')
<script src="{{ URL::asset('/assets/js/jquery-3.6.1.js')}}"></script>
<script src="{{ URL::asset('/assets/js/datatables/datatables.min.js') }}"></script>
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
<script src="{{ URL::asset('/assets/js/datatable.js') }}"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
@if (count($errors) > 0 && $errors->has('name') || $errors->has('ip'))
<script type="text/javascript">
   $(document).ready(function () {
       $("#newOvpn").modal("show");
   });
</script>
@endif
{{-- @if (count($errors) > 0 && $errors->has('serverip'))
<script type="text/javascript">
   $(document).ready(function () {
       $("#ovpnsetup").modal("show");
   });
</script>
@endif --}}
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

<script>
  // Get a reference to the button element
  const restartButton = document.getElementById('ovpnRestart');

  // Add an event listener to the button
  restartButton.addEventListener('click', function(event) {
    // Prevent the default behavior of the button
    event.preventDefault();

    // Show the confirmation dialog
    swal({
      title: "Are you sure?",
      text: "This will restart the Openvpn server and disconnect all clients. Do you want to continue?",
      icon: "warning",
      buttons: true,
      dangerMode: true,
    })
    .then((willRestart) => {
      // If the user clicks the confirmation button, submit the form
      if (willRestart) {
        // Submit the form
        document.getElementById('restartOvpn').submit();
      }
    });
  });
</script>


@endsection