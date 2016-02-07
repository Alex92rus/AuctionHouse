<?php
require_once "class.session_operator.php";


class ValidationOperator
{
    const EMPTY_FIELDS_MESSAGES = [
        "username" => "Please enter a non empty username",
        "email" => "Please enter a non empty email address",
        "firstName" => "Please enter a non empty first name",
        "lastName" => "Please enter a non empty last name",
        "address" => "Please enter a non empty address",
        "postcode" => "Please enter a non empty postcode",
        "city" => "Please enter a non empty city",
        "country" => "Please select a non empty username",
        "currentPassword" => "Please enter your current password",
        "password1" => "Please enter a new password",
        "password2" => "Please enter the same new password again"
    ];
    const INCORRECT_PASSWORD_MESSAGES = [
        "Password needs to be at least 10 characters long!",
        "Does not match with the other password field!",
        "Please enter your correct current password!"
    ];


    // Prevent people from instantiating this static class
    private function __construct() {}


    // Check for empty inputs
    public static function hasEmtpyFields( $fields )
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
                $emptyFields[ $key ] = ValidationOperator::EMPTY_FIELDS_MESSAGES[ $key ];
            }
        }

        // Registration is incomplete since we found empty field(s)
        if ( !empty( $emptyFields ) )
        {
            // Create a session for the missing input fields
            SessionOperator::setInputErrors( $emptyFields );
            return true;
        }

        // No error
        return false;
    }


    // Check if both username and email is not already used by another account
    public static function isTaken( $username, $email = null )
    {
        require_once "../classes/class.query_operator.php";
        $nonUniqueFields = [];

        // Check if username is already taken
        if ( !QueryOperator::isUnique( "username", $username ) )
        {
            $nonUniqueFields[ "username" ] = $username . " already exists";
        }
        // Check if email is already taken
        if ( !is_null( $email ) && !QueryOperator::isUnique( "email", $email ) )
        {
            $nonUniqueFields[ "email" ] = $email . " already exists";
        }

        // Inputted username or email were already taken
        if ( !empty( $nonUniqueFields ) )
        {
            // Create a session for the taken input fields
            SessionOperator::setInputErrors( $nonUniqueFields );
            return true;
        }

        // No error
        return false;
    }


    // Check for new username
    public static function getChangedFields( $updated_user )
    {
        $changedFields = [];
        $user = SessionOperator::getUser();

        foreach ( $updated_user as $key => $value )
        {
            if ( strcmp( $key, "country" ) == 0 )
            {
                $key = $key . "Id";
            }
            $previous_value = call_user_func( array( $user, "get" . ucfirst( $key ) ) );
            if ( strcmp( $previous_value, $value ) != 0 )
            {
                $changedFields[ $key ] = $previous_value;
            }
        }

        return $changedFields;
    }


    // Check inputted "current" password
    public static function isCurrentPassword( $currentPassword )
    {
        $userId = SessionOperator::getUser() -> getUserId();

        // Password matches
        if ( QueryOperator::checkPassword( $userId , $currentPassword ) )
        {
            return true;
        }

        // Password does not match
        SessionOperator::setInputErrors( [ "currentPassword" => ValidationOperator::INCORRECT_PASSWORD_MESSAGES[ 2 ] ] );
        return false;
    }


    // Check inputted passwords
    public static function validPasswords( $password1, $password2 )
    {
        $info = null;

        // Check if passwords have a minimum length
        if ( strlen( $password1 ) < 10 )
        {
            $info = ValidationOperator::INCORRECT_PASSWORD_MESSAGES[ 0 ];
        }
        // Check if the two inputted passwords mismatch
        else if ( strcmp( $password1, $password2 ) != 0 )
        {
            $info = ValidationOperator::INCORRECT_PASSWORD_MESSAGES[ 1 ];
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