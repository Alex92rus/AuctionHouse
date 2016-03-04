<?php
require_once "../classes/class.helper_operator.php";
require_once "../classes/class.session_operator.php";
require_once "../classes/class.validation_operator.php";
require_once "../classes/class.query_operator.php";
require_once( $_SERVER['DOCUMENT_ROOT'] . '/classes/class.db_auction.php' );
require_once( $_SERVER['DOCUMENT_ROOT'] . '/classes/class.db_item.php' );

$auctionId = $_GET["id"];

if(!is_numeric($auctionId)){ // at least no sql injection
    HelperOperator::redirectTo("../views/my_live_auctions_view.php");
    return;
}

/* @var User $user */
$user = SessionOperator::getUser();
$userId = $user->getUserId();

/* @var DbAuction $auction */
$auction = DbAuction::find($auctionId);
$item = DbItem::find($auction->getField("itemId"));

//check user owns auction;
if($item->getField("userId") == $userId){
    var_dump($auction->delete());
}
HelperOperator::redirectTo("../views/my_live_auctions_view.php");
return;




