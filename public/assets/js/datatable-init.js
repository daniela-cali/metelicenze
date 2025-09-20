$(document).ready(function () {
    $('.datatable').each(function () {
        $(this).DataTable({
            dom: 'Bfrtip',
            responsive: true,
            paging: true,

            language: {
                url: baseUrl + '/assets/datatables/i18n/it-IT.json'
            },

            buttons: [
                {
                    extend: 'copy',
                    text: '<i class="bi bi-clipboard"></i> Copia',
                    className: 'btn btn-sm btn-outline-primary'
                },
                {
                    extend: 'csv',
                    text: '<i class="bi bi-filetype-csv"></i> CSV',
                    className: 'btn btn-sm btn-outline-success'
                },
                {
                    extend: 'excel',
                    text: '<i class="bi bi-file-earmark-excel"></i> Excel',
                    className: 'btn btn-sm btn-outline-success'
                },
                {
                    extend: 'pdf',
                    text: '<i class="bi bi-file-earmark-pdf"></i> PDF',
                    className: 'btn btn-sm btn-outline-danger'
                },
                {
                    extend: 'print',
                    text: '<i class="bi bi-printer"></i> Stampa',
                    className: 'btn btn-sm btn-outline-secondary'
                }
            ]
        });
    });
});
