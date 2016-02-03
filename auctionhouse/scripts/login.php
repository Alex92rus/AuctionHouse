<?php
require_once "helperfunctions.php";
require_once "../classes/class.session_operator.php";
require_once "../classes/class.user.php";


// Sign in button was clicked
if ( isset( $_POST[ "signIn" ] ) )
{
    require_once "../classes/class.query_operator.php";
    require_once "../classes/class.session_operator.php";
    $email = trim( $_POST[ "loginEmail" ] );
    $password = trim( $_POST[ "loginPassword" ] );

    // Login details correct
    if ( !is_null( $account = QueryOperator::checkAccount( $email, $password ) ) )
    {
        // Login user and redirect to home page
        SessionOperator::login( new User ( $account ) );
        redirectTo( "../home.php" );
    }
    // Login failed
    else
    {
        // Create a session for the login inputs so that they can be recovered after the page reloads
        SessionOperator::setFormInput( [
                "loginEmail" => $email,
                "loginPassword" => $password ] );

        // Create a session for incorrect email and user details
        $message = "The entered email and password did not match our records, please try again.";
        SessionOperator::setInputErrors( [ "login" => $message ] );
    }
}

// Sign in button was not clicked or sign in failed
redirectTo( "../index.php" );
