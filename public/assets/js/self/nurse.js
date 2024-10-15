$("#myDatatable").DataTable({
        
    ajax: {
        url: 'nurse/dt_nurse',
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
        { data: 'name' },
        { data: 'telephone' },
        { data: 'email' },
        { data: 'id',
          render: function(data){
            return `<div class="row">
            <div class="col-2"><i class="fa-solid fa-pen-to-square fa-xl" style="color: #00D100;" data-bs-toggle="modal" data-bs-target="#mdEdit" id="btnEdit" data-id="`+data+`"></i></div> 
            <div class="col-3"><a href="nurse/credential-tracking/`+data+`">Cred.Tracking</a></div> 
            <div class="col-4"><a href="nurse/geo-area/`+data+`">Geo. Area</a></div> 
            <div class="col-2" ><i class="fa-solid fa-trash fa-xl" style="color: #E32227;" data-bs-toggle="modal" data-bs-target="#delModal" id="dataID" data-id="`+data+`"></i></div> 
        </div>`;
          }
        }, // You can specify default content for the Actions column if needed
    ],
});


$(document).ready(function () {
    $(document).on('submit','#frmAddNurse',function () { 
        var formData = new FormData(this);
        
        $.ajax({
            type: "post",
            url: "nurse/nurse",
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
            url: "nurse/edit_nurse",
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
            url: "nurse/update_nurse",
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
            url: "nurse/find_single_nurse",
            data: {'id' : id},
            success: function (data) {
                $('#delDescription').text(data.fname + ' ' + data.lname);
                $('#InputVal').val(id);
            }
        });
        
    })

    
    $(document).on('click','#btnDelete',function () { 
        var id = $('#InputVal').val();
        
        $.ajax({
            type: "post",
            url: "nurse/nurse-delete",
            data: {'id' : id},
            success: function (data) {
                showSuccessMessage('Deleted');
            }
        });
    });

    $(".CHKrn_contracted").click(function () { 
        
        if ($(".CHKrn_contracted").is(":checked")) {
           $('.rn_contracted').prop('required', true)
        } else {
            $('.rn_contracted').prop('required', false)
            $('.rn_contracted').val('')
        }
    });
    $(".CHKprescreen_interview").click(function () { 
        if ($(".CHKprescreen_interview").is(":checked")) {
           $('.prescreen_interview').prop('required', true)
        } else {
            $('.prescreen_interview').prop('required', false)
            $('.prescreen_interview').val('')
        }
    });
    $(".CHKapplication").click(function () { 
        if ($(".CHKapplication").is(":checked")) {
           $('.application').prop('required', true)
        } else {
            $('.application').prop('required', false)
            $('.application').val('')
        }
    });
    $(".CHKall_documents_submitted").click(function () { 
        if ($(".CHKall_documents_submitted").is(":checked")) {
           $('.all_documents_submitted').prop('required', true)
        } else {
            $('.all_documents_submitted').prop('required', false)
            $('.all_documents_submitted').val('')
        }
    });
    $(".CHKbackground_check_completed").click(function () { 
        if ($(".CHKbackground_check_completed").is(":checked")) {
           $('.background_check_completed').prop('required', true)
        } else {
            $('.background_check_completed').prop('required', false)
            $('.background_check_completed').val('')
        }
    });
    $(".CHKfile_created").click(function () { 
        if ($(".CHKfile_created").is(":checked")) {
           $('.file_created').prop('required', true)
        } else {
            $('.file_created').prop('required', false)
            $('.file_created').val('')
        }
    });
    $(".CHKref_check_completed").click(function () { 
        if ($(".CHKref_check_completed").is(":checked")) {
           $('.ref_check_completed').prop('required', true)
        } else {
            $('.ref_check_completed').prop('required', false)
            $('.ref_check_completed').val('')
        }
    });
    $(".CHKorientation").click(function () { 
        if ($(".CHKorientation").is(":checked")) {
           $('.orientation').prop('required', true)
        } else {
            $('.orientation').prop('required', false)
            $('.orientation').val('')
        }
    });
    $(".CHKcontract_signed").click(function () { 
        if ($(".CHKcontract_signed").is(":checked")) {
           $('.contract_signed').prop('required', true)
        } else {
            $('.contract_signed').prop('required', false)
            $('.contract_signed').val('')
        }
    });
    $(".CHKshadowed").click(function () { 
        if ($(".CHKshadowed").is(":checked")) {
           $('.shadowed').prop('required', true)
        } else {
            $('.shadowed').prop('required', false)
            $('.shadowed').val('')
        }
    });
    $(".CHKfirst_visit").click(function () { 
        if ($(".CHKfirst_visit").is(":checked")) {
           $('.first_visit').prop('required', true)
        } else {
            $('.first_visit').prop('required', false)
            $('.first_visit').val('')
        }
    });


    // The DOM elements you wish to replace with Tagify
var input1 = document.querySelector("#kt_tagify_1");
var input2 = document.querySelector("#kt_tagify_2");

// Initialize Tagify components on the above inputs
new Tagify(input2);


});