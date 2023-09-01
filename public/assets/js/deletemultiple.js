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

            // Display a confirmation modal using SweetAlert2
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
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
                            Swal.fire(
                                'Deleted!',
                                'Your items have been deleted.',
                                'success'
                            )
                        },
                        error: function(xhr, status, error) {
                            // Handle error
                            Swal.fire(
                                'Oops!',
                                'Something went wrong!',
                                'error'
                            )
                        }
                    });
                } else {
                    // User clicked the "Cancel" button in the modal
                    Swal.fire(
                        'Cancelled',
                        'Your items are safe 😊',
                        'error'
                    )                    
                }
            })
        }
    });
});
