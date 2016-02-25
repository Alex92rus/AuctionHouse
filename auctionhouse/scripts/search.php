<?php
require_once "helper_functions.php";
require_once "../classes/class.session_operator.php";


if ( isset( $_GET[ "searchCategory" ] ) && isset( $_GET[ "searchString" ] ) )
{
    // Set initial search setting sessions
    SessionOperator::setSearchSettings( SessionOperator::SEARCH_CATEGORY, $_GET[ "searchCategory" ] );
}

// Return back to search page
redirectTo( "../views/search_view.php" );
