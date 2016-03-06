<?php
require_once "../classes/class.helper_operator.php";
require_once "../classes/class.session_operator.php";
require_once "../classes/class.query_operator.php";
require_once "../classes/class.db_category.php";
require_once "../classes/class.db_super_category.php";
require_once "../classes/class.pagination.php";


$updated_session = null;
$result = array();

// Initial search
if ( isset( $_GET[ "searchString" ] ) && isset( $_GET[ "searchCategory" ] ) && strlen($_GET[ "searchString" ] ) >= 3 )
{
    $searchString = trim(htmlspecialchars_decode($_GET[ "searchString" ]));
    $searchCategory = htmlspecialchars_decode($_GET[ "searchCategory" ]);
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
// Problem
else {
    HelperOperator::redirectTo( "../views/search_view.php" );
    return;
}

$cats = getCatIdAndType($searchCategory);

// Set up pagination object
$total = QueryOperator::countFoundAuctions(buildQuery($searchString, $cats, $sort));
$page = ( isset ( $_GET[ "page" ] ) ) ? $_GET[ "page" ] : 1; $page = $page <= $total ? $page : 1;
$per_page = 15;
$pagination = new Pagination( $page, $per_page, $total );

// Get paginated search results
$catsAndAuctions = QueryOperator::searchAuctions(buildQuery($searchString, $cats, $sort, $per_page, $pagination -> offset() ) );

// Update search sessions
$updated_session = array_merge([SessionOperator::SEARCH_RESULT => $catsAndAuctions], $updated_session);
$updated_session = array_merge([SessionOperator::SEARCH_PAGINATION => $pagination], $updated_session);
SessionOperator::setSearch( $updated_session );

// Return back to search page
HelperOperator::redirectTo( "../views/search_view.php" );




function buildQuery($searchString, $searchCategory, $sortOption, $limit = null, $offset = null )
{
    $query = null;

    // Prepare count query
    if ( is_null( $limit ) && is_null( $offset ) )
    {
        $query = "SELECT COUNT(*) ";
    }
    // Prepare list search results query
    else
    {
        $query =
            "SELECT auctions.auctionId, quantity, startPrice, reservePrice, startTime,
            endTime, itemName, itemBrand, itemDescription, items.image, auctions.views,
            item_categories.categoryName as subCategoryName, superCategoryName,
            item_categories.superCategoryId, item_categories.categoryId,
            conditionName, countryName, COUNT(bids.bidId) AS numBids,
            COUNT(auction_watches.auctionId) AS numWatches,
            MAX(bids.bidPrice) AS highestBid,
            case
                when MAX(bids.bidPrice)is not null THEN MAX(bids.bidPrice)
                else startPrice
            end AS currentPrice ";
    }

    $query .=
        "FROM auctions
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
        GROUP BY auctions.auctionId ";

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

    switch ($sortOption)
    {
        case "Best Match":
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
    }

    if ( !is_null( $limit ) && !is_null( $offset ) )
    {
        $query .= " LIMIT {$limit} OFFSET {$offset}";
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

