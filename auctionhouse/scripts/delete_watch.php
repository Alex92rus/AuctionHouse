<?php
require_once "../classes/class.helper_operator.php";
require_once "../classes/class.session_operator.php";
require_once "../classes/class.validation_operator.php";
require_once "../classes/class.query_operator.php";

require_once( $_SERVER['DOCUMENT_ROOT'] . '/classes/class.db_auction.php' );
require_once( $_SERVER['DOCUMENT_ROOT'] . '/classes/class.db_auction_watch.php' );

$watchId = $_GET["id"];

// Prevent sql injection
if(!is_numeric($watchId)){
    HelperOperator::redirectTo("../views/my_watch_list_view.php");
}

/* @var User $user */
$user = SessionOperator::getUser();
$userId = $user->getUserId();

/* @var DbAuction $auction */
$watch = DbAuctionWatch::find($watchId);

// User owns watch
if($watch->getField("userId") == $userId){
    // Delete watch
    $watch->delete();
    // Set feedback session
    SessionOperator::setFeedback( SessionOperator::DELETED_WATCH );
}


HelperOperator::redirectTo("../views/my_watch_list_view.php");




