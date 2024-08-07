@extends('layouts.master') @section('title') Customer - Invoices @endsection @section('css')
<link href="{{URL::asset('assets/js/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{URL::asset('assets/css/datatable-custom.css')}}" rel="stylesheet" type="text/css" />
<style>
   table.dataTable thead th, 
   table.dataTable thead td {
   border-top: none !important;
   border-bottom: 1px solid #eee !important;
   }
   table.dataTable {
   border-bottom: none !important;
   }
   /* Styles for dark layout mode */
   [data-layout-mode=dark] table.dataTable thead th, 
   table.dataTable thead td {
   border-bottom: 1px solid #32383e !important;
   }
   table.dataTable > tbody > tr.child ul.dtr-details > li {
   border-bottom: none !important;
   }
</style>
@endsection 
@section('content') 
@component('components.breadcrumb') @slot('li_1') Customer @endslot @slot('title') Invoices @endslot @endcomponent

<div class="row">
    <div class="col-lg-12">
    <div class="card card-height-100">
         <!-- end card header -->
         <div class="card-body">
            <div class="table-responsive table-card">
               <table
                  class="table table-hover table-borderless table-centered align-middle table-nowrap mb-0" id="datatable" style="width:100%">
                  <thead class="text-muted bg-light-subtle">
                     <tr>
                     <th>#</th>
                        <th>Invoice Number</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Due Date</th>
                        <th>View</th>
                     </tr>
                  </thead>
                  <!-- end thead -->
                  <tbody>
                  @foreach($invoices as $invoice)
                     <tr class="no-border @if ($invoice->creditnotes->count() > 0) striped @endif">
                        <td>{{ $invoice->id }}</td>
                        <td class="invoice-number"><a href="{{ route('invoice.show', [$invoice->invoice_number]) }}" class="text-info" target="_blank">{{$invoice->invoice_number}}</a></td>
                        <td class="amount">
                           <div class="original-amount" style="{{$invoice->creditnotes->count() > 0 ? 'text-decoration: line-through;' : ''}}">
                              Ksh {{$invoice->amount}}
                           </div>
                           @if($invoice->creditnotes->count() > 0)
                           <div class="adjusted-amount">
                              Ksh {{$invoice->adjusted_amount}}
                           </div>
                           @endif
                        </td>
                        <td class="status"><span class="badge badge-label {{ $invoice->status_class }}"><i class="mdi mdi-circle-medium"></i> {{ ucfirst($invoice->status) }}</span></td>
                        <td class="due-date">
                           @if ($invoice->status != 'paid' && $invoice->due_date < now())
                           <span class="badge bg-soft-danger text-danger">Overdue</span>
                           @elseif ($invoice->status != 'paid')
                           {{ $invoice->due_date }}
                           @endif
                        </td>
                        <td>
                           <a href="{{ route('invoice.show', [$invoice->invoice_number]) }}" class="btn btn-soft-info btn-sm"><i class="ri-eye-2-line"></i> View</a>
                        </td>
                     </tr>
                     @endforeach
                  </tbody>
                  <!-- end tbody -->
               </table>
               <!-- end table -->
            </div>
            <!-- end tbody -->
         </div>
         <!-- end cardbody -->
      </div>
    </div>
</div>

<!--end row-->
@endsection @section('script')
<script src="{{ URL::asset('/assets/js/jquery-3.6.1.js')}}"></script>
<script src="{{ URL::asset('/assets/js/datatables/datatables.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.9/dist/sweetalert2.all.min.js"></script>
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
{{-- <script src="{{ URL::asset('/assets/js/datatable.js') }}"></script> --}}
<script>
   $(document).ready(function () {
    $('#datatable').DataTable({
        responsive: true,
        deferRender: true,
        "lengthMenu": [20, 50, 100],
        "pageLength": 50,
        "order": [[0, 'desc']], // Order by the fourth column (index 3) in descending order
        language: {
            paginate: {
                next: '&#8594;', // or '→'
                previous: '&#8592;' // or '←'
            }
        },
    });
   });
</script>
@endsection