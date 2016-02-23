<?php
require_once "helper_functions.php";
require_once "../classes/class.session_operator.php";



// Browse to a different category
if ( isset( $_GET[ "activeCategory" ] ) )
{
    // Update session
    SessionOperator::updateSearchSetting( SessionOperator::ACTIVE_CATEGORY, $_GET[ "activeCategory" ] );

    // TODO: filter auctions
}


// Return back to search page
redirectTo( "../views/search_view.php" );
