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
        // Send email to outbidded user (only if it is not the same user)
        $highestBid = QueryOperator::getAuctionBids( $auctionId, 1 );
        if ( !empty( $highestBid ) && ( $email = $highestBid[ 0 ] -> getBidderEmail() ) != $user -> getEmail() )
        {
            $outbidEmail = new Email( $email, $highestBid[ 0 ] -> getBidderFirstName(), $highestBid[ 0 ] -> getBidderLastName() );
            $outbidEmail -> prepareOutbidEmail(
                $bidPrice,
                $user -> getUserName(),
                $auction -> getItemName(),
                $auction -> getItemBrand(),
                $auction -> getImage() );
            $outbidEmail -> sentEmail();
        }

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