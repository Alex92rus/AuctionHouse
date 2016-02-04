<?php
require_once "helper_functions.php";
require_once "../classes/class.validation_operator.php";
require_once "../classes/class.query_operator.php";
require_once "../classes/class.session_operator.php";
require_once "../classes/class.email.php";


// Retrieve Passwords
$passwordFields = [
    "currentPassword" => $_POST[ "currentPassword" ],
    "password1"   => $_POST[ "password1" ],
    "password2"   => $_POST[ "password2" ]
];

// Get current user session
$user = SessionOperator::getUser();

// Current password is correct and both new passwords are valid and match
if ( !ValidationOperator::hasEmtpyFields( $passwordFields ) &&
     ValidationOperator::isCurrentPassword( $passwordFields[ "currentPassword" ] ) &&
     ValidationOperator::validPasswords( $passwordFields[ "password1" ], $passwordFields[ "password2" ] ) )
{
    QueryOperator::updatePassword( $user -> getEmail(), $passwordFields[ "password2" ] );
    SessionOperator::setFeedback( SessionOperator::CHANGED_PASSWORD );

    // Send a password changed confirmation email to the user
    $mail = new Email( $user -> getEmail(), $user -> getFirstName(), $user -> getLastName() );
    $mail -> preparePasswordConfirmEmail();
    $mail -> sentEmail();
}
// Invalid inputs
else
{
    SessionOperator::setFormInput( $passwordFields );
}

redirectTo( "../account.php" );


