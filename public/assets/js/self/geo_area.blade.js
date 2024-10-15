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

    $(document).on("submit", "#frmArea", function () {
        var formData = new FormData(this);

        $.ajax({
            type: "post",
            url: "nurse/save_area",
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


    var input2 = document.querySelector("#kt_tagify_2");

    new Tagify(input2);



});
