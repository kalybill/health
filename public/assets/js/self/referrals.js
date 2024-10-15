 $("#myDatatable").DataTable({
        
    ajax: {
        url: 'dt_referrals',
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
        { data: 'name'},
        { data: 'mrn'},
        { data: 'access_type'},
        { data: 'pump'},
        { data: 'ref_src'},
        { data: 'ref_date'},
        { data: 'soc_date'},
        { data: 'status'},
        { data: 'id',
          render: function(data){
            return ` <div class="row">
            <div class="col-md-6"><i class="fa-solid fa-pen-to-square fa-xl" style="color: #00D100;" data-bs-toggle="modal" data-bs-target="#mdEdit" id="btnEdit" data-id="`+data+   `"></i></div> 
            `;
          }
        }, // You can specify default content for the Actions column if needed
    ],
});
{/* <div class="col-md-6" ><i class="fa-solid fa-trash fa-xl" style="color: #E32227;" data-bs-toggle="modal" data-bs-target="#delModal" id="dataID" data-id="`+data+`"></i></div></div> */}
// Filter Datatable
// var handleFilterDatatable = () => {
//     // Select filter options
//     filterPayment = document.querySelectorAll('[data-kt-docs-table-filter="payment_type"] [name="payment_type"]');
//     const filterButton = document.querySelector('[data-kt-docs-table-filter="filter"]');

//     // Filter datatable on submit
//     filterButton.addEventListener('click', function () {
//         // Get filter values
//         let paymentValue = '';

//         // Get payment value
//         filterPayment.forEach(r => {
//             if (r.checked) {
//                 paymentValue = r.value;
//             }

//             // Reset payment value if "All" is selected
//             if (paymentValue === 'all') {
//                 paymentValue = '';
//             }
//         });

//         // Filter datatable --- official docs reference: https://datatables.net/reference/api/search()
//         dt.search(paymentValue).draw();
//     });
// };

// Call the filter function
// handleFilterDatatable();

$(document).ready(function () {
    $('.order_description_repeater').repeater({
        initEmpty: false,
    
        defaultValues: {
            'text-input': 'foo'
        },
    
        show: function () {
            $(this).slideDown();
        },
    
        hide: function (deleteElement) {
            $(this).slideUp(deleteElement);
        }
    });


    $('.potential_nurse_repeater').repeater({
        initEmpty: false,
    
        defaultValues: {
            'text-input': 'foo'
        },
    
        show: function () {
            $(this).slideDown();
            
        },
    
        hide: function (deleteElement) {
            $(this).slideUp(deleteElement);
        }
    });

    

    $(document).on('submit','#frmReferral',function () { 
        var formData = new FormData(this);

        $.ajax({
            type: "post",
            url: "referrals",
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
        })

    });


    $(document).on('submit','#frmUpReferral',function () { 
        var formData = new FormData(this);

        $.ajax({
            type: "post",
            url: "update_referrals",
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
        })

    });



    $(document).on('click','#btnEdit',function () { 
        var id = $(this).data('id');
        $.ajax({
            type: "post",
            url: "edit_referrals",
            data: {'id': id},
            success: function (data) {
                $('#mdBody').html(data)

                $(".kt_datepicker").flatpickr({
                    dateFormat: "m-d-Y",
                    allowInput: true,
        
                });

                $('#mdBody select[data-control="select2"]').select2();
            }
        });
    });


    $(document).on('click','#dataID', function(){
        var id = $(this).data('id');
        
        $.ajax({
            type: "get",
            url: "find_single_referral",
            data: {'id' : id},
            success: function (data) {
                $('#delDescription').text(data.name);
                $('#InputVal').val(id);
            }
        });
        
    })


    $(document).on('click','#btnDelete',function () { 
        var id = $('#InputVal').val();
        
        $.ajax({
            type: "post",
            url: "referral-delete",
            data: {'id' : id},
            success: function (data) {
                showSuccessMessage('Deleted');
            }
        });
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