@if(session()->has('common_data'))
@php
$common_data = session()->get('common_data');
@endphp
<div>
   <!--$(if chap-id)-->
   <form name="sendin" action="{{$common_data['link_login_only']}}" method="post" style="display:none">
      <input type="hidden" name="username" />
      <input type="hidden" name="password" />
      <!-- <input type="hidden" name="dst" value="link_orig" /> -->
      <input type="hidden" name="popup" value="true" />
   </form>

   <!--$(endif)-->
   <div class="ie-fixMinHeight">
      <div class="main">
         <div class="wrap animated fadeIn">
            <form name="login" id="login-form" action="{{$common_data['link_login_only']}}" method="post" onSubmit="return doLogin()">
               <!-- <input type="hidden" name="dst" value="link_orig" /> -->
               <input type="hidden" name="dst" value="/status" />
               <input type="hidden" name="popup" value="true" />
               <p class="info">
                  <!--$(if error == "")-->Please log in to use the internet hotspot service 
                  <!--$(if trial == 'yes')--><br />Free trial available, <a href="{{$common_data['link_login_only']}}?dst={{$common_data['link_orig_esc']}}&amp;username=T-{{$common_data['mac_esc']}}">click here</a>.<!--$(endif)-->
                  <!--$(endif)-->
                  <!-- $(if error) -->
                  <br />
               <div class="text-danger"><?php echo $common_data['error']; ?></div>
               <!-- $(endif) -->
               </p>
               <div class="input-group input-group-lg">
                  <input name="username" type="text" value="{{$common_data['username']}}" placeholder="Voucher code" class="form-control" id="code" onkeyup="return forceLower(this);" onblur="this.value=removeSpaces(this.value);" />
                  <input name="password" type="hidden" placeholder="Password" />
                  <button class="btn btn-outline-success btn-submit" type="submit"><i class="ri-login-circle-line"></i> Connect</button>
               </div>
               <script>
                  function forceLower(strInput)
                  {
                    strInput.value=strInput.value.toUpperCase();
                  }
                  function removeSpaces(string) {
                   return string.split(' ').join('');
                  }
               </script>
            </form>
         </div>
      </div>
   </div>
   <!-- login template -->
</div>
@endif