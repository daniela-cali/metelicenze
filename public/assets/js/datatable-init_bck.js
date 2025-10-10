datatableDefaults = $.extend(true, $.fn.dataTable.defaults, {
            dom: 'Bfrtip',
            responsive: true,
            paging: true,

            language: {
                url: '/assets/datatables/i18n/it-IT.json'
            },

            buttons: [
                {
                    extend: 'copy',
                    text: '<i class="bi bi-clipboard"></i> Copia',
                    className: 'btn btn-sm btn-outline-primary',
                    exportOptions: { columns: ':not(.notexport)' }
                },
                {
                    extend: 'csv',
                    text: '<i class="bi bi-filetype-csv"></i> CSV',
                    className: 'btn btn-sm btn-outline-success',
                    exportOptions: { columns: ':not(.notexport)' }
                },
                {
                    extend: 'excel',
                    text: '<i class="bi bi-file-earmark-excel"></i> Excel',
                    className: 'btn btn-sm btn-outline-success',
                    exportOptions: { columns: ':not(.notexport)' }
                },
                {
                    extend: 'pdf',
                    text: '<i class="bi bi-file-earmark-pdf"></i> PDF',
                    className: 'btn btn-sm btn-outline-danger',
                    exportOptions: { columns: ':not(.notexport)' }
                },
                {
                    extend: 'print',
                    text: '<i class="bi bi-printer"></i> Stampa',
                    className: 'btn btn-sm btn-outline-secondary',
                    exportOptions: { columns: ':not(.notexport)' }
                }

            ]

        });

