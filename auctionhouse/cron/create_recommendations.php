<?php
// Set unlimited time limit
set_time_limit(0);

// Get all userIds and the auctions they have bin on
$cronDb = new CronQueryOperator();
$allUserBids = $cronDb -> getUsersBidOnAuctions();
$cronDb = new CronQueryOperator();
$allLiveAuctions = $cronDb -> getAllLiveAuctions();


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
    $allRecommendations = RecommenderSystem::getRecommendedAuctions( $remainingUserBids );

    // Get recommended auctions that are still running (live)
    $allRecommendedAuctionIds = array_keys( $allRecommendations );
    $liveRecommendedAuctionIds = array_intersect( $allRecommendedAuctionIds, $allLiveAuctions);
    $liveRecommendedAuctions = [];
    foreach ( $liveRecommendedAuctionIds as $auctionId )
    {
        $liveRecommendedAuctions[ $auctionId ] = $allRecommendations[ $auctionId ];
    }

    // Store recommended auctions into the database
    $cronDb = new CronQueryOperator();
    $cronDb -> setAuctionRecommendation( $currentUserId, $liveRecommendedAuctions );
}





// Recommender System
class RecommenderSystem
{
    public static function getRecommendedAuctions( $userBids )
    {
        $matchList = [];

        // Compare each user with each user
        foreach ( $userBids as $userA => $userABids )
        {
            foreach ( $userBids as $userB => $userBBids )
            {
                if ( $userB <= $userA )
                {
                    continue;
                }

                // Get mutual auctionIds both users bid on
                $matches = array_intersect( $userABids, $userBBids );
                if ( !empty( $matches ) )
                {
                    // For each common auctionId, increment its counter
                    foreach( $matches as $match )
                    {
                        if ( array_key_exists( $match, $matchList ) )
                        {
                            $sum = $matchList[ $match ];
                            $matchList[ $match ] = ++$sum;
                        }
                        else
                        {
                            $matchList[ $match ] = 1;
                        }
                    }
                }
            }

        }

        // First sort values (number of matches) in desc order, then sort keys (auctionIds) in asc asc order
        $k = array_keys( $matchList );
        $v = array_values( $matchList );
        array_multisort( $v, SORT_DESC, $k, SORT_ASC );
        $matchList = array_combine( $k, $v );

        // Return the first 50 auctions with the highest matches
        $matchList = array_slice( $matchList, 0, 50, true );
        return $matchList;
    }
}



// Cron job query operator
class CronQueryOperator
{
    private $connection;


    public function __construct()
    {
        // Set up connection
        $this -> connection = new mysqli( "localhost", "root", "", "auctionsystem", "3306" );
        if ( $this -> connection -> connect_error )
        {
            die( "Database connection failed: " . $this -> connection -> connect_error );
        }
    }


    private function checkForErrors( $result )
    {
        if ( !$result )
        {
            die( "Failure when performing recommendations updates "  . mysqli_error( $this -> connection ) );
        }
        return $result;
    }


    public function setAuctionRecommendation( $userId, $recommendedAuctions )
    {
        // Delete out of date recommendations
        $deleteQuery = "delete from recommendations where userId = $userId";
        $this -> checkForErrors( $this -> connection -> query( $deleteQuery ) );

        // Insert new recommendations
        foreach ( $recommendedAuctions as $auctionId => $score )
        {
            $insertQuery = "insert into recommendations(userId, auctionId, score) VALUES( $userId, $auctionId, $score )";
            $this -> checkForErrors( $this -> connection -> query( $insertQuery ) );
        }

        $this -> connection ->close();
    }


    private function getBidOnAuctions( $userId )
    {
        // SQL for retrieving all distinct auctions a user has bid on
        $query  = "select distinct auctionId from bids where userId = $userId";
        $result = $this -> checkForErrors( $this -> connection -> query( $query ) );

        $auctionIds = [];
        while ( $row = $result -> fetch_row() )
        {
            $auctionIds[] = $row[ 0 ];
        }

        return $auctionIds;
    }


    public function getUsersBidOnAuctions()
    {
        // SQL for retrieving all verified users expect the specified one
        $query  = "select userId from users where userId not in ( select userId from unverified_users) order by userId asc";
        $result = $this -> checkForErrors( $this -> connection -> query( $query ) );

        $users = [];
        while ( $row = $result -> fetch_row() )
        {
            $bids = $this -> getBidOnAuctions( $row[ 0 ] );
            if ( !empty( $bids ) )
            {
                $users[ $row[ 0 ] ] = $bids;
            }
        }

        $this -> connection ->close();
        return $users;
    }


    public function getAllLiveAuctions()
    {
        // SQL for retrieving all live auctions (not expired yet)
        $query  = "select auctionId from auctions where endTime > NOW()";
        $result = $this -> checkForErrors( $this -> connection -> query( $query ) );
        $this -> connection ->close();

        $auctionIds = [];
        while ( $row = $result -> fetch_row() )
        {
            $auctionIds[] = $row[ 0 ];
        }

        return $auctionIds;
    }
}
