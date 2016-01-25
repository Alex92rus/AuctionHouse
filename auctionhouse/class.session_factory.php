<?php

session_start();


class SessionFactory
{
    // Create a session for the just submitted registration from
    public static function setRegistration( $registration )
    {
        $_SESSION[ "registration" ] = $registration;
    }

    // Create a session for the incorrect registration fields
    public static function setRegistrationErrors( $incorrectFields )
    {
        $_SESSION[ "input_errors" ] = $incorrectFields;
    }

    // Create a session for the successfully submitted / fully completed registration
    public static function setRegistrationStatus( $status )
    {
        if ( $status == 'submitted' )
        {
            $title = "Registration submitted!";
            $info  = "Before accessing your account, you have to follow the verification ";
            $info .= "link we sent you to your email address";
        }
        else
        {
            $title = "Registration completed!";
            $info  = "Thank you for joining us. Your account is now ready for signing in.";
        }

        $_SESSION[ "registration_status" ] = [ "title" => $title, "info" => $info ];
    }

    // Check if a registration was successfully submitted or completed, if yes output positive feedback on the screen
    public static function getRegistrationStatus()
    {
        $title = null;
        $info = null;

        if ( isset( $_SESSION[ "registration_status" ] ) )
        {
            // Retrieve registration status
            $status = $_SESSION[ "registration_status" ];
            $title = "<strong>" . $status[ "title" ] . "</strong>";
            $info = $status[ "info" ];

            // Delete registration notification session
            unset( $_SESSION[ "registration_status" ] );
        }

        return array( $title, $info );
    }

    // Get error message for incorrect field input
    public static function getErrorMessage( $key )
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
    public static function getInput( $key )
    {
        $input = "";

        if ( isset( $_SESSION[ "registration" ] ) )
        {
            $input = htmlentities( $_SESSION[ "registration" ][ $key ] );
            unset( $_SESSION[ "registration" ][ $key ] );

            // Delete the registration session after all field inputs were recovered
            if ( empty( $_SESSION[ "registration" ] ) )
            {
                unset( $_SESSION[ "registration" ] );
            }
        }

        return $input;
    }
}