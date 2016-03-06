<?php
require_once "class.session_operator.php";
require_once "class.bid.php";


class ValidationOperator
{
    const NO_MATCH = "no_match";
    const WRONG_FORMAT = "wrong_format";
    const INVALID_SIZE = "invalid_size";
    const INVALID_PRICES = "invalid_prices";
    const INVALID_BID = "invalid_bid";
    const INCORRECT_PASSWORD = "incorrect_password";
    const NO_IMAGE = "no_image";

    const EMPTY_FIELDS = [
        "username" => "Please enter a non empty username",
        "email" => "Please enter a non empty email address",
        "firstName" => "Please enter a non empty first name",
        "lastName" => "Please enter a non empty last name",
        "address" => "Please enter a non empty address",
        "postcode" => "Please enter a non empty postcode",
        "city" => "Please enter a non empty city",
        "country" => "Please select a country",
        "currentPassword" => "Please enter your current password",
        "password1" => "Please enter a new password",
        "password2" => "Please enter the same new password again",

        "item" => "Please specify whether you want to create a new item or use one of your existing ones",
        "itemName" => "Please enter a non empty item name",
        "itemBrand" => "Please enter a non empty item brand",
        "itemCategory" => "Please select your item's category",
        "itemCondition" => "Please specify your item's condition",
        "itemDescription" => "Please describe your item and its features",
        "quantity" => "Please specify the amount of items you want to sell",
        "startTime" => "Please specify your auction's start time",
        "endTime" => "Please specify your auction's end time",
        "startPrice" => "Please specify your auction's start price"
    ];
    const PASSWORD = [
        self::INVALID_SIZE => "Password needs to be at least 10 characters long!",
        self::NO_MATCH => "Does not match with the other password field!",
        self::INCORRECT_PASSWORD => "Please enter your correct current password!"
    ];
    const IMAGE_UPLOAD = [
        self::NO_IMAGE => "Please select an image file",
        self::WRONG_FORMAT => "Please choose a JPEG, JPG or PNG file",
        self::INVALID_SIZE => "The image size must be less than 500KB"
    ];
    const PRICES = [
        self::WRONG_FORMAT => " must be a decimal number",
        self::INVALID_SIZE => " must be greater than 0",
        self::INVALID_PRICES => "The start price must be less than the reserve price",
        self::INVALID_BID => "Your bid price must be greater or equal to "
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
            if ( empty( $value ) &&  $key != "reservePrice" )
            {
                $emptyFields[ $key ] = self::EMPTY_FIELDS[ $key ];
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
        SessionOperator::setInputErrors( [ "currentPassword" => self::PASSWORD[ self::INCORRECT_PASSWORD ] ] );
        return false;
    }


    // Check inputted passwords
    public static function validPasswords( $password1, $password2 )
    {
        $info = null;

        // Check if passwords have a minimum length
        if ( strlen( $password1 ) < 10 )
        {
            $info = self::PASSWORD[ self::INVALID_SIZE ];
        }
        // Check if the two inputted passwords mismatch
        else if ( strcmp( $password1, $password2 ) != 0 )
        {
            $info = self::PASSWORD[ self::NO_MATCH ];
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


    // Check image file
    public static function checkImage()
    {
        $image = null;
        $image_name = null;
        $image_extension = null;
        $error = [];

        // No file selected
        if ( $_FILES[ "image" ][ "error" ] != UPLOAD_ERR_OK )
        {
            $error[ "upload" ] = self::IMAGE_UPLOAD[ self::NO_IMAGE ];
        }
        else
        {
            $image = ( $_FILES[ "image" ][ "tmp_name" ] );
            $image_name = $_FILES[ "image" ][ "name" ];
            $image_extension = strtolower( pathinfo( addslashes( $image_name ), PATHINFO_EXTENSION ) );
            $image_dimensions = getimagesize( $image );
            $image_size = $_FILES[ "image" ][ "size" ];
            $extensions = array( "jpeg", "jpg", "png" );

            // File is not an image
            if ( empty( $error ) && $image_dimensions == False )
            {
                $error[ "upload" ] = self::IMAGE_UPLOAD[ self::NO_IMAGE ];
            }

            // Image has wrong extension
            if ( empty( $error ) &&  in_array( $image_extension, $extensions ) === false )
            {
                $error[ "upload" ] = self::IMAGE_UPLOAD[ self::WRONG_FORMAT ];
            }

            // Image size is too large
            if ( $image_size > 512000 )
            {
                $error[ "upload" ] = self::IMAGE_UPLOAD[ self::INVALID_SIZE ];
            }
        }

        // Display errors
        if ( !empty( $error ) )
        {
            SessionOperator::setInputErrors( $error );
            return null;
        }

        // No errors
        return [ "image" => $image, "imageExtension" => $image_extension ];
    }


    // Check inputted prices
    public static function checkPrizes( $startPrice, $reservePrice )
    {
        $isStartNumber = self::isPositiveNumber( $startPrice, "startPrice" );

        // Reserve price specified
        if ( !empty( $reservePrice ) )
        {
            if ( $isStartNumber && self::isPositiveNumber( $reservePrice, "reservePrice" ) )
            {
                // Valid prices
                if ( $startPrice < $reservePrice )
                {
                    return true;
                }
                // Invalid prices
                else
                {
                    $error = [ "startPrice" => self::PRICES[ self::INVALID_PRICES ] ];
                    SessionOperator::setInputErrors( $error );
                }
            }
        }
        // No reserve price specified
        else
        {
            // Valid start price
            if ( $isStartNumber )
            {
                return true;
            }
        }

        // Error
        return false;
    }


    // Check inputted bid price
    public static function checkBidPrice( $input, $auctionId )
    {
        $currentHighestBid = QueryOperator::getAuctionBids( $auctionId )[ 0 ] -> getBidPrice();

        // Invalid bid price
        if ( $input < $currentHighestBid )
        {
            SessionOperator::setInputErrors( [ "bidPrice" => self::PRICES[ self::INVALID_BID ] . $currentHighestBid ] );
            return false;
        }

        // No error
        return true;
    }


    // Check input is number
    public static function isPositiveNumber( $fieldValue, $fieldName )
    {
        $error = [];

        // Is a number
        if ( is_numeric( $fieldValue ) )
        {
            // Is positive
            if ( $fieldValue > 0 )
            {
                return true;
            }
            // Not a number
            else
            {
                $error[ $fieldName ] = $fieldName . self::PRICES[ self::INVALID_SIZE ];
            }
        }
        // Not decimal
        else
        {
            $error[ $fieldName ] = $fieldName . self::PRICES[ self::WRONG_FORMAT ];
        }

        // Error
        SessionOperator::setInputErrors( $error );
        return false;
    }
}