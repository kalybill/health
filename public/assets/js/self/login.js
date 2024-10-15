$(document).ready(function () {
    $(document).on('submit','#frmLogin',function () { 
        var formData = new FormData(this);
        $.ajax({
            type: "post",
            url: "login",
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
                        window.location.href = 'dashboard'
                    }, 3000)
                }
            }
        });
    });
});