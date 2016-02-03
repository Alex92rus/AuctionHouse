<?php
require_once "class.database.php";


class QueryOperator
{
    private static $database;


    private static function initialize()
    {
        // Create new database object
        self::$database = new Database();
    }


    public static function getCountryId( $countryName )
    {
        self::initialize();
        $getCountryQuery = "SELECT countryId FROM countries WHERE countryName = '$countryName'";
        $getCountryQueryResult = self::$database -> selectQuery( $getCountryQuery );

        //Close database
        self::$database -> closeConnection();
    
        $countryRow = $getCountryQueryResult -> fetch_assoc();
        return $countryRow[ "countryId" ];
    }


    public static function isUnique( $field, $value )
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
        $registerUserQuery  = "INSERT INTO users ( username, email, firstName, lastName, address, postcode, city, countryId, password ) ";
        $registerUserQuery .= "VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ? )";
        $insertId = self::$database -> insertQuery( $registerUserQuery, "sssssssis", $parameters );

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


    public static function checkAccount( $email, $password )
    {
        // SQL query for checking if account exists
        self::initialize();
        $checkAccount  = "SELECT userId, username, email, firstName, lastName, address, postcode, city, countryId, password, image from users ";
        $checkAccount .= "WHERE email='$email' AND verified = 1 ";
        $result = self::$database -> selectQuery( $checkAccount );
        self::$database -> closeConnection();

        // Process result table
        $account = $result -> fetch_assoc();

        // One verified account exits for this email and password matches as well
        if( $account != null && password_verify( $password, $account[ "password" ] ) )
        {
            unset( $account[ "password" ] );
            return $account;
        }

        // Email and/or password incorrect
        return null;
    }


    public static function getAccount( $userId )
    {
        // SQL query for retrieving account information
        self::initialize();
        $getAccount  = "SELECT userId, username, email, firstName, lastName, address, postcode, city, countryId, image from users ";
        $getAccount .= "WHERE userId='$userId'";
        $result = self::$database -> selectQuery( $getAccount );
        self::$database -> closeConnection();

        return $result -> fetch_assoc();
    }


    public static function updateAccount( $userId, $updatedUser )
    {
        // SQL query for updating user information
        self::initialize();
        $update  = "UPDATE users SET ";
        $update .= "username = '{$updatedUser[ "username" ]}',";
        $update .= "firstName = '{$updatedUser[ "firstName" ]}',";
        $update .= "lastName = '{$updatedUser[ "lastName" ]}',";
        $update .= "address = '{$updatedUser[ "address" ]}',";
        $update .= "postcode = '{$updatedUser[ "postcode" ]}',";
        $update .= "city = '{$updatedUser[ "city" ]}',";
        $update .= "countryId = '{$updatedUser[ "country" ]}' ";
        $update .= "WHERE userId = $userId";
        self::$database -> updateQuery( $update );

        // Close database
        self::$database -> closeConnection();
    }


    public static function getAccountFromEmail( $email )
    {
        // SQL for checking if given email is associated with a verified account
        self::initialize();
        $getAccountQuery  = "SELECT firstName, lastName from users ";
        $getAccountQuery .= "WHERE email='{$email}' AND verified = 1";
        $result = self::$database -> selectQuery( $getAccountQuery );
        self::$database -> closeConnection();

        // Check for inconsistency
        if ( $result -> num_rows > 1 )
        {
            die( "Database inconsistency. {$email} not unique" );
        }

        // Process result table
        $account = $result -> fetch_assoc();

        // One verified account exits for this email
        if( $account != null )
        {
            return array( "firstName" => $account[ "firstName" ], "lastName" => $account[ "lastName" ] );
        }

        // Email does not exist
        return null;
    }


    public static function updatePassword( $email, $password )
    {
        // SQL query for updating a user's password
        self::initialize();
        $encryptedPassword = password_hash( $password, PASSWORD_BCRYPT );
        $updateQuery  = "UPDATE users ";
        $updateQuery .= "SET password = '$encryptedPassword' ";
        $updateQuery .=  "WHERE email = '$email'  ";
        self::$database -> updateQuery( $updateQuery );
        self::$database -> closeConnection();
     }


    public static function uploadImage( $userId, $imageName, $table )
    {
        // SQL query for uploading an image
        self::initialize();
        $uploadImage = "UPDATE {$table} SET image = '{$imageName}' WHERE userId = {$userId}";
        self::$database -> updateQuery( $uploadImage );
        self::$database -> closeConnection();
    }
}