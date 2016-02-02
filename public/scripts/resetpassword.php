<?php
require_once "helperfunctions.php";
require_once "../classes/class.email.php";
require_once "../classes/class.query_operator.php";
require_once "../classes/class.validation_operator.php";
require_once "../classes/class.session_operator.php";


// Check if email is associated with an account
$userInfo = QueryOperator:: getAccountFromEmail( $_POST[ "email" ] );


// Email belongs to an account - send password reset email to that user
if ( $userInfo != null )
{
    $mail = new Email( $_POST[ "email" ], $userInfo[ "firstName" ], $userInfo[ "lastName" ] );
    $mail -> prepareResetEmail();
    $mail -> sentEmail();
    SessionOperator::setFeedback( SessionOperator::RESET );
    redirectTo( "../index.php" );
}
else
{
    // Create a session for not found email
    SessionOperator::setInputErrors( [ "email" => "Email could not be found in our records" ] );
    // Create a session for the inputted email so that it can be recovered after the page reloads
    SessionOperator::setFormInput( [ "email" => $_POST[ "email" ] ] );
    redirectTo( "../forgotpassword.php" );
}
