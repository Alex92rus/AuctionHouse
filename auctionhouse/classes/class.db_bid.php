<?php
require_once "class.db_entity.php";

class DbBid extends DbEntity
{
    protected static $tableName = "bids";

    protected static $primaryKeyName = "bidId";

    protected static $fields = array(

        "userId" => "i",
        "auctionId"  => "i",
        "bidTime" => "s",
        "bidPrice" => "i"


    );
}