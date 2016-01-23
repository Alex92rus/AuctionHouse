<?php
require_once "class.user.php";
session_start();
submitRegistration();


// Call when a registration form is submitted
function submitRegistration()
{
    // Only process registration form if sign up button was clicked
    if ( !isset( $_POST[ "signup" ] ) )
    {
        header( "Location: index.php" );
        exit();
    }

    // Create a session for all input fields of the registration form
    createRegistrationSession();

    // Check if any input fields are empty
    if ( checkForEmptyFields() )
    {
        header( "Location: index.php" );
        exit();
    }

    // Check if both username and email is not already used by another account
    if ( !checkUsernameAndEmail() )
    {
        header( "Location: index.php" );
        exit();
    }

    // Register new unverified account
    registerUser();
    header( "Location: index.php" );
    exit();
}


function createRegistrationSession()
{
    $registration = new User(
        $_POST[ 'username' ],
        $_POST[ 'email' ],
        $_POST[ 'firstName' ],
        $_POST[ 'lastName' ],
        $_POST[ 'address' ],
        $_POST[ 'postcode' ],
        $_POST[ 'city' ],
        $_POST[ 'country' ],
        $_POST[ 'password1' ],
        $_POST[ 'password2' ] );

    $_SESSION[ "registration" ] = $registration;
}


function checkForEmptyFields()
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

    // Get user object (stores registration information)
    $registrationFields = $_SESSION[ "registration" ] -> getObjectVars();

    // For each member variable in the user object, check if it is empty
    foreach ( $registrationFields as $key => $value )
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
        $_SESSION[ "input_errors" ] = $emptyFields;
        return true;
    }
    
    return false;
}


function checkUsernameAndEmail()
{
    // Retrieve username and email from the registration session
    $registration = $_SESSION[ "registration" ];
    $username = $registration -> getUsername();
    $email = $registration -> getEmail();

    // Check if username and email are already taken
    require_once "class.queryfactory.php";
    $nonUniqueFields = [];
    QueryFactory::checkUniqueness( $nonUniqueFields, 'username', $username );
    QueryFactory::checkUniqueness( $nonUniqueFields, 'email', $email );

    // Inputted username or email were already taken
    if ( !empty( $nonUniqueFields ) )
    {
        // Create a session for the taken input fields
        $_SESSION[ "input_errors" ] = $nonUniqueFields;
        return false;
    }

    return true;
}


function registerUser()
{
    // Retrieve all information from the registration session
    $registration = $_SESSION[ "registration" ];
    $username = $registration -> getUsername();
    $email = $registration -> getEmail();
    $firstName = $registration -> getFirstName();
    $lastName = $registration -> getLastName();
    $address = $registration -> getAddress();
    $postcode = $registration -> getPostcode();
    $city = $registration -> getCity();
    $country = $registration -> getCountry();
    $password = $registration -> getPassword1();

    // Create new user
    QueryFactory::addAccount( array( &$username, &$email, &$firstName, &$lastName, &$address, &$postcode, &$city, &$country, &$password ) );

    // Mark user as unverified
    $confirmCode = rand( 100000, 100000000 );
    QueryFactory::addUnverifiedAccount( array( &$email, &$confirmCode ) );

    // Create a session for the successfully submitted registration (account not verified yet)
    $title = "Registration submitted!";
    $info  = "Before accessing your account, you have to follow the verification ";
    $info .= "link we sent you to your email address";
    $_SESSION[ "registration_status" ] = [ "title" => $title, "info" => $info ];

    // Email a verification link to the user - must be verified before accessing the new account
    require_once "class.email.php";
    $mail = new Email( $email, $firstName, $lastName );
    $mail -> prepareVerificationEmail( $confirmCode );
    $mail -> sentEmail();
}