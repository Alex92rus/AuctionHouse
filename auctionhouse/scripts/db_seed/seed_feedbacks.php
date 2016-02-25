<?php

global $faker;
global $auctions;
global $userIds;

$soldAuctions = DbAuction::withConditions("WHERE `sold` = 1")->getAsClasses();

foreach ($soldAuctions as $auction) {

    if($faker->boolean(100)){
        makeFeedbackBySeller($auction,$faker->numberBetween(1,5), $faker->sentence());
    }

    if($faker->boolean(100)){
        makeFeedbackByBuyer($auction, $faker->numberBetween(1,5), $faker->sentence());
    }

}


/**
 * @param $auction DbAuction
 * @param $score int
 * @param $comment string
 */


function makeFeedbackBySeller($auction, $score, $comment){

    $feedback = new DbFeedback(array(
        "auctionId" => $auction->getId(),
        "receiverId" =>getBuyerId($auction),
        "creatorId" => getSellerId($auction),
        "score"     =>$score,
        "comment"   =>$comment
    ));
    $feedback->create();

}
/**
 * @param $auction DbAuction
 * @param $score int
 * @param $comment string
 */

function makeFeedbackByBuyer($auction, $score, $comment){

    $feedback = new DbFeedback(array(
        "auctionId" => $auction->getId(),
        "receiverId" =>getSellerId($auction),
        "creatorId" => getBuyerId($auction),
        "score"     =>$score,
        "comment"   =>$comment
    ));
    $feedback->create();
}

/**
 * @param $auction DbAuction
 * @return mixed
 */

function getSellerId($auction){
    $itemId = $auction->getField("itemId");
    $item = DbItem::find($itemId);
    return $item->getField("userId");


}

/**
 * @param $auction DbAuction
 * @return mixed
 */

function getBuyerId($auction){

    $bids = DbBid::withConditions("WHERE `auctionId` =". $auction->getId() . " ORDER BY `bidPrice` DESC")->getAsClasses();
    $highestBid = $bids[0];
    return $highestBid->getField("userId");


}