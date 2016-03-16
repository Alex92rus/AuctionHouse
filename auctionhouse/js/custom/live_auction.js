$(document).ready(function() {
    $('[id^=more-details-]').hide();
    $('.toggle').click(function() {
        $input = $( this );
        $target = $('#'+$input.attr('data-toggle'));
        $target.slideToggle();
        var $icon = $input.find( "i" );
        if( $icon.hasClass("fa-chevron-down") )
        {
            $icon.removeClass( "fa-chevron-down" );
            $icon.addClass( "fa-chevron-up" );
        }
        else
        {
            $icon.removeClass( "fa-chevron-up" );
            $icon.addClass( "fa-chevron-down" );
        }
    });
});

$(document).ready(function() {
    $('[id^="dataTables-example"]').filter(
        function(){
            return this.id.match(/\d+$/);
        }).DataTable({
        "order": [[ 0, "desc" ]],
        responsive: true
    });
});

