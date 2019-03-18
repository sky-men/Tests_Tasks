$(document).ready(function() {
    handles();
});

function handles()
{
    var datepicker_opt = {
        changeMonth: true,
        changeYear: true
    };

    $( "#from" ).datepicker(datepicker_opt);

    $( "#to" ).datepicker(datepicker_opt);

    $("#purchases_tbl").tablesorter({sortList: [[0,0], [1,0]]} );

    $('#filer').on("submit", function(event){
        event.preventDefault();

        $.blockUI();

        var url =window.location+'?from='+$('#from').val()+'&to='+$('#to').val();

        $.get(url, function(data){
            $( "#content").html(data);

            handles();

        }, 'html').complete(function() {  $.unblockUI(); });
    });
}