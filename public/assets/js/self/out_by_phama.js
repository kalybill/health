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
        url: 'reports/dt_out_phama',
        type: 'GET', // Or 'POST' depending on your server-side implementation
        data: function(d) {
            d.draw = 1; // You can set the 'draw' parameter here
        }, 
    },
    "order": [[0, "desc"]],
    "dom":
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
        { data: 'id', 'visible': false},
        { data: 'client' },
        { data: 'patient' },
        { data: 'visit_date'},
        { data: 'visit_type'},
        { data: 'remarks'},
    ],
    buttons: [
        'csvHtml5',
        'pdfHtml5'
    ],
    initComplete: function () {
        exportButtons();
    }
});


$(document).ready(function () {
    
    $(document).on('submit','#frmNurse',function () { 
        var formData = new FormData(this);
        $.ajax({
            type: "post",
            url: "reports/searchByPhama",
            data: formData,
            cache: false,
            contentType:false,
            processData:false,
            beforeSend: function(){
                $('#kt_sign_in_submit').attr("data-kt-indicator", "on");
                $('#kt_sign_in_submit').attr('disabled', true)
            },
            success: function (data) {
                if(data.errors){
                    $.each(data.errors, function(field, error){
                        $('.'+field + '-error').text(error[0]);
                    })

                    $('#kt_sign_in_submit').attr("data-kt-indicator", "off");
                    $('#kt_sign_in_submit').attr('disabled', false)
                }else if(data.logginError){
                    toastr.error("Error", data.logginError);
                    $('#kt_sign_in_submit').attr("data-kt-indicator", "off");
                    $('#kt_sign_in_submit').attr('disabled', false)
                }else if(data){
                    // toastr.success("Successful");
                    setTimeout(function(){
                        window.location.href = '/reports/single-client-report/'+data.client+'';
                    }, 3000)
                }
            }
        });
    });


    $(document).on('click','#btnView',function () { 
        var id = $(this).data('id')

        $.ajax({
            type: "post",
            url: "reports/view-md-records",
            data: {'id' : id},
            success: function (data) {
                $('#mdMdRecords').html(data)
            }
        });
    });
});