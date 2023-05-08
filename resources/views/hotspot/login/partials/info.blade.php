@if(empty(setting('hotspot_info')))
<div class="text-muted">
   <h5 class="fs-12 text-uppercase text-success">Wifi Hotspot</h5>
   <h4 class="mb-3">How to access internet</h4>
   <p class="mb-4 ff-secondary">Please follow the instructions given to purchase a voucher code for the hotspot.</p>
   <p class="mb-4 ff-secondary">1. Choose a package below and click purchase <br>
      2. Enter your <strong>Mpesa</strong> number & then proceed.<br>
      3. When prompted enter your Mpesa pin & send <br>
      4. You will receive an sms with login code/pin<br>
      @if(session()->has('common_data'))
      5. Enter the <strong>code/pin</strong> below and click connect<br>
      @endif
   </p>
</div>
@else
{!!html_entity_decode(setting('hotspot_info'))!!}
@endif