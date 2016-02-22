<?php


$faker = Faker\Factory::create();


///create bids

$userIds = DbUser::listIds();
$auctions= DbAuction::withConditions()->getAsClasses();




$auctionsWithBids= $faker->randomElements($auctions, count($auctions)/2);
foreach ($auctionsWithBids as $auctionWithBid){

    $userIdsWithoutOwner = listUserIdsWithoutOwner($auctionWithBid, $userIds);
    makeBidsForAuction($auctionWithBid, $faker->numberBetween(1, 20), $userIdsWithoutOwner);
}


function makeBidsForAuction($auction, $numBids, $userIds){

    $faker = Faker\Factory::create();

    $startTime = new DateTime($auction->getField("startTime") );

    $endTime = new DateTime($auction->getField("endTime") );
    date_sub($endTime, date_interval_create_from_date_string("5 seconds"));

    $bidInterval = (int)(($endTime->getTimestamp() - $startTime->getTimestamp())/ $numBids);

    $price = $auction->getField("startPrice");

    for ($i = 0 ; $i<$numBids ; $i++){

        $time = new DateTime('@'.($startTime->getTimestamp()+ ($bidInterval * ($i+1))));
        $price = $price + $faker->randomFloat(2, 1.00, 10.00);

        $bid = new DbBid(array(
            "userId" => $faker->randomElement($userIds),
            "auctionId" =>$auction->getId(),
            "bidTime" => $time->format('Y-m-d H:i:s'),
            "bidPrice" =>$price
        ));
        $bid->create();

    }
}

function listUserIdsWithoutOwner($auction, $userIds){

    $item = DbItem::find($auction->getField("itemId"));
    $ownerId = DbUser::find($item->getField("userId"))->getId();

    $key = array_search($ownerId, $userIds);
    unset($userIds[$key]);
    return$userIds;
}




