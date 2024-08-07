@extends('layouts.master') @section('title') services @endsection @section('css')
<link href="{{URL::asset('assets/js/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{URL::asset('assets/css/datatable-custom.css')}}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.3/css/selectize.min.css">
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
   .orange {
   background-color: orange;
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
   .ri-close-fill {
   cursor: pointer;
   margin-left: 5px;
   font-size: 12px;
   color: #ffff;
   } 
   .selectize-control.multi .selectize-input > div {
   cursor: pointer;
   margin: 0 3px 3px 0;
   padding: 2px 6px;
   background: #299cdb;
   color: #fff;
   border: 1px solid #299cdb;
   border-radius: 4px;
   transition: background-color 0.3s ease;
   }
   .selectize-control.multi .selectize-input > div:hover {
   background: #0056b3;
   }
   .selectize-control.multi .selectize-input > div:active {
   background: #003080;
   }
</style>
@endsection @section('content') 
{{-- @component('components.breadcrumb') @slot('li_1') Account @endslot @slot('title') settings @endslot @endcomponent --}}
<div class="row">
   <div class="col-lg-12">
      <div class="card mt-n4 mx-n4">
         <div class="bg-soft-light">
            @include('clients.header')
            <!-- end card body -->
         </div>
      </div>
      <!-- end card -->
   </div>
   <!-- end col -->
</div>
<div class="row">
   <div class="col-lg-12">
      <!-- show success message  -->
      @if (session('status'))
      <div class="alert alert-success alert-dismissible alert-label-icon label-arrow fade show" role="alert">
         <i class="ri-check-double-line label-icon"></i><strong>Success</strong> - {{session('status')}}
         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      <!-- show error message  -->
      @endif @if (session('error'))
      <div class="alert alert-danger alert-dismissible alert-label-icon label-arrow fade show mb-xl-0" role="alert">
         <i class="ri-error-warning-line label-icon"></i><strong>Failed</strong>
         - {{session('error')}}
         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      <br />
      @endif
      @if (session('info'))
      <div class="alert alert-info alert-dismissible alert-label-icon label-arrow fade show mb-xl-0" role="alert">
         <i class="ri-error-warning-line label-icon"></i><strong>Failed</strong>
         - {{session('info')}}
         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      <br />
      @endif
      @if($errors->any())
      <div class="alert alert-danger">
         <ul>
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
         </ul>
      </div>
      @endif
      <div class="card">
         <div class="card-header border-bottom-dashed">
            <div class="d-flex align-items-center">
               <h5 class="card-title mb-0 flex-grow-1"><i class="ri-router-line"></i> Internet Services</h5>
               <div class="flex-shrink-0">
                  @can('manage pppoe')
                  <button class="btn btn-soft-info add-btn" data-bs-toggle="modal" data-bs-target="#showModal"><i class="ri-gps-line align-bottom me-1"></i> Add New Service</button>
                  @endcan
               </div>
            </div>
         </div>
         <div class="card-body pt-0">
            <div>
               <!-- show services message  -->
               @if(isset($services) && count($services))
               <div class="table-responsive table-card mb-1">
                  <table class="table table-nowrap align-middle table-striped" id="datatable" style="width: 100%;">
                     <thead class="text-muted table-light">
                        <tr class="text-uppercase">
                           {{-- 
                           <th>#</th>
                           --}}
                           <th>Status</th>
                           <th>Type</th>
                           <th>Package</th>
                           <th>IP Address</th>
                           <th>Tags</th>
                           <th>Description</th>
                           <th>Price</th>
                           <th>Mac address</th>
                           <th>Username</th>
                           <th>Password</th>
                           <th>Expiry</th>
                           <th>Router</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody class="list form-check-all">
                        @foreach($services as $service)
                        <tr class="no-border">
                           {{-- 
                           <td>{{ $service->id }}</td>
                           --}}
                           <td>
                              <span class="service-status" data-service-id="{{ $service->id }}">
                              <span class="status-text">{!! $service->status() !!}</span>
                              <span class="online-status">{!! $service->getOnlineStatus() !!}</span>
                              </span>
                           </td>
                           <td>
                              @if(isset($service->type))
                              {{ $service->type }}
                              @elseif($service->cleartextpassword)
                              PPP
                              @else
                              DHCP
                              @endif
                           </td>
                           <td>{{ $service->package->name }} </td>
                           <td style="font-size:17px"><code class="text-muted">{{$service->ipaddress}}</code></td>
                              <td>
                                @if(isset($service->tags) && count($service->tags))
                                   @foreach($service->tags as $tag)
                                      {{ $tag->name }}
                                      @if(!$loop->last)
                                         , <!-- Add a comma if it's not the last tag -->
                                      @endif
                                   @endforeach
                                @endif
                             </td>
                           <td style="white-space: normal; min-width: 120px;">{{ $service->description }}</td>
                           <td>{{ $service->price }} ksh</td>
                           <td style="font-size:17px">
                              <code class="text-muted">{{$service->mac_address}}</code>
                              @can('clear MAC address')
                              @if ($service->mac_address && $service->type != 'DHCP')
                              @if($service->type !== 'DHCP')
                              <li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Clear MAC Address">
                                 <a href="#" class="text-danger d-inline-block edit-item-btn" onclick="confirmClearMac({{ $service->id }})">
                                 <i class="ri-close-circle-fill fs-16"></i>
                                 </a>
                              </li>
                              @endif
                              <!-- Update the form ID to include the service ID -->
                              <form action="{{ route('clear_mac_address', ['id' => $service->id]) }}" method="POST" id="clearMacForm_{{ $service->id }}" style="display: none;">
                                 @csrf
                                 @method('DELETE')
                              </form>
                              @else
                              <!-- Show an empty cell if the MAC address is not set -->
                              @endif
                              @endcan
                           </td>
                           @can('manage pppoe')
                           <td>{{ $service->username }}</td>
                           <td>{{ $service->cleartextpassword }}</td>
                           @else
                           <td>*******</td>
                           <td>*******</td>
                           @endcan  
                           <td>
                              @php
                                  $displayExpiry = $service->grace_expiry && Carbon\Carbon::parse($service->grace_expiry) > Carbon\Carbon::parse($service->expiry) && Carbon\Carbon::parse($service->grace_expiry) > Carbon\Carbon::now() ? Carbon\Carbon::parse($service->grace_expiry) : Carbon\Carbon::parse($service->expiry);
                                  $isWithinGracePeriod = $service->grace_expiry && Carbon\Carbon::parse($service->grace_expiry) > Carbon\Carbon::parse($service->expiry) && Carbon\Carbon::parse($service->grace_expiry) > Carbon\Carbon::now();
                                  $blockAfterDays = setting('block_recurring_clients_days', 14);
                                  $disconnectionDate = Carbon\Carbon::parse($service->expiry)->addDays($blockAfterDays);
                                  $pendingDisconnection = $disconnectionDate->isFuture();
                              @endphp
                          
                              @if($displayExpiry->isPast())
                                  <div class="badge badge-soft-danger badge-border fs-12">Expired {{ $displayExpiry->format('d F Y') }}</div>
                                  @if($service->client->billingType === 'recurring' && $service->is_active)
                                      @if($pendingDisconnection)
                                          <div class="text-warning fs-12">Pending Disconnection on {{ $disconnectionDate->format('d F Y') }}</div>
                                      @endif
                                  @endif
                              @else
                                  @if($displayExpiry->lte(\Carbon\Carbon::now()->addWeek()))
                                      <div class="badge badge-soft-info badge-border fs-12">{{ $displayExpiry->diffForHumans() }}</div>
                                  @else
                                      <div class="badge badge-soft-info badge-border fs-12">{{ $displayExpiry->format('d F Y') }}</div>
                                  @endif
                              @endif
                          
                              {{-- Show grace period indicator --}}
                              @if($isWithinGracePeriod)
                                  <span class="text-danger ml-1">(Grace Period)</span>
                              @endif
                          </td>
                                             
                           @if($service->nas()->exists())
                           <td>{{$service->nas->shortname}}</td>
                           @else
                           <td></td>
                           @endif
                           <td class="no-padding">
                              <ul class="list-inline hstack gap-2 mb-0">
                                 @can('edit services')
                                 <li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Edit">
                                    <a href="{{ route('service.edit',[$service->id]) }}" class="text-info d-inline-block edit-item-btn">
                                       <div class="avatar-xs">
                                          <div class="avatar-title bg-soft-primary text-info rounded-circle fs-16">
                                             <i class="ri-pencil-fill fs-16"></i>
                                          </div>
                                       </div>
                                    </a>
                                 </li>
                                 @endcan
                                 @can('destroy services')
                                 <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Remove">
                                    <a class="text-danger d-inline-block remove-item-btn" data-bs-toggle="modal" data-id="{{$service->id}}" data-title="{{$service->package->name}}" href="#deleteItem">
                                       <div class="avatar-xs">
                                          <div class="avatar-title bg-soft-danger text-danger rounded-circle fs-16">
                                             <i class="ri-delete-bin-5-fill fs-16"></i>
                                          </div>
                                       </div>
                                    </a>
                                 </li>
                                 @endcan
                                 @can('extend services')
                                 <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Extend expiration">
                                    <a href="#extendModal" class="d-inline-block" data-bs-toggle="modal" data-id="{{$service->id}}" data-title="{{$service->package->name}}">
                                       <div class="avatar-xs">
                                          <div class="avatar-title bg-soft-success text-success rounded-circle fs-16">
                                             <i class="ri-history-line fs-16"></i>
                                          </div>
                                       </div>
                                    </a>
                                 </li>
                                 @endcan
                                 @can('refresh services')
                                 <li class="list-inline-item refresh" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Refresh">
                                    <a href="{{ route('client.disconnect',[$service->id]) }}" class="d-inline-block refresh-item-btn" onclick="spinner()">
                                       <div class="avatar-xs">
                                          <div class="avatar-title bg-soft-info text-info rounded-circle fs-16">
                                             <i class="ri-refresh-line fs-16"></i>
                                          </div>
                                       </div>
                                    </a>
                                 </li>
                                 @endcan
                                 @can('block/unblock services')
                                 <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="{{ $service->is_active ? 'Block Service' : 'Unblock Service' }}">
                                    <a href="javascript:void(0)" class="d-inline-block" onclick="blockUnblockService({{$service->id}}, {{$service->is_active}})">
                                       <div class="avatar-xs">
                                          <div class="avatar-title {{ $service->is_active ? 'bg-soft-danger' : 'bg-soft-success' }} {{ $service->is_active ? 'text-danger' : 'text-success' }} rounded-circle fs-16">
                                             <i class="{{ $service->is_active ? 'ri-forbid-line' : 'ri-check-fill' }} fs-16"></i>
                                          </div>
                                       </div>
                                    </a>
                                 </li>
                                 @endcan
                                 <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Change Service">
                                    <a href="{{ route('service.change', [$service->id]) }}" class="text-primary d-inline-block">
                                        <div class="avatar-xs">
                                            <div class="avatar-title bg-soft-primary text-primary rounded-circle fs-16">
                                                <i class="ri-exchange-dollar-fill fs-16"></i> <!-- Assuming this icon represents a service change -->
                                            </div>
                                        </div>
                                    </a>
                                </li>
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
                     <h5 class="mt-2 text-danger">Sorry! No service Found</h5>
                     <p class="text-muted mb-0">You have not added any internet service. You need atleast one to proceed</p>
                  </div>
               </div>
               @endif
            </div>
            <div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
               <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                     <div class="modal-header p-3 bg-soft-info">
                        <h5 class="modal-title" id="exampleModalLabel">New Internet Service</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                     </div>
                     <form action="{{route('service.save',[$client->username])}}" method="POST">
                        @csrf
                        <div class="modal-body">
                           <input type="hidden" id="id-field" />
                           <div class="mb-3" id="modal-id">
                              <label for="service-type" class="form-label">Select Service Type</label>
                              <select name="service_type" id="service-type" class="form-control @error('service_type') is-invalid @enderror">
                              <option value="pppoe" {{ old('service_type', 'pppoe') == 'pppoe' ? 'selected' : '' }}>PPPoE</option>
                              <option value="dhcp" {{ old('service_type') == 'dhcp' ? 'selected' : '' }}>DHCP</option>
                              </select>
                              @error('service_type')
                              <div class="text-danger">{{ $message }}</div>
                              @enderror
                           </div>
                           <div class="mb-3" id="modal-id">
                              <label for="package" class="form-label">Select package</label>
                              <select name="package" id="package" class="form-control @error('package') is-invalid @enderror">
                                 <option value="" disabled selected hidden>Select internet package</option>
                                 @if(isset($packages) && count($packages) > 0)
                                 @foreach($packages as $package)
                                 <option data-price="{{$package->price}}" {{old('package') == $package->id ? 'selected' : ''}} value="{{$package->id}}">{{$package->name}}</option>
                                 @endforeach
                                 @else
                                 <option disabled>No packages found. Please create a package first.</option>
                                 @endif
                              </select>
                              @error('package')
                              <div class="text-danger">{{ $message }}</div>
                              @enderror
                           </div>
                           <div id="amount" style="{{ old('price') ? old('price') : 'display:none;' }}">
                              <div class="mb-3">
                                 <label>Price:</label>
                                 <input type="number" name="price" class="form-control" id="price-input" value="{{ old('price') }}">
                              </div>
                           </div>
                           @if(isset($packages) && count($packages) == 0)
                           <div class="alert alert-warning" role="alert">
                              No packages found. Please create a package first. <a href="{{ route('tariff.create') }}" class="btn btn-soft-success btn-sm">create</a>
                           </div>
                           @endif
                           @if(isset($routers) && count($routers))
                           <div class="mb-3" id="modal-id">
                              <label for="package" class="form-label">Select router</label>
                              <select name="nas" id="nas" class="form-control @error('nas') is-invalid @enderror">
                                 <option value="" disabled selected hidden>Select router</option>
                                 @foreach($routers as $router)
                                 <option {{old('nas') == $router->id ? 'selected' : ''}} value="{{$router->id}}">{{$router->shortname}}</option>
                                 @endforeach
                              </select>
                              @error('nas')
                              <div class="text-danger">{{ $message }}</div>
                              @enderror
                           </div>
                           @else
                           <div class="alert alert-warning" role="alert">
                              No routers found. Please create a router first. <a href="{{ route('nas.create') }}" class="btn btn-soft-success btn-sm">create</a>
                           </div>
                           @endif
                           <!-- Add your new input field here -->
                           <div class="mb-3">
                              <label for="ipv4_networks" class="form-label">IPv4 Networks</label>
                              <select name="ipv4_networks" id="ipv4_networks" class="form-control @error('ipv4_networks') is-invalid @enderror">
                                 <!-- Options will be populated based on AJAX request -->
                              </select>
                              @error('ipv4_networks')
                              <div class="text-danger">{{ $message }}</div>
                              @enderror
                           </div>
                           <div class="mb-3" id="modal-id">
                              <label for="ipaddress" class="form-label">IP Address</label>
                              <p class="text-muted"><code>assign fixed ip address to the user</code></p>
                              <div id="ipaddressSection" class="input-group mb-3" @if(old('manualIpAddress'))
                              style="display:none"
                              @endif>
                              <select name="ipaddress" id="ipaddress" class="form-control @error('ipaddress') is-invalid @enderror">
                                 <option value="" disabled selected hidden>Select IP address</option>
                                 <!-- Options will be populated dynamically based on the selected IPv4 network -->
                              </select>
                              <div class="input-group-append">
                                 <button type="button" class="btn btn-outline-secondary" onclick="showManualInput()">Add Manually</button>
                              </div>
                           </div>
                           <div id="manualInput" style="display: {{ old('manualIpAddress') ? 'block' : 'none' }};">
                              <label for="manualIpAddress" class="form-label">Enter IP Address Manually</label>
                              <input type="text" name="manualIpAddress" id="manualIpAddress" class="form-control" value="{{ old('manualIpAddress') }}">
                              @if($errors->has('manualIpAddress'))
                              <div class="text-danger">{{ $errors->first('manualIpAddress') }}</div>
                              @endif
                           </div>
                        </div>
                        <script>
                           // Show manual input and hide ipaddress select box on button click
                           function showManualInput() {
                              document.getElementById("manualInput").style.display = "block";
                              document.getElementById("ipaddressSection").style.display = "none";
                           }
                        </script>
                        @php
                        $baseUsername = $client->username;
                        $counter = 0;
                        do {
                        if($counter > 0) {
                        $username = $baseUsername . '_' . $counter;
                        } else {
                        $username = $baseUsername;
                        }
                        $exists = \App\Models\Service::where('username', $username)->exists();
                        $counter++;
                        } while($exists);
                        @endphp
                        <div class="mb-3 pppoe-section">
                           <label for="username" class="form-label">PPPoE Username <span class="text-danger">*</span></label>
                           <div class="input-group">
                              <input type="text" name="username" value="{{ old('username', $username) }}" id="username" class="form-control @error('username') is-invalid @enderror" aria-label="username" placeholder="username" />
                              <button class="btn btn-soft-info" type="button" id="button" onclick="randomPortalLogin(this)">Generate</button>
                           </div>
                           @error('username')
                           <div class="text-danger">{{ $message }}</div>
                           @enderror
                        </div>
                        <div class="mb-3 pppoe-section">
                           <label for="userpassword" class="form-label">PPPoE Password <span class="text-danger">*</span></label>
                           <div class="input-group">
                              <input type="text" name="password" value="{{ old('password') }}" id="userpassword" class="form-control @error('password') is-invalid @enderror" aria-label="password" placeholder="password" />
                              <button class="btn btn-soft-info" type="button" id="button" onclick="randomPortalPassword(this)">Generate</button>
                           </div>
                           @error('password')
                           <div class="text-danger">{{ $message }}</div>
                           @enderror
                        </div>
                        <div class="mb-3 dhcp-section" style="display: none;">
                           <label for="macaddress" class="form-label">MAC Address <span class="text-danger">*</span></label>
                           <input type="text" name="macaddress" value="{{ old('macaddress') }}" id="macaddress" class="form-control @error('macaddress') is-invalid @enderror" aria-label="macaddress" placeholder="MAC Address" />
                           @error('macaddress')
                           <div class="text-danger">{{ $message }}</div>
                           @enderror
                        </div>
                        <div class="mb-3">
                           <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                           <div class="input-group">
                              <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" aria-label="description" placeholder="Enter description here...">{{ old('description') }}</textarea>
                           </div>
                           @error('description')
                           <div class="text-danger">{{ $message }}</div>
                           @enderror
                        </div>
                        <div class="mb-3">
                           <label for="tags" class="form-label">Tags <span class="text-muted">(search or create)</span></label>
                           <select id="tags" name="tags[]" multiple>
                              <!-- Options will be added dynamically -->
                           </select>
                        </div>
                        <div class="mb-3">
                           <div class="form-check">
                              <input type="checkbox" class="form-check-input" name="addInstallationFee" id="installationFeeCheckbox" {{ old('addInstallationFee') ? 'checked' : '' }}>
                              <label class="form-check-label" for="installationFeeCheckbox">Add Installation Fee</label>
                           </div>
                        </div>
                        @php
                        $installationFee = setting('installation_fee');
                        $installationFeeFormatted = $installationFee !== null ? number_format((float)$installationFee, 2, '.', '') : null;
                        @endphp
                        <div class="mb-3" id="installationFeeDiv" style="display: {{ old('addInstallationFee') ? 'block' : 'none' }};">
                           <label for="installationFee" class="form-label">Installation Fee</label>
                           <input type="number" step="0.01" name="installationFee" id="installationFee" class="form-control @error('installationFee') is-invalid @enderror" placeholder="Enter installation fee" value="{{ old('installationFee', $installationFeeFormatted) }}">
                           @error('installationFee')
                           <div class="text-danger">{{ $message }}</div>
                           @enderror
                        </div>
                  </div>
                  <div class="modal-footer">
                  <div class="hstack gap-2 justify-content-end">
                  <a href="{{route('client.service',[$client->username])}}" class="btn btn-light">Cancel</a>
                  <button type="submit" class="btn btn-soft-info" id="add-btn"><i class="las la-save"></i> Save</button>
                  </div>
                  </div>
                  </form>
               </div>
            </div>
         </div>
         <div class="modal fade" id="extendModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
               <div class="modal-content">
                  <div class="modal-header p-3 bg-soft-info">
                     <h5 class="modal-title" id="exampleModalLabel"></h5>
                     <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                  </div>
                  <form action="{{route('service.extend',[$client->username])}}" method="POST">
                     @csrf
                     <input type="hidden" name="id" id="id"/>
                     <div class="modal-body">
                        <div class="mb-3">
                           <label for="expiry" class="form-label">Extend Service </label>
                           <input type="text" name="expiry" id="expiry" class="form-control @error('expiry') is-invalid @enderror" data-provider="flatpickr" data-date-format="Y-m-d" placeholder="Select date" value="{{old('expiry')}}" />
                           @error('expiry')
                           <span class="invalid-feedback" role="alert">
                           <strong>{{ $message }}</strong>
                           </span>
                           @enderror
                           <br>
                           <small class="form-text text-muted">Please note that the original expiry date will be preserved if you choose to add this to billing. If not, the expiry date will be updated to your selected date.</small>
                        </div>
                        <div class="mb-3 form-check form-switch form-switch-md" dir="ltr">
                           <input type="checkbox" name="addToInvoice" class="form-check-input" id="addToInvoiceSwitch">
                           <label class="form-check-label" for="addToInvoiceSwitch">Add to Billing</label>
                        </div>
                        <small class="form-text text-muted">When you mark this as compensation, a paid invoice for the days selected will also be created</small>
                        
                        <div class="mb-3 form-check form-switch form-switch-md" dir="ltr">
                           <input type="checkbox" name="compensation" class="form-check-input" id="compensationInvoiceSwitch">
                           <label class="form-check-label" for="compensationInvoiceSwitch">Compensation</label>
                        </div>
                     </div>
                     <div class="modal-footer">
                        <div class="hstack gap-2 justify-content-end">
                           <a href="{{route('client.service',[$client->username])}}" class="btn btn-light">Cancel</a>
                           <button type="submit" class="btn btn-primary" id="add-btn"><i class="las la-save"></i> Save</button>
                        </div>
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
                        <h4>You are about to delete <span class="modal-title"></span> package <span class="text-danger">!</span></h4>
                        <p class="text-muted fs-15 mb-4">Are you sure you want to remove all information from the database?</p>
                        <div class="hstack gap-2 justify-content-center remove">
                           <button class="btn btn-link link-success fw-medium text-decoration-none" data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i> Close</button>
                           <form action="{{route('service.delete',[$client->username])}}" method="POST">
                              @csrf
                              <input type="hidden" name="id" id="id" />
                              <button type="submit" class="btn btn-danger">Yes delete it</button>
                           </form>
                           {{-- <a href="" class="btn btn-danger" id="delete-record">Yes Delete it</a> --}}
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
<!--end row-->
@endsection @section('script')
<script src="{{ URL::asset('/assets/js/jquery-3.6.1.js')}}"></script>
<script src="{{ URL::asset('/assets/js/datatables/datatables.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.9/dist/sweetalert2.all.min.js"></script>
<!-- init js -->
<script src="{{URL::asset('/assets/js/pages/form-pickers.init.js')}}"></script>
<script src="{{ URL::asset('/assets/js/datatable.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.3/js/standalone/selectize.min.js"></script>
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
<script type="text/javascript">
   function spinner() {
       var loadingContainer = document.getElementById('loader-wrapper');
       loadingContainer.style.display = 'block';
   }
   
   $(document).ready(function () {
       @if (count($errors) > 0)
           @if ($errors->has('package') || $errors->has('username') || $errors->has('password') || $errors->has('ipaddress') || $errors->has('nas') || $errors->has('macaddress'))
               $("#showModal").modal("show");
           @endif
           @if ($errors->has('expiry'))
               $("#extendModal").modal("show");
           @endif
       @endif
   
       $('#extendModal').on('show.bs.modal', function(event) {
           var button = $(event.relatedTarget); // Button that triggered the modal
           var title = button.data('title'); // Extract info from data-* attributes
           var id = button.data('id');
           var modal = $(this);
           modal.find('.modal-title').text(title);
           modal.find('#id').val(id);
       });
       
       const packageSelect = document.querySelector('select[name="package"]');
       const priceInput = document.querySelector('#price-input');
       const amountDiv = document.querySelector('#amount');
   
       packageSelect.addEventListener('change', function() {
           const selectedOption = this.options[this.selectedIndex];
           if (selectedOption.value !== '') {
               priceInput.value = selectedOption.dataset.price;
               amountDiv.style.display = 'block';
           } else {
               priceInput.value = '';
               amountDiv.style.display = 'none';
           }
       });
   });
   
   function randomPortalLogin(clicked_element) {
       var self = $(clicked_element);
       var random_string = generateRandomString(5);
       $('input[name=username]').val(random_string);
   }
   
   function randomPortalPassword(clicked_element) {
       var self = $(clicked_element);
       var random_string = generateRandomString(7);
       $('input[name=password]').val(random_string);
   }
   
   function generateRandomString(string_length) {
       var characters = '0123456789';
       var string = '';
   
       for(var i = 0; i <= string_length; i++) {
           var rand = Math.round(Math.random() * (characters.length - 1));
           var character = characters.substr(rand, 1);
           string = string + character;
       }
   
       return string;
   }
   
   function confirmClearMac(serviceId) {
      Swal.fire({
         title: 'Clear MAC Address?',
         text: 'Are you sure you want to clear the MAC address and delete the radcheck entry?',
         icon: 'warning',
         showCancelButton: true,
         confirmButtonText: 'Yes, clear it!',
         cancelButtonText: 'No, cancel!',
         reverseButtons: true,
         customClass: {
            confirmButton: 'btn btn-danger',
         },
         customStyle: {
            confirmButtonBackground: '#d33',
         },
         showLoaderOnConfirm: true, // This option will show the loading spinner until the user clicks the confirm button
         preConfirm: () => {
            // Dynamically construct the form ID based on the service ID
            var formId = 'clearMacForm_' + serviceId;
   
            // Trigger the form submission
            document.getElementById(formId).submit();
   
            // Return a Promise to handle the asynchronous operation
            return new Promise(() => {});
         },
      });
   }
   
   document.getElementById('installationFeeCheckbox').addEventListener('change', function() {
       document.getElementById('installationFeeDiv').style.display = this.checked ? 'block' : 'none';
   });
   
   // Ip network and address selection 
   
   $('#showModal').on('shown.bs.modal', function (e) {
   
       const routerNetworksUrlTemplate = '{{ route('nas.networks', ['id' => '__ID__']) }}';
       const ipAddressesUrlTemplate = '{{ route('network.getAvailableIpAddresses', ['networkId' => '__ID__']) }}';
       
       const oldRouterId = '{{ old('nas') }}';
       const oldIPv4NetworkId = '{{ old('ipv4_networks') }}';
       const oldIp = '{{ old('ipaddress') }}';  
   
       setTimeout(() => {
           const routerSelect = document.getElementById('nas');
           const ipv4NetworksSelect = document.getElementById('ipv4_networks');
           const ipAddressesSelect = document.getElementById('ipaddress');
   
           if (oldRouterId) {
               routerSelect.value = oldRouterId;
           }
   
           routerSelect.addEventListener('change', function() {
              // Clear IP address select options when a new router is selected
              ipAddressesSelect.innerHTML = '<option value="" disabled selected hidden>Select IP address</option>';
   
              const routerId = this.value;
   
              fetch(routerNetworksUrlTemplate.replace('__ID__', routerId))
                 .then(response => response.json())
                 .then(data => {
                       ipv4NetworksSelect.innerHTML = ''; 
   
                       if (data.ipv4_networks.length === 0) {
                          Swal.fire({
                             icon: 'warning',
                             title: 'No IPv4 networks',
                             text: 'No IPv4 networks available for the selected router.',
                          });
                          return;
                       }
   
                       data.ipv4_networks.forEach(network => {
                          const option = document.createElement('option');
                          option.value = network.id;
                          option.textContent = network.network;
                          ipv4NetworksSelect.appendChild(option);
                       });
   
                       if (oldIPv4NetworkId) {
                          ipv4NetworksSelect.value = oldIPv4NetworkId;
                       }
   
                       ipv4NetworksSelect.dispatchEvent(new Event('change'));
                 })
                 .catch(error => console.error('Error:', error));
           });
   
           ipv4NetworksSelect.addEventListener('change', function() {
   
               const networkId = this.value;
   
               fetch(ipAddressesUrlTemplate.replace('__ID__', networkId))
                   .then(response => response.json())
                   .then(data => {
                       ipAddressesSelect.innerHTML = '<option value="" disabled selected hidden>Select IP address</option>'; 
   
                       data.availableIpAddresses.forEach(address => {
                           const option = document.createElement('option');
                           option.value = address.id;
                           option.textContent = address.ip;
   
                           if (address.ip === oldIp) { 
                               option.selected = true;
                           }
   
                           ipAddressesSelect.appendChild(option);
                       });
                   })
                   .catch(error => console.error('Error:', error));
           });
   
           if (oldRouterId) {
               routerSelect.dispatchEvent(new Event('change'));
           }
       }, 100); 
   });
</script>
<script>
   function blockUnblockService(serviceId, isActive) {
    Swal.fire({
        title: 'Are you sure?',
        text: isActive ? "This will block the service" : "This will unblock the service",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, do it!',
        cancelButtonText: 'No, cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: isActive ? 'Blocking...' : 'Unblocking...',
                text: 'Please wait while the service is being ' + (isActive ? 'blocked.' : 'unblocked.'),
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                    
                    // Create a form dynamically and submit it for blocking/unblocking the service
                    let form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '{{ route('service.blockUnblock', '') }}/' + serviceId;
   
                    // Add CSRF token to the form
                    let csrfInput = document.createElement('input');
                    csrfInput.type = 'hidden';
                    csrfInput.name = '_token';
                    csrfInput.value = '{{ csrf_token() }}';
                    form.appendChild(csrfInput);
   
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }
    })
   }
