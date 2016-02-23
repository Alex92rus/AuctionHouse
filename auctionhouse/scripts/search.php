<?php
require_once "helper_functions.php";
require_once "../classes/class.session_operator.php";

$updated_session = null;


/*
 * The format of the result must be one of following formats:
 * 1 [ "All" , [$auction1, $auction2] ]
 * 2 [ [1,2,3,4] , [$auction1, $auction2] ]
 * 3 [ [1] , [2,3,4], [$auction1, $auction2] ]
 *
 * Fake results
 */
$result1 = [ [1,2,3,4,5,6,7,8], ["test1", "test1" ] ];
$result2 = [ [1,2,3,4,5,6,7,8], ["test1", "test1" ] ];
$result = [ ["All"], ["test1", "test1" ] ];


// Initial search
if ( isset( $_GET[ "searchString" ] ) && isset( $_GET[ "searchCategory" ] ) )
{
    $searchString = $_GET[ "searchString" ];
    $searchCategory = $_GET[ "searchCategory" ];
    $sort = SessionOperator::getSearchSetting( SessionOperator::SORT );


    // TODO: search for auctions


    // Set search sessions
    $updated_session = [
        SessionOperator::SEARCH_STRING => $_GET[ "searchString" ],
        SessionOperator::SEARCH_CATEGORY => $_GET[ "searchCategory" ],
        SessionOperator::SEARCH_RESULT => $result ];
}
// Search by different category
else if ( isset( $_GET[ "searchCategory" ] ) )
{
    $searchString = SessionOperator::getSearchSetting( SessionOperator::SEARCH_STRING );
    $searchCategory = $_GET[ "searchCategory" ];
    $sort = SessionOperator::getSearchSetting( SessionOperator::SORT );


    // TODO: search for auctions


    // Set search sessions
    $updated_session = [
        SessionOperator::SEARCH_CATEGORY => $searchCategory,
        SessionOperator::SEARCH_RESULT => $result ];
}
// Sort search
else if ( isset( $_GET[ "sort" ] ) )
{
    $searchString = SessionOperator::getSearchSetting( SessionOperator::SEARCH_STRING );
    $searchCategory = SessionOperator::getSearchSetting( SessionOperator::SEARCH_CATEGORY );
    $sort = $_GET[ "sort" ];


    // TODO: sort auctions


    // Set search sessions
    $updated_session = [
        SessionOperator::SORT => $sort,
        SessionOperator::SEARCH_RESULT => $result ];
}


// Update search sessions
if ( !is_null( $updated_session ) )
{
    SessionOperator::setSearch( $updated_session );
}


// Return back to search page
redirectTo( "../views/search_view.php" );