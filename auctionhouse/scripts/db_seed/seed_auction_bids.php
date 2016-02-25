<?php

global $faker;
global $auctions;
global $userIds;

$auctionsWithBids = $faker->randomElements($auctions, count($auctions) / 2);

foreach ($auctionsWithBids as $auctionWithBid) {

    $userIdsWithoutOwner = listUserIdsWithoutAuctionOwner($auctionWithBid, $userIds);
    makeBidsForAuction($auctionWithBid, $faker->numberBetween(1, 20), $userIdsWithoutOwner);
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

    $price = $auction->getField("startPrice");

    for ($i = 0; $i < $numBids; $i++) {

        $time = new DateTime('@' . ($startTime->getTimestamp() + ($bidInterval * ($i + 1))));
        $price = $price + $faker->randomFloat(2, 1.00, 10.00);

        $bid = new DbBid(array(
            "userId" => $faker->randomElement($userIds),
            "auctionId" => $auction->getId(),
            "bidTime" => $time->format('Y-m-d H:i:s'),
            "bidPrice" => $price
        ));
        $bid->create();
        $auction->setField("highestBid",$price);


    }
    $auction->setField("numBids", $numBids);
    //addViews($auction, $numBids);
}


