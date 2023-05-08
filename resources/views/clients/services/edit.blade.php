@extends('layouts.master') @section('title')
    edit
    @endsection @section('css')
    @endsection @section('content')
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
                                
                                    <div class="alert alert-danger alert-dismissible alert-label-icon label-arrow fade show mb-xl-0"
                                    role="alert">
                                    <i class="ri-error-warning-line label-icon"></i><strong>Danger</strong>
                                    - If you change PPPoE Password, you will need to update in the client router
                                    too.
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                                
                                <br />
                                <label for="package" class="form-label">Select package</label>
                                {{-- @if(!$service->is_active) --}}
                                    <select name="package" class="form-control">
                                    @foreach ($packages as $package)
                                        <option {{ $package->id == $service->package->id ? 'selected' : '' }}
                                            value="{{ $package->id }}">{{ $package->name }}</option>
                                    @endforeach
                                </select>
                                {{-- @else<select name="package" class="form-control" readonly="readonly">
                                        <option
                                            value="{{ $service->package->id }}">{{ $service->package->name }}</option>
                                </select> --}}
                                {{-- @endif --}}
                                
                                @error('package')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            {{-- <div class="mb-3">
                                <label for="username" class="form-label">PPPoE Username <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="text" name="username" value="{{ $service->username }}" id="username"
                                        class="form-control @error('username') is-invalid @enderror" aria-label="username"
                                        placeholder="Portal login" @if($service->is_active)
                                            readonly="readonly"
                                        @endif />
                                        @if(!$service->is_active)
                                           <button class="btn btn-soft-info" type="button" id="button"
                                        onclick="randomPortalLogin(this)">Generate</button> 
                                        @endif
                                    @error('username')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div> --}}
                            <div class="mb-3">
                                <label for="userpassword" class="form-label">PPPoE Password <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="text" name="password" value="{{ $service->cleartextpassword }}"
                                        id="username" class="form-control @error('password') is-invalid @enderror"
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
                            <div class="mb-3">
                                <label for="userpassword"
                                    class="form-label">{{ $service->is_active ? 'Service is active' : 'Service is inactive' }}
                                    <span class="text-danger">*</span></label>
                                <div class="form-check form-switch form-switch-md mb-3" dir="ltr">
                                    <input type="checkbox" name="is_active" class="form-check-input" id="customSwitchsizemd"
                                        {{ $service->is_active ? 'checked' : '' }}>
                                    @if ($service->is_active)
                                        <label class="form-check-label" for="customSwitchsizemd">Do you want to deactivate
                                            the service?</label>
                                    @else
                                        <label class="form-check-label" for="customSwitchsizemd">Activate service
                                            now?</label>
                                    @endif
                                </div>
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
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection