$(document).ready(function () {
    $('#datatable').DataTable({
        responsive: true,
        deferRender: true,
        "lengthMenu": [ 20, 50, 100 ],
        "pageLength":50,
        language: {
            paginate: {
              next: '&#8594;', // or '→'
              previous: '&#8592;' // or '←' 
            }
          },
        // dom: 'Blfrtip',
        // // buttons: [
        // //     'copy', 'csv', 'excel', 'pdf', 'print'
        // // ]
        // buttons: [

        //     {
        //         extend: 'collection',
        //         text: 'Export',
        //         buttons: [
        //             {
        //                 extend: 'copyHtml5',
        //                 text: '<i class="ri-clipboard-line text-info fs-18"></i>',
        //                 titleAttr: 'Copy'
        //             },
        //             {
        //                 extend: 'excelHtml5',
        //                 text: '<i class="ri-file-excel-2-line text-info fs-18"></i>',
        //                 titleAttr: 'Excel'
        //             },
        //             {
        //                 extend: 'csvHtml5',
        //                 text: '<i class="ri-eye-fill fs-16"></i> CSV',
        //                 titleAttr: 'CSV'
        //             },
        //             {
        //                 extend: 'pdfHtml5',
        //                 text: '<i class="fas fa-file-pdf"></i> PDF',
        //                 titleAttr: 'PDF'
        //             },
        //             {
        //                 extend: 'print',
        //                 text: '<i class="ri-printer-fill text-info fs-18"></i> Print ',
        //                 titleAttr: 'Print'
        //             }
        //         ]
        //     }
 
        // ]
    });
});

// Modal pass package data
$('#deleteItem').on('show.bs.modal', function(event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var title = button.data('title') // Extract info from data-* attributes
    var id = button.data('id')
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = $(this)
    modal.find('.modal-title').text(title)
    modal.find('.modal-body #id').val(id)
})