@extends('layouts.master') @section('title') messages @endsection @section('css')

@endsection @section('content') 
<div class="row">
   <div class="col-lg-12">
      <div class="card mt-n4 mx-n4">
         <div class="bg-soft-light">
            @include('support.header')
            <!-- end card body -->
         </div>
      </div>
      <!-- end card -->
   </div>
   <!-- end col -->
</div>

<div class="row justify-content-center">
   <div class="col-lg-8">
      @if (session('status'))
      <div class="alert alert-success alert-dismissible alert-label-icon label-arrow fade show" role="alert">
         <i class="ri-check-double-line label-icon"></i><strong>Success</strong> - {{session('status')}}
         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      @endif @if (session('error'))
      <div class="alert alert-danger alert-dismissible alert-label-icon label-arrow fade show mb-xl-0" role="alert">
         <i class="ri-error-warning-line label-icon"></i><strong>Failed</strong>
         - {{session('error')}}
         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      <br />
      @endif
      <div class="card">
         <div class="card-header border-bottom-dashed bg-soft-warning">
            <div class="d-flex align-items-center">
               <h5 class="card-title mb-0 flex-grow-1"><i class="ri-mail-line"></i> Imap Mail config</h5>
               <div class="flex-shrink-0">
               </div>
            </div>
         </div>
         <div class="card-body">
           <form class="form-margin" action="{{route('support.mail_save')}}" method="POST">
   @csrf
   <div class="row mb-3">
      <div class="col-lg-3">
         <label for="supportMailHost" class="form-label">Mail Host</label>
      </div>
      <div class="col-lg-9">
         <input type="text" name="support_host" value="{{Setting::get('support_host')}}" class="form-control @error('support_host') is-invalid @enderror" id="supportMailHost" placeholder="Enter email host">
         @error('support_host')
         <span class="invalid-feedback" role="alert">
         <strong>{{ $message }}</strong>
         </span>
         @enderror
      </div>
   </div>
   <div class="row mb-3">
      <div class="col-lg-3">
         <label for="supportMailUsername" class="form-label">Mail Username</label>
      </div>
      <div class="col-lg-9">
         <input type="text" name="support_username" value="{{Setting::get('support_username')}}" class="form-control @error('support_username') is-invalid @enderror" id="supportMailUsername" placeholder="Enter email username">
         @error('support_username')
         <span class="invalid-feedback" role="alert">
         <strong>{{ $message }}</strong>
         </span>
         @enderror
      </div>
   </div>
   <div class="row mb-3">
      <div class="col-lg-3">
         <label for="supportMailPassword" class="form-label">Mail Password</label>
      </div>
      <div class="col-lg-9">
         <input type="text" name="support_password" value="{{Setting::get('support_password')}}" class="form-control @error('support_password') is-invalid @enderror" id="supportMailPassword" placeholder="Enter email password">
         @error('support_password')
         <span class="invalid-feedback" role="alert">
         <strong>{{ $message }}</strong>
         </span>
         @enderror
      </div>
   </div>
   <div class="row mb-3">
      <div class="col-lg-3">
         <label for="supportMailFromAddress" class="form-label">Mail From Address</label>
      </div>
      <div class="col-lg-9">
         <input type="email" name="support_from_address" value="{{Setting::get('support_from_address')}}" class="form-control @error('support_from_address') is-invalid @enderror" id="supportMailFromAddress" placeholder="Enter email address">
         @error('support_from_address')
         <span class="invalid-feedback" role="alert">
         <strong>{{ $message }}</strong>
         </span>
         @enderror
      </div>
   </div>
   <div class="row mb-3">
      <div class="col-lg-3">
         <label for="supportMailFromName" class="form-label">Mail From Name</label>
      </div>
      <div class="col-lg-9">
         <input type="text" name="support_from_name" value="{{Setting::get('support_from_name') !== null ? Setting::get('support_from_name') : Setting::get('company')}}" class="form-control @error('support_from_name') is-invalid @enderror" id="supportMailFromName" placeholder="Enter name">
         @error('support_from_name')
         <span class="invalid-feedback" role="alert">
         <strong>{{ $message }}</strong>
         </span>
         @enderror
      </div>
   </div>
   <div class="col-12 text-end">
      <div class="hstack gap-2 justify-content-end">
         <button type="submit" class="btn btn-soft-success" id="add-btn">
            <i class="las la-save"></i> Save
         </button>
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
    <script src="{{ URL::asset('/assets/js/jquery-3.6.1.js')}}"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection