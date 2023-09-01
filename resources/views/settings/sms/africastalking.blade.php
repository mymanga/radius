<input type="hidden" name="africastalking_gateway" value="Africastalking" class="form-control" id="gateway" placeholder="gateway" readonly>
<div class="row mb-3">
   <div class="col-lg-3">
      <label for="sender_id" class="form-label">Sender ID</label>
   </div>
   <div class="col-lg-9">
      <input type="text" name="africastalking_sender_id" value="{{Setting::get('africastalking_sender_id')}}" class="form-control" id="sender_id" placeholder="sender id ">
   </div>
</div>
<div class="row mb-3">
   <div class="col-lg-3">
      <label for="username" class="form-label">Username</label>
   </div>
   <div class="col-lg-9">
      <input type="text" name="africastalking_username" value="{{Setting::get('africastalking_username')}}" class="form-control" id="username" placeholder="username">
   </div>
</div>
<div class="row mb-3">
   <div class="col-lg-3">
      <label for="api_key" class="form-label">API Key</label>
   </div>
   <div class="col-lg-9">
      <input type="text" name="africastalking_api_key" value="{{Setting::get('africastalking_api_key')}}" class="form-control" id="api_key" placeholder="api key">
   </div>
</div>
<div class="col-12 text-end">
   <div class="hstack gap-2 justify-content-end">
      <button type="submit" class="btn btn-soft-success"
         id="add-btn"><i class="las la-save"></i> Save</button>
   </div>
</div>