<?php
require_once "class.db_entity.php";

class DbNotification extends DbEntity
{
    protected static $tableName = "notifications";

    protected static $primaryKeyName = "notificationId";

    protected static $fields = array(

        "userId"      => "i",
        "message"     => "s",
        "categoryId"  => "i",
        "time"        => "s",
        "seen"        => "i",
        "emailed"     => "i",
    );
}