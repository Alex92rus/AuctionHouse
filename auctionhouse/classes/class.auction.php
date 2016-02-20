<?php


class Auction extends DbEntity
{
    protected $tableName = "auctions";

    protected $primaryKey = "auctionId";

    protected $fields = array(

        "itemId" => true,
        "userId" => true,
        "bidId" => false,
        "quantity" => true,
        "startPrice" => true,
        "reservePrice" =>false,
        "startTime" =>true,
        "endTime" => true,
        "sold" => true

    );
}