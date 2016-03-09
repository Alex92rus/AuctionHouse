<?php
require_once "../classes/class.helper_operator.php";
require_once "../classes/class.session_operator.php";
require_once "../classes/class.validation_operator.php";
require_once "../classes/class.query_operator.php";
require_once "../classes/class.db_auction_watch.php";

/* @var User $user*/
$user = SessionOperator::getUser();
$auctionId = $_GET["liveAuction"];

if(!is_numeric($auctionId)){
    HelperOperator::redirectTo("../views/open_live_auction_view.php?".$_SERVER['QUERY_STRING']);
}

//check user hasn't already watched
$alreadyWatching =
    DbAuctionWatch::withConditions("WHERE userId = ".$user->getUserId(). " AND auctionId =".$auctionId)
        ->exists() ? true: false;

if($alreadyWatching){
    HelperOperator::redirectTo("../views/open_live_auction_view.php?".$_SERVER['QUERY_STRING']);
}

//create an auction_watch
$watch = new DbAuctionWatch(array(
    "userId" => $user->getUserId(),
    "auctionId" =>$auctionId
));
$watch->create();

HelperOperator::redirectTo("../views/open_live_auction_view.php?".$_SERVER['QUERY_STRING']);



