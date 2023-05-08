

// Purchase modal 
$(document).ready(function() {
    $('#purchaseVoucherModal form').submit(function(e) {
        e.preventDefault(); // prevent the form from submitting normally

        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: $(this).serialize(), // serialize the form data
            success: function(response) {
                // handle response here
                console.log(response);

                // Close the purchase voucher modal
                $('#purchaseVoucherModal').modal('hide');

                // Show either the success modal or the error modal, depending on the value of `success`
                if (response.success) {
                    $('#successModal').modal('show');
                    $('#successMessage').text(response.message);
                } else {
                    $('#errorModal').modal('show');
                    $('#errorMessage').text(response.message);
                }
            },
            error: function(xhr, status, error) {
                // handle error response here
                console.log(xhr.responseText);
            }
        });
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
