$(document).ready(function() {
    // Show delete button when a checkbox is checked
    $('#datatable').on('change', 'input[type="checkbox"]:not(#select-all)', function() {
        var numChecked = $('input[type="checkbox"]:checked:not(#select-all)').length;
        if (numChecked > 0) {
            $('#delete-btn').show();
            $('#delete-btn').text('Delete ' + numChecked + ' item(s)');
        } else {
            $('#delete-btn').hide();
        }
    });

    // Check/uncheck all checkboxes when select-all checkbox is clicked
    $('#select-all').click(function() {
        $('input[type="checkbox"]:not(#select-all)').prop('checked', $(this).prop('checked'));
        $('input[type="checkbox"]:not(#select-all)').trigger('change');
    });

    // Handle delete button click event
    $('#delete-btn').click(function() {
        var ids = [];
        $('input[type="checkbox"]:checked:not(#select-all)').each(function() {
            ids.push($(this).val());
        });
        if (ids.length > 0) {
            // Get the CSRF token value
            var csrfToken = $('meta[name="csrf-token"]').attr('content');

            // Display a confirmation modal using SweetAlert
            swal({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    // User clicked the "Confirm" button in the modal
                    // Send an AJAX request to the delete-multiple route
                    $.ajax({
                        url: deleteMultipleUrl,
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                        },
                        data: {
                            ids: ids,
                        },
                        success: function(data) {
                            // Remove the deleted items from the page
                            ids.forEach(function(id) {
                                $('#select-' + id).closest('tr').remove();
                            });

                            // Hide the delete button and uncheck the "select-all" checkbox
                            $('#delete-btn').hide();
                            $('#select-all').prop('checked', false);

                            // Show a success message
                            swal("Your items have been deleted!", {
                                icon: "success",
                            });
                        },
                        error: function(xhr, status, error) {
                            // Handle error
                            swal("Oops!", "Something went wrong!", "error");
                        }
                    });
                } else {
                    // User clicked the "Cancel" button in the modal
                    swal("Your items are safe!");
                }
            });
        }
    });
});
