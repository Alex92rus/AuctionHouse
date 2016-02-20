<?php
require_once "class.db_entity.php";

class DbUser extends DbEntity
{
    protected static $tableName = "users";

    protected static $primaryKeyName = "userId";

    protected static $fields = array(

        "username"      => "s",
        "email"        => "s",
        "firstName"      => "s",
        "lastName"    => "s",
        "address"  => "s",
        "postcode"     => "s",
        "city"       => "s",
        "countryId"          => "i",
        "password"      => "s",
        "verified"       => "i",
        "image"         => "s"

    );
}