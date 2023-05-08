@extends('layouts.master') @section('title') transactions @endsection @section('css')
<link href="{{URL::asset('assets/js/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{URL::asset('assets/css/datatable-custom.css')}}" rel="stylesheet" type="text/css" />
@endsection @section('content') 
{{-- @component('components.breadcrumb') @slot('li_1') Account @endslot @slot('title') settings @endslot @endcomponent --}}
<div class="page-title-box d-sm-flex align-items-center justify-content-between">
   <h4 class="mb-sm-0 font-size-18">Transactions</h4>
   <div class="page-title-right">
      <ol class="breadcrumb m-0">
         <li class="breadcrumb-item"><a href="{{ route('billing.index') }}">Finance</a></li>
         <li class="breadcrumb-item active"><a href="{{ route('billing.transactions') }}">Transactions</a></li>
      </ol>
   </div>
</div>
<div class="row">
     @include('layouts.partials.flash')
      <div class="card">
         <div class="card-body">
            @if(!empty($transactions))
               <div class="table-responsive table-card mb-1">
                  <table class="table table-nowrap align-middle table-striped" id="datatable" style="width: 100%;">
                        <thead class="text-muted table-light">
                           <tr>
                                <th>ID</th>
                                <th>User</th>
                                <th>Type</th>
                                <th>Amount</th>
                                <th>Meta</th>
                                <th>Unique ID</th>
                                <th>Created At</th>
                            </tr>
                        </thead>
                        <tbody class="list form-check-all">
                           @foreach ($transactions as $transaction)
                            <tr>
                                <td>{{ $transaction->id }}</td>
                                <td>{{ $transaction->user->firstname . ' ' . $transaction->user->lastname }}</td>
                                <td><span class="badge badge-soft-{{ $transaction->type == 'deposit' ? 'success' : 'info' }} badge-border text-uppercase">{{$transaction->type}}</span></td>
                                <td>Ksh {{ $transaction->amount }}</td>
                                <td>
                                    @if ($transaction->meta)
                                        @php $meta = json_decode($transaction->meta, true) @endphp
                                        <strong>Title:</strong> {{ $meta['title'] ?? 'N/A' }}<br>
                                        <strong>Description:</strong> {{ $meta['description'] ?? 'N/A' }}
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>{{ $transaction->uuid }}</td>
                                <td>{{ $transaction->created_at }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                  </table>
               </div>
            @else
               <div class="noresult" style="display: block;">
                  <div class="text-center">
                        <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop" colors="primary:#121331,secondary:#08a88a" style="width: 75px; height: 75px;"> </lord-icon>
                        <h5 class="mt-2 text-danger">Sorry! No transaction Found</h5>
                        <p class="text-muted mb-0">We cant find an record</p>
                  </div>
               </div>
            @endif

         </div>
      </div>
   </div>
   <!--end col-->
</div>

<!--end row-->
@endsection @section('script')
<script src="{{ URL::asset('/assets/js/jquery-3.6.1.js')}}"></script>
<script src="{{ URL::asset('/assets/js/datatables/datatables.min.js') }}"></script>
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
<script src="{{ URL::asset('/assets/js/datatable.js') }}"></script>
@endsection