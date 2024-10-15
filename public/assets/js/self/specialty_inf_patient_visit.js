$("#myDatatable").DataTable({
  ajax: {
    url: "reports/dt_specialty_infusion_patient_visit",
    type: "GET",
    data: function (d) {
      d.draw = 1;
    }
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
    { data: "ref_source" },
    { data: "patient" },
    { data: "dob" },
    { data: "visit_date" },
    { data: "primary_rn" },
    { data: "visit_type" },
    { data: "case" },
    { data: "created_at" },
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
        const date = new Date(data[4]);
        
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