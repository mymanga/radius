@extends('layouts.master')

@section('title')
Equity Bank Settings
@endsection

@section('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11">
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
       <div class="card mt-n4 mx-n4">
          <div class="bg-soft-light">
             @include('settings.general.header')
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
      @endif
      @if (session('error'))
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
               <h5 class="card-title mb-0 flex-grow-1"> Equity Bank Settings</h5>
            </div>
         </div>
         <div class="card-body">
            <form class="form-margin" id="equitySettingsForm" action="{{ route('settings.general_save') }}" Method="POST">
               @csrf
               <div class="row mb-3">
                  <div class="col-lg-3">
                     <label for="username" class="form-label">Username</label>
                  </div>
                  <div class="col-lg-9">
                     <input type="text" name="equity_username" value="{{ old('equity_username') ?: setting('equity_username')}}" class="form-control @error('equity_username') is-invalid @enderror" id="equity_username" placeholder="Enter Equity Bank username" readonly>
                     @error('equity_username')
                     <div class="text-danger">{{ $message }}</div>
                     @enderror
                  </div>
               </div>
               <div class="row mb-3">
                  <div class="col-lg-3">
                     <label for="password" class="form-label">Password</label>
                  </div>
                  <div class="col-lg-9">
                     <input type="password" name="equity_password" value="{{ old('equity_password') ?: setting('equity_password')}}" class="form-control @error('equity_password') is-invalid @enderror" id="equity_password" placeholder="Enter Equity Bank password" readonly>
                     @error('equity_password')
                     <div class="text-danger">{{ $message }}</div>
                     @enderror
                  </div>
               </div>
               <div class="row mb-3">
                  <div class="col-lg-3">
                     <label for="billercode" class="form-label">Biller Code</label>
                  </div>
                  <div class="col-lg-9">
                     <input type="text" name="equity_biller_code" value="{{ old('equity_biller_code') ?: setting('equity_biller_code') }}" class="form-control @error('equity_biller_code') is-invalid @enderror" id="equity_biller_code" placeholder="Enter Equity Biller Code" readonly>
                     @error('equity_biller_code')
                     <div class="text-danger">{{ $message }}</div>
                     @enderror
                  </div>
               </div>
               <div class="col-12 text-end">
                  <div class="hstack gap-2 justify-content-end">
                     <button type="button" id="editBtn" class="btn btn-soft-primary"><i class="las la-pencil"></i> Edit</button>
                     <button type="submit" id="submitBtn" class="btn btn-soft-success" style="display: none;"><i class="las la-save"></i> Update</button>
                  </div>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>
@endsection

@section('script')
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById('editBtn').addEventListener('click', function(event) {
        event.preventDefault();
        Swal.fire({
            title: 'Are you sure you want to edit?',
            text: 'You will be able to make changes.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, edit it!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('equity_username').readOnly = false;
                document.getElementById('equity_password').readOnly = false;
                document.getElementById('equity_biller_code').readOnly = false;
                document.getElementById('editBtn').style.display = 'none';
                document.getElementById('submitBtn').style.display = 'inline-block';
            }
        });
    });

    document.getElementById('submitBtn').addEventListener('click', function(event) {
        event.preventDefault();
        Swal.fire({
            title: 'Are you sure you want to save changes?',
            text: 'This action cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, save it!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('equitySettingsForm').submit();
            }
        });
    });
</script>
@endsection

