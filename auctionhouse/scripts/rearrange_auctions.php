<?php
require_once "helper_functions.php";
require_once "../classes/class.session_operator.php";


// Search sorting
if ( isset( $_GET[ "sort" ] ) )
{
    // Update search setting session
    SessionOperator::setSearchSettings( SessionOperator::SORT, $_GET[ "sort" ] );
}
// Search filtering
else if ( isset( $_GET[ "categoryFilter" ] ) )
{
    // Update search setting session
    SessionOperator::setSearchSettings( SessionOperator::CATEGORY_FILTER, $_GET[ "categoryFilter" ] );
}


// Return back to search page
redirectTo( "../views/search_view.php" );
