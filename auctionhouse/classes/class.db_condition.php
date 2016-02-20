<?php
require_once "class.db_entity.php";

class DbItemCondition extends DbEntity
{
    protected static $tableName = "item_conditions";

    protected static $primaryKeyName = "conditionId";

    protected static $fields = array(

        "conditionName"        => "s"

    );
}