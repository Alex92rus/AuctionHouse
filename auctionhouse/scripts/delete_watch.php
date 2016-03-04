<?php
require_once "../classes/class.helper_operator.php";
require_once "../classes/class.session_operator.php";
require_once "../classes/class.validation_operator.php";
require_once "../classes/class.query_operator.php";
require_once( $_SERVER['DOCUMENT_ROOT'] . '/classes/class.db_auction.php' );
require_once( $_SERVER['DOCUMENT_ROOT'] . '/classes/class.db_auction_watch.php' );

$watchId = $_GET["id"];

if(!is_numeric($watchId)){ // at least no sql injection
    HelperOperator::redirectTo("../views/my_watch_list_view.php");
    return;
}

/* @var User $user */
$user = SessionOperator::getUser();
$userId = $user->getUserId();

/* @var DbAuction $auction */
$watch = DbAuctionWatch::find($watchId);
//$item = DbItem::find($auction->getField("itemId"));

//check user owns watch;
if($watch->getField("userId") == $userId){
    $watch->delete();
}
HelperOperator::redirectTo("../views/my_watch_list_view.php");
return;




