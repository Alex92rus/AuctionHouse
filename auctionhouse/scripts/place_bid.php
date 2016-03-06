<?php
require_once "../classes/class.helper_operator.php";
require_once "../classes/class.query_operator.php";
require_once "../classes/class.validation_operator.php";

$auctionId = null;


if ( isset( $_GET[ "auctionId" ] ) && isset( $_GET[ "userId" ] ) && isset( $_GET[ "bidPrice" ] ) )
{
    $auctionId = ( int ) $_GET[ "auctionId" ];
    $userId = ( int ) $_GET[ "userId" ];
    $bidPrice = $_GET[ "bidPrice" ];

    // Incorrect inputs
    if ( ValidationOperator::hasEmtpyFields( $_GET ) ||
        !ValidationOperator::isPositiveNumber( $bidPrice, "bidPrice" ) ||
        !ValidationOperator::checkBidPrice( $bidPrice, $auctionId ) )
    {
        // Create a session for bid price so that it can be recovered after the page returns
        SessionOperator::setFormInput( [ "bidPrice" => $bidPrice ] );
    }
    // Correct inputs
    else
    {
        echo "make bid";
        //QueryOperator::placeBid( $auctionId, $userId, $bidPrice );
    }
}


// Return back to page
HelperOperator::redirectTo( "../views/open_live_auction_view.php?liveAuction=" . $auctionId );