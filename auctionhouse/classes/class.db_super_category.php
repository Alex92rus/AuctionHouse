<?php
require_once "class.db_entity.php";

class DbItemSuperCategory extends DbEntity
{
    protected static $tableName = "super_item_categories";

    protected static $primaryKeyName = "superCategoryId";

    protected static $fields = array(

        "superCategoryName"      => "s"

    );
}