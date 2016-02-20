<?php
require_once "class.db_entity.php";

class DbUnverifiedUser extends DbEntity
{
    protected static $tableName = "unverified_users";

    protected static $primaryKeyName = "userId";

    protected static $fields = array(

        "confirmCode" => "i"

    );
}