<?php
require_once "../classes/class.helper_operator.php";
require_once "../classes/class.session_operator.php";
require_once "../classes/class.query_operator.php";
require_once "../classes/class.db_category.php";
require_once "../classes/class.db_super_category.php";

$updated_session = null;

/**
 * I think the liveAuction class with all the other collections
 * like bids can be queried when clicking on an auction
 * --it would be a huge pain in the arse and inefficient to get
 * them all in the search for every returned auction, sort them etc.
 * plus you don't need them as current bid is enough info. Number of watches
 * and could be private for the seller only as on ebay?
 *
 **/

/*
 * The format of the result must be one of following formats:
 * 1 [ "All" , [$auction1, $auction2] ]
 * 2 [ [1,2,3,4] , [$auction1, $auction2] ]
 * 3 [ [1] , [2,3,4], [$auction1, $auction2] ]
 *
 * Fake results
 */
/*$result1 = [ [1,2,3,4,5,6,7,8], ["test1", "test1" ] ];
$result2 = [ [1,2,3,4,5,6,7,8], ["test1", "test1" ] ];
$result = [ ["All"], ["test1", "test1" ] ];*/


$result = array();


// Initial search
if ( isset( $_GET[ "searchString" ] ) && isset( $_GET[ "searchCategory" ] )
        && strlen($_GET[ "searchString" ] ) >= 3 )
{
    $searchString = urldecode($_GET[ "searchString" ]);
    $searchCategory = urldecode($_GET[ "searchCategory" ]);
    $sort = SessionOperator::getSearchSetting( SessionOperator::SORT );

    // Set search sessions
    $updated_session = [
        SessionOperator::SEARCH_STRING => $searchString,
        SessionOperator::SEARCH_CATEGORY => $searchCategory];
}

// Search by different category
else if ( isset( $_GET[ "searchCategory" ] ) )
{
    $searchString = SessionOperator::getSearchSetting( SessionOperator::SEARCH_STRING );
    $searchCategory = htmlspecialchars_decode($_GET[ "searchCategory" ]);
    $sort = SessionOperator::getSearchSetting( SessionOperator::SORT );

    // Set search sessions
    $updated_session =[
        SessionOperator::SEARCH_CATEGORY => $searchCategory ];

}

// Sort search
else if ( isset( $_GET[ "sort" ] ) )
{
    $searchString = SessionOperator::getSearchSetting( SessionOperator::SEARCH_STRING );
    $searchCategory = SessionOperator::getSearchSetting( SessionOperator::SEARCH_CATEGORY );
    $sort = urldecode($_GET[ "sort" ]);

    // Set search sessions
    $updated_session = [SessionOperator::SORT => $sort ];
}
else{
    //problem
    HelperOperator::redirectTo( "../views/search_view.php" );
    return;
}

$cats = getCatIdAndType($searchCategory);
$catsAndAuctions = QueryOperator::searchAuctions(buildQuery(
    $searchString, $cats, $sort));


$updated_session = array_merge([SessionOperator::SEARCH_RESULT => $catsAndAuctions], $updated_session);
// Update search sessions
SessionOperator::setSearch( $updated_session );

// Return back to search page
HelperOperator::redirectTo( "../views/search_view.php" );


function buildQuery($searchString, $searchCategory, $sortOption ){

    $query =

        "SELECT  auctions.auctionId, quantity, startPrice, reservePrice, startTime,
		endTime, itemName, itemBrand, itemDescription, items.image, auctions.views,
        item_categories.categoryName as subCategoryName, superCategoryName,
        item_categories.superCategoryId, item_categories.categoryId,
        conditionName, countryName, COUNT(bids.bidId) AS numBids,
        COUNT(auction_watches.auctionId) AS numWatches,
        MAX(bids.bidPrice) AS highestBid,
        case
			when MAX(bids.bidPrice)is not null THEN MAX(bids.bidPrice)
            else startPrice
		end as currentPrice


        FROM auctions
            LEFT OUTER JOIN bids ON bids.auctionId = auctions.auctionId
            LEFT OUTER JOIN auction_watches ON auction_watches.auctionId = auctions.auctionId
            JOIN items ON items.itemId = auctions.itemId
            JOIN users ON items.userId = users.userId
            JOIN item_categories ON items.categoryId = item_categories.categoryId
            JOIN super_item_categories ON  item_categories.superCategoryId = super_item_categories.superCategoryId
            JOIN item_conditions ON items.conditionId = item_conditions.conditionId
            JOIN countries ON users.countryId = countries.countryId


        WHERE auctions.startTime < now() AND auctions.endTime > now() AND
            items.itemName LIKE \"%__ss__%\" __cc__
        GROUP BY auctions.auctionId "
        ;

    $query = str_replace("__ss__", $searchString, $query);
    if($searchCategory != null){
        if($searchCategory["type"] == "super"){
            $query = str_replace("__cc__",
                "AND super_item_categories.superCategoryId = ".$searchCategory["id"]
                , $query);
        }else{
            $query = str_replace("__cc__",
                "AND item_categories.categoryId = ".$searchCategory["id"]
                , $query);
        }
    }else{
        //searching all categories
        $query = str_replace("__cc__", "", $query);
    }
    switch ($sortOption){
        case "Best Match":
            var_dump("BEST MATCH");
            $orderBy = "ORDER BY CASE WHEN items.itemName = '__ss__' THEN 0
                                      WHEN items.itemName LIKE '__ss__ %' THEN 1
                                      WHEN items.itemName LIKE '% __ss__ %' THEN 2
                                      WHEN items.itemName LIKE '% __ss__' THEN 3
                                      WHEN items.itemName LIKE '__ss__%' THEN 4
                                      WHEN items.itemName LIKE '%__ss__%' THEN 5
                                      WHEN items.itemName LIKE '%__ss__' THEN 6
                                      ELSE 7
                                END ASC";
            $orderBy = str_replace("__ss__", $searchString, $orderBy);
            $query .= $orderBy;
            break;
        case "Time: ending soonest":
            $orderBy = "ORDER BY auctions.endTime ASC";
            $query .= $orderBy;
            break;
        case "Time: newly listed":
            $orderBy = "ORDER BY auctions.endTime DESC";
            $query .= $orderBy;
            break;
        case "Price: lowest first":
            $orderBy = "ORDER BY currentPrice ASC";
            $query .= $orderBy;
            break;
        case "Price: highest first":
            $orderBy = "ORDER BY currentPrice DESC";
            $query .= $orderBy;
            break;
        case "Distance: nearest first":
            //TODO would need a latlng for user and a field to enter where you are
            //--screw that
            break;
    }
    return $query;


}
function getCatIdAndType($catName){

    if($catName == "All"){
        return null;
    }
    $catName = addslashes($catName);
    $catName = "'". $catName . "'";

    $superCatId = DbItemSuperCategory::withConditions
        ("WHERE superCategoryName = ".$catName)->getListOfColumn("superCategoryId");

    if(count($superCatId)> 0){

        $id = $superCatId[0];
        $type = "super";
    }else{
        $subCatId = DbItemCategory::withConditions("WHERE categoryName = ".$catName)
            ->getListOfColumn("categoryId");


        $id = $subCatId[0];
        $type = "sub";
    }
    return array(
        "id"    => $id,
        "type"  => $type
    );


}





