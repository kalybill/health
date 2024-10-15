$("#myDatatable").DataTable({
        
    ajax: {
        url: 'settings/dt_visit',
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
        { data: 'description' },
        { data: 'id',
          render: function(data){
            return ` <div class="row">
            <div class="col-2"><i class="fa-solid fa-pen-to-square fa-xl" style="color: #00D100;" data-bs-toggle="modal" data-bs-target="#mdEdit" id="btnEdit" data-id="`+data+   `"></i></div> 
            <div class="col-2" ><i class="fa-solid fa-trash fa-xl" style="color: #E32227;" data-bs-toggle="modal" data-bs-target="#delModal" id="dataID" data-id="`+data+`"></i></div> 
        </div>`;
          }
        }, // You can specify default content for the Actions column if needed
    ],
});


$(document).ready(function () {
    $(document).on('submit','#frmPump',function () { 
        var formData = new FormData(this);
        
        $.ajax({
            type: "post",
            url: "settings/visit",
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
                }else if(data.success){
                    toastr.success("Successful", data.success);
                    setTimeout(function(){
                        location.reload()
                    }, 3000)
                }
            }
        });
    });


    $(document).on('click','#btnEdit',function () { 
        var id = $(this).data('id');
        $.ajax({
            type: "post",
            url: "settings/edit_visit",
            data: {'id': id},
            success: function (data) {
                $('#mdBody').html(data)
            }
        });
    });


    $(document).on('submit','#frmUptAccessType',function () { 
        var formData = new FormData(this);
        
        $.ajax({
            type: "post",
            url: "settings/update_visit",
            data: formData,
            cache: false,
            contentType:false,
            processData:false,
            beforeSend: function(){
                $('#kt_sign_in_update').attr("data-kt-indicator", "on");
                $('#kt_sign_in_update').attr('disabled', true)
            },
            success: function (data) {
                if(data.errors){
                    $.each(data.errors, function(field, error){
                        $('.'+field + '-error').text(error[0]);
                    })

                    $('#kt_sign_in_update').attr("data-kt-indicator", "off");
                    $('#kt_sign_in_update').attr('disabled', false)
                }else if(data.logginError){
                    toastr.error("Error", data.logginError);
                    $('#kt_sign_in_update').attr("data-kt-indicator", "off");
                    $('#kt_sign_in_update').attr('disabled', false)
                }else if(data.success){
                    toastr.success("Successful", data.success);
                    setTimeout(function(){
                        location.reload()
                    }, 3000)
                }
            }
        });
    });


    $(document).on('click','#dataID', function(){
        var id = $(this).data('id');
        
        $.ajax({
            type: "get",
            url: "settings/find_single_item_visit",
            data: {'id' : id},
            success: function (data) {
                $('#delDescription').text(data.description);
                $('#InputVal').val(id);
            }
        });
        
    })

    
    $(document).on('click','#btnDelete',function () { 
        var id = $('#InputVal').val();
        
        $.ajax({
            type: "post",
            url: "settings/visit-delete",
            data: {'id' : id},
            success: function (data) {
                showSuccessMessage('Deleted');
            }
        });
    });
    

});