$("#myDatatable").DataTable({
    ajax: {
        url: "medrecords/dt_notes",
        type: "GET", // Or 'POST' depending on your server-side implementation
        data: function (d) {
            d.draw = 1; // You can set the 'draw' parameter here
        },
    },
    order: [[0, "desc"]],
    dom:
      "<'row'" +
      "<'col-sm-4 d-flex align-items-center justify-conten-start'l>" +
      "<'col-sm-4 d-flex align-items-center justify-content-end date-range-selector'f>" +
      "<'col-sm-4 d-flex align-items-center justify-content-end'B>" +
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
            </div> 
        </div>`
                );
            },
        }, // You can specify default content for the Actions column if needed
    ],
    buttons: ["csvHtml5", "pdfHtml5"],
  initComplete: function () {
    const dateRangeSelector = document.createElement('input');
    dateRangeSelector.setAttribute('type', 'text');
    dateRangeSelector.setAttribute('id', 'dateRangeSelector');
    dateRangeSelector.setAttribute('class', 'form-control form-control-sm');
    const dateRangeContainer = document.querySelector('.date-range-selector');
    dateRangeContainer.appendChild(dateRangeSelector);

    const table = this.api();

    const applyDateRangeFilter = function () {
      const minDate = $('#dateRangeSelector').data('minDate');
      const maxDate = $('#dateRangeSelector').data('maxDate');
      
      // Remove previous search function
      $.fn.dataTable.ext.search.pop();
      
      $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
        const date = new Date(data[1]);
        
        if (
          (minDate === undefined && maxDate === undefined) ||
          (minDate === undefined && date <= maxDate) ||
          (minDate <= date && maxDate === undefined) ||
          (minDate <= date && date <= maxDate)
        ) {
          return true;
        }
        return false;
      });

      table.draw();
    };

    $('#dateRangeSelector').daterangepicker({
      autoUpdateInput: true,
      locale: {
        cancelLabel: 'Clear',
        format: 'MM-DD-YYYY'
      }
    }).on('apply.daterangepicker', function (ev, picker) {
      $(this).data('minDate', picker.startDate.toDate());
      $(this).data('maxDate', picker.endDate.toDate());
      applyDateRangeFilter();
    }).on('cancel.daterangepicker', function (ev, picker) {
      $(this).val('');
      $(this).data('minDate', undefined);
      $(this).data('maxDate', undefined);
      applyDateRangeFilter();
      
    });
  }
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
