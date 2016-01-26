<?php
require_once "helperfunctions.php";
require_once "class.session_factory.php";


// Registration form was submitted
signUp();


// Check and process registration form
function signUp()
{
    // Only process when sign up button was clicked
    if ( !isset( $_POST[ "signUp" ] ) )
    {
        redirectTo( "index.php" );
    }

    // Store POST values from registration form
    $registration = createRegistration();

    // Check registration inputs
    if ( checkForEmptyFields( $registration ) ||
         !checkUsernameAndEmail( $registration[ "username" ], $registration[ "email" ] ) ||
         !checkPasswords( $registration[ "password1" ], $registration[ "password2" ] ) )
    {
        // Create a session for the registration inputs so that they can be recovered after the page reloads
        SessionFactory::setFormInput( $registration );
    }
    // Registration form valid
    else
    {
        registerUser( $registration );
    }

    // Redirect back
    redirectTo( "index.php" );
}


// Get all registration information
function createRegistration()
{
    $registration = [
        "username"  => $_POST[ "username" ],
        "email"     => $_POST[ "email" ],
        "firstName" => $_POST[ "firstName" ],
        "lastName"  => $_POST[ "lastName" ],
        "address"   => $_POST[ "address" ],
        "postcode"  => $_POST[ "postcode" ],
        "city"      => $_POST[ "city" ],
        "country"   => $_POST[ "country" ],
        "password1" => $_POST[ "password1" ],
        "password2" => $_POST[ "password2" ] ];

    return $registration;
}


// Check if any input fields are empty
function checkForEmptyFields( $registration )
{
    // Error messages for each field in case it is empty
    $emptyFieldMessages = [
        "username" => "Please enter a username",
        "email" => "Please enter your email",
        "firstName" => "Please enter your first name",
        "lastName" => "Please enter your last name",
        "address" => "Please enter your address you live in",
        "postcode" => "Please enter your postcode",
        "city" => "Please enter the city you live in",
        "country" => "Please enter the country you live in",
        "password1" => "Please enter a password",
        "password2" => "Please enter the same password again"
    ];

    // Variable for storing missing input fields
    $emptyFields = [];

    // For each member variable in the user object, check if it is empty
    foreach ( $registration as $key => $value )
    {
        // Trim whitespaces
        $value = is_array( $value ) ? $value : trim( $value );

        // Empty field was found, hence store them with their corresponding error message
        if ( empty( $value ) &&  $key != "signup" )
        {
            $emptyFields[ $key ] = $emptyFieldMessages[ $key ];
        }
    }

    // Registration is incomplete since we found empty field(s)
    if ( !empty( $emptyFields ) )
    {
        // Create a session for the missing input fields
        SessionFactory::setInputErrors( $emptyFields );
        return true;
    }

    // No error
    return false;
}


// Check if both username and email is not already used by another account
function checkUsernameAndEmail( $username, $email )
{
    require_once "class.query_factory.php";
    $nonUniqueFields = [];

    // Check if username is already taken
    if ( !QueryFactory::checkUniqueness( "username", $username ) )
    {
        $nonUniqueFields[ "username" ] = "This " . $username . " already exists";
    }
    // Check if email is already taken
    if ( !QueryFactory::checkUniqueness( "email", $email ) )
    {
        $nonUniqueFields[ "email" ] = "This " . $email . " already exists";
    }

    // Inputted username or email were already taken
    if ( !empty( $nonUniqueFields ) )
    {
        // Create a session for the taken input fields
        SessionFactory::setInputErrors( $nonUniqueFields );
        return false;
    }

    // No error
    return true;
}


// Check inputted passwords
function checkPasswords( $password1, $password2 )
{
    $info = null;

    // Check if passwords have a minimum length
    if ( strlen( $password1 ) < 10 )
    {
        $info = "Password needs to be at least 10 characters long!";
    }
    // Check if the two inputted passwords match
    else if ( strcmp( $password1, $password2 ) != 0 )
    {
        $info = "Does not match with other password field!";
    }

    // Create a session for the incorrect passwords
    if ( $info != null )
    {
        $passwordError = [ "password1" => $info, "password2" => $info ];
        SessionFactory::setInputErrors( $passwordError );
        return false;
    }

    // No error
    return true;
}


// Register new unverified account
function registerUser( $completeForm )
{
    // Create new user
    $encryptedPassword = password_hash( $completeForm[ "password1" ], PASSWORD_BCRYPT );
    $insertId = QueryFactory::addAccount( array(
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
    QueryFactory::addUnverifiedAccount( array( &$insertId, &$confirmCode ) );

    // Create a session for the successfully submitted registration (account not verified yet)
    SessionFactory::setRegistrationStatus( "submitted" );

    // Email a verification link to the user - must be verified before accessing the new account
    require_once "class.email.php";
    $mail = new Email( $completeForm[ "email" ], $completeForm[ "firstName" ], $completeForm[ "lastName" ] );
    $mail -> prepareVerificationEmail( $confirmCode );
    $mail -> sentEmail();
}