$("#myDatatable").DataTable({
    ajax: {
        url: "patient/dt_specialty_infusion",
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
        { data: "is_new" },
        {
            data: "id",
            render: function (data) {
                return (
                    ` <div class="row">
            <div class="col-md-6"><a href="/patient/edit-patient/` +
                    data +
                    `"><i class="fa-solid fa-pen-to-square fa-xl" style="color: #00D100;"></i></a></div> 
            <div class="col-md-6" ><i class="fa-solid fa-trash fa-xl" style="color: #E32227;" data-bs-toggle="modal" data-bs-target="#delModal" id="dataID" data-id="` +
                    data +
                    `"></i></div> 
        </div>`
                );
            },
        }, // You can specify default content for the Actions column if needed
    ],
    
});





$(document).ready(function () {

    $(document).on('click','#dataID', function(){
        var id = $(this).data('id');
        
        $.ajax({
            type: "get",
            url: "find_single_referral",
            data: {'id' : id},
            success: function (data) {
                $('#delDescription').text(data.name);
                $('#InputVal').val(id);
            }
        });
        
    })
    
    $(document).on('click','#btnDelete',function () { 
        var id = $('#InputVal').val();
        
        $.ajax({
            type: "post",
            url: "patient/patient-delete",
            data: {'id' : id},
            success: function (data) {
                showSuccessMessage('Deleted');
            }
        });
    });

    $(document).on('change','.ref_source',function () {
        var id = $(this).val();
        
        $.ajax({
            type: "post",
            url: "get-clients",
            data: {'id' : id},
            success: function (data) {
                $('.ref_source_staff').html(data)
            }
        });
    });
    
});
