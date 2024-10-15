const url = window.location.href;
const pathSegments = url.split("/");
const lastSegment = pathSegments[pathSegments.length - 1];
const lastId = parseInt(lastSegment);

$("#myDatatable").DataTable({
        
    ajax: {
        url: 'nurse/dt_credential_tracking/'+lastId+'',
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
        { data: 'document_name' },
        { data: 'issue_date' },
        { data: 'expires' },
        { data: 'expiry_date' },
        { data: 'remarks' },
        { data: 'id',
          render: function(data){
            return ` <div class="row">
            <div class="col-2"><i class="fa-solid fa-pen-to-square fa-xl" style="color: #00D100;" data-bs-toggle="modal" data-bs-target="#exampleModal" id="btnEdit" data-id="`+data+   `"></i></div> 
            <div class="col-2" ><i class="fa-solid fa-trash fa-xl" style="color: #E32227;" data-bs-toggle="modal" data-bs-target="#delModal" id="dataID" data-id="`+data+`"></i></div> 
        </div>`;
          }
        }, // You can specify default content for the Actions column if needed
    ],
});


$(document).ready(function () {
    $('.expiry_date').prop('disabled', true)
    $(document).on('click','.expires',function () { 
        if($(this).is(':checked')){
            $('.expiry_date').prop('disabled', false)
        }else{
            $('.expiry_date').val('');
            $('.expiry_date').prop('disabled', true)
        }

    });


    $(document).on('submit','#frmCred',function () { 
        var formData = new FormData(this);

        $.ajax({
            type: "post",
            url: "nurse/save_credential",
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


    $(document).on('submit','#frmUpdateCred',function () { 
        var formData = new FormData(this);

        $.ajax({
            type: "post",
            url: "nurse/update_credential",
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
        var id = $(this).data('id')
        
        $.ajax({
            type: "post",
            url: "nurse/edit_credentails",
            data: {'id': id},
            success: function (data) {
                $('#mdEdit').html(data);
            }
        });
    });


});