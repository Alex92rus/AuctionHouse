<?php
require_once "class.database.php";
require_once "class.db_user.php";
require_once "class.db_feedback.php";
require_once "class.db_bid.php";
require_once "class.db_country.php";
require_once "class.db_category.php";
require_once "class.db_super_category.php";
require_once "class.db_condition.php";
require_once "class.db_sort.php";
require_once "class.bid.php";
require_once "class.auction.php";
require_once "class.feedback.php";
require_once "class.advanced_auction.php";
require_once "class.advanced_feedback.php";


class QueryOperator
{
    const SELLER_LIVE_AUCTIONS = "live";
    const SELLER_SOLD_AUCTIONS = "sold";
    const SELLER_UNSOLD_AUCTIONS = "unsold";
    const ROLE_SELLER = "seller";
    const ROLE_BUYER = "buyer";
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
        $auctionQuery = "INSERT INTO auctions ( itemId, quantity, startPrice, reservePrice, startTime, endTime ) VALUES ( ?, ?, ?, ?, ?, ? )";
        $auctionParameters[ 0 ] = &$itemId;
        $auctionId = self::$database -> issueQuery( $auctionQuery, "iiddss", $auctionParameters );
        return [ "auctionId" => $auctionId, "itemId" => $itemId ];
    }



    public static function addAuctionEvent( $endTime, $userId, $auctionId )
    {
        self::getDatabaseInstance();

        // SQL query for creating auction event
        $query = "CREATE EVENT auction_$auctionId
                  ON SCHEDULE AT '$endTime'
                  DO INSERT INTO notifications(userId, auctionId, categoryId) VALUES($userId, $auctionId, 1)";
        self::$database -> issueQuery( $query );
    }


    public static function dropAuctionEvent( $auctionId )
    {
        self::getDatabaseInstance();

        // SQL query for dropping auction event
        $query = "DROP EVENT IF EXIST 'auction_$auctionId'";
        self::$database -> issueQuery( $query );
    }


    public static function getAuctionWatches( $auctionId )
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


    public static function getAuctionBids( $auctionId, $limit = null )
    {
        self::getDatabaseInstance();

        // SQL query for retrieving all bids for a specific auction
        $bidsQuery  = "SELECT u.username AS bidderName, u.email AS bidderEmail, u.firstName AS bidderFirstName, u.lastName AS bidderLastName, ";
        $bidsQuery .= "b.bidTime, b.bidPrice ";
        $bidsQuery .= "FROM auctions a, bids b, users u ";
        $bidsQuery .= "WHERE a.auctionId = b.auctionId AND b.userId = u.userId AND a.auctionId = $auctionId ";
        $bidsQuery .= "ORDER BY b.bidId DESC";
        $bidsQuery .= ( is_null( $limit ) ) ? "" : " LIMIT " . $limit;
        $result = self::$database -> issueQuery( $bidsQuery );

        $bids = [];
        while ( $row = $result -> fetch_assoc() )
        {
            $bid = new Bid( $row );
            $bids[] = $bid;
        }

        return $bids;
    }


    public static function countFoundAuctions( $query )
    {
        self::getDatabaseInstance();
        $result = self::$database -> issueQuery( $query );
        return $result -> num_rows;
    }


    public static function searchAuctions($query) {
        self::getDatabaseInstance();
        $result = self::$database -> issueQuery( $query );
        $auctions = array();
        $categories = array();
        while ($row = $result->fetch_assoc()){
            $auctions[] = new Auction($row);
            if(!array_key_exists($row["superCategoryId"], $categories )){
                $categories[$row["superCategoryId"]] = array();
                $categories[$row["superCategoryId"]][] = $row["categoryId"];
            }else{
                $subCats =  $categories[$row["superCategoryId"]];
                if(!in_array($row["categoryId"], $subCats)){
                    $categories[$row["superCategoryId"]][] = $row["categoryId"];
                }
            }
        }
        return array(
            "categories" => $categories,
            "auctions"   => $auctions
        );
    }


    public static function getWatchEmails( $auctionId )
    {
        self::getDatabaseInstance();
        $query = "SELECT u.email FROM users u, auction_watches w WHERE w.userId = u.userId AND auctionId = {$auctionId}";
        $result = self::$database -> issueQuery( $query );

        $emails = [];
        while ( $row = $result -> fetch_row() )
        {
            $emails[] = $row[ 0 ];
        }

        return $emails;
    }


    public static function getWatchedAuctions($userId)
    {
        $query = "SELECT auctions.auctionId, quantity, startPrice, reservePrice, startTime, sold,
		endTime, itemName, itemBrand, itemDescription, items.image, auctions.views,
        item_categories.categoryName as subCategoryName, superCategoryName,
        item_categories.superCategoryId, item_categories.categoryId,
        conditionName, countryName, auction_watches.watchId, COUNT(DISTINCT (bids.bidId)) AS numBids,
        MAX(bids.bidPrice) AS highestBid,
        case
			when MAX(bids.bidPrice)is not null THEN MAX(bids.bidPrice)
            else startPrice
		end as currentPrice


        FROM auctions
            LEFT OUTER JOIN bids ON bids.auctionId = auctions.auctionId
            JOIN auction_watches ON auction_watches.auctionId = auctions.auctionId
            JOIN items ON items.itemId = auctions.itemId
            JOIN users ON items.userId = users.userId
            JOIN item_categories ON items.categoryId = item_categories.categoryId
            JOIN super_item_categories ON  item_categories.superCategoryId = super_item_categories.superCategoryId
            JOIN item_conditions ON items.conditionId = item_conditions.conditionId
            JOIN countries ON users.countryId = countries.countryId


        WHERE auction_watches.watchId IN( SELECT auction_watches.watchId
                                          FROM auctions JOIN auction_watches ON auctions.auctionId = auction_watches.auctionId
                                          WHERE auction_watches.userId = __userId__ )

        GROUP BY auctions.auctionId

        ORDER BY CASE WHEN auctions.endTime > now() THEN 0 ELSE 1 END ASC, auctions.endTime ASC
        ";

        $query = str_replace("__userId__", $userId, $query);
        self::getDatabaseInstance();
        $result = self::$database -> issueQuery( $query );
        $auctions = array();
        while ($row = $result->fetch_assoc()) {
            $row[ "numWatches" ] = self::getAuctionWatches( $row[ "auctionId" ] );
            $auctions[] = new Auction($row);
        }
        return $auctions;

    }


    public static function getSellerAuctions( $userId, $type )
    {
        self::getDatabaseInstance();

        // SQL query for retrieving all live auctions and their details for a specific userId
        $detailsQuery  = "SELECT a.auctionId, a.quantity, a.startPrice, a.reservePrice, a.startTime, a.endTime, i.itemName, i.itemBrand, i.itemDescription, ";
        $detailsQuery .= "i.image, cat.categoryName, con.conditionName, u.username, a.views, TIMEDIFF(a.endTime, a.startTime) AS duration, a.startTime <= NOW() AS hasStarted ";
        $detailsQuery .= "FROM auctions a, items i, item_categories cat, item_conditions con, users u ";
        $detailsQuery .= "WHERE a.itemId = i.itemId AND i.categoryId = cat.categoryId AND i.conditionId = con.conditionId AND i.userId = u.userId AND i.userId = $userId ";
        $detailsQuery .= ( $type == self::SELLER_SOLD_AUCTIONS ) ? "AND a.sold = 1 " : "";
        $detailsQuery .= ( $type == self::SELLER_LIVE_AUCTIONS ) ? "AND a.endTime > NOW() " : "AND a.endTime < NOW() ";
        $detailsQuery .= "ORDER BY ";
        $detailsQuery .= ( $type == self::SELLER_LIVE_AUCTIONS ) ? "hasStarted DESC, duration ASC, a.endTime ASC" : "a.endTime DESC";
        $result = self::$database -> issueQuery( $detailsQuery );

        $liveAuctions = [];
        while ( $row = $result -> fetch_assoc() )
        {
            $auction = new Auction( $row );
            $auctionId = $auction -> getAuctionId();
            $bids = self::getAuctionBids( $auctionId );
            $views = $auction->getViews();
            $watches = self::getAuctionWatches( $auctionId );

            $liveAuction = new AdvancedAuction( $auction, $bids, $views, $watches );
            $liveAuctions[] = $liveAuction;
        }

        return $liveAuctions;
    }


    public static function getLiveAuction( $auctionId )
    {
        self::getDatabaseInstance();

        // SQL query for retrieving all live auctions and their details for a specific auctionId
        $detailsQuery  = "SELECT a.auctionId, a.quantity, a.startPrice, a.reservePrice, a.startTime, a.endTime, i.itemName, i.itemBrand, i.itemDescription, ";
        $detailsQuery .= "i.image, cat.categoryName, con.conditionName, u.username, a.views ";
        $detailsQuery .= "FROM auctions a, items i, item_categories cat, item_conditions con, users u ";
        $detailsQuery .= "WHERE a.itemId = i.itemId AND i.categoryId = cat.categoryId AND i.conditionId = con.conditionId AND i.userId = u.userId AND a.auctionId = " .$auctionId . " ";
        $detailsQuery .= "AND a.endTime > NOW() ";
        $detailsQuery .= "ORDER BY a.startTime ASC, a.endTime ASC";
        $result = self::$database -> issueQuery( $detailsQuery );

        return new Auction( $result -> fetch_assoc() );
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


    public static function placeBid( $auctionId, $userId, $bidPrice )
    {
        $date = new DateTime();

        $bid = new DbBid( array(
            "userId" => $userId,
            "auctionId" => $auctionId,
            "bidTime" => $date -> format('Y-m-d H:i:s'),
            "bidPrice" => $bidPrice
        ) );
        $bid -> create();
    }


    public static function getUserImage( $username )
    {
        return DbUser::withConditions( "WHERE username = '$username'" ) ->get( array( "image" ) )[ 0 ][ "image" ];
    }


    private static function getFeedbackScores( $userId, $score )
    {
        $count = DbFeedback::withConditions( "WHERE receiverId = $userId AND score = $score" ) -> count();
        return ( $count > 0 ) ? $count : 0;
    }


    private static function getFeedbacks( $userId, $role )
    {
        self::getDatabaseInstance();

        $query  = "SELECT feedbackId, time AS feedbackTime, itemName, itemBrand, u.image AS creatorImage, username AS creatorUsername, score, comment ";
        $query .= "FROM feedbacks f, auctions a, items i, users u ";
        $query .= "WHERE f.auctionId = a.auctionId AND a.itemId = i.itemId AND f.creatorId = u.userId AND ";
        $query .= "f.receiverId = $userId AND i.userId";
        $query .= ( $role == self:: ROLE_SELLER ) ? " = " : " != ";
        $query .= "$userId";
        $result = self::$database -> issueQuery( $query );

        $feedbacks = [];
        while ( $row = $result -> fetch_assoc() )
        {
            $feedbacks[] = new Feedback( $row );
        }

        return $feedbacks;
    }


    public static function getFeedback( $username )
    {
        // Retrieve user feedback statistics
        $userId = DbUser::withConditions( "WHERE username = '$username'" ) -> get( array( "userId" ) )[ 0 ][ "userId" ];
        $scores = [];
        for ( $index = 1; $index <= 5; $index++ )
        {
            $scores[] = self::getFeedbackScores( $userId, $index );
        }

        // Retrieve feedbacks
        $feedbackAsSeller = self::getFeedbacks( $userId, self::ROLE_SELLER );
        $feedbackAsBuyer = self::getFeedbacks( $userId, self::ROLE_BUYER );

        $advancedFeedback =  new AdvancedFeedback( $scores, $feedbackAsSeller, $feedbackAsBuyer );
        //var_dump($advancedFeedback);
        return $advancedFeedback;
    }


    public static function getCountriesList()
    {
        // Query for returning all countries stored in the db
        return DbCountry::withConditions()->getListOfColumn( "countryName" );
    }


    public static function getCategoriesList()
    {
        // Query for returning all item categories stored in the db
        return DbItemCategory::withConditions()->getListOfColumn( "categoryName" );
    }


    public static function getSuperCategoriesList()
    {
        // Query for returning all super item categories stored in the db
        return DbItemSuperCategory::withConditions()->getListOfColumn( "superCategoryName" );
    }


    public static function getConditionsList()
    {
        // Query for returning all item conditions stored in the db
        return DbItemCondition::withConditions()->getListOfColumn( "conditionName" );
    }


    public static function getSortOptionsList()
    {
        // Query for returning all sort options stored in the db
        return DbSortOption::withConditions()->getListOfColumn( "sortName" );
    }
}