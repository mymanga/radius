function renderTable(url, columns) {
    $(document).ready(function () {
        var table = $('#datatable').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: {
                url: url,
                type: 'GET',
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
            },
            columns: columns,
            order: [[0, 'desc']],
            pageLength: 50,
            lengthMenu: [[20, 35, 50, 100], [20, 35, 50, 100]],
            language: {
                searchPlaceholder: 'Search...',
                paginate: {
                    first: 'First',
                    last: 'Last',
                    next: '&rarr;',
                    previous: '&larr;'
                }
            },
        });

        table.on('draw', function () {
            window.scrollTo(0, 0);
        });

        // Add event listener for the Refresh button
        $('#refresh-btn').on('click', function () {
            table.ajax.reload(null, false);
        });

        // Add your event listeners for the Print and Export buttons here.
    });
}
