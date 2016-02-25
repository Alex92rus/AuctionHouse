$(document).ready(function(e){
    $('.search-panel .dropdown-menu').find('a').click(function(e) {
        e.preventDefault();
        var param = $(this).attr("href").replace("#","");
        var concept = $(this).text();
        $('.search-panel span#search_concept').text(concept);
        $('.input-group #searchCategory').val(param);
    });
});


$(document).ready(function(){
    $("#moreCategories").on("hide.bs.collapse", function(){
        $("a#showCategories").text( "Show more categories" );
    });
    $("#moreCategories").on("show.bs.collapse", function(){
        $("a#showCategories").text( "Hide categories" );
    });
});

