$(document).ready(function(){
    new getAlert();
});


function getAlert(){
    var alerts = $.ajax({
        type: "POST",
        url: "../../scripts/get_alerts.php",
        async: false
    }).complete(function(){
        setTimeout(function(){getAlert();}, 10000 );
    }).responseText;

    console.log(alerts);

    if ( alerts.length ) {
        $('#last').remove();
        var numberOfLis = $('ul#alerts li').length;

        if ( numberOfLis > 0 ){
            $('#alerts li:eq(0)').before( alerts );
        } else {
            $('#alerts').append( alerts );
        }
        $('#alerts').append(
            "<li id=\"last\">" +
            "<a class=\"text-center\" href=\"../views/my_notifications_view.php\"> <strong>See All Alerts</strong> <i class=\"fa fa-angle-right\"></i></a>" +
            "</li>"
        );

        var currentAlerts = parseInt( $('#alertCounter').text() );
        var newAlertsCount = ( alerts.match(/<li id=/g) || [] ).length;
        console.log( "old" + currentAlerts );

        console.log( "new " + (currentAlerts + newAlertsCount));
        $('#alertCounter').text( (currentAlerts + newAlertsCount) );
        $('#alertCounter').show();
    }
}


$(document).ready(function(){
    $('.dropdown-menu').click(function(e) {
        var pieces = e.target.id.split('_');
        if (e.target.nodeName === 'BUTTON') {
            e.stopPropagation();
            $.ajax({
                type: "GET",
                url: "../../scripts/have_seen.php?notificationId=" + pieces[ 1 ],
                async: false
            });
            var notification = "#notification" + pieces[ 1 ];
            var divider = "#divider" + pieces[ 1 ];
            console.log( notification );
            $( notification).fadeOut(300, function() {
                $(this).remove();
                $(divider).remove();
                var currentAlerts = parseInt( $('#alertCounter').text() ) - 1;
                $('#alertCounter').text( currentAlerts );
                if ( currentAlerts == 0 ) {
                    $('#alertCounter').hide();
                }
            });
        }
    });
});