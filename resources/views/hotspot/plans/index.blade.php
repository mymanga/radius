@extends('layouts.master') @section('title') hotspot plans @endsection @section('css')
<link href="{{URL::asset('assets/js/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{URL::asset('assets/css/datatable-custom.css')}}" rel="stylesheet" type="text/css" />
@endsection @section('content') 
{{-- @component('components.breadcrumb') @slot('li_1') Hotspot @endslot @slot('title') Plans @endslot @endcomponent  --}}
<div class="page-title-box d-sm-flex align-items-center justify-content-between">
   <h4 class="mb-sm-0 font-size-18">Plans</h4>
   <div class="page-title-right">
      <ol class="breadcrumb m-0">
         <li class="breadcrumb-item"><a href="{{ route('hotspot.index') }}">Hotspot</a></li>
         <li class="breadcrumb-item active"><a href="{{ route('plan.index') }}">Plans</a></li>
      </ol>
   </div>
</div>
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
         - {!! session('error') !!}
         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      <br />
      @endif
      <div class="d-flex align-items-center mb-3">
         <div class="flex-grow-1">
            <h5 class="mb-0 text-uppercase text-muted">Plan List</h5>
         </div>
         <div class="flexshrink-0">
            <button class="btn btn-soft-info add-btn" data-bs-toggle="modal" data-bs-target="#createPlanModal"><i class="ri-gps-line align-bottom me-1"></i> Create Plan</button>
         </div>
      </div>
      <div class="card">
         <div class="card-body">
            <div>
               @if(count($plans))
               <div class="table-responsive table-card mb-1">
                  <table class="table align-middle table-striped" id="datatable" style="width: 100%;">
                     <thead class="table-light text-muted">
                        <tr>
                           <th>ID</th>
                           <th>Title</th>
                           <th>Duration</th>
                           <th>Price</th>
                           <th>Usage</th>
                           <th>Speed Limit</th>
                           <th>Data Limit</th>
                           <th>Created At</th>
                           <th>Updated At</th>
                           <th>Actions</th>
                        </tr>
                     </thead>
                     <tbody class="list form-check-all">
                        @foreach($plans as $plan)
                        <tr class="no-border">
                           <td>{{$plan->id}}</td>
                           <td>{{$plan->title}}</td>
                           <td>{{ $plan->duration ? formatDuration($plan->duration) : '' }}</td>
                           <td>Ksh {{$plan->price}}</td>
                           <td>{{$plan->simultaneous_use_limit}}</td>
                           <td>{{ $plan->speed_limit ? $plan->speed_limit . ' Mbps' : '' }}</td>
                           <td>{{ $plan->data_limit ? formatSizeUnits($plan->data_limit) : '' }}</td>
                           <td>{{$plan->created_at->format('d M Y H:i')}}</td>
                           <td>{{$plan->updated_at->format('d M Y H:i')}}</td>
                           <td>
                              <ul class="list-inline hstack gap-2 mb-0">
                                 <li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Edit">
                                    <a href="{{route('plan.edit',[$plan->id]) }}" class="text-info d-inline-block edit-item-btn">
                                    <i class="ri-pencil-fill fs-16"></i>
                                    </a>
                                 </li>
                                 <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Remove">
                                    <a class="text-danger d-inline-block remove-item-btn" data-bs-toggle="modal" data-id="{{$plan->id}}" data-title="{{$plan->title}}" href="#deleteItem">
                                    <i class="ri-delete-bin-5-fill fs-16"></i>
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
                     <h5 class="mt-2 text-danger">Sorry! No plan found</h5>
                  </div>
               </div>
               @endif
            </div>
            <!-- Create plan modal -->
            <!-- Modal -->
            <div class="modal fade" id="createPlanModal" tabindex="-1" aria-labelledby="createPlanModalLabel" aria-hidden="true">
               <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                     <div class="modal-header p-3 bg-soft-info">
                        <h5 class="modal-title" id="createPlanModalLabel">Create Plan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                     </div>
                     <form action="{{ route('plan.store') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                           <!-- Add form elements here -->
                           <div class="mb-3">
                              <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                              <input type="text" name="title" value="{{ old('title') }}" id="title" class="form-control @error('title') is-invalid @enderror" aria-label="title" placeholder="title" />
                              @error('title')
                              <div class="text-danger">{{ $message }}</div>
                              @enderror
                           </div>
                           <div class="mb-3">
                              <label for="description" class="form-label">Description</label>
                              <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" aria-label="description" placeholder="description">{{ old('description') }}</textarea>
                              @error('description')
                              <div class="text-danger">{{ $message }}</div>
                              @enderror
                           </div>
                           <div class="mb-3">
                              <label for="duration" class="form-label">Duration <code>[Leave blank for unlimited]</code> </label>
                              <div class="input-group">
                                 <input type="number" name="duration" value="{{ old('duration', 0) }}" id="duration" class="form-control @error('duration') is-invalid @enderror" aria-label="duration" />
                                 <select name="duration_unit" id="duration_unit" class="form-select">
                                 <option {{ old('duration_unit') == 'minutes' ? 'selected' : '' }} value="minutes">Minutes</option>
                                 <option {{ old('duration_unit') == 'hours' ? 'selected' : '' }} value="hours">Hours</option>
                                 <option {{ old('duration_unit') == 'days' ? 'selected' : '' }} value="days">Days</option>
                                 </select>
                              </div>
                              @error('duration')
                              <div class="text-danger">{{ $message }}</div>
                              @enderror
                           </div>
                           <div class="mb-3">
                              <label for="data_limit" class="form-label">Total Data Limit</label>
                              <div class="input-group">
                                 <input type="number" name="data_limit" value="{{ old('data_limit', 0) }}" id="data_limit" class="form-control @error('data_limit') is-invalid @enderror" aria-label="data_limit" />
                                 <select name="data_limit_unit" id="data_limit_unit" class="form-select">
                                 <option {{ old('data_limit_unit') == 'MB' ? 'selected' : '' }} value="MB">MB</option>
                                 <option {{ old('data_limit_unit') == 'GB' ? 'selected' : '' }} value="GB">GB</option>
                                 </select>
                              </div>
                              @error('data_limit')
                              <div class="text-danger">{{ $message }}</div>
                              @enderror
                           </div>
                           <!-- From here for validity -->
                           <!-- Add Valid Time Range fields here -->
                           <div class="row">
                              <div class="col">
                                 <div class="mb-3">
                                    <label for="valid_from" class="form-label">Valid From <small>(Time)</small></label>
                                    <div class="input-group">
                                       <input type="text" name="valid_from" id="valid_from" class="form-control @error('valid_from') is-invalid @enderror" data-provider="timepickr" data-default-time="" value="{{ old('valid_from') }}" placeholder="select time" />
                                       <button type="button" class="btn btn-soft-info" onclick="document.getElementById('valid_from').value = ''">Clear</button>
                                    </div>
                                    @error('valid_from')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                 </div>
                              </div>
                              <div class="col">
                                 <div class="mb-3">
                                    <label for="valid_to" class="form-label">Valid To <small>(Time)</small></label>
                                    <div class="input-group">
                                       <input type="text" name="valid_to" id="valid_to" class="form-control @error('valid_to') is-invalid @enderror" data-provider="timepickr" data-default-time="" value="{{ old('valid_to') }}" placeholder="select time" />
                                       <button type="button" class="btn btn-soft-info" onclick="document.getElementById('valid_to').value = ''">Clear</button>
                                    </div>
                                    @error('valid_to')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                 </div>
                              </div>
                           </div>
                           <!-- Add Valid Days field here -->
                           <div class="mb-3">
                              <label for="valid_days" class="form-label">Valid Days <small>(leave blank for all days)</small></label>
                              <div class="row">
                                 @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $index => $day)
                                       @if($index % 2 == 0)
                                          <div class="col-3">
                                       @endif
                                       <div class="form-check">
                                          <input class="form-check-input" type="checkbox" name="valid_days[]" value="{{ $day }}" id="{{ $day }}"
                                             {{ in_array($day, old('valid_days', isset($plan) ? json_decode($plan->valid_days) : []) ?? []) ? 'checked' : '' }}>
                                          <label class="form-check-label" for="{{ $day }}">
                                             {{ $day }}
                                          </label>
                                       </div>
                                       @if($index % 2 == 1 || $index == count(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday']) - 1)
                                          </div>
                                       @endif
                                 @endforeach
                              </div>
                              @error('valid_days')
                                 <div class="text-danger">{{ $message }}</div>
                              @enderror
                           </div>
                           <br>
                           <div class="mb-3">
                              <label for="price" class="form-label">Price <span class="text-danger">*</span></label>
                              <input type="number" name="price" value="{{ old('price', 0.00) }}" step="0.01" id="price" class="form-control @error('price') is-invalid @enderror" aria-label="price" />
                              @error('price')
                              <div class="text-danger">{{ $message }}</div>
                              @enderror
                           </div>
                           <div class="row">
                              <div class="col-md-6">
                                 <div class="mb-3">
                                    <label for="simultaneous_use_limit" class="form-label">Simultaneous Use Limit <span class="text-danger">*</span></label>
                                    <input type="number" name="simultaneous_use_limit" value="{{ old('simultaneous_use_limit', 1) }}" id="simultaneous_use_limit" class="form-control @error('simultaneous_use_limit') is-invalid @enderror" aria-label="simultaneous_use_limit" min="1" pattern="[0-9]+" />
                                    @error('simultaneous_use_limit')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="mb-3">
                                    <label for="speed_limit" class="form-label">Speed Limit <small> - (Mbps)</small></label>
                                    <input type="number" name="speed_limit" value="{{ old('speed_limit') }}" id="speed_limit" class="form-control @error('speed_limit') is-invalid @enderror" aria-label="speed_limit" />
                                    @error('speed_limit')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                 </div>
                              </div>
                           </div>
                           <div class="card bg-soft-warning">
                              <div class="card-body">
                                 <div class="mb-3">
                                    <div class="form-check form-switch form-switch-md mb-3" dir="ltr">
                                       <input type="checkbox" name="offer" class="form-check-input" id="customSwitchoffer" {{ old('offer') ? 'checked' : '' }}>
                                       <label class="form-check-label" for="customSwitchoffer">Is this plan on offer?</label>
                                    </div>
                                 </div>
                                 <div class="mb-3">
                                    <label for="offer_details" class="form-label">Offer Details</label>
                                    <textarea name="offer_details" id="offer_details" class="form-control @error('offer_details') is-invalid @enderror" aria-label="offer_details" placeholder="offer_details">{{ old('offer_details') }}</textarea>
                                    @error('offer_details')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                 </div>
                                 <div class="mb-3">
                                    <label for="discount_rate" class="form-label">Discount Rate (%)</label>
                                    <input type="number" name="discount_rate" value="{{ old('discount_rate', 0.00) }}" step="0.01" min="0" id="discount_rate" class="form-control @error('discount_rate') is-invalid @enderror" aria-label="discount_rate" />
                                    @error('discount_rate')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                 </div>
                              </div>
                           </div>
                           <div class="mb-3">
                              <div class="form-check form-switch form-switch-md mb-3" dir="ltr">
                                 <input type="checkbox" name="public" class="form-check-input" id="customSwitchsizemd" {{ old('public') ? 'checked' : '' }}>
                                 <label class="form-check-label" for="customSwitchsizemd">Public hotspot plan?</label>
                              </div>
                           </div>
                        </div>
                        <div class="modal-footer">
                           {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> --}}
                           <button type="submit" class="btn btn-primary">Save Plan</button>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
            <!-- Delete Modal -->
            <div class="modal fade flip" id="deleteItem" tabindex="-1" aria-hidden="true">
               <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                     <div class="modal-body p-5 text-center">
                        <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#405189,secondary:#f06548" style="width: 90px; height: 90px;"></lord-icon>
                        <div class="mt-4 text-center">
                           <h4>You are about to delete <span class="modal-title"></span> plan!</h4>
                           <p class="text-muted fs-15 mb-4">Deleting a plan will remove all of the information from the database.</p>
                           <div class="hstack gap-2 justify-content-center remove">
                              <button class="btn btn-link link-success fw-medium text-decoration-none" data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i> Close</button>
                              <form action="{{route('plan.delete')}}" method="POST">
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
         </div>
      </div>
   </div>
   <!--end col-->
</div>
<!--end row-->
@endsection 
@section('script')
<script src="{{ URL::asset('/assets/js/jquery-3.6.1.js')}}"></script>
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
<script src="{{ URL::asset('/assets/js/datatables/datatables.min.js') }}"></script>
<script src="{{ URL::asset('/assets/js/datatable.js') }}"></script>
@if (count($errors) > 0 && $errors->has('title') || $errors->has('duration') || $errors->has('duration_unit') || $errors->has('price'))
<script type="text/javascript">
   $(document).ready(function () {
       $("#createPlanModal").modal("show");
   });
</script>
@endif
@endsection