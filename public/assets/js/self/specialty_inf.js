var exportButtons = () => {
    const documentTitle = 'Customer Orders Report';
    var buttons = new $.fn.dataTable.Buttons(table, {
        buttons: [
            {
                extend: 'csvHtml5',
                title: documentTitle
            },
            {
                extend: 'pdfHtml5',
                title: documentTitle
            }
        ]
    }).container().appendTo($('#kt_datatable_example_buttons'));

    // Hook dropdown menu click event to datatable export buttons
    const exportButtons = document.querySelectorAll('#kt_datatable_example_export_menu [data-kt-export]');
    exportButtons.forEach(exportButton => {
        exportButton.addEventListener('click', e => {
            e.preventDefault();

            // Get clicked export value
            const exportValue = e.target.getAttribute('data-kt-export');
            const target = document.querySelector('.dt-buttons .buttons-' + exportValue);

            // Trigger click event on hidden datatable export buttons
            target.click();
        });
    });
};

$("#myDatatable").DataTable({
    ajax: {
        url: "reports/dt_specialty_inf",
        type: "GET", // Or 'POST' depending on your server-side implementation
        data: function (d) {
            d.draw = 1; // You can set the 'draw' parameter here
        },
    },
    order: [[0, "desc"]],
    dom:
        "<'row'" +
        "<'col-sm-4 d-flex align-items-center justify-conten-start'l>" +
        "<'col-sm-4 d-flex align-items-center justify-content-end'f>" +
        "<'col-sm-4 d-flex align-items-center justify-content-end'B>" +
        ">" +
        "<'table-responsive'tr>" +
        "<'row'" +
        "<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
        "<'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
        ">",
    columns: [
        { data: "id", visible: false },
        { data: "rn_name" },
        { data: "patient" },
        { data: "case" },
    ],
    buttons: [
        'csvHtml5',
        'pdfHtml5'
    ],
    initComplete: function () {
        exportButtons();
    }
});