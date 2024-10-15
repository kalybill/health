$("#myDatatable").DataTable({
    ajax: {
        url: "medrecords/dt_untransfeered_no_date",
        type: "GET", // Or 'POST' depending on your server-side implementation
        data: function (d) {
            d.draw = 1; // You can set the 'draw' parameter here
        },
    },
    order: [[0, "desc"]],
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
        { data: "id", visible: false },
        { data: "name" },
        { data: "date" },
        { data: "visit_type" },
        { data: "nurse" },
        { data: "client" },
        {
            data: "id",
            render: function (data) {
                return (
                    ` <div class="row">
            <div class="col-md-4"><i class="fa-solid fa-pen-to-square fa-xl" style="color: #00D100;" data-bs-toggle="modal" data-bs-target="#exampleModal" id="btnEdit" data-id="` +
                    data +
                    `"></i></div> 
        </div>`
                );
            },
        }, // You can specify default content for the Actions column if needed
    ],
});


$(document).ready(function () {
    $(document).on("click", ".chkSendToBill", function () {
        if ($(this).is(":checked")) {
            $(".sendToBill").text("Save & Send To Bill");
        } else {
            $(".sendToBill").text("Save");
        }
    });

    $(document).on("click", "#btnEdit", function () {
        var id = $(this).data("id");

        $.ajax({
            type: "post",
            url: "medrecords/get_md_records",
            data: { id: id },
            success: function (data) {
                $("#mdMdRecords").html(data);
            },
        });
    });

    $(document).on("submit", "#frmSaveMdRecord", function () {
        var formData = new FormData(this);

        $.ajax({
            type: "post",
            url: "medrecords/save_record",
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




    $(document).change("#time_in, #time_out", function (e) {
        var timeIn = flatpickr.parseDate($("#time_in").val(), "H:i");
        var timeOut = flatpickr.parseDate($("#time_out").val(), "H:i");

        var diffInMillisecs = timeOut - timeIn;
    var diffInMinutes = Math.floor(diffInMillisecs / (1000 * 60));
       
    
       
        var hours = Math.floor(diffInMinutes / 60);
        var minutes = diffInMinutes % 60;
        
        var totalTime = hours.toString().padStart(2, '0') + ':' + minutes.toString().padStart(2, '0');
        $("#total_time").val(totalTime);

              
    });



});

