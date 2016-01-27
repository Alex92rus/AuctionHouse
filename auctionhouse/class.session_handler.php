<?php

session_start();


class SessionFactory
{
    // Create a session for the just submitted but failed form
    public static function setFormInput( $form )
    {
        $_SESSION[ "form_inputs" ] = $form;
    }

    // Recover field input after each failed form submission
    public static function getFormInput( $key )
    {
        $input = "";

        if ( isset( $_SESSION[ "form_inputs" ] ) && array_key_exists( $key, $_SESSION[ "form_inputs" ] ) )
        {
            $input = htmlentities( $_SESSION[ "form_inputs" ][ $key ] );
            unset( $_SESSION[ "form_inputs" ][ $key ] );

            // Delete the session after all field inputs were recovered
            if ( empty( $_SESSION[ "form_inputs" ] ) )
            {
                unset( $_SESSION[ "form_inputs" ] );
            }
        }

        return $input;
    }

    // Create a session for the incorrect form fields
    public static function setInputErrors( $incorrectFields )
    {
        $_SESSION[ "input_errors" ] = $incorrectFields;
    }

    // Get error message for incorrect field input
    public static function getInputErrors( $key )
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

    // Login user
    public static function login( $id )
    {
        $_SESSION[ "userId" ] = $id;
    }

    // Logout user
    public static function logout()
    {
        if ( isset( $_SESSION[ "userId" ] ) )
        {
            unset( $_SESSION[ "userId" ] );
        }
    }

    // Check if a user has already logged in
    public static function isLoggedIn()
    {
        if ( isset( $_SESSION[ "userId" ] ) )
        {
            return true;
        }

        return false;
    }

}