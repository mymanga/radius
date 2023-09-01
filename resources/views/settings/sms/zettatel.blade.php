<input type="hidden" name="zettatel_gateway" value="zettatel" class="form-control" id="gateway" placeholder="gateway" readonly>
<div class="row mb-3">
   <div class="col-lg-3">
      <label for="sender_id" class="form-label">Sender ID</label>
   </div>
   <div class="col-lg-9">
      <input type="text" name="zettatel_sender_id" value="{{Setting::get('zettatel_sender_id')}}" class="form-control" id="sender_id" placeholder="sender id ">
   </div>
</div>
<div class="row mb-3">
   <div class="col-lg-3">
      <label for="user_id" class="form-label">User ID</label>
   </div>
   <div class="col-lg-9">
      <input type="text" name="zettatel_userid" value="{{Setting::get('zettatel_userid')}}" class="form-control" id="user_id" placeholder="user id ">
   </div>
</div>
<div class="row mb-3">
   <div class="col-lg-3">
      <label for="password" class="form-label">Password</label>
   </div>
   <div class="col-lg-9">
      <input type="text" name="zettatel_password" value="{{Setting::get('zettatel_password')}}" class="form-control" id="password" placeholder="Zettatel password (default: XXXXX)">
   </div>
</div>
<div class="row mb-3">
   <div class="col-lg-3">
      <label for="api_key" class="form-label">API Key</label>
   </div>
   <div class="col-lg-9">
      <input type="text" name="zettatel_api_key" value="{{Setting::get('zettatel_api_key')}}" class="form-control" id="api_key" placeholder="api key">
   </div>
</div>
<div class="col-12 text-end">
   <div class="hstack gap-2 justify-content-end">
      <button type="submit" class="btn btn-soft-success"
         id="add-btn"><i class="las la-save"></i> Save</button>
   </div>
</div>