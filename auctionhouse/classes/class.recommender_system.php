<?php

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