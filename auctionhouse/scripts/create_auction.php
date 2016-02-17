<?php
require_once "helper_functions.php";
require_once "../classes/class.session_operator.php";
require_once "../classes/class.validation_operator.php";
require_once "../classes/class.query_operator.php";


// Only process when start auction button was clicked
if ( !isset( $_POST[ "startAuction" ] ) )
{
    redirectTo( "../views/create_auction_view.php" );
}


// Store POST values
$new_auction = [
    "item"            => $_POST[ "item" ],
    "itemName"        => $_POST[ "itemName" ],
    "itemBrand"       => $_POST[ "itemBrand" ],
    "itemCategory"    => $_POST[ "itemCategory" ],
    "itemCondition"   => $_POST[ "itemCondition" ],
    "itemDescription" => $_POST[ "itemDescription" ],
    "quantity"        => $_POST[ "quantity" ],
    "startTime"       => $_POST[ "startTime" ],
    "endTime"         => $_POST[ "endTime" ],
    "startPrice"      => $_POST[ "startPrice" ],
    "reservePrice"    => $_POST[ "reservePrice" ] ];


// Add empty string for default selects
if ( $new_auction[ "itemCategory" ] == "Select" )
{
    $new_auction[ "itemCategory" ]  = "";
}
if ( $new_auction[ "itemCondition" ] == "Select" )
{
    $new_auction[ "itemCondition" ]  = "";
}


// Check inputs
if ( ValidationOperator::hasEmtpyFields( $new_auction ) ||
     ( $upload = ValidationOperator::checkImage() ) == null ||
     !ValidationOperator::checkPrizes( $new_auction[ "startPrice" ], $new_auction[ "reservePrice" ] ) )
{
    // Create a session for all inputs so that they can be recovered after the page returns
    SessionOperator::setFormInput( $new_auction );

    // Redirect back
    redirectTo( "../views/create_auction_view.php" );
}
// Form valid
else
{
    redirectTo( "../views/dashboard_view.php" );
}



