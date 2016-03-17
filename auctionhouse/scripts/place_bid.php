<?php
require_once "../classes/class.helper_operator.php";
require_once "../classes/class.query_operator.php";
require_once "../classes/class.validation_operator.php";
require_once "../classes/class.email.php";
require_once "../classes/class.db_auction.php";

$auctionId = null;

if ( isset( $_GET[ "auctionId" ] ) && isset( $_GET[ "bidPrice" ] ) )
{
    $auctionId = ( int ) $_GET[ "auctionId" ];
    $bidPrice = $_GET[ "bidPrice" ];

    $auction = QueryOperator::getLiveAuction( $auctionId );
    $user = SessionOperator::getUser();
    $userId = ( int ) $user -> getUserId();

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
        // Notify outbid user (only if it is not the same user)
        $highestBidderId = $auction -> getHighestBidderId();
        if ( !is_null( $highestBidderId ) && $highestBidderId != $userId )
        {
            $comment  = "You were outbid on the auction \"" . $auction -> getItemName() . " " . $auction -> getItemBrand() . "\" by ";
            $comment .= "by \"" .$user -> getUserName() . "\". The new highest bid is " . $bidPrice . " GSP.";
            QueryOperator::addNotification( $highestBidderId, $comment, QueryOperator::NOTIFICATION_OUTBID );
        }


        $comment  = "You received a new bid on the auction \"" . $auction -> getItemName() . " " . $auction -> getItemBrand() . "\" by ";
        $comment .= "by \"" .$user -> getUserName() . "\". The new highest bid is " . $bidPrice . " GSP.";
        QueryOperator::addNotification( $auction -> getSellerId(), $comment, QueryOperator::NOTIFICATION_NEW_BID );

        // Place bid
        QueryOperator::placeBid( $auctionId, $userId, $bidPrice );
        $dbAuction = DbAuction::find($auctionId);
        $dbAuction->setField("highestBidderId", $userId);
        $dbAuction->save();

        // Set feedback session
        SessionOperator::setNotification( SessionOperator::PLACED_BID );
    }
}


// Return back to page
HelperOperator::redirectTo( "../views/open_live_auction_view.php?liveAuction=" . $auctionId . "&s=1" );