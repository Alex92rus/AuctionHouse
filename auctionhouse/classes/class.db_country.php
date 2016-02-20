<?php
require_once "class.db_entity.php";

class DbCountry extends DbEntity
{
    protected static $tableName = "countries";

    protected static $primaryKeyName = "countryId";

    protected static $fields = array(

        "countryName"        => "s",


    );
}