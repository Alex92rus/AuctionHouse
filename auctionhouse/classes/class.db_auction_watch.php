<?php
require_once "class.db_entity.php";

class DbAuctionWatch extends DbEntity
{
    protected static $tableName = "auction_watchs";

    protected static $primaryKeyName = "watchId";

    protected static $fields = array(

        "userId" => "i",
        "auctionId"  => "s"

    );
}