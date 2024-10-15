$("#myDatatable").DataTable({
    ajax: {
        url: "patient/dt_schedules",
        type: "GET", // Or 'POST' depending on your server-side implementation
        data: function (d) {
            d.draw = 1; // You can set the 'draw' parameter here
        },
    },
    "order": [[0, "desc"]],
    dom:
        "<'row'" +
        "<'col-sm-6 d-flex align-items-center justify-conten-start'l>" +
        "<'col-sm-6 d-flex align-items-center justify-content-end'f>" +
        ">" +
        "<'table-responsive'tr>" +
        "<'row'" +
        "<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
        "<'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
        ">",
        columns: [
        { data: 'id', 'visible': false},
        { data: "name" },
        { data: "mrn" },
        { data: "access_type" },
        { data: "pump" },
        { data: "ref_src" },
        { data: "ref_date" },
        { data: "soc_date" },
        { data: "status" },
        {
            data: "id",
            render: function (data) {
                return (
                    ` <div class="row">
            <div class="col-md-6"><a href="/patient/edit-schedules/` +
                    data +
                    `"><i class="fa-solid fa-pen-to-square fa-xl" style="color: #00D100;"></i></a></div> 
        </div>`
                );
            },
        }, // You can specify default content for the Actions column if needed
    ],
    
});