<?php
require_once "class.db_entity.php";

class DbAuctionView extends DbEntity
{
    protected static $tableName = "auction_views";

    protected static $primaryKeyName = "viewId";

    protected static $fields = array(

        "auctionId" => "i",
        "viewTime"  => "s"

    );
}