<?php
require_once "../classes/class.helper_operator.php";
require_once "../classes/class.session_operator.php";
require_once "../classes/class.validation_operator.php";
require_once "../classes/class.query_operator.php";
require_once "../classes/class.db_feedback.php";
require_once "../classes/class.db_user.php";


// Only process when start auction button was clicked
if ( !isset( $_POST[ "createFeedback" ] ) )
{
    HelperOperator::redirectTo( "../views/my_sold_auctions_view.php" );
}

$origin = $_POST[ "origin" ];
if($origin = "won"){
    $redirectUrl = "../views/my_successful_bids_view.php";
}elseif ($origin = "sold"){
    $redirectUrl = "../views/my_sold_auctions_view.php";
}else{
    $redirectUrl = "../views/my_sold_auctions_view.php";
}


$auctionId =  $_POST[ "auctionId" ];
$creatorId = SessionOperator::getUser()->getUserId();

//get the id of receiver
$receiverUsername = $_POST[ "receiverUsername" ];
/* @var DbUser $receiver */
$receiver = DbUser::withConditions("WHERE username = '". $receiverUsername ."'")->first();


//check receiver exists AND there is no existing feedback (we only allow one)
if($receiver == null or DbFeedback::withConditions
    ("WHERE auctionId = ". $auctionId . " AND creatorId = ". $creatorId . " AND receiverId = ". $receiver->getId())->exists()){
    HelperOperator::redirectTo( $redirectUrl );
}

$now = new DateTime();

$feedback = new DbFeedback(array(
    "auctionId" => $_POST[ "auctionId" ],
    "creatorId" => SessionOperator::getUser()->getUserId(),
    "receiverId" => $receiver->getId(),
    "score" => $_POST[ "score" ],
    "comment" => $_POST[ "comment" ],
    "time" =>$now->format('Y-m-d H:i:s')
));
$feedback->create();


HelperOperator::redirectTo( $redirectUrl );





