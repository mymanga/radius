@extends('layouts.master')

@section('title')
    nas login
@endsection

@section('css')
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1') Nas @endslot
        @slot('title') Config @endslot
    @endcomponent

    <!-- .card-->
    <div class="row justify-content-center">
    
        <div class="col-lg-8">
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
            <div class="card">
                <div class="card-header border-bottom-dashed">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1"><i class="ri-router-line"></i> {{$nas->shortname}}</h5>
                        <div class="flex-shrink-0"></div>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <form action="{{route('nas.config',['nas'=>$nas->id])}}" method="POST" id="configForm">
                        @csrf
                        <input type="hidden" name="id" id="id"/>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username </label>
                                <input type="text" name="username" id="username" class="form-control @error('username') is-invalid @enderror" placeholder="Current username" value="{{old('username')}}" />
                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password </label>
                                <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Current password" />
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class="hstack gap-2 justify-content-end">
                                <a href="{{route('nas.index')}}" class="btn btn-light">Cancel</a>
                                <button type="submit" class="btn btn-soft-success" id="loading"><i class="ri-login-circle-fill"></i> Connect</button>
                            </div>
                        </div>
                        <small class="text-muted">Connect to the router using the current username and password</small>
                    </form>
                    <!--end modal -->
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
    // Function to show a loading screen
    function showLoadingScreen() {
        Swal.fire({
            title: 'Configuring Router...',
            text: 'Please wait while the router is being configured.',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
    }

    // Function to hide the loading screen
    function hideLoadingScreen() {
        Swal.close();
    }

    // Add an event listener to the form submission
    document.getElementById('configForm').addEventListener('submit', function (event) {
        // Show the loading screen before form submission
        showLoadingScreen();
    });
</script>

@endsection
