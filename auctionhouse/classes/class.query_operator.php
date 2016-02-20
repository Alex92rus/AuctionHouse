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
        // SQL retrieving a country Id
        $getCountryQuery = "SELECT countryId FROM countries WHERE countryName = '$countryName'";
        $result = self::$database -> issueQuery( $getCountryQuery );

        $countryRow = $result -> fetch_assoc();
        return $countryRow[ "countryId" ];
    }


    public static function getItemRelatedIds( $category, $condition )
    {
        self::getDatabaseInstance();

        // SQL for retrieving category id
        $categoryQuery = "SELECT categoryId FROM item_categories WHERE categoryName = '$category'";
        $categoryResult = self::$database -> issueQuery( $categoryQuery );
        $categoryRow = $categoryResult -> fetch_assoc();

        // SQL for retrieving condition id
        $conditionQuery = "SELECT conditionId FROM item_conditions WHERE conditionName = '$condition'";
        $conditionResult = self::$database -> issueQuery( $conditionQuery );
        $conditionRow = $conditionResult -> fetch_assoc();

        return [ "categoryId" => $categoryRow[ "categoryId" ], "conditionId" => $conditionRow[ "conditionId" ] ];
    }


    public static function isUnique( $field, $value )
    {
        self::getDatabaseInstance();

        // SQL query for retrieving users with a specific username/email
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
        self::getDatabaseInstance();

        // SQL query for creating a new user record
        $registerUserQuery  = "INSERT INTO users ( username, email, firstName, lastName, address, postcode, city, countryId, password ) ";
        $registerUserQuery .= "VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ? )";
        $accountId = self::$database -> issueQuery( $registerUserQuery, "sssssssis", $parameters );

        return $accountId;
    }


    public static function addUnverifiedAccount( $parameters )
    {
        self::getDatabaseInstance();

        // SQL query for creating unregistered user
        $unverifiedAccountQuery = "INSERT INTO unverified_users ( userId, confirmCode ) VALUES ( ?, ? )";
        self::$database -> issueQuery( $unverifiedAccountQuery, "si", $parameters );
    }


    public static function addAuction( $itemParameters, $auctionParameters )
    {
        self::getDatabaseInstance();

        // SQL query for inserting item
        $itemQuery = "INSERT INTO items ( userId, itemName, itemBrand, categoryId, conditionId, itemDescription, image ) VALUES ( ?, ?, ?, ?, ?, ?, ? )";
        $itemId = self::$database -> issueQuery( $itemQuery, "issiiss", $itemParameters );

        // SQL query for inserting auction
        $auctionQuery = "INSERT INTO auctions ( itemId, quantity, startPrice, reservePrice, startTime, endTime ) VALUES ( ?, ?, ?, ?, ?, ?)";
        $auctionParameters[ 0 ] = &$itemId;
        self::$database -> issueQuery( $auctionQuery, "iiddss", $auctionParameters );

        return $itemId;
    }


    private static function getAuctionDetails( $userId )
    {
        self::getDatabaseInstance();

        // SQL query for retrieving all live auctions and their details for a specific userId
        $detailsQuery  = "SELECT a.auctionId, a.quantity, a.startPrice, a.reservePrice, a.startTime, a.endTime, i.itemName, i.itemBrand, i.itemDescription, ";
        $detailsQuery .= "i.image, cat.categoryName, con.conditionName ";
        $detailsQuery .= "FROM auctions a, items i, item_categories cat, item_conditions con ";
        $detailsQuery .= "WHERE a.itemId = i.itemId AND i.categoryId = cat.categoryId AND i.conditionId = con.conditionId AND i.userId = $userId AND a.sold = 0";
        $result = self::$database -> issueQuery( $detailsQuery );

        $auctions = [];
        while ( $row = $result -> fetch_row() )
        {
            $auctionDetails[ "auctionId" ] = $row[ 0 ];
            $auctionDetails[ "quantity" ] = $row[ 1 ];
            $auctionDetails[ "startPrice" ] = $row[ 2 ];
            $auctionDetails[ "reservePrice" ] = $row[ 3 ];
            $auctionDetails[ "startTime" ] = $row[ 4 ];
            $auctionDetails[ "endTime" ] = $row[ 5 ];
            $auctionDetails[ "itemName" ] = $row[ 6 ];
            $auctionDetails[ "itemBrand" ] = $row[ 7 ];
            $auctionDetails[ "itemDescription" ] = $row[ 8 ];
            $auctionDetails[ "image" ] = $row[ 9 ];
            $auctionDetails[ "itemCategoryName" ] = $row[ 10 ];
            $auctionDetails[ "itemConditionName" ] = $row[ 11 ];
            $auctions[] = $auctionDetails;
        }

        return $auctions;
    }


    private static function getAuctionViews( $auctionId )
    {
        return self::getAuctionTraffic( $auctionId, "auction_views" );
    }


    private static function getAuctionWatches( $auctionId )
    {
        return self::getAuctionTraffic( $auctionId, "auction_watches" );
    }


    private static function getAuctionTraffic( $auctionId, $table )
    {
        self::getDatabaseInstance();

        // SQL query for calculating number of views or watches for a specific auction
        $query  = "SELECT COUNT(*)";
        $query .= "FROM auctions a, $table v ";
        $query .= "WHERE a.auctionId = v.auctionId AND a.auctionId = $auctionId" ;
        $result = self::$database -> issueQuery( $query );
        $row = $result -> fetch_row();

        return $row[ 0 ];
    }


    private static function getAuctionBids( $auctionId )
    {
        self::getDatabaseInstance();

        // SQL query for retrieving all bids for a specific auction
        $bidsQuery  = "SELECT u.username, b.bidTime, b.bidPrice ";
        $bidsQuery .= "FROM auctions a, bids b, users u ";
        $bidsQuery .= "WHERE a.auctionId = b.auctionId AND b.userId = u.userId AND a.auctionId = $auctionId ";
        $bidsQuery .= "ORDER BY b.bidId DESC";
        $result = self::$database -> issueQuery( $bidsQuery );

        $bids = [];
        while ( $row = $result -> fetch_row() )
        {
            $bid[ "bidderName" ] = $row[ 0 ];
            $bid[ "bidTime" ] = $row[ 1 ];
            $bid[ "bidPrice" ] = $row[ 2 ];
            $bids[] = $bid;
        }

        return $bids;
    }


    public static function getAuction( $userId )
    {
        $auctions = self::getAuctionDetails( $userId );

        for ( $index = 0; $index < count( $auctions ); $index++ )
        {
            $auction = $auctions[ $index ];
            $auction[ "views" ] = self::getAuctionViews( $auction[ "auctionId" ] );
            $auction[ "watches" ] = self::getAuctionWatches( $auction[ "auctionId" ] );
            $auction[ "bids" ] = self::getAuctionBids( $auction[ "auctionId" ] );
            $auctions[ $index ] = $auction;
        }

        return $auctions;
    }


    public static function checkVerificationLink( $email, $confirmCode )
    {
        self::getDatabaseInstance();

        // SQL query for retrieving users for the given email
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
        self::getDatabaseInstance();

        // SQL query for verify user's account
        $verifyUserQuery = "UPDATE users SET verified = 1 WHERE userId = '$userId'";
        self::$database -> issueQuery( $verifyUserQuery );

        // SQL query for deleting unverified account
        $deleteUnverified = "DELETE FROM unverified_users WHERE userId = '$userId'";
        self::$database -> issueQuery( $deleteUnverified );
    }


    public static function checkAccount( $email, $password )
    {
        self::getDatabaseInstance();

        // SQL query for retrieving a verified user
        $checkAccount  = "SELECT u.userId, u.username, u.email, u.firstName, u.lastName, u.address, u.postcode, u.city, c.countryName, u.password, u.image ";
        $checkAccount .= "FROM users u, countries c ";
        $checkAccount .= "WHERE u.countryId = c.countryId AND email='$email' AND verified = 1";
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
        self::getDatabaseInstance();

        // SQL query for retrieving a user's account password
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
        self::getDatabaseInstance();

        // SQL query for retrieving account information
        $getAccount  = "SELECT u.userId, u.username, u.email, u.firstName, u.lastName, u.address, u.postcode, u.city, c.countryName, u.image ";
        $getAccount .= "FROM users u, countries c ";
        $getAccount .= "WHERE u.countryId = c.countryId AND userId='$userId'";
        $result = self::$database -> issueQuery( $getAccount );

        return $result -> fetch_assoc();
    }


    public static function updateAccount( $userId, $updatedUser )
    {
        self::getDatabaseInstance();

        // SQL query for updating user information
        $updateQuery  = "UPDATE users SET ";
        $updateQuery .= "username = '{$updatedUser[ "username" ]}',";
        $updateQuery .= "firstName = '{$updatedUser[ "firstName" ]}',";
        $updateQuery .= "lastName = '{$updatedUser[ "lastName" ]}',";
        $updateQuery .= "address = '{$updatedUser[ "address" ]}',";
        $updateQuery .= "postcode = '{$updatedUser[ "postcode" ]}',";
        $updateQuery .= "city = '{$updatedUser[ "city" ]}',";
        $updateQuery .= "countryId = '{$updatedUser[ "country" ]}' ";
        $updateQuery .= "WHERE userId = $userId";
        self::$database -> issueQuery( $updateQuery );
    }


    public static function getAccountFromEmail( $email )
    {
        self::getDatabaseInstance();

        // SQL for checking retrieving a user's account through an email
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
        self::getDatabaseInstance();

        // SQL query for updating a user's password
        $encryptedPassword = password_hash( $password, PASSWORD_BCRYPT );
        $updateQuery  = "UPDATE users ";
        $updateQuery .= "SET password = '$encryptedPassword' ";
        $updateQuery .=  "WHERE email = '$email'  ";
        self::$database -> issueQuery( $updateQuery );
     }


    public static function uploadImage( $id, $imageName, $table )
    {
        self::getDatabaseInstance();

        // SQL query for uploading an image
        $uploadImage  = "UPDATE {$table} SET image = '{$imageName}' WHERE ";
        $uploadImage .= ( $table == "users" ) ? "userId" : "itemId";
        $uploadImage .= "= {$id}";

        self::$database -> issueQuery( $uploadImage );
    }




}