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

    public static function checkUniqueness( $field, $value )
    {
        // SQL query for retrieving users with a specific username/email
        self::initialize();
        $checkFieldQuery = "SELECT " . $field . " FROM users where " . $field . " = '$value' ";
        $result = self::$database -> selectQuery( $checkFieldQuery );
        
        //Close database
        self::$database -> closeConnection();

        // Query returned a row, meaning there exists already a user with the same registered username/email
        if ( $result -> num_rows   > 0 )
        {
            return false;
        }

        return true;
    }

    public static function addAccount( $parameters )
    {
        // SQL query for creating a new user record
        self::initialize();
        $registerUserQuery  = "INSERT INTO users ( username, email, firstName, lastName, address, postcode, city, country, password ) ";
        $registerUserQuery .= "VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ? )";
        $insertId = self::$database -> insertQuery( $registerUserQuery, "sssssssss", $parameters );

        // Close database
        self::$database -> closeConnection();

        return $insertId;
    }

    public static function addUnverifiedAccount( $parameters )
    {
        // SQL query for creating unregistered user
        self::initialize();
        $unverifiedAccountQuery = "INSERT INTO unverified_users ( userId, confirmCode ) VALUES ( ?, ? )";
        self::$database -> insertQuery( $unverifiedAccountQuery, "si", $parameters );

        // Close database
        self::$database -> closeConnection();
    }


    public static function checkVerificationLink( $email, $confirmCode )
    {
        // SQL query for retrieving users for the given email
        self::initialize();
        $usersQuery = "SELECT userId, firstName, lastName, verified FROM users WHERE email = '$email'";
        $usersQueryResult = self::$database -> selectQuery( $usersQuery );
        $usersRow = $usersQueryResult -> fetch_assoc();

        // SQL query for retrieving unverified users for the given email
        $unverifiedQuery = "SELECT * FROM unverified_users WHERE userId = '{$usersRow[ "userId" ]}'";
        $unverifiedQueryResult = self::$database -> selectQuery( $unverifiedQuery );
        $unverifiedRow = $unverifiedQueryResult -> fetch_assoc();

        // Close database
        self::$database -> closeConnection();

        // Email and code matches to a unique unverified user
        if ( $usersQueryResult -> num_rows == 1 && $usersRow[ "verified" ] == 0 &&
             $unverifiedQueryResult -> num_rows == 1 && $unverifiedRow[ "confirmCode" ] == $confirmCode )
        {
            return [
                "userId" => $usersRow[ "userId" ],
                "firstName" => $usersRow[ "firstName" ],
                "lastName" => $usersRow[ "lastName" ] ];
        }
        return null;
    }

    public static function activateAccount( $userId )
    {
           // SQL query for verify user's account
        self::initialize();
        $verifyUserQuery = "UPDATE users SET verified = 1 WHERE userId = '$userId'";
        self::$database -> updateQuery( $verifyUserQuery );

        // SQL query for deleting unverified account
        $deleteUnverified = "DELETE FROM unverified_users WHERE userId = '$userId'";
        self::$database -> updateQuery( $deleteUnverified );

        // Close database
        self::$database -> closeConnection();
    }
}