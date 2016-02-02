<?php
require_once "class.session_operator.php";


class ValidationOperator
{
   const EMPTY_FIELD_MESSAGES = [
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
    const INCORRECT_PASSWORDS = [
        "Password needs to be at least 10 characters long!",
        "Does not match with other password field!"
    ];


    public static function checkForEmptyFields( $fields )
    {
        // Variable for storing missing input fields
        $emptyFields = [];

        // For each member variable in the user object, check if it is empty
        foreach ( $fields as $key => $value )
        {
            // Trim whitespaces
            $value = is_array( $value ) ? $value : trim( $value );

            // Empty field was found, hence store them with their corresponding error message
            if ( empty( $value ) &&  $key != "signUp" )
            {
                $emptyFields[ $key ] = ValidationOperator::EMPTY_FIELD_MESSAGES[ $key ];
            }
        }

        // Registration is incomplete since we found empty field(s)
        if ( !empty( $emptyFields ) )
        {
            // Create a session for the missing input fields
            SessionOperator::setInputErrors( $emptyFields );
            return false;
        }

        // No error
        return true;
    }


    // Check inputted passwords
    public static function checkPasswords( $password1, $password2 )
    {
        $info = null;

        // Check if passwords have a minimum length
        if ( strlen( $password1 ) < 10 )
        {
            $info = ValidationOperator::INCORRECT_PASSWORDS[ 0 ];
        }
        // Check if the two inputted passwords mismatch
        else if ( strcmp( $password1, $password2 ) != 0 )
        {
            $info = ValidationOperator::INCORRECT_PASSWORDS[ 1 ];
        }

        // Create a session for the incorrect passwords
        if ( $info != null )
        {
            $passwordError = [ "password1" => $info, "password2" => $info ];
            SessionOperator::setInputErrors( $passwordError );
            return false;
        }

        // No error
        return true;
    }
}