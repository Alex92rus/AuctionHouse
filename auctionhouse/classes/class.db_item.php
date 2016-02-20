<?php
require_once "class.db_entity.php";

class DbItem extends DbEntity
{
    protected static $tableName = "items";

    protected static $primaryKeyName = "itemId";

    protected static $fields = array(

        "itemName" => "s",
        "userId"   => "i",
        "itemBrand" => "s",
        "categoryId" => "i",
        "conditionId" => "i",
        "itemDescription" => "s",
        "image" => "s"

    );
}