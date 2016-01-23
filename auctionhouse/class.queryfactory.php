<?php
require_once "class.database.php";


class QueryFactory
{
    private static $database;

    private static function initialize()
    {
        // Create new database object
        self::$database = new Database();
    }

    public static function checkUniqueness( &$fieldArray, $field, $value )
    {
        // SQL query for retrieving users with a specific username/email
        self::initialize();
        $checkFieldQuery = "SELECT " . $field . " FROM users where " . $field . " = '$value' ";
        $result = self::$database -> selectQuery( $checkFieldQuery );
        $numberOfRows = $result -> num_rows;
        self::$database -> closeConnection();

        // Query returned a row, meaning there exists already a user with the same registered username/email
        if ( $numberOfRows > 0 )
        {
            $fieldArray[ $field ] = "This " . $field . " already exists";
        }
    }

    public static function addAccount( $parameters )
    {
        // SQL query for creating a new user record
        self::initialize();
        $registerUserQuery  = "INSERT INTO users ( username, email, firstName, lastName, address, postcode, city, country, password ) ";
        $registerUserQuery .= "VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ? )";
        self::$database -> insertQuery( $registerUserQuery, "sssssssss", $parameters );
    }

    public static function addUnverifiedAccount( $parameters )
    {
        // SQL query for creating unregistered user
        self::initialize();
        $unverifiedAccountQuery = "INSERT INTO unverified_users ( email, confirmCode ) VALUES ( ?, ? )";
        self::$database -> insertQuery( $unverifiedAccountQuery, "si", $parameters );

        // Close database
        self::$database -> closeConnection();
    }


    public static function checkVerificationLink( $email, $confirmCode )
    {
        // SQL query for retrieving users for the given email
        self::initialize();
        $usersQuery = "SELECT firstName, lastName, verified FROM users WHERE email = '$email'";
        $usersQueryResult = self::$database -> selectQuery( $usersQuery );
        $usersRow = $usersQueryResult -> fetch_assoc();

        // SQL query for retrieving unverified users for the given email
        $unverifiedQuery = "SELECT * FROM unverified_users WHERE email = '$email'";
        $unverifiedQueryResult = self::$database -> selectQuery( $unverifiedQuery );
        $unverifiedRow = $unverifiedQueryResult -> fetch_assoc();

        // Query returned a row with an unverified user
        if ( $usersQueryResult -> num_rows == 1 && $usersRow[ "verified" ] == 0 &&
             $unverifiedQueryResult -> num_rows == 1 && $unverifiedRow[ "confirmCode" ] == $confirmCode )
        {
            return [ "firstName" => $usersRow[ "firstName" ], "lastName" => $usersRow[ "lastName" ] ];
        }

        return null;
    }

    public static function activiateAccont( $email )
    {
        // SQL query for verify user's account
        self::initialize();
        $verifyUserQuery = "UPDATE users SET verified = 1 WHERE email = '$email'";
        self::$database -> updateQuery( $verifyUserQuery );

        // SQL query for deleting unverified account
        $deleteUnverified = "DELETE FROM unverified_users WHERE email = '$email'";
        self::$database -> updateQuery( $deleteUnverified );
    }
}