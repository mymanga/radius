@extends('layouts.master')
@section('title') 
reports
@endsection
@section('css')
@endsection
@section('content')
{{-- @component('components.breadcrumb')
@slot('li_1') Finance @endslot
@slot('title') Reports @endslot
@endcomponent --}}
<div class="page-title-box d-sm-flex align-items-center justify-content-between">
   <h4 class="mb-sm-0 font-size-18">Reports</h4>
   <div class="page-title-right">
      <ol class="breadcrumb m-0">
         <li class="breadcrumb-item"><a href="{{ route('billing.index') }}">Finance</a></li>
         <li class="breadcrumb-item active"><a href="{{ route('billing.report') }}">Report</a></li>
      </ol>
   </div>
</div>
<!-- .card-->
<div class="row justify-content-center">
   <div class="col-lg-8">
      <div class="card">
         <div class="card-body p-0">
            <div class="tab-content p-0">
               <div class="tab-pane active" id="report" role="tabpanel">
                  <div class="p-3 bg-soft-warning">
                     <h6 class="mb-0 text-danger text-center">CREATE TRANSACTIONS REPORTS</h6>
                  </div>
                  <form action="{{ route('billing.report') }}" method="POST">
                     @csrf
                     <div class="p-3">
                        <div class="row">
                           <div class="col-md-6">
                              <div class="mb-3">
                                 <label>Start Date :</label>
                                 <input class="form-control @error('start_date') is-invalid @enderror" type="text" id="start_date" name="start_date" data-provider="flatpickr" placeholder="start date" value="{{old('start_date')}}">
                                 @error('start_date')
                                 <span class="invalid-feedback" role="alert">
                                 <strong>{{ $message }}</strong>
                                 </span>
                                 @enderror
                              </div>
                           </div>
                           <!-- end col -->
                           <div class="col-md-6">
                              <div class="mb-3">
                                 <label>End Date :</label>
                                 <input class="form-control @error('end_date') is-invalid @enderror" type="text" id="end_date" name="end_date" data-provider="flatpickr" placeholder="end date" value="{{old('end_date')}}">
                                 @error('end_date')
                                 <span class="invalid-feedback" role="alert">
                                 <strong>{{ $message }}</strong>
                                 </span>
                                 @enderror
                              </div>
                           </div>
                           <!-- end col -->
                           <div class="col-md-12">
                              <div class="mb-3">
                                 <label>Select Report Model :</label>
                                 <select id="model" name="model" class="form-control @error('model') is-invalid @enderror" data-choices required>
                                    <option value="Payment">M-Pesa</option>
                                    <option value="Transaction">Transactions</option>
                                 </select>
                                 @error('model')
                                 <span class="invalid-feedback" role="alert">
                                 <strong>{{ $message }}</strong>
                                 </span>
                                 @enderror
                              </div>
                           </div>

                           <div id="transaction-type" style="display:none;">
                                <div class="mb-3">
                                    <label>Transaction type:</label>
                                    <select id="transaction-type" name="transaction_type" class="form-control" data-choices>
                                        <option value="deposit">Deposit</option>
                                        <option value="withdraw">Payment</option>
                                    </select>
                                </div>
                            </div>
                           <!-- end col -->
                        </div>
                        <!-- end row -->
                        <div class="mt-3 pt-2">
                           <button type="submit" class="btn btn-primary w-100">Generate Report</button>
                        </div>
                     </div>
                  </form>
               </div>
               <!-- end tabpane -->
            </div>
            <!-- end tab pane -->
         </div>
         <!-- end card body -->
      </div>
      <!-- end card -->
   </div>
   <!-- end col -->
</div>
@endsection
@section('script')
<script src="{{ URL::asset('/assets/js/jquery-3.6.1.js')}}"></script>
<script src="{{asset('assets/js/app.js')}}"></script>
<script>
    $(document).ready(function() {
        $('#model').on('change', function() {
            if ($(this).val() == 'Transaction') {
                $('#transaction-type').show();
            } else {
                $('#transaction-type').hide();
            }
        });
    });
</script>
@endsection