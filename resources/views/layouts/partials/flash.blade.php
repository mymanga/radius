<div class="col-lg-12">
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
@if (session('emailsent'))
<div class="alert alert-success alert-dismissible alert-label-icon label-arrow fade show" role="alert">
   <i class="ri-check-double-line label-icon"></i><strong>Success</strong> - {{session('emailsent')}}
   <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif 
@if (session('smssent'))
<div class="alert alert-success alert-dismissible alert-label-icon label-arrow fade show" role="alert">
   <i class="ri-check-double-line label-icon"></i><strong>Success</strong> - {{session('smssent')}}
   <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif 
@if (session('emailfailed'))
<div class="alert alert-danger alert-dismissible alert-label-icon label-arrow fade show mb-xl-0" role="alert">
   <i class="ri-error-warning-line label-icon"></i><strong>Failed</strong>
   - {{session('emailfailed')}}
   <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<br />
@endif
@if (session('smsfailed'))
<div class="alert alert-danger alert-dismissible alert-label-icon label-arrow fade show mb-xl-0" role="alert">
   <i class="ri-error-warning-line label-icon"></i><strong>Failed</strong>
   - {{session('smsfailed')}}
   <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<br />
@endif