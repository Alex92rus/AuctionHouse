<?php
require_once "helperfunctions.php";
require_once "../classes/class.validation_operator.php";
require_once "../classes/class.query_operator.php";
require_once "../classes/class.session_operator.php";


// Retrieve Passwords
$passwordFields = [ "password1" => $_POST[ "password1" ], "password2" => $_POST[ "password2" ] ];
$email = SessionOperator::getEmail();
$userDetails = QueryOperator::getAccountFromEmail( $email );

// Both passwords valid and match
if ( ValidationOperator::checkForEmptyFields( $passwordFields ) &&
	 ValidationOperator::checkPasswords( $passwordFields[ "password1" ], $passwordFields[ "password2" ] ) )
{
	QueryOperator::updatePassword( $email, $passwordFields[ "password2" ] );
	SessionOperator::deleteEmail();
	SessionOperator::setFeedback( SessionOperator::CHANGED );

	// Send a password changed confirmation email to the user
	require_once "../classes/class.email.php";
	$mail = new Email( $email, $userDetails[ "firstName" ], $userDetails[ "lastName" ] );
	$mail -> preparePasswordConfirmEmail();
	$mail -> sentEmail();

	redirectTo( "../index.php" );
}
// Invalid password inputs
else
{
	SessionOperator::setFormInput( $passwordFields );
}

redirectTo( "../changepassword.php?email=" . $email );
