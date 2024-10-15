$(document).ready(function () {
    $(document).on("submit", "#frmDemo", function () {
        var formData = new FormData(this);

        $.ajax({
            type: "post",
            url: "patient/save-patient",
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

    $(document).on("submit", "#frmService", function () {
        var formData = new FormData(this);

        $.ajax({
            type: "post",
            url: "patient/save-service",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function () {
                $("#kt_sign_in_submit_serviceInfo").attr("data-kt-indicator", "on");
                $("#kt_sign_in_submit_serviceInfo").attr("disabled", true);
            },
            success: function (data) {
                if (data.errors) {
                    $.each(data.errors, function (field, error) {
                        $("." + field + "-error").text(error[0]);
                    });

                    $("#kt_sign_in_submit_serviceInfo").attr("data-kt-indicator", "off");
                    $("#kt_sign_in_submit_serviceInfo").attr("disabled", false);
                } else if (data.logginError) {
                    toastr.error("Error", data.logginError);
                    $("#kt_sign_in_submit_serviceInfo").attr("data-kt-indicator", "off");
                    $("#kt_sign_in_submit_serviceInfo").attr("disabled", false);
                } else if (data.success) {
                    toastr.success("Successful", data.success);
                    setTimeout(function () {
                        location.reload();
                    }, 3000);
                }
            },
        });
    });


    $(document).on("submit", "#frmPhyInfo", function () {
        var formData = new FormData(this);

        $.ajax({
            type: "post",
            url: "patient/save-phyinfo",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function () {
                $("#kt_sign_in_submit_phInfo").attr("data-kt-indicator", "on");
                $("#kt_sign_in_submit_phInfo").attr("disabled", true);
            },
            success: function (data) {
                if (data.errors) {
                    $.each(data.errors, function (field, error) {
                        $("." + field + "-error").text(error[0]);
                    });

                    $("#kt_sign_in_submit_phInfo").attr("data-kt-indicator", "off");
                    $("#kt_sign_in_submit_phInfo").attr("disabled", false);
                } else if (data.logginError) {
                    toastr.error("Error", data.logginError);
                    $("#kt_sign_in_submit_phInfo").attr("data-kt-indicator", "off");
                    $("#kt_sign_in_submit_phInfo").attr("disabled", false);
                } else if (data.success) {
                    toastr.success("Successful", data.success);
                    setTimeout(function () {
                        location.reload();
                    }, 3000);
                }
            },
        });
    });


    $(document).on("submit", "#frmPayor", function () {
        var formData = new FormData(this);

        $.ajax({
            type: "post",
            url: "patient/save-payor",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function () {
                $("#kt_sign_in_submit_payorInfo").attr("data-kt-indicator", "on");
                $("#kt_sign_in_submit_payorInfo").attr("disabled", true);
            },
            success: function (data) {
                if (data.errors) {
                    $.each(data.errors, function (field, error) {
                        $("." + field + "-error").text(error[0]);
                    });

                    $("#kt_sign_in_submit_payorInfo").attr("data-kt-indicator", "off");
                    $("#kt_sign_in_submit_payorInfo").attr("disabled", false);
                } else if (data.logginError) {
                    toastr.error("Error", data.logginError);
                    $("#kt_sign_in_submit_payorInfo").attr("data-kt-indicator", "off");
                    $("#kt_sign_in_submit_payorInfo").attr("disabled", false);
                } else if (data.success) {
                    toastr.success("Successful", data.success);
                    setTimeout(function () {
                        location.reload();
                    }, 3000);
                }
            },
        });
    });



    $(document).on("change", "#birthdate", function () {

            var birthdate = $("#birthdate").val();
            var today = new Date();
            var selectedDate = new Date(birthdate);
            var yearsDiff = today.getFullYear() - selectedDate.getFullYear();
            var monthsDiff = today.getMonth() - selectedDate.getMonth();
            var daysDiff = today.getDate() - selectedDate.getDate();
        
            if (monthsDiff < 0 || (monthsDiff === 0 && daysDiff < 0)) {
                yearsDiff--;
                monthsDiff += 12;
        
                // Calculate the number of days in the previous month
                var prevMonth = new Date(today.getFullYear(), today.getMonth() - 1, 1);
                daysDiff += (selectedDate.getDate() - prevMonth.getDate());
            }
        
            var ageString = "";
        
            if (yearsDiff > 0) {
                ageString += yearsDiff + (yearsDiff === 1 ? " year" : " years");
            }
        
            if (monthsDiff > 0) {
                if (ageString !== "") {
                    ageString += " and ";
                }
                ageString += monthsDiff + (monthsDiff === 1 ? " month" : " months");
            }
        
            if (daysDiff > 0) {
                if (ageString !== "") {
                    ageString += " and ";
                }
                ageString += daysDiff + (daysDiff === 1 ? " day" : " days");
            }
        
            if (ageString === "") {
                ageString = "Less than a day";
            }
        
            $("#age").val(ageString);
        
    });

    CalAge();
    function CalAge() {
        var birthdate = $("#birthdate").val();
        var today = new Date();
        var selectedDate = new Date(birthdate);
        var yearsDiff = today.getFullYear() - selectedDate.getFullYear();
        var monthsDiff = today.getMonth() - selectedDate.getMonth();
        var daysDiff = today.getDate() - selectedDate.getDate();
    
        if (monthsDiff < 0 || (monthsDiff === 0 && daysDiff < 0)) {
            yearsDiff--;
            monthsDiff += 12;
    
            // Calculate the number of days in the previous month
            var prevMonth = new Date(today.getFullYear(), today.getMonth() - 1, 1);
            daysDiff += (selectedDate.getDate() - prevMonth.getDate());
        }
    
        var ageString = "";
    
        if (yearsDiff > 0) {
            ageString += yearsDiff + (yearsDiff === 1 ? " yr" : " yrs");
        }
    
        if (monthsDiff > 0) {
            if (ageString !== "") {
                ageString += ",";
            }
            ageString += monthsDiff + (monthsDiff === 1 ? " month" : " months");
        }
    
        if (daysDiff > 0) {
            if (ageString !== "") {
                ageString += ",";
            }
            ageString += daysDiff + (daysDiff === 1 ? " day" : " days");
        }
    
        if (ageString === "") {
            ageString = "Less than a day";
        }
    
        $("#age").val(ageString);
    }

    $(document).on("change", "#cert_from", function () {
        var certFrom = $("#cert_from").val();
        var selectedDate = new Date(certFrom);

        // var certTo = new Date(selectedDate);
        var cert = selectedDate.setDate(selectedDate.getDate() + 60);
        var certToString = selectedDate.toLocaleDateString();

        // Convert certToString to ISO format (YYYY-MM-DD)
        var isoDate = selectedDate.toISOString().split("T")[0];

        // Set the value of the HTML date input field
        $("#cert_to").val(isoDate);
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
