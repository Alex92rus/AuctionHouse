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

    // Register new user account
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
    $nonUniqueFields = [];

    // Retrieve username and email from the registration session
    $registration = $_SESSION[ "registration" ];
    $username = $registration -> getUsername();
    $email = $registration -> getEmail();

    // Check if username and email are already taken
    $usernameResult = checkUniqueness( $nonUniqueFields, 'username', $username );
    $emailResult = checkUniqueness( $nonUniqueFields, 'email', $email );

    // Inputted username or email were already taken
    if ( !$usernameResult || !$emailResult )
    {
        // Create a session for the taken input fields
        $_SESSION[ "input_errors" ] = $nonUniqueFields;
        return false;
    }

    return true;
}


function checkUniqueness( &$fieldArray, $field, $value )
{
    // Create database object
    require_once "class.database.php";
    $database = new Database();

    // SQL query for retrieving users with a specific username/email
    $checkFieldQuery = "SELECT " . $field . " FROM users where " . $field . " = '$value' ";

    // Query database
    $result = $database -> selectQuery( $checkFieldQuery );
    $numberOfRows = $result -> num_rows;

    // Close database connection
    $database -> closeConnection();

    // Query returned a row, meaning there exists already a user with the same registered username/email
    if ( $numberOfRows > 0 )
    {
        $fieldArray[ $field ] = "This " . $field . " already exists";
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

    // Create random confirmId (necessary when confirming registration)
    $confirmId = rand( 100000, 100000000 );

    // Create database object
    require_once "class.database.php";
    $database = new Database();

    // SQL query for creating a new user record
    $registerUserQuery  = "INSERT INTO users (username, email, firstName, lastName, address, postcode, city, country, password, confirmId) ";
    $registerUserQuery .= "VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ? )";

    // Query database
    $database -> insertQuery(
        $registerUserQuery,
        "sssssssssi",
        array( &$username, &$email, &$firstName, &$lastName, &$address, &$postcode, &$city, &$country, &$password, &$confirmId ) );

    // Close database
    $database -> closeConnection();

    // Create a session for the successfully submitted registration (account not verified yet)
    $title = "Registration submitted!";
    $info  = "Before accessing your account, you have to follow the verification ";
    $info .= "link we sent you to your email address";
    $_SESSION[ "registration_status" ] = [ "title" => $title, "info" => $info ];

    // Email a confirmation link to the user - must be verified before accessing the new account
    require_once "class.email.php";
    $mail = new Email();
    $mail -> prepareVerificationEmail( $email, $firstName, $lastName, $confirmId );
    $mail -> sentEmail();
}