// Function to show a SweetAlert 2 loading animation
function showLoadingAnimation() {
    Swal.fire({
      title: "Processing Data",
      text: "Please wait...",
      icon: "info",
      allowOutsideClick: false,
      allowEscapeKey: false,
      showConfirmButton: false,
      showCancelButton: false,
      showCloseButton: false,
      didOpen: () => {
        Swal.showLoading();
      },
    });
  }
  
  // Function to hide the SweetAlert 2 loading animation
  function hideLoadingAnimation() {
    Swal.close();
  }
  
  // AJAX function to handle form submission
  function handleFormSubmission(formData) {
    // Show the loading animation using SweetAlert 2
    showLoadingAnimation();
  
    $.ajax({
      type: 'POST',
      url: '{{ route("voucher.buy") }}', // Replace with your route URL
      data: formData,
      success: function(response) {
        hideLoadingAnimation(); // Hide the SweetAlert 2 loading animation
  
        // Close the purchase voucher modal
        $('#purchaseVoucherModal').modal('hide');
  
        // Show either the success modal or the error modal, depending on the value of `success`
        if (response.success) {
          // Show the success modal with the SweetAlert 2 success animation
          Swal.fire({
            title: "Success",
            text: response.message,
            icon: "success",
            showCancelButton: false,
            showCloseButton: false,
            allowOutsideClick: false,
            allowEscapeKey: false,
            timer: 2000, // Display the success message for 2 seconds
            didOpen: () => {
              Swal.hideLoading();
            },
          });
          showLoadingAnimation();
        } else {
          // Show the error modal with the SweetAlert 2 error animation
          Swal.fire({
            title: "Error",
            text: response.message,
            icon: "error",
            showCancelButton: false,
            showCloseButton: false,
            allowOutsideClick: false,
            allowEscapeKey: false,
          });
        }
      },
      error: function(xhr, status, error) {
        hideLoadingAnimation(); // Hide the SweetAlert 2 loading animation on error
  
        // Handle the error or display an error message if needed
        Swal.fire({
          title: "Error",
          text: "An error occurred while processing your request.",
          icon: "error",
          showCancelButton: false,
          showCloseButton: false,
          allowOutsideClick: false,
          allowEscapeKey: false,
        });
  
        console.log(xhr.responseText);
      }
    });
  }
  
  // Attach form submission event handler
  $(document).ready(function() {
    $('#purchaseVoucherModal form').submit(function(e) {
      e.preventDefault(); // prevent the form from submitting normally
  
      const formData = $(this).serialize(); // serialize the form data
      handleFormSubmission(formData);
    });
  });
  
  // Contact for submission
  $(document).ready(function() {
    $("#contact-form").submit(function(event) {
        // Prevent the form from submitting via the browser.
        event.preventDefault();
  
        // Submit the form via AJAX.
        $.ajax({
            type: "POST",
            url: $(this).attr("action"),
            data: $(this).serialize(),
            success: function(response) {
                // Show either the success modal or the error modal, depending on the value of `success`
                if (response.success) {
                    // Remove any existing error messages.
                    $('.alert').remove();
  
                    $("#contact-form")[0].reset();
                    $('#successModal').modal('show');
                    $('#successMessage').text(response.message);
                } else {
                    // Display the error message in a Bootstrap alert component.
                    var errorMessage = '<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
                        '<strong>Error:</strong> ' + response.message + '</div>';
  
                    $('#contact-form').prepend(errorMessage);
                }
            },
            error: function(xhr, status, error) {
                // Remove any existing alert messages.
                $('.alert').remove();
  
                // Display a list of validation errors in a Bootstrap alert component.
                var errorResponse = JSON.parse(xhr.responseText);
                var errors = errorResponse.errors;
                var errorMessage = '<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
                    '<strong>Error:</strong><br>';
                $.each(errors, function(key, value) {
                    errorMessage += '- ' + value + '<br>';
                });
                errorMessage += '</div>';
  
                $('#contact-form').prepend(errorMessage);
            }
        });
    });
  });
  
      // Function to handle the AJAX request and form submission
      // Function to display a SweetAlert 2 success message
  function showSuccessMessage(message) {
    Swal.fire({
      title: "Success",
      text: message,
      icon: "success",
      showCancelButton: false,
      showCloseButton: false,
      allowOutsideClick: false,
      allowEscapeKey: false,
      timer: 2000, // Display the success message for 2 seconds
    });
  }
  
  // Function to display a SweetAlert 2 error message
  function showErrorMessage(errorMessage) {
    Swal.fire({
      title: "Error",
      text: errorMessage,
      icon: "error",
      showCancelButton: false,
      showCloseButton: false,
      allowOutsideClick: false,
      allowEscapeKey: false,
    });
  }
  
  // Function to handle the AJAX request and form submission
  function submitLoginForm(username, password, chap_id, chap_challenge) {
    // Show the loading animation using SweetAlert 2
    showLoadingAnimation();
  
    const xhr = new XMLHttpRequest();
    xhr.open('POST', '{{ route("hotspotlogincheck") }}', true);
    xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');
    xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
    xhr.onreadystatechange = function () {
      if (xhr.readyState === XMLHttpRequest.DONE) {
        hideLoadingAnimation(); // Hide the SweetAlert 2 loading animation
  
        if (xhr.status === 200) {
          const response = JSON.parse(xhr.responseText);
          if (response.success) {
            // Call the doLogin function to submit the form
            document.login.username.value = username;
            document.login.password.value = hexMD5(chap_id + username + chap_challenge);
            document.login.submit();
  
            // Show the success message
            showSuccessMessage(response.message);
          } else {
            // Otherwise, display an error message in the modal
            const errorMessage = response.message || 'An error occurred';
            showErrorMessage(errorMessage);
          }
        } else {
          // Show error message in the modal
          showErrorMessage('An error occurred while processing your request.');
        }
      }
    };
    xhr.send(JSON.stringify({
      username: username,
      password: password
    }));
  }
  
  // Attach form submission event handler
  $(document).ready(function() {
    $('#purchaseVoucherModal form').submit(function(e) {
      e.preventDefault(); // prevent the form from submitting normally
  
      const formData = $(this).serialize(); // serialize the form data
      handleFormSubmission(formData);
    });
  });
      
      // Function to display the error modal with the given error message
      function showErrorModal(errorMessage) {
          const errorModal = $('#errorModal');
          errorModal.find('#errorMessage').text(errorMessage);
          errorModal.modal('show');
      }
      
      // Modal pass package data
      $('#purchaseVoucherModal').on('show.bs.modal', function (event) {
          var button = $(event.relatedTarget); // Button that triggered the modal
          var title = button.data('title'); // Extract info from data-* attributes
          var amount = button.data('amount');
          var modal = $(this);
          modal.find('.voucher_title').text(title);
          modal.find('#amount').val(amount);
      });
      
      // Ajax submit form data
      setTimeout(function () {
          $("#loader-wrapper").hide();
      }, 200);
      
      // Get common data from PHP variables
      const username = "{{ isset($common_data['username']) ? $common_data['username'] : '' }}";
      const chap_id = "{{ isset($common_data['chap_id']) ? $common_data['chap_id'] : '' }}";
      const chap_challenge = "{{ isset($common_data['chap_challenge']) ? $common_data['chap_challenge'] : '' }}";
      
      // Handle form submission on submit button click
      const loginForm = document.getElementById('login-form');
      const submitButton = loginForm ? loginForm.querySelector('button[type="submit"]') : null;
      
      if (submitButton) {
          submitButton.addEventListener('click', function (event) {
              event.preventDefault(); // Prevent the form from submitting
      
              // Get the values of the username and password fields
              const usernameInput = loginForm.elements['username'].value;
              const password = loginForm.elements['password'].value;
      
              // Make an AJAX request to the Laravel controller for login check
              submitLoginForm(usernameInput, password, chap_id, chap_challenge);
          });
      }
      
      // Auto-submit the form function on page load
      function autoSubmitForm() {
         // Check if the username is present and not empty
         if (username && username.trim() !== "") {
            // Check if the form has already been auto-submitted
            if (!loginForm.getAttribute("data-auto-submitted")) {
                  loginForm.setAttribute("data-auto-submitted", "true");
  
                  // Call the checkVoucherIssuance function periodically (every 5 seconds in this example)
                  setInterval(checkVoucherIssuance, 5000); // Adjust the interval as needed
            }
         }
      }
  
      // Initial delay of 5 seconds before running the function
      setTimeout(function () {
         checkVoucherIssuance(); // Call the function immediately on page load
  
         // Now, set the interval to run every 10 seconds
         setInterval(function () {
            checkVoucherIssuance(); // Call the function every 10 seconds
         }, 10000); // 10000 milliseconds = 10 seconds
      }, 5000); // 5000 milliseconds = 5 seconds gap before starting the setInterval
  
      // AJAX function to check voucher issuance
      function checkVoucherIssuance() {
         const xhr = new XMLHttpRequest();
         xhr.open('POST', '{{ route("checkVoucherIssuance") }}', true);
         xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');
         xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
         xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
               const response = JSON.parse(xhr.responseText);
               if (response.voucher) {
                  // Voucher value found, use it as the username and auto-submit the form
                  submitLoginForm(response.voucher, '', chap_id, chap_challenge);
               }
            } else {
               // Handle the error or display an error message if needed
            }
            }
         };
  
         const sessionId = '{{ isset($common_data['session_id']) ? $common_data['session_id'] : '' }}'; // Get the session_id from the cache
         xhr.send(JSON.stringify({
            session_id: sessionId
         }));
      }
      
      // Call the autoSubmitForm() function when the page loads
      //window.onload = autoSubmitForm;
   
