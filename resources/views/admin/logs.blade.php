@extends('layouts.master') @section('title') Client logs @endsection @section('css')
<link href="{{URL::asset('assets/js/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{URL::asset('assets/css/datatable-custom.css')}}" rel="stylesheet" type="text/css" />
@endsection @section('content') 
@component('components.breadcrumb') @slot('li_1') Admin @endslot @slot('title') Logs @endslot @endcomponent 

<div class="row">
   <div class="col-lg-12">
      @if($errors->any())
      <div class="alert alert-danger">
         <ul>
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
         </ul>
      </div>
      @endif
      @if(session('success'))
      <div class="alert alert-success alert-dismissible alert-label-icon rounded-label fade show" role="alert">
         <i class="ri-check-line label-icon"></i><strong>Success</strong> - {{ session('success') }}
         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      @endif
      @if(session('error'))
      <div class="alert alert-danger alert-dismissible alert-label-icon rounded-label fade show" role="alert">
         <i class="ri-error-warning-line label-icon"></i><strong>Error</strong> - {{ session('error') }}
         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      @endif
      <div class="card">
         <div class="card-body">
            <div>
               <div class="table-responsive table-card mb-1">
                  <table class="table table-nowrap align-middle table-striped" id="logs-table" style="width: 100%;">
                        <thead>
                            <tr class="text-muted text-uppercase">
                                <th>Action</th>
                                <th>Subject</th>
                                <th>Description</th>
                                <th>User</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody class="text-muted"></tbody> 
                    </table>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<!--end col-->
<!--end row-->
@endsection 
@section('script')
<script src="{{ URL::asset('/assets/js/jquery-3.6.1.js')}}"></script>
<script src="{{ URL::asset('/assets/js/datatables/datatables.min.js') }}"></script>
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
<script>
    $(document).ready(function () {
        $('#logs-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route("admin.logs") }}',
                type: 'GET',
            },
            columns: [
                { data: 'action', name: 'action', orderable: false },
                { data: 'subjectType', name: 'subjectType', orderable: false },
                { data: 'description', name: 'description', orderable: false },
                { data: 'admin', name: 'admin', orderable: false },
                { data: 'created_at', name: 'created_at' }, 
            ],
            order: [[4, 'desc']], 
            pageLength: 50,
            responsive: true, 
        });
    });
</script>

@endsection