// script.js

      // Modal pass package data
         $('#purchaseVoucherModal').on('show.bs.modal', function(event) {
         var button = $(event.relatedTarget) // Button that triggered the modal
         var title = button.data('title') // Extract info from data-* attributes
         var amount = button.data('amount')
         // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
         // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
         var modal = $(this)
         modal.find('.voucher_title').text(title)
         // Set the value of the #amount input field
         modal.find('#amount').val(amount);
         })
      
      // Ajax submit form data
      setTimeout(function() {
      $("#loader-wrapper").hide();
      }, 200);  
      
      
      const loginForm = document.getElementById('login-form');
      const submitButton = loginForm ? loginForm.querySelector('button[type="submit"]') : null;
      const errorModal = $('#errorModal');
      const chap_id = '<?php echo isset($common_data["chap_id"]) ? $common_data["chap_id"] : "" ?>';
      const chap_challenge = '<?php echo isset($common_data["chap_challenge"]) ? $common_data["chap_challenge"] : "" ?>';
      
      if (submitButton) {
      submitButton.addEventListener('click', function(event) {
      event.preventDefault(); // Prevent the form from submitting
      
      // Get the values of the username and password fields
      const username = loginForm.elements['username'].value;
      const password = loginForm.elements['password'].value;
      
      // Make an AJAX request to the Laravel controller
      const xhr = new XMLHttpRequest();
      xhr.open('POST', '{{ route("hotspotlogincheck") }}', true);
      xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');
      xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
      xhr.onreadystatechange = function() {
      if (xhr.readyState === XMLHttpRequest.DONE) {
       if (xhr.status === 200) {
         const response = JSON.parse(xhr.responseText);
         if (response.success) {
           // Call the doLogin function to submit the form
           document.login.username.value = username;
           document.login.password.value = hexMD5(chap_id + username + chap_challenge);
           document.login.submit();
         } else {
           // Otherwise, display an error message in the modal
           const errorMessage = response.message || 'An error occurred';
           errorModal.find('#errorMessage').text(errorMessage);
           errorModal.modal('show');
         }
       } else {
         // Show error message in the modal
         const errorMessage = document.getElementById('errorMessage');
          errorMessage.innerText = response.message;
          $('#errorModal').modal('show');
       }
      }
      };
      xhr.send(JSON.stringify({
      username: username,
      password: password
      }));
      });
      }