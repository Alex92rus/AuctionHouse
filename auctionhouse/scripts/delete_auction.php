<?php
require_once "../classes/class.helper_operator.php";
require_once "../classes/class.session_operator.php";
require_once "../classes/class.validation_operator.php";
require_once "../classes/class.query_operator.php";
require_once( $_SERVER['DOCUMENT_ROOT'] . '/classes/class.db_auction.php' );
require_once( $_SERVER['DOCUMENT_ROOT'] . '/classes/class.db_item.php' );

$auctionId = $_GET["id"];

// Prevent sql injection
if(!is_numeric($auctionId)){
    HelperOperator::redirectTo("../views/my_live_auctions_view.php");
}

/* @var User $user */
$user = SessionOperator::getUser();
$userId = $user->getUserId();

/* @var DbAuction $auction */
$auction = DbAuction::find($auctionId);
$item = DbItem::find($auction->getField("itemId"));

// User owns auction
if($item->getField("userId") == $userId) {
    // Delete auction
    $auction->delete();
    if ( !empty( $imageName = $item -> getField( "image" ) ) )
    {
        unlink( ROOT . $imageName );
    }
    // Set feedback session
    SessionOperator::setFeedback( SessionOperator::DELETED_AUCTION );
}

HelperOperator::redirectTo("../views/my_live_auctions_view.php");




