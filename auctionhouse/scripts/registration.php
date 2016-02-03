<?php
require_once "helperfunctions.php";
require_once "../classes/class.session_operator.php";
require_once "../classes/class.validation_operator.php";
require_once "../classes/class.query_operator.php";


// Only process when sign up button was clicked
if ( !isset( $_POST[ "signUp" ] ) )
{
    redirectTo( "../index.php" );
}

// Store POST values from registration form
$registration = [
    "username"  => $_POST[ "username" ],
    "email"     => $_POST[ "email" ],
    "firstName" => $_POST[ "firstName" ],
    "lastName"  => $_POST[ "lastName" ],
    "address"   => $_POST[ "address" ],
    "postcode"  => $_POST[ "postcode" ],
    "city"      => $_POST[ "city" ],
    "country"   =>  $_POST[ "country" ],
    "password1" => $_POST[ "password1" ],
    "password2" => $_POST[ "password2" ] ];

// Check registration inputs
if ( $registration[ "country" ] == "Country" )
{
    $registration[ "country" ]  = "";
}
if ( !ValidationOperator::checkForEmptyFields( $registration ) ||
     !ValidationOperator::checkUsernameAndEmail( $registration[ "username" ], $registration[ "email" ] ) ||
     !ValidationOperator::checkPasswords( $registration[ "password1" ], $registration[ "password2" ] ) )
{
    // Create a session for the registration inputs so that they can be recovered after the page reloads
    SessionOperator::setFormInput( $registration );
}
// Registration form valid
else
{
    // Create new user
    $registration[ "country" ] = QueryOperator::getCountryId( $registration[ "country" ] );
    $encryptedPassword = password_hash( $registration[ "password1" ], PASSWORD_BCRYPT );
    $insertId = QueryOperator::addAccount( array(
        &$registration[ "username" ],
        &$registration[ "email" ],
        &$registration[ "firstName" ],
        &$registration[ "lastName" ],
        &$registration[ "address" ],
        &$registration[ "postcode" ],
        &$registration[ "city" ],
        &$registration["country"],
        &$encryptedPassword ) );

    // Mark user as unverified
    $confirmCode = rand( 100000, 100000000 );
    QueryOperator::addUnverifiedAccount( array( &$insertId, &$confirmCode ) );

    // Create a session for the successfully submitted registration (account not verified yet)
    SessionOperator::setFeedback( "submitted" );

    // Email a verification link to the user - must be verified before accessing the new account
    require_once "../classes/class.email.php";
    $mail = new Email( $registration[ "email" ], $registration[ "firstName" ], $registration[ "lastName" ] );
    $mail -> prepareVerificationEmail( $confirmCode );
    $mail -> sentEmail();
}

// Redirect back
redirectTo( "../index.php" );
