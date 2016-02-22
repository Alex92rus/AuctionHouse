<?php
require_once "class.db_entity.php";

class DbSortOption extends DbEntity
{
    protected static $tableName = "sort_options";

    protected static $primaryKeyName = "sortId";

    protected static $fields = array(

        "sortName"        => "s"

    );
}