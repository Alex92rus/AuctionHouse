<?php
require_once "../classes/class.helper_operator.php";
require_once "../classes/class.query_operator.php";
require_once "../classes/class.validation_operator.php";
require_once "../classes/class.email.php";

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
        // Send email to outbidded user
        $highestBid = QueryOperator::getAuctionBids( $auctionId, 1 )[ 0 ];
        if ( !empty( $highestBid ) && ( $email = $highestBid -> getBidderEmail() ) != $user -> getEmail() )
        {
            $outbidEmail = new Email( $email, $highestBid -> getBidderFirstName(), $highestBid -> getBidderLastName() );
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

        // Set feedback session
        SessionOperator::setFeedback( SessionOperator::PLACED_BID );
    }
}


// Return back to page
HelperOperator::redirectTo( "../views/open_live_auction_view.php?liveAuction=" . $auctionId . "&s=1" );