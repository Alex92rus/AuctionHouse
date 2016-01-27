<?php 
require_once "helperfunctions.php";
require_once "class.session_factory.php";
require_once "class.email.php";
require_once "class.query_factory.php";

//Recover form submitted
recover();

function recover() {

	$userInfo = QueryFactory:: getAccountFromEmail($_POST[ "email" ]);
    $mail = new Email( $userInfo[ "email" ], $userInfo[ "firstName" ], $userInfo[ "lastName" ] );
    $mail -> prepareRecoveryEmail();
    $mail -> sentEmail();
}
?>
