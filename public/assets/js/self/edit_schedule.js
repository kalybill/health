var currentUrl = window.location.href;
var explode = currentUrl.split('/');
var id = explode.pop();

$("#myDatatable").DataTable({
    ajax: {
        url: "patient/dt_scheduling/"+id+"",
        type: "GET", // Or 'POST' depending on your server-side implementation
        data: function (d) {
            d.draw = 1; // You can set the 'draw' parameter here
        },
    },
    "order": [[1, "desc"]],
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
        { data: "visit_date" },
        { data: "visit_type" },
        { data: "nurse_id" },
        { data: "client" },
        { data: "staffer" },
        { data: "eta" },
        { data: "remarks" },
        {
            data: "id",
            render: function (data) {
                return (
                    ` <div class="row">
            <div class="col-md-6"><a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#editSchedule"><i class="fa-solid fa-pen-to-square fa-xl" style="color: #00D100;" data-id="`+data+`" id="editSch"></i></a></div> 
            <div class="col-md-6" ><i class="fa-solid fa-trash fa-xl" style="color: #E32227;" data-bs-toggle="modal" data-bs-target="#delModal" id="btnSchID" data-id="` + data +`"></i></div> 
        </div>`
                );
            },
        }, // You can specify default content for the Actions column if needed
    ],
    
});

$("#myDatatableProgress").DataTable({
    ajax: {
        url: "patient/dt_progress/"+id+"",
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
        { data: "mrn" },
        { data: "nurse_id" },
        { data: "report" },
        { data: "reporter" },
        { data: "report_date" },
        { data: "staffer" },
        { data: "fu_action" },
        {
            data: "id",
            render: function (data) {
                return (
                    ` <div class="row">
            <div class="col-md-6"><a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#editNote"><i class="fa-solid fa-pen-to-square fa-xl" style="color: #00D100;" " data-id="`+data+`" id="btneditProgrss"></i></a></div> 
            <div class="col-md-6" ><i class="fa-solid fa-trash fa-xl" style="color: #E32227;" data-bs-toggle="modal" data-bs-target="#progressModal" id="btnProgID" data-id="` +
                    data +
                    `"></i></div> 
        </div>`
                );
            },
        }, // You can specify default content for the Actions column if needed
    ],
    
});


$("#myDatatableNewnote").DataTable({
    ajax: {
        url: "patient/dt_addnote/"+id+"",
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
        { data: "order_type" },
        { data: "new_order" },
        { data: "start_date" },
        { data: "end_date" },
        {
            data: "id",
            render: function (data) {
                return (
                    ` <div class="row">
            <div class="col-md-6"><a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#editNote"><i class="fa-solid fa-pen-to-square fa-xl" style="color: #00D100;" data-id="`+data+`" id="btneditNewNote"></i></a></div> 
            <div class="col-md-6" ><i class="fa-solid fa-trash fa-xl" style="color: #E32227;" data-bs-toggle="modal" data-bs-target="#noteModal" id="btnNewID" data-id="` +
                    data +
                    `"></i></div> 
        </div>`
                );
            },
        }, // You can specify default content for the Actions column if needed
    ],
    
});