</script>
<script>
   var serviceStatusUrl = "{{ route('service.status', ['id' => '__ID__']) }}";
      // Polling interval in milliseconds (e.g., 5000ms for 5 seconds)
      var pollingInterval = 5000;
   
      function updateServiceStatus(serviceId) {
        $.ajax({
           url: serviceStatusUrl.replace('__ID__', serviceId),
           method: 'GET',
           dataType: 'json',
           success: function (data) {
              var statusElement = $('.service-status[data-service-id="' + serviceId + '"]');
              statusElement.find('.status-text').html(data.status);
              statusElement.find('.online-status').html(data.online_status);
           },
           error: function (error) {
                 console.error('Error fetching service status:', error);
           }
        });
     }
   
      // Start polling for each service status
      $('.service-status').each(function () {
          var serviceId = $(this).data('service-id');
          setInterval(function () {
              updateServiceStatus(serviceId);
          }, pollingInterval);
      });
</script>
<script>
   $(document).ready(function () {
       // Show/hide sections based on selected service type
       $('#service-type').change(function () {
           var selectedServiceType = $(this).val();
   
           if (selectedServiceType === 'pppoe') {
               $('.pppoe-section').show();
               $('.dhcp-section').hide();
           } else if (selectedServiceType === 'dhcp') {
               $('.pppoe-section').hide();
               $('.dhcp-section').show();
           }
       });
   
       // Trigger change event on page load to handle initial state
       $('#service-type').trigger('change');
   });
