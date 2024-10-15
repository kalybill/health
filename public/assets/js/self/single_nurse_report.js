$('#myDatatable').DataTable();

$(document).ready(function () {
    
    $(document).on('click','#btnView',function () { 
        var id = $(this).data('id')

        $.ajax({
            type: "post",
            url: "reports/view-md-records",
            data: {'id' : id},
            success: function (data) {
                $('#mdMdRecords').html(data)
            }
        });
    });
});