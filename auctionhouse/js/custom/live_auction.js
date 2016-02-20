$(document).ready(function() {
    $('[id^=more-details-]').hide();
    $('.toggle').click(function() {
        $input = $( this );
        $target = $('#'+$input.attr('data-toggle'));
        $target.slideToggle();
        if( $("#view-all").hasClass("fa-chevron-down") )
        {
            $("#view-all").removeClass( "fa-chevron-down" );
            $("#view-all").addClass( "fa-chevron-up" );
        }
        else
        {
            $("#view-all").removeClass( "fa-chevron-up" );
            $("#view-all").addClass( "fa-chevron-down" );
        }
    });
});



$(document).ready(function() {
    $('#dataTables-example').DataTable({
        "order": [[ 0, "desc" ]],
        "bLengthChange": false,
        responsive: true
    });
});