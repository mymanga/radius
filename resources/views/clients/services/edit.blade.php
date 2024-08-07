@extends('layouts.master') @section('title')
edit
@endsection
 @section('css')
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.3/css/selectize.min.css">
<style>
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
@endsection 
@section('content')
@component('components.breadcrumb')
@slot('li_1')
Service
@endslot @slot('title')
Edit
@endslot
@endcomponent
<!-- .card-->
<div class="row justify-content-center">
   <div class="col-lg-8">
      <div class="card" id="orderList">
         <div class="card-header border-bottom-dashed">
            <div class="d-flex align-items-center">
               <h5 class="card-title mb-0 flex-grow-1"><i class="ri-router-line"></i> EDIT SERVICE <code>[{{$service->username}}]</code> </h5>
               <div class="flex-shrink-0"></div>
            </div>
         </div>
         <div class="card-body pt-0">
            <form action="{{ route('service.update', [$service->id]) }}" method="POST">
               @csrf @method('put')
               <div class="modal-body">
                  <div class="mb-3" id="modal-id">
                     <div class="alert alert-warning alert-dismissible alert-label-icon label-arrow fade show mb-xl-0"
                        role="alert">
                        <i class="ri-error-warning-line label-icon"></i><strong>Note</strong>
                        - Editing service details will affect the current connected session.
                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                           aria-label="Close"></button>
                     </div>
                     <br />
                     <label for="package" class="form-label">Select package</label>
                     <select name="package" class="form-control" id="package">
                     @foreach ($packages as $package)
                     <option data-price="{{ $package->price }}" {{ old('package', $service->package->id) == $package->id ? 'selected' : '' }} value="{{ $package->id }}">{{ $package->name }}</option>
                     @endforeach
                     </select>
                     @error('package')
                     <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                     </span>
                     @enderror
                  </div>
                  <div class="mb-3">
                     <label for="price" class="form-label">Price <span class="text-danger">*</span></label>
                     <div class="input-group">
                        <input type="number" name="price" value="{{ old('price', $service->price) }}" 
                           id="price" class="form-control @error('price') is-invalid @enderror"
                           aria-label="price" placeholder="Enter price" step="0.01" min="0"/>
                        @error('price')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                     </div>
                  </div>
                  @if(isset($routers) && count($routers))
                  <div class="mb-3">
                     <label for="nas" class="form-label">Select router</label>
                     <select name="nas" id="nas" class="form-control @error('nas') is-invalid @enderror">
                        <option value="" disabled selected hidden>Select router</option>
                        @foreach($routers as $router)
                        <option value="{{ $router->id }}" {{ old('nas', $service->nas_id) == $router->id ? 'selected' : '' }}>
                        {{ $router->shortname }}
                        </option>
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
                  <div class="mb-3">
                     <label for="ipaddress" class="form-label">IP Address</label>
                     <p class="text-muted"><code>assign fixed ip address to the user</code></p>
                     <select name="ipaddress" id="ipaddress" class="form-control @error('ipaddress') is-invalid @enderror" data-current-ip="{{ $service->ipaddress }}">
                        <option value="" disabled selected hidden>Select IP address</option>
                        <!-- Options will be populated dynamically based on the selected IPv4 network -->
                     </select>
                     @error('ipaddress')
                     <div class="text-danger">{{ $message }}</div>
                     @enderror
                  </div>
                  <div class="mb-3">
                     <div id="manualInput">
                        <label for="manualIpAddress" class="form-label">Enter IP Address Manually</label>
                        <input type="text" name="manualIpAddress" id="manualIpAddress" class="form-control" value="{{ old('manualIpAddress') }}">
                        @if($errors->has('manualIpAddress'))
                        <div class="text-danger">{{ $errors->first('manualIpAddress') }}</div>
                        @endif
                     </div>
                  </div>
                  @if($service->type == 'PPP' || $service->type == null)
                  <div class="mb-3">
                     <label for="username" class="form-label">PPPoE Username <span
                        class="text-danger">*</span></label>
                     <div class="input-group">
                        <input type="text" name="username" value="{{ $service->username }}" id="username"
                           class="form-control @error('username') is-invalid @enderror" aria-label="username"
                           placeholder="Portal login" autocomplete="off">
                        <button class="btn btn-soft-info" type="button" id="button"
                           onclick="randomPortalLogin(this)">Generate</button> 
                        @error('username')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                     </div>
                  </div>
                  <div class="mb-3">
                     <label for="password" class="form-label">PPPoE Password <span
                        class="text-danger">*</span></label>
                     <div class="input-group">
                        <input type="text" name="password" value="{{ $service->cleartextpassword }}"
                           id="password" class="form-control @error('password') is-invalid @enderror"
                           aria-label="password" placeholder="portal password"/>
                        {{-- @if(!$service->is_active) --}}
                        <button class="btn btn-soft-info" type="button" id="button"
                           onclick="randomPortalPassword(this)">Generate</button>
                        {{-- @endif --}}
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                     </div>
                  </div>
                  @else
                  <div class="mb-3">
                     <label for="username" class="form-label">Macaddress <span
                        class="text-danger">*</span></label>
                     <div class="input-group">
                        <input type="text" name="username" value="{{ $service->username }}" id="username"
                           class="form-control @error('username') is-invalid @enderror" aria-label="username"
                           placeholder="Portal login" autocomplete="off">
                        @error('username')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                     </div>
                  </div>
                  @endif
                  <div class="mb-3">
                     <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                     <div class="input-group">
                        <textarea 
                           name="description" 
                           id="description" 
                           class="form-control @error('description') is-invalid @enderror" 
                           aria-label="description" 
                           placeholder="Enter description here..."
                           >{{ old('description', $service->description) }}</textarea>
                     </div>
                     @error('description')
                     <div class="text-danger">{{ $message }}</div>
                     @enderror
                  </div>
                  <div class="mb-3">
                     <label for="tags" class="form-label">Tags <span class="text-muted">(search or create)</span></label>
                     <select id="tags" name="tags[]" multiple>
                        @foreach($tags as $tag)
                        <option value="{{ $tag }}" selected>{{ $tag }}</option>
                        @endforeach
                     </select>
                  </div>
               </div>
               <div class="modal-footer">
                  <div class="hstack gap-2 justify-content-end">
                     <a href="{{ route('client.service', [$service->client->username]) }}"
                        class="btn btn-light">Cancel</a>
                     <button type="submit" class="btn btn-soft-info" id="loading"><i class="las la-save"></i>
                     Save</button>
                  </div>
               </div>
            </form>
            <!--end modal -->
         </div>
      </div>
   </div>
