<?php
require_once "helperfunctions.php";


// User wants to sign in
signIn();


// Check and process login form
function signIn()
{
    // Sign in button was clicked
    if ( isset( $_POST[ "signIn" ] ) )
    {
        require_once "class.query_handler.php";
        require_once "class.session_handler.php";
        $email = trim( $_POST[ "loginEmail" ] );
        $password = trim( $_POST[ "loginPassword" ] );

        // Login details correct
        if ( !is_null( $userId = QueryFactory::checkAccount( $email, $password ) ) )
        {
            // Login user and redirect to home page
            SessionFactory::login( $userId );
            redirectTo( "home.php" );
        }
        // Login failed
        else
        {
            // Create a session for the login inputs so that they can be recovered after the page reloads
            SessionFactory::setFormInput( [
                    "loginEmail" => $email,
                    "loginPassword" =>$password]);

            // Create a session for incorrect email and user details
            $message = "The entered email and password did not match our records, please try again.";
            SessionFactory::setInputErrors( [ "login" => $message ] );
        }
    }

    // Sign in button was not clicked or sign in failed
    redirectTo( "index.php" );
}
