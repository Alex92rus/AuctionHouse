<?php
require_once "../classes/class.query_operator.php";
require_once "../classes/class.recommender_system.php";


ini_set('max_execution_time', 3600);


// Get all userIds and the auctions they have bin on
$allUserBids = QueryOperator::getUsersBidOnAuctions();
$allLiveAuctions = QueryOperator::getAllLiveAuctions();

// For each userId calculate their recommended auctions
foreach ( $allUserBids as $currentUserId => $currentUserBidOnAuctions )
{
    // Get a new array with all remaining userIds and the auctions they have bin on
    $remainingUserBids = $allUserBids;
    unset( $remainingUserBids[ $currentUserId ] );

    // Remove users with unrelated bids
    foreach ( $remainingUserBids as $otherUserId => $otherUserBidOnAuctions )
    {
        $intersect = array_intersect( $currentUserBidOnAuctions, $otherUserBidOnAuctions );
        if ( empty( $intersect ) )
        {
            unset( $remainingUserBids[ $otherUserId ] );
        }
    }

    // Calculate recommendation array
    $recommendations = RecommenderSystem::getRecommendedAuctions( $remainingUserBids );

    // Ret recommended auctionIds that are still running (live)
    $recommendedAuctionIds = array_keys( $recommendations );
    $recommendedAuctionIds = array_intersect( $allLiveAuctions, $recommendedAuctionIds );

    // Prepare recommendation list string
    $list = "";
    $counter = 0;
    $total = count( $recommendedAuctionIds );
    foreach ( $recommendedAuctionIds as $auctionId )
    {
        $list .= $auctionId;
        if ( $counter < $total - 1 )
        {
            $list .= ",";
        }
        $counter++;
    }

    //Store string in the database
    QueryOperator::setUserRecommendations( $currentUserId, $list );
}


