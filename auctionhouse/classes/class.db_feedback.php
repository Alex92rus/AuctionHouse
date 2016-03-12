<?php
require_once "class.db_entity.php";

class DbFeedback extends DbEntity
{
    protected static $tableName = "feedbacks";

    protected static $primaryKeyName = "feedbackId";

    protected static $fields = array(

        "auctionId" => "i",
        "receiverId"  => "i",
        "creatorId" => "i",
        "score"     => "i",
        "comment"   => "s",
        "time" => "s"

    );
}