<input type="hidden" name="mspace_gateway" value="mspace" class="form-control" id="gateway" placeholder="gateway" readonly>
<div class="row mb-3">
   <div class="col-lg-3">
      <label for="username" class="form-label">Username</label>
   </div>
   <div class="col-lg-9">
      <input type="text" name="mspace_username" value="{{Setting::get('mspace_username')}}" class="form-control" id="username" placeholder="username">
   </div>
</div>
<div class="row mb-3">
   <div class="col-lg-3">
      <label for="password" class="form-label">Password</label>
   </div>
   <div class="col-lg-9">
      <input type="text" name="mspace_password" value="{{Setting::get('mspace_password')}}" class="form-control" id="password" placeholder="password">
   </div>
</div>
<div class="row mb-3">
   <div class="col-lg-3">
      <label for="sender_id" class="form-label">Sender ID</label>
   </div>
   <div class="col-lg-9">
      <input type="text" name="mspace_sender_id" value="{{Setting::get('mspace_sender_id')}}" class="form-control" id="sender_id" placeholder="sender id ">
   </div>
</div>
<div class="col-12 text-end">
   <div class="hstack gap-2 justify-content-end">
      <button type="submit" class="btn btn-soft-success"
         id="add-btn"><i class="las la-save"></i> Save</button>
   </div>
</div>