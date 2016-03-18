<?php

global $faker;
global $auctions;
global $userIds;
global $reportFrequencies;


/*$auctionsWithBids = DbAuction::withConditions("WHERE startTime < now()")->getAsClasses();
$auctionsWithBids = $faker->randomElements($auctionsWithBids, count($auctionsWithBids) / 5);

foreach ($auctionsWithBids as $auctionWithBid) {

    $userIdsWithoutOwner = listUserIdsWithoutAuctionOwner($auctionWithBid, $userIds);
    makeBidsForAuction($auctionWithBid, $faker->numberBetween(1, 20), $userIdsWithoutOwner);
}*/

$now = new DateTime();
foreach ($auctions as $auction) {

    $start = new DateTime($auction->getField("startTime"));
    if($start < $now){
        if($faker->boolean(50)){
            $userIdsWithoutOwner = listUserIdsWithoutAuctionOwner($auction, $userIds);
            makeBidsForAuction($auction, $faker->numberBetween(1, 20), $userIdsWithoutOwner);
        }
    }

}



/**
 * @param $auction DbAuction
 * @param $numBids int
 * @param $userIds array
 */

function makeBidsForAuction($auction, $numBids, $userIds)
{

    $faker = Faker\Factory::create();

    $startTime = new DateTime($auction->getField("startTime"));

    $endTime = new DateTime($auction->getField("endTime"));
    date_sub($endTime, date_interval_create_from_date_string("5 seconds"));

    $bidInterval = (int)(($endTime->getTimestamp() - $startTime->getTimestamp()) / $numBids);

    $price = (double)$auction->getField("startPrice");

    $userId = null;
    for ($i = 0; $i < $numBids; $i++) {

        $time = new DateTime('@' . ($startTime->getTimestamp() + ($bidInterval * ($i + 1))));
        $price = $price + 0.5 * $faker->numberBetween(2, 10);

        $userId = $faker->randomElement($userIds);
        $bid = new DbBid(array(
            "userId" => $userId,
            "auctionId" => $auction->getId(),
            "bidTime" => $time->format('Y-m-d H:i:s'),
            "bidPrice" => $price
        ));
        $bid->create();
        $auction->setField("highestBid",$price);


    }
    $auction->setField("numBids", $numBids);
    $auction->setField("highestBidderId", $userId);
    $auction->save();
    //addViews($auction, $numBids);
}


