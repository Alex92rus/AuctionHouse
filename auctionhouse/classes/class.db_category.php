<?php
require_once "class.db_entity.php";

class DbItemCategory extends DbEntity
{
    protected static $tableName = "item_categories";

    protected static $primaryKeyName = "categoryId";

    protected static $fields = array(

        "superCategoryId"   => "i",
        "categoryName"      => "s"

    );
}