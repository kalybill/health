$("#myDatatable").DataTable({
        
    ajax: {
        url: 'reports/dt_nursereport',
        type: 'GET', // Or 'POST' depending on your server-side implementation
        data: function(d) {
            d.draw = 1; // You can set the 'draw' parameter here
        }, 
    },
    "order": [[0, "desc"]],
    "dom":
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
        { data: 'rn_name' },
        { data: 'patient' },
        { data: 'date_process'},
        { data: 'id',
          render: function(data){
            return ` <div class="row">
            <div class="col-2"><i class="fa-solid fa-pen-to-square fa-xl" style="color: #00D100;" data-bs-toggle="modal" data-bs-target="#exampleModal" id="btnView" data-id="`+data+`"></i></div>  `;
          }
        }, // You can specify default content for the Actions column if needed
    ],
    buttons: [
        'copy', 'excel', 'pdf'
    ]
});


$(document).ready(function () {
    
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