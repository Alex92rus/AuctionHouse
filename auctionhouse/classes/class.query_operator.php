<?php
require_once "class.database.php";


class QueryOperator
{
    private static $database;


    // Prevent people from instantiating this static class
    private function __construct() {}


    private static function getDatabaseInstance()
    {
        if ( is_null( self::$database ) )
        {
            self::$database = new Database();
        }
    }


    public static function getCountryId( $countryName )
    {
        self::getDatabaseInstance();
        $getCountryQuery = "SELECT countryId FROM countries WHERE countryName = '$countryName'";
        $result = self::$database -> issueQuery( $getCountryQuery );
    
        $countryRow = $result -> fetch_assoc();
        return $countryRow[ "countryId" ];
    }


    public static function isUnique( $field, $value )
    {
        // SQL query for retrieving users with a specific username/email
        self::getDatabaseInstance();
        $checkFieldQuery = "SELECT " . $field . " FROM users where " . $field . " = '$value' ";
        $result = self::$database -> issueQuery( $checkFieldQuery );

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
        self::getDatabaseInstance();
        $registerUserQuery  = "INSERT INTO users ( username, email, firstName, lastName, address, postcode, city, countryId, password ) ";
        $registerUserQuery .= "VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ? )";
        $insertId = self::$database -> issueQuery( $registerUserQuery, "sssssssis", $parameters );

        return $insertId;
    }


    public static function addUnverifiedAccount( $parameters )
    {
        // SQL query for creating unregistered user
        self::getDatabaseInstance();
        $unverifiedAccountQuery = "INSERT INTO unverified_users ( userId, confirmCode ) VALUES ( ?, ? )";
        self::$database -> issueQuery( $unverifiedAccountQuery, "si", $parameters );
    }


    public static function checkVerificationLink( $email, $confirmCode )
    {
        // SQL query for retrieving users for the given email
        self::getDatabaseInstance();
        $usersQuery = "SELECT userId, firstName, lastName, verified FROM users WHERE email = '$email'";
        $usersQueryResult = self::$database -> issueQuery( $usersQuery );
        $usersRow = $usersQueryResult -> fetch_assoc();

        // SQL query for retrieving unverified users for the given email
        $unverifiedQuery = "SELECT * FROM unverified_users WHERE userId = '{$usersRow[ "userId" ]}'";
        $unverifiedQueryResult = self::$database -> issueQuery( $unverifiedQuery );
        $unverifiedRow = $unverifiedQueryResult -> fetch_assoc();

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
        self::getDatabaseInstance();
        $verifyUserQuery = "UPDATE users SET verified = 1 WHERE userId = '$userId'";
        self::$database -> issueQuery( $verifyUserQuery );

        // SQL query for deleting unverified account
        $deleteUnverified = "DELETE FROM unverified_users WHERE userId = '$userId'";
        self::$database -> issueQuery( $deleteUnverified );
    }


    public static function checkAccount( $email, $password )
    {
        // SQL query for retrieving a verified user
        self::getDatabaseInstance();
        $checkAccount  = "SELECT userId, username, email, firstName, lastName, address, postcode, city, countryId, password, image from users ";
        $checkAccount .= "WHERE email='$email' AND verified = 1 ";
        $result = self::$database -> issueQuery( $checkAccount );

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


    public static function checkPassword( $userId, $password )
    {
        // SQL query for retrieving a user's account password
        self::getDatabaseInstance();
        $checkPassword  = "SELECT password from users WHERE userId='$userId'";
        $result = self::$database -> issueQuery( $checkPassword );

        // Process result table
        $account = $result -> fetch_assoc();

        // Password matching
        if ( password_verify( $password, $account[ "password" ] ) )
        {
            return true;
        }

        // No match
        return false;
    }


    public static function getAccount( $userId )
    {
        // SQL query for retrieving account information
        self::getDatabaseInstance();
        $getAccount  = "SELECT userId, username, email, firstName, lastName, address, postcode, city, countryId, image from users ";
        $getAccount .= "WHERE userId='$userId'";
        $result = self::$database -> issueQuery( $getAccount );

        return $result -> fetch_assoc();
    }


    public static function updateAccount( $userId, $updatedUser )
    {
        // SQL query for updating user information
        self::getDatabaseInstance();
        $update  = "UPDATE users SET ";
        $update .= "username = '{$updatedUser[ "username" ]}',";
        $update .= "firstName = '{$updatedUser[ "firstName" ]}',";
        $update .= "lastName = '{$updatedUser[ "lastName" ]}',";
        $update .= "address = '{$updatedUser[ "address" ]}',";
        $update .= "postcode = '{$updatedUser[ "postcode" ]}',";
        $update .= "city = '{$updatedUser[ "city" ]}',";
        $update .= "countryId = '{$updatedUser[ "country" ]}' ";
        $update .= "WHERE userId = $userId";
        self::$database -> issueQuery( $update );
    }


    public static function getAccountFromEmail( $email )
    {
        // SQL for checking retrieving a user's account through an email
        self::getDatabaseInstance();
        $getAccountQuery  = "SELECT firstName, lastName from users ";
        $getAccountQuery .= "WHERE email='{$email}' AND verified = 1";
        $result = self::$database -> issueQuery( $getAccountQuery );

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
        self::getDatabaseInstance();
        $encryptedPassword = password_hash( $password, PASSWORD_BCRYPT );
        $updateQuery  = "UPDATE users ";
        $updateQuery .= "SET password = '$encryptedPassword' ";
        $updateQuery .=  "WHERE email = '$email'  ";
        self::$database -> issueQuery( $updateQuery );
     }


    public static function uploadImage( $userId, $imageName, $table )
    {
        // SQL query for uploading an image
        self::getDatabaseInstance();
        $uploadImage = "UPDATE {$table} SET image = '{$imageName}' WHERE userId = {$userId}";
        self::$database -> issueQuery( $uploadImage );
    }
}