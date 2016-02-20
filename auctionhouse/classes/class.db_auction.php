<?php
require_once "class.db_entity.php";

class DbAuction extends DbEntity
{
    protected static $tableName = "auctions";

    protected static $primaryKeyName = "auctionId";

    protected static $fields = array(

        "itemId"        => "i",
        "quantity"      => "i",
        "startPrice"    => "d",
        "reservePrice"  => "d",
        "startTime"     => "s",
        "endTime"       => "s",
        "sold"          => "i"

    );
}