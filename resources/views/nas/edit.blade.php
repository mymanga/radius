@extends('layouts.master') @section('title') nas details @endsection @section('css') @endsection @section('content') @component('components.breadcrumb') @slot('li_1') Nas @endslot @slot('title') Edit @endslot
@endcomponent
<!-- .card-->
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <h5 class="card-title mb-0 flex-grow-1"><i class="ri-router-line text-info"></i> Edit Nas</h5>
                    <div class="flex-shrink-0"></div>
                </div>
            </div>
            <div class="card-body pt-0">
                <form action="{{route('nas.update')}}" method="POST">
                    @foreach($nas as $n) @csrf
                    <div class="modal-body">
                        <input type="hidden" name="id" value="{{ $n->id }}" />
                        <div class="mb-3" id="modal-id">
                            <label for="nasname" class="form-label">Nas Ip Address</label>
                            <input type="text" name="nasname" id="nasname" class="form-control @error('nasname') is-invalid @enderror" placeholder="Ip address" value="{{$n->nasname ?: old('nasname')}}" />
                            @error('nasname')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="secret" class="form-label">Nas Secret </label>
                            <input type="text" name="secret" id="secret" class="form-control @error('secret') is-invalid @enderror" placeholder="Nas secret" value="{{$n->secret ?: old('secret')}}" />
                            @error('secret')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="secret" class="form-label">Nas Shortname </label>
                            <input type="text" name="shortname" id="shortname" class="form-control @error('shortname') is-invalid @enderror" placeholder="Nas Shortname" value="{{$n->shortname ?: old('shortname')}}" />
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
                            <button type="submit" class="btn btn-primary" id="add-btn"><i class="las la-save"></i> Save</button>
                        </div>
                    </div>
                    @endforeach
                </form>
                <!--end modal -->
            </div>
        </div>
    </div>
</div>
@endsection @section('script')
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection
