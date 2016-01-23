<?php
require_once "class.user.php";
session_start();


// Check if a registration was successfully submitted or completed, if yes output positive feedback on the screen
function getRegistrationStatus()
{
    $title = null;
    $info = null;

    if ( isset( $_SESSION[ "registration_status" ] ) )
    {
        // Retrieve registration status
        $status = $_SESSION[ "registration_status" ];
        $title = "<strong>" . $status[ "title" ] . "</strong>";
        $info = $status[ "info" ];

        // Delete all sessions related to the completed registration
        unset( $_SESSION[ "registration_status" ] );
        unset( $_SESSION[ "registration" ] );
    }

    return array( $title, $info );
}


// Get error message for incorrect field input
function getErrorMessage( $key )
{
    $message = "";

    // There was an input error within a specific field
    if ( isset( $_SESSION[ "input_errors" ] ) && array_key_exists( $key, $_SESSION[ "input_errors" ] ) )
    {
        // Get the error message for the input field
        $message = $_SESSION[ "input_errors" ][ $key ];

        // Remove the input field from the input errors array
        unset( $_SESSION[ "input_errors" ][ $key ] );

        // Delete the input error session after all error messages were outputted to the screen
        if ( empty( $_SESSION[ "input_errors" ] ) )
        {
            unset( $_SESSION[ "input_errors" ] );
        }
    }

    return $message;
}


// Recover field input after each unsuccessful registration attempt
function getInput( $key )
{
    $input = "";


    if ( isset( $_SESSION[ "registration" ] ) )
    {
        $input = htmlentities( $_SESSION[ "registration" ] -> getMemberField( $key ) );

        // Delete the registration session after all field inputs were recovered
        if ( $key == 'password2' )
        {
            unset( $_SESSION[ "registration" ] );
        }
    }

    return $input;
}
