<div class="avatar-lg mx-auto mt-2">
   <div class="avatar-title bg-light text-muted display-3 rounded-circle">
      <i class="ri-key-2-fill"></i>
   </div>
</div>
<div class="text-center mt-2">
   <h5 class="text-info">Activate License</h5>
   @if (session('status'))
   <div class="alert alert-success alert-border-left alert-dismissible fade show" role="alert">
      <i class="ri-notification-off-line me-3 align-middle"></i> {{ ucfirst(session('status')) }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
   </div>
   @endif 
   @if (session('error'))
   <div class="alert alert-danger alert-border-left alert-dismissible fade show" role="alert">
      <i class="ri-error-warning-line me-3 align-middle"></i> {{ ucfirst(session('error')) }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
   </div>
   @endif
</div>
<div class="p-2 mt-4">
   <form action="{{ route('activate_license') }}" method="POST">
      @csrf
      <div class="mb-3">
         <label for="license_code" class="form-label">License Code</label>
         <input type="text" class="form-control {{ $errors->has('license') ? ' is-invalid' : '' }}" value="{{ old('license')}}" id="license" name="license" placeholder="Enter Purchase licence">
         @error('license')
         <div class="text-danger">{{ $message }}</div>
         @enderror
      </div>
      <div class="mb-3">
         <label for="name" class="form-label">Licensed client Name</label>
         <input type="text" class="form-control {{ $errors->has('client') ? ' is-invalid' : '' }}" value="{{ old('client')}}" id="client" name="client" placeholder="Enter licenced client name">
         @error('client')
         <div class="text-danger">{{ $message }}</div>
         @enderror
      </div>
      <br>
      <div class="col-12">
         <div class="hstack gap-2 justify-content-end">
            <button type="submit" class="btn btn-soft-info w-100"
               id="submit"> Activate</button>
         </div>
      </div>
   </form>
</div>