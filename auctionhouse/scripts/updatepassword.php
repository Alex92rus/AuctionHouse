<?php
require_once "helperfunctions.php";
require_once "../classes/class.validation_operator.php";
require_once "../classes/class.query_operator.php";
require_once "../classes/class.session_operator.php";


// Retrieve Passwords
$passwordFields = [ "password1" => $_POST[ "password1" ], "password2" => $_POST[ "password2" ] ];


// Both passwords valid and match
if ( ValidationOperator::checkForEmptyFields( $passwordFields ) &&
	 ValidationOperator::checkPasswords( $passwordFields[ "password1" ], $passwordFields[ "password2" ] ) )
{
	QueryOperator::updatePassword( SessionOperator::getEmail(), $passwordFields[ "password2" ] );
	SessionOperator::deleteEmail();
	SessionOperator::setFeedback( SessionOperator::CHANGED );
	redirectTo( "../index.php" );
}
// Invalid password inputs
else
{
	SessionOperator::setFormInput( $passwordFields );
}

redirectTo( "../changepassword.php?email=" . SessionOperator::getEmail() );