</script>
<script>
   $(document).ready(function() {
       $('#tags').selectize({
           delimiter: ',',
           persist: false,
           create: function(input) {
               return {
                   value: input,
                   text: input
               };
           },
           load: function(query, callback) {
               if (!query.length) return callback();
               $.ajax({
                   url: '{{ route("fetch.tags") }}',
                   type: 'GET',
                   dataType: 'json',
                   data: {
                       q: query
                   },
                   success: function(response) {
                       // Format response as an array of objects with 'value' and 'text' properties
                       var formattedTags = response.tags.map(function(tag) {
                           return { value: tag, text: tag };
                       });
                       callback(formattedTags);
                   }
               });
           },
           render: {
               item: function(item, escape) {
                   return '<div>' +
                       (item.text ? '<span class="tag">' + escape(item.text) + '</span>' : '') +
                       '<i class="ri-close-fill" data-value="' + escape(item.value) + '"></i>' +
                   '</div>';
               },
               option_create: function(data, escape) {
                   return '<div class="create">Add <strong>' + escape(data.input) + '</strong>&hellip;</div>';
               }
           },
           onItemRemove: function(value) {
               // Handle tag removal logic here
               console.log('Tag removed:', value);
           }
       });
   
       // Event delegation to handle click events on cancel icons
       $(document).on('click', '.ri-close-fill', function(e) {
           e.preventDefault();
           var value = $(this).data('value');
           var selectize = $('#tags')[0].selectize;
           selectize.removeItem(value);
       });
   });
</script>

<script>
   // Get references to the checkboxes
   const addToInvoiceCheckbox = document.getElementById('addToInvoiceSwitch');
   const compensationCheckbox = document.getElementById('compensationInvoiceSwitch');

   // Add event listeners to handle checkbox selection/deselection
   addToInvoiceCheckbox.addEventListener('change', function() {
      if (this.checked) {
         // If Add to Billing is selected, deselect Compensation
         compensationCheckbox.checked = false;
      }
   });

   compensationCheckbox.addEventListener('change', function() {
      if (this.checked) {
         // If Compensation is selected, deselect Add to Billing
         addToInvoiceCheckbox.checked = false;
      }
   });
</script>
@endsection