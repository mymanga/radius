<input type="hidden" name="celcom_gateway" value="celcom" class="form-control" id="gateway" placeholder="gateway" readonly>
<div class="row mb-3">
   <div class="col-lg-3">
      <label for="sender_id" class="form-label">Sender ID / Shortcode</label>
   </div>
   <div class="col-lg-9">
      <input type="text" name="celcom_sender_id" value="{{ Setting::get('celcom_sender_id') }}" class="form-control" id="sender_id" placeholder="sender id">
   </div>
</div>
<div class="row mb-3">
   <div class="col-lg-3">
      <label for="partner_id" class="form-label">Partner ID</label>
   </div>
   <div class="col-lg-9">
      <input type="text" name="celcom_partner_id" value="{{ Setting::get('celcom_partner_id') }}" class="form-control" id="partner_id" placeholder="partner id">
   </div>
</div>
<div class="row mb-3">
   <div class="col-lg-3">
      <label for="api_key" class="form-label">API Key</label>
   </div>
   <div class="col-lg-9">
      <input type="text" name="celcom_api_key" value="{{ Setting::get('celcom_api_key') }}" class="form-control" id="api_key" placeholder="api key">
   </div>
</div>
<div class="col-12 text-end">
   <div class="hstack gap-2 justify-content-end">
      <button type="submit" class="btn btn-soft-success" id="add-btn"><i class="las la-save"></i> Save</button>
   </div>
</div>