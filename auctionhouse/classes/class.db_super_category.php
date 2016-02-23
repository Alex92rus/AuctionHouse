<?php
require_once "class.db_entity.php";

class DbItemSuperCategory extends DbEntity
{
    protected static $tableName = "item_super_categories";

    protected static $primaryKeyName = "superCategoryId";

    protected static $fields = array(

        "superCategoryName"      => "s"

    );
}