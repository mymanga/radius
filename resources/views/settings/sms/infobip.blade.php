<input type="hidden" name="infobip_gateway" value="Infobip" class="form-control" id="gateway" placeholder="gateway" readonly>
<div class="row mb-3">
   <div class="col-lg-3">
      <label for="sender_id" class="form-label">Sender ID</label>
   </div>
   <div class="col-lg-9">
      <input type="text" name="infobip_sender_id" value="{{Setting::get('infobip_sender_id')}}" class="form-control" id="sender_id" placeholder="sender id ">
   </div>
</div>
<div class="row mb-3">
   <div class="col-lg-3">
      <label for="api_key" class="form-label">API Key</label>
   </div>
   <div class="col-lg-9">
      <input type="text" name="infobip_api_key" value="{{Setting::get('infobip_api_key')}}" class="form-control" id="api_key" placeholder="api key">
   </div>
</div>
<div class="row mb-3">
   <div class="col-lg-3">
      <label for="base_url" class="form-label">Base URL</label>
   </div>
   <div class="col-lg-9">
      <input type="text" name="infobip_baseurl" value="{{Setting::get('infobip_baseurl')}}" class="form-control" id="base_url" placeholder="base_url">
   </div>
</div>
<div class="col-12 text-end">
   <div class="hstack gap-2 justify-content-end">
      <button type="submit" class="btn btn-soft-success"
         id="add-btn"><i class="las la-save"></i> Save</button>
   </div>
</div>