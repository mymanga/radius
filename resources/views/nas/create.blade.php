@extends('layouts.master') @section('title') create nas @endsection @section('css') @endsection @section('content') @component('components.breadcrumb') @slot('li_1') Nas @endslot @slot('title') Create @endslot
@endcomponent
<!-- .card-->
<div class="row justify-content-center">
    <div class="col-lg-6">
    <form action="{{route('nas.save')}}" method="POST">
        <div class="card">
            <div class="card-header border-bottom-dashed">
                <div class="d-flex align-items-center">
                    <h5 class="card-title mb-0 flex-grow-1"><i class="ri-router-line"></i> Create Nas</h5>
                    <div class="flex-shrink-0"></div>
                </div>
            </div>
            <div class="card-body pt-0">
                
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" id="id-field" />
                        <div class="mb-3" id="modal-id">
                            <label for="nasname" class="form-label">Nas Ip Address</label>
                            <input type="text" name="nasname" id="nasname" class="form-control @error('nasname') is-invalid @enderror" placeholder="Ip address" value="{{old('nasname')}}" />
                            @error('nasname')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="secret" class="form-label">Nas Secret </label>
                            <input type="text" name="secret" id="secret" class="form-control @error('secret') is-invalid @enderror" placeholder="Nas secret" value="{{old('secret')}}" />
                            @error('secret')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="shortname" class="form-label">Nas Shortname </label>
                            <input type="text" name="shortname" id="shortname" class="form-control @error('shortname') is-invalid @enderror" placeholder="Nas Shortname" value="{{old('shortname')}}" />
                            @error('shortname')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="hstack gap-2 justify-content-end">
                            <a href="{{route('nas.index')}}" class="btn btn-light">Cancel</a>
                            <button type="submit" class="btn btn-soft-success" id="add-btn"><i class="las la-save"></i> Save</button>
                        </div>
                    </div>
                
                <!--end modal -->
            </div>
        </div>
        </form>
    </div>
</div>
@endsection @section('script')
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection
