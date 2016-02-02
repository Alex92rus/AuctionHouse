<?php
require_once "helperfunctions.php";
require_once "../classes/class.session_operator.php";
require_once "../classes/class.validation_operator.php";
require_once "../classes/class.query_operator.php";

// Registration form was submitted
signUp();


// Check and process registration form
function signUp()
{
    // Only process when sign up button was clicked
    if ( !isset( $_POST[ "signUp" ] ) )
    {
        redirectTo( "../index.php" );
    }


    $countryId = QueryOperator::getCountryId( $_POST[ "country" ] );
    // Store POST values from registration form
    $registration = [
        "username"  => $_POST[ "username" ],
        "email"     => $_POST[ "email" ],
        "firstName" => $_POST[ "firstName" ],
        "lastName"  => $_POST[ "lastName" ],
        "address"   => $_POST[ "address" ],
        "postcode"  => $_POST[ "postcode" ],
        "city"      => $_POST[ "city" ],
        "country"   => $countryId,
        "password1" => $_POST[ "password1" ],
        "password2" => $_POST[ "password2" ] ];

    // Check registration inputs
    if ($registration["country"] == "Country") {
        $registration["country"]  = "";
    }
    if ( !ValidationOperator::checkForEmptyFields( $registration ) ||
         !checkUsernameAndEmail( $registration[ "username" ], $registration[ "email" ] ) ||
         !ValidationOperator::checkPasswords( $registration[ "password1" ], $registration[ "password2" ] ) )
    {
        // Create a session for the registration inputs so that they can be recovered after the page reloads
        SessionOperator::setFormInput( $registration );
    }
    // Registration form valid
    else
    {
        registerUser( $registration );
    }

    // Redirect back
    redirectTo( "../index.php" );
}



// Check if both username and email is not already used by another account
function checkUsernameAndEmail( $username, $email )
{
    require_once "../classes/class.query_operator.php";
    $nonUniqueFields = [];

    // Check if username is already taken
    if ( !QueryOperator::checkUniqueness( "username", $username ) )
    {
        $nonUniqueFields[ "username" ] = "This " . $username . " already exists";
    }
    // Check if email is already taken
    if ( !QueryOperator::checkUniqueness( "email", $email ) )
    {
        $nonUniqueFields[ "email" ] = "This " . $email . " already exists";
    }

    // Inputted username or email were already taken
    if ( !empty( $nonUniqueFields ) )
    {
        // Create a session for the taken input fields
        SessionOperator::setInputErrors( $nonUniqueFields );
        return false;
    }

    // No error
    return true;
}


// Register new unverified account
function registerUser( $completeForm )
{
    // Create new user
    $completeForm["country"] = QueryOperator::getCountryId($completeForm["country"]);
    $encryptedPassword = password_hash( $completeForm[ "password1" ], PASSWORD_BCRYPT );
    $insertId = QueryOperator::addAccount( array(
        &$completeForm[ "username" ],
        &$completeForm[ "email" ],
        &$completeForm[ "firstName" ],
        &$completeForm[ "lastName" ],
        &$completeForm[ "address" ],
        &$completeForm[ "postcode" ],
        &$completeForm[ "city" ],
        &$completeForm[ "country" ],
        &$encryptedPassword ) );

    // Mark user as unverified
    $confirmCode = rand( 100000, 100000000 );
    QueryOperator::addUnverifiedAccount( array( &$insertId, &$confirmCode ) );

    // Create a session for the successfully submitted registration (account not verified yet)
    SessionOperator::setFeedback( "submitted" );

    // Email a verification link to the user - must be verified before accessing the new account
    require_once "../classes/class.email.php";
    $mail = new Email( $completeForm[ "email" ], $completeForm[ "firstName" ], $completeForm[ "lastName" ] );
    $mail -> prepareVerificationEmail( $confirmCode );
    $mail -> sentEmail();
}