<?php

global $auctions;
global $faker;
global $userIds;

foreach ($auctions as $auction) {

    $userIdsWithoutOwner = listUserIdsWithoutAuctionOwner($auction, $userIds);
    $numWatches = 0;
    if($numBids= $auction->getField("numBids")){
        $numWatches = (int)($numBids * $faker->randomFloat(1,0.5, 1.5));
        //addWatches($auction, $userIdsWithoutOwner, (int)($numBids * $faker->randomFloat(0.5, 1.5)));
    }else{
        if( $faker->boolean(30)){

            $numWatches = $faker->numberBetween(1,5);
        }
    }

    //echo "numwatches: ". $numWatches . "\t";
    addWatches($auction, $userIdsWithoutOwner, $numWatches);

    //addWatches($auction, $userIdsWithoutOwner);
}


/**
 * @param $auction DbAuction
 * @param $userIds array
 * @param int $numWatches
 */
function addWatches($auction, &$userIds, $numWatches = 1)
{


    global $faker;
    for ($i = 0; $i < $numWatches; $i++) {


        $userId = $faker->randomElement($userIds);
        $auctionWatch = new DbAuctionWatch(array(
            "userId" => $userId,
            "auctionId" => $auction->getId()
        ));
        $auctionWatch->create();
        $key = array_search($userId, $userIds);
        unset($userIds[$key]);
    }

}