$(document).ready(function () {
    $(document).on("submit", "#frmSchdule", function () {
        var formData = new FormData(this);

        $.ajax({
            type: "post",
            url: "patient/save-schedule",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function () {
                $("#kt_sign_in_submit_sch").attr("data-kt-indicator", "on");
                $("#kt_sign_in_submit_sch").attr("disabled", true);
            },
            success: function (data) {
                if (data.errors) {
                    $.each(data.errors, function (field, error) {
                        $("." + field + "-error").text(error[0]);
                    });

                    $("#kt_sign_in_submit_sch").attr("data-kt-indicator", "off");
                    $("#kt_sign_in_submit_sch").attr("disabled", false);
                } else if (data.logginError) {
                    toastr.error("Error", data.logginError);
                    $("#kt_sign_in_submit_sch").attr("data-kt-indicator", "off");
                    $("#kt_sign_in_submit_sch").attr("disabled", false);
                } else if (data.success) {
                    toastr.success("Successful", data.success);
                    setTimeout(function () {
                        location.reload();
                    }, 3000);
                }
            },
        });
    });


    $(document).on("submit", "#frmUpdtSchdule", function () {
        var formData = new FormData(this);

        $.ajax({
            type: "post",
            url: "patient/update-schedule",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function () {
                $("#kt_sign_in_submit").attr("data-kt-indicator", "on");
                $("#kt_sign_in_submit").attr("disabled", true);
            },
            success: function (data) {
                if (data.errors) {
                    $.each(data.errors, function (field, error) {
                        $("." + field + "-error").text(error[0]);
                    });

                    $("#kt_sign_in_submit").attr("data-kt-indicator", "off");
                    $("#kt_sign_in_submit").attr("disabled", false);
                } else if (data.logginError) {
                    toastr.error("Error", data.logginError);
                    $("#kt_sign_in_submit").attr("data-kt-indicator", "off");
                    $("#kt_sign_in_submit").attr("disabled", false);
                } else if (data.success) {
                    toastr.success("Successful", data.success);
                    setTimeout(function () {
                        location.reload();
                    }, 3000);
                }
            },
        });
    });


    $(document).on("submit", "#frmProgress", function () {
        var formData = new FormData(this);

        $.ajax({
            type: "post",
            url: "patient/save-progressnote",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function () {
                $("#kt_sign_in_submit_progressNote").attr("data-kt-indicator", "on");
                $("#kt_sign_in_submit_progressNote").attr("disabled", true);
            },
            success: function (data) {
                if (data.errors) {
                    $.each(data.errors, function (field, error) {
                        $("." + field + "-error").text(error[0]);
                    });

                    $("#kt_sign_in_submit_progressNote").attr("data-kt-indicator", "off");
                    $("#kt_sign_in_submit_progressNote").attr("disabled", false);
                } else if (data.logginError) {
                    toastr.error("Error", data.logginError);
                    $("#kt_sign_in_submit_progressNote").attr("data-kt-indicator", "off");
                    $("#kt_sign_in_submit_progressNote").attr("disabled", false);
                } else if (data.success) {
                    toastr.success("Successful", data.success);
                    setTimeout(function () {
                        location.reload();
                    }, 3000);
                }
            },
        });
    });

    $(document).on("submit", "#frmUpdtProgress", function () {
        var formData = new FormData(this);

        $.ajax({
            type: "post",
            url: "patient/update-progressnote",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function () {
                $("#kt_sign_in_submit").attr("data-kt-indicator", "on");
                $("#kt_sign_in_submit").attr("disabled", true);
            },
            success: function (data) {
                if (data.errors) {
                    $.each(data.errors, function (field, error) {
                        $("." + field + "-error").text(error[0]);
                    });

                    $("#kt_sign_in_submit").attr("data-kt-indicator", "off");
                    $("#kt_sign_in_submit").attr("disabled", false);
                } else if (data.logginError) {
                    toastr.error("Error", data.logginError);
                    $("#kt_sign_in_submit").attr("data-kt-indicator", "off");
                    $("#kt_sign_in_submit").attr("disabled", false);
                } else if (data.success) {
                    toastr.success("Successful", data.success);
                    setTimeout(function () {
                        location.reload();
                    }, 3000);
                }
            },
        });
    });


    $(document).on("submit", "#frmNewNote", function () {
        var formData = new FormData(this);

        $.ajax({
            type: "post",
            url: "patient/save-neworder",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function () {
                $("#kt_sign_in_submit_newOrder").attr("data-kt-indicator", "on");
                $("#kt_sign_in_submit_newOrder").attr("disabled", true);
            },
            success: function (data) {
                if (data.errors) {
                    $.each(data.errors, function (field, error) {
                        $("." + field + "-error").text(error[0]);
                    });

                    $("#kt_sign_in_submit_newOrder").attr("data-kt-indicator", "off");
                    $("#kt_sign_in_submit_newOrder").attr("disabled", false);
                } else if (data.logginError) {
                    toastr.error("Error", data.logginError);
                    $("#kt_sign_in_submit_newOrder").attr("data-kt-indicator", "off");
                    $("#kt_sign_in_submit_newOrder").attr("disabled", false);
                } else if (data.success) {
                    toastr.success("Successful", data.success);
                    setTimeout(function () {
                        location.reload();
                    }, 3000);
                }
            },
        });
    });

    $(document).on("submit", "#frmUpdtNewNote", function () {
        var formData = new FormData(this);

        $.ajax({
            type: "post",
            url: "patient/update_neworder",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function () {
                $("#kt_sign_in_submit").attr("data-kt-indicator", "on");
                $("#kt_sign_in_submit").attr("disabled", true);
            },
            success: function (data) {
                if (data.errors) {
                    $.each(data.errors, function (field, error) {
                        $("." + field + "-error").text(error[0]);
                    });

                    $("#kt_sign_in_submit").attr("data-kt-indicator", "off");
                    $("#kt_sign_in_submit").attr("disabled", false);
                } else if (data.logginError) {
                    toastr.error("Error", data.logginError);
                    $("#kt_sign_in_submit").attr("data-kt-indicator", "off");
                    $("#kt_sign_in_submit").attr("disabled", false);
                } else if (data.success) {
                    toastr.success("Successful", data.success);
                    setTimeout(function () {
                        location.reload();
                    }, 3000);
                }
            },
        });
    });


    $(document).on('click','#editSch',function () { 
        var id = $(this).data('id');
        $.ajax({
            type: "post",
            url: "/patient/edit_schedule",
            data: {'id' : id},
            success: function (data) {
                $('#mdSchd').html(data);
                $(".kt_datepicker").flatpickr({
                    dateFormat: "m-d-Y",
                    allowInput: true,
        
                });
            }
        });
    });


    $(document).on('click','#btneditProgrss',function () { 
        var id = $(this).data('id');
        $.ajax({
            type: "post",
            url: "/patient/edit_progress",
            data: {'id' : id},
            success: function (data) {
                $('#mdNote').html(data);
                $(".kt_datepicker").flatpickr({
                    dateFormat: "m-d-Y",
                    allowInput: true,
        
                });
            }
        });
    });


    $(document).on('click','#btneditNewNote',function () { 
        var id = $(this).data('id');
       
        $.ajax({
            type: "post",
            url: "/patient/edit_note",
            data: {'id' : id},
            success: function (data) {
                $('#mdNote').html(data);
                $(".kt_datepicker").flatpickr({
                    dateFormat: "m-d-Y",
                    allowInput: true,
        
                });
            }
        });
    });


    
    $(document).on('click','#btnSchID', function(){
        var id = $(this).data('id');
        $('#InputVal').val(id);
        
    })
    
    $(document).on('click','#btnDelete',function () { 
        var id = $('#InputVal').val();
       
        $.ajax({
            type: "post",
            url: "patient/delete_schedule",
            data: {'id' : id},
            success: function (data) {
                showSuccessMessage('Deleted');
            }
        });
    });


    $(document).on('click','#btnProgID', function(){
        var id = $(this).data('id');
        $('#InputValProg').val(id);
        
    })
    
    $(document).on('click','#btnDeleteProgrs',function () { 
        var id = $('#InputValProg').val();
        
        $.ajax({
            type: "post",
            url: "patient/delete_progress",
            data: {'id' : id},
            success: function (data) {
                showSuccessMessage('Deleted');
            }
        });
    });



    $(document).on('click','#btnNewID', function(){
        var id = $(this).data('id');
        $('#InputValNew').val(id);
        
    })
    
    $(document).on('click','#btnDeleteNew',function () { 
        var id = $('#InputValNew').val();
        
        $.ajax({
            type: "post",
            url: "patient/delete_new",
            data: {'id' : id},
            success: function (data) {
                showSuccessMessage('Deleted');
            }
        });
    });

    $(document).on('click','#btnSch',function () {
        var countSch = $(this).data('sch');
        var authorization = $(this).data('authorization');

      if(countSch != null){
        if(authorization == 1){
            alert("You may be exceeding the number of allowed authorizations for this patient Are you sure you want to add additional schedules?");
        }
      }else{
        if(authorization < countSch){
            alert("You may be exceeding the number of allowed authorizations for this patient Are you sure you want to add additional schedules?");
        }else{
            
        }
    }
    });

    

});