</div>
@endsection @section('script')
<script src="{{ URL::asset('/assets/js/jquery-3.6.1.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.9/dist/sweetalert2.all.min.js"></script>
<script>
   function randomPortalLogin(clicked_element) {
       var self = $(clicked_element);
       var random_string = generateRandomString(5);
       $('input[name=username]').val(random_string);
       {{-- self.remove(); --}}
   }
   
   function randomPortalPassword(clicked_element) {
       var self = $(clicked_element);
       var random_string = generateRandomString(7);
       $('input[name=password]').val(random_string);
       {{-- self.remove(); --}}
   }
   
   function generateRandomString(string_length) {
       var characters = '0123456789';
       var string = '';
   
       for (var i = 0; i <= string_length; i++) {
           var rand = Math.round(Math.random() * (characters.length - 1));
           var character = characters.substr(rand, 1);
           string = string + character;
       }
   
       return string;
   }
</script>
<script>
   const packageSelect = document.querySelector('select[name="package"]');
   const priceInput = document.querySelector('input[name="price"]');
   
   packageSelect.addEventListener('change', function() {
       const selectedOption = this.options[this.selectedIndex];
       if (selectedOption.value !== '') {
           priceInput.value = selectedOption.dataset.price;
       } else {
           priceInput.value = '';
       }
   });
</script>
<script>
   const routerNetworksUrlTemplate = '{{ route('nas.networks', ['id' => '__ID__']) }}';
   const ipAddressesUrlTemplate = '{{ route('network.getAvailableIpAddresses', ['networkId' => '__ID__']) }}';
   
   const currentRouterId = '{{ old('nas', $service->nas_id) }}';
   const currentIPv4NetworkId = '{{ old('ipv4_networks', $service->ipv4_network_id) }}';
   const currentIp = document.getElementById('ipaddress').getAttribute('data-current-ip');
   console.log("Current IP:", currentIp);
   
   const routerSelect = document.getElementById('nas');
   const ipv4NetworksSelect = document.getElementById('ipv4_networks');
   const ipAddressesSelect = document.getElementById('ipaddress');
   
   
   if (currentRouterId) {
       routerSelect.value = currentRouterId;
   }
   
   routerSelect.addEventListener('change', function() {
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
   
                if (currentIPv4NetworkId) {
                    ipv4NetworksSelect.value = currentIPv4NetworkId;
                    ipv4NetworksSelect.dispatchEvent(new Event('change'));
                } else {
                    ipv4NetworksSelect.selectedIndex = 0;
                    ipv4NetworksSelect.dispatchEvent(new Event('change'));
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
   
            let currentIpExists = false;
   
            data.availableIpAddresses.forEach(address => {
                const option = document.createElement('option');
                option.value = address.ip;  // Assuming the IP itself is being used as the value
                option.textContent = address.ip;
   
                if (address.ip === currentIp) { 
                    option.selected = true;
                    currentIpExists = true;
                }
   
                ipAddressesSelect.appendChild(option);
            });
   
            // If the current IP does not exist in the list of available IPs, add it manually
            if (!currentIpExists && currentIp) {
                const option = document.createElement('option');
                option.value = currentIp; // Using the IP itself as the value, adjust if necessary
                option.textContent = currentIp;
                option.selected = true;
                ipAddressesSelect.appendChild(option);
            }
        })
        .catch(error => console.error('Error:', error));
    });
   
   
   if (currentRouterId) {
    routerSelect.dispatchEvent(new Event('change'));
   }
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.3/js/standalone/selectize.min.js"></script>
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
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection