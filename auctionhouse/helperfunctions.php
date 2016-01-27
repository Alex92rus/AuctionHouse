<?php
require_once "class.session_factory.php";


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

// Redirect to a page
function redirectTo( $page )
{
    header( "Location: " . $page );
    exit();
}