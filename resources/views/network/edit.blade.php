@extends('layouts.master') @section('title') network @endsection @section('css')
<link href="{{URL::asset('assets/js/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{URL::asset('assets/css/datatable-custom.css')}}" rel="stylesheet" type="text/css" />
@endsection @section('content') @component('components.breadcrumb') @slot('li_1') IPv4 @endslot @slot('title') Network @endslot @endcomponent 
<div class="row justify-content-center">
   <div class="col-lg-6">
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
         <div class="card-header border-bottom-dashed bg-soft-warning">
            <div class="d-flex align-items-center">
               <h5 class="card-title mb-0 flex-grow-1"><i class="ri-notification-badge-fill text-success"></i> Edit Network</h5>
            </div>
         </div>
         <div class="card-body">
            <form action="{{ route('network.update', $network->id) }}" method="POST">
               @csrf
               @method('PUT')
               <div class="modal-body">
                  @foreach ([
                  ['type' => 'text', 'name' => 'network', 'label' => 'NETWORK', 'placeholder' => 'xxx.xxx.xxx.xxx', 'example' => '(192.168.0.0)', 'value' => old('network', $network->network)],
                  ['type' => 'text', 'name' => 'title', 'label' => 'TITLE', 'placeholder' => 'title', 'example' => null, 'value' => old('title', $network->title)],
                  ['type' => 'textarea', 'name' => 'comment', 'label' => 'COMMENT', 'placeholder' => null, 'example' => null, 'value' => old('comment', $network->comment)],
                  ] as $field)
                  <div class="mb-3">
                     <label for="{{ $field['name'] }}" class="form-label text-muted">{{ $field['label'] }} @if($field['example'])<code>Example: {{ $field['example'] }}</code>@endif</label>
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
                           <option value="{{ $subnet }}" {{ old('subnet', $network->subnet) == $subnet ? 'selected' : '' }}>{{ $subnet }} ({{ $hosts }})</option>
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
                        <option value="{{ $nas->id }}" {{ old('nas', $network->nas_id) == $nas->id ? 'selected' : '' }}>{{ $nas->shortname }} - <code>{{ $nas->nasname }}</code></option>
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
                     <button type="submit" class="btn btn-soft-info" id="update-btn"><i class="las la-save"></i> Update</button>
                  </div>
               </div>
            </form>
         </div>
      </div>
   </div>
   <!--end col-->
</div>
@endsection @section('script')
<script src="{{ URL::asset('/assets/js/jquery-3.6.1.js')}}"></script>
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection