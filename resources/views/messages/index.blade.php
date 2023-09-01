@extends('layouts.master') @section('title') messages @endsection @section('css')
<link href="{{URL::asset('assets/js/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{URL::asset('assets/css/datatable-custom.css')}}" rel="stylesheet" type="text/css" />
<style>
    /* Adjust the white-space property for the message cell */
    .message-cell {
        white-space: normal;
        overflow: hidden;
    }
</style>
@endsection @section('content') 
{{-- @component('components.breadcrumb') @slot('li_1') Clients @endslot @slot('title') Messages @endslot @endcomponent  --}}
<div class="page-title-box d-sm-flex align-items-center justify-content-between">
   <h4 class="mb-sm-0 font-size-18">Messages</h4>
   <div class="page-title-right">
      <ol class="breadcrumb m-0">
         <li class="breadcrumb-item"><a>Crm</a></li>
         <li class="breadcrumb-item active"><a href="{{ route('message.index') }}">Messages</a></li>
      </ol>
   </div>
</div>
<div class="row">
   <div class="col-lg-12">
      @if (session('status'))
      <div class="alert alert-success alert-dismissible alert-label-icon label-arrow fade show" role="alert">
         <i class="ri-check-double-line label-icon"></i><strong>Success</strong> - {!! session('status') !!}
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
            <h5 class="mb-0 text-uppercase text-muted">Message List</h5>
         </div>
         <div class="flexshrink-0">
         @can('send message')
            <a href="{{route('message.create')}}" class="btn btn-soft-info btn-md"><i class="ri-add-line align-bottom me-1"></i> Simple message</a>
         @endcan
         @can('send bulk message')
            <a href="{{route('message.bulk')}}" class="btn btn-soft-success btn-md"><i class="ri-add-line align-bottom me-1"></i> Bulk messages</a>
         @endcan
         </div>
      </div>
      <div class="card">
         <div class="card-body">
            <div>
               <div class="table-responsive table-card mb-1">
                  <table class="table table-nowrap align-middle table-striped" id="datatable" style="width: 100%;">
                     <thead class="table-light text-muted">
                        <tr class="text-uppercase">
                           <th>ID</th>
                           <th>User</th>
                           <th>Sender</th>
                           <th>Message</th>
                           <th>Gateway</th>
                           <th>Created At</th>
                        </tr>
                     </thead>
                     <tbody class="list form-check-all">
                     </tbody>
                  </table>
               </div>
            </div>
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
<script src="{{ URL::asset('/assets/js/servertable.js') }}"></script>

<script>
    var url = '{{ route("message.index") }}';
    var columns = [
        { data: 'id', orderable: false },
        { data: 'user', orderable: false },
        { data: 'sender', orderable: false },
        { 
            data: 'message',
            orderable: false,
            render: function(data, type, row) {
                // Wrap the message in a div with the message-cell class
                return '<div class="message-cell">' + data + '</div>';
            }
        },
        { data: 'gateway', orderable: false },
        { data: 'created_at', orderable: false },
    ];
    renderTable(url, columns);
</script>
@endsection