@extends('layouts.master')
@section('title') edit tariff @endsection
@section('css')
@endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Tariff plans @endslot
@slot('title') Edit @endslot
@endcomponent
<!-- .card-->
<div class="row justify-content-center">
   <div class="col-lg-8">
      <div class="card" id="orderList">
         <div class="card-header border-bottom-dashed">
            <div class="d-flex align-items-center">
               <h5 class="card-title mb-0 flex-grow-1"><i class="ri-gps-line"></i> Edit {{$package->name}} Tarrif</h5>
               <div class="flex-shrink-0">
               </div>
            </div>
         </div>
         <div class="card-body">
            <form class="row g-3" action="{{route('tariff.update',[$package->id])}}" method="POST">
               @csrf
               @method('put')
               
               <div class="col-md-6">
                  <label for="name" class="form-label">Title</label>
                  <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                     placeholder="tarrif name" value="{{$package->name}}" required/>
                  @error('name')
                  <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                  </span>
                  @enderror
               </div>
               <div class="col-md-6">
                  <label for="type" class="form-label">Type
                     <i class="ri-question-line text-info" data-bs-toggle="tooltip" data-bs-placement="top" title="Enter the type of tariff."></i>
                  </label>
                  <select name="type" id="type" class="form-select @error('type') is-invalid @enderror" required>
                     <option value="home" {{ $package->type == 'home' ? 'selected' : '' }}>Home package</option>
                     <option value="business" {{ $package->type == 'business' ? 'selected' : '' }}>Business Package</option>
                     {{-- <option value="Enterprise" {{ $package->type == 'Enterprise' ? 'selected' : '' }}>Enterprise</option> --}}
                  </select>
                  @error('type')
                  <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                  </span>
                  @enderror
               </div>
               <div class="col-md-6">
                  <label for="upgrade" class="form-label">Upgrade option</label>
                  <div class="form-check form-switch form-switch-md">
                     <input class="form-check-input" type="checkbox" name="customer_upgrade" id="customer_upgrade" value="1" {{ $package->customer_upgrade ? 'checked' : '' }}>
                     <label class="form-check-label" for="upgrade">
                        Available in customer portal
                     </label>
                  </div>
               </div>
               <div class="col-md-6">
                  <label for="price" class="form-label">Price
                  </label>
                  <input type="number" name="price" id="price"
                     class="form-control @error('price') is-invalid @enderror" placeholder="Tarrif price" value="{{$package->price}}"
                      required/>
                  @error('price')
                  <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                  </span>
                  @enderror
               </div>
               <div class="col-md-6">
                  <label for="download" class="form-label">Download speed
                  </label>
                  <div class="input-group">
                     <input type="number" name="download" id="download" value="{{$package->download}}" class="form-control @error('download') is-invalid @enderror" placeholder="download speed" aria-label="Download speed" required>
                     <span class="input-group-text" id="basic-addon2">kbps</span>
                     @error('download')
                     <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                     </span>
                     @enderror
                  </div>
               </div>
               <div class="col-md-6">
                  <label for="upload" class="form-label">upload speed
                  </label>
                  <div class="input-group">
                     <input type="number" name="upload" id="upload" value="{{$package->upload}}" class="form-control @error('upload') is-invalid @enderror" placeholder="upload speed" aria-label="upload speed" required>
                     <span class="input-group-text" id="basic-addon2">kbps</span>
                     @error('upload')
                     <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                     </span>
                     @enderror
                  </div>
               </div>
               <div class="col-md-6">
                  <label for="BD" class="form-label">Burst download speed
                  </label>
                  <div class="input-group">
                     <input type="number" name="burst_download" id="BD" value="{{$package->burst_download}}" class="form-control @error('burst_download') is-invalid @enderror" placeholder="burst download speed" aria-label="burst download speed" required>
                     <span class="input-group-text" id="basic-addon2">kbps</span>
                     @error('burst_download')
                     <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                     </span>
                     @enderror
                  </div>
               </div>
               <div class="col-md-6">
                  <label for="BU" class="form-label">Burst upload speed
                  </label>
                  <div class="input-group">
                     <input type="number" name="burst_upload" id="BU" value="{{$package->burst_upload}}" class="form-control @error('burst_upload') is-invalid @enderror" placeholder="burst upload speed" aria-label="burst upload speed" required>
                     <span class="input-group-text" id="basic-addon2">kbps</span>
                     @error('burst_upload')
                     <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                     </span>
                     @enderror
                  </div>
               </div>
               <div class="col-md-6">
                  <label for="BTD" class="form-label">Burst threshold download
                  </label>
                  <div class="input-group">
                     <input type="number" name="burst_threshold_download" id="BTD" value="{{$package->burst_threshold_download}}" class="form-control @error('burst_threshold_download') is-invalid @enderror" placeholder="burst threshold download" aria-label="burst threshold download" required>
                     <span class="input-group-text" id="basic-addon2">kbps</span>
                     @error('burst_threshold_download')
                     <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                     </span>
                     @enderror
                  </div>
               </div>
               <div class="col-md-6">
                  <label for="BTU" class="form-label">Burst threshold upload
                  </label>
                  <div class="input-group">
                     <input type="number" name="burst_threshold_upload" id="BTU" value="{{$package->burst_threshold_upload}}" class="form-control @error('burst_threshold_upload') is-invalid @enderror" placeholder="burst threshold upload" aria-label="burst threshold upload" required>
                     <span class="input-group-text" id="basic-addon2">kbps</span>
                     @error('burst_threshold_upload')
                     <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                     </span>
                     @enderror
                  </div>
               </div>
               <div class="col-md-6">
                  <label for="BT" class="form-label">Burst time
                  </label>
                  <div class="input-group">
                     <input type="number" name="burst_time" id="BT" value="{{$package->burst_time}}" class="form-control @error('burst_time') is-invalid @enderror" placeholder="burst time" aria-label="burst time" required>
                     <span class="input-group-text" id="basic-addon2">seconds</span>
                     @error('burst_time')
                     <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                     </span>
                     @enderror
                  </div>
               </div>
               <div class="col-md-6">
                  <label for="aggregation" class="form-label">Aggregation
                  </label>
                  <div class="input-group">
                  <span class="input-group-text" id="basic-addon2"><b>1 :</b></span>
                     <input type="number" name="aggregation" id="aggregation" value="{{old('aggregation') ? old('aggregation') : $package->aggregation}}" min="1" max="10" class="form-control @error('aggregation') is-invalid @enderror" aria-label="aggregation" required>
                     
                     @error('aggregation')
                     <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                     </span>
                     @enderror
                  </div>
               </div>
               <div class="col-12">
                  <div class="hstack gap-2 justify-content-end">
                     <a href="{{route('tariff.index')}}" class="btn btn-light w-50">Cancel</a>
                     <button type="submit" class="btn btn-soft-success w-50"
                        id="add-btn"><i class="las la-save"></i> Save</button>
                  </div>
               </div>
            </form>
            <!--end modal -->
         </div>
      </div>
   </div>
</div>
@endsection
@section('script')
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection