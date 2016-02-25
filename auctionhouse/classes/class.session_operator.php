<?php
require_once "class.user.php";
require_once "class.live_auction.php";
session_start();


class SessionOperator
{
    const FORM_INPUTS = "form_inputs";
    const INPUT_ERRORS = "input_errors";
    const USER = "user";
    const EMAIL = "email";

    const LIVE_AUCTIONS = "live_auctions";
    const SEARCH_RESULT = "search_result";
    const SEARCH_STRING = "search_string";
    const SEARCH_CATEGORY = "search_category";
    const SORT = "sort";

    const FEEDBACK = "feedback";
    const TITLE = "title";
    const INFO = "info";
    const TYPE = "type";

    const SUBMITTED_REGISTRATION = "submitted_registration";
    const COMPLETED_REGISTRATION = "completed_registration";
    const RESET_PASSWORD = "reset_password";
    const CHANGED_PASSWORD = "changed_password";
    const UPDATED_PROFILE_INFO = "updated_profile_info";
    const UPLOADED_PROFILE_PHOTO = "uploaded_profile_photo";
    const DELETED_PROFILE_PHOTO = "deleted_profile_photo";

    const SUCCESS = "success";
    const WARNING = "warning";
    const DANGER = "danger";


    // Prevent people from instantiating this static class
    private function __construct() {}


    // Create a session for the just submitted but failed form
    public static function setFormInput( $form )
    {
        $_SESSION[ self::FORM_INPUTS ] = $form;
    }


    // Recover field input after each failed form submission
    public static function getFormInput( $key )
    {
        $input = "";

        if ( isset( $_SESSION[ self::FORM_INPUTS ] ) && array_key_exists( $key, $_SESSION[ self::FORM_INPUTS ] ) )
        {
            $input = htmlentities( $_SESSION[ self::FORM_INPUTS ][ $key ] );
            unset( $_SESSION[ self::FORM_INPUTS ][ $key ] );

            // Delete the session after all field inputs were recovered
            if ( empty( $_SESSION[ self::FORM_INPUTS ] ) )
            {
                unset( $_SESSION[ self::FORM_INPUTS ] );
            }
        }

        return $input;
    }


    // Create a session for the incorrect form fields
    public static function setInputErrors( $incorrectFields )
    {
        $_SESSION[ self::INPUT_ERRORS ] = $incorrectFields;
    }


    // Get error message for incorrect field input
    public static function getInputErrors( $key )
    {
        $message = "";

        // There was an input error within a specific field
        if ( isset( $_SESSION[ self::INPUT_ERRORS ] ) && array_key_exists( $key, $_SESSION[ self::INPUT_ERRORS ] ) )
        {
            // Get the error message for the input field
            $message = $_SESSION[ self::INPUT_ERRORS ][ $key ];

            // Remove the input field from the input errors array
            unset( $_SESSION[ self::INPUT_ERRORS ][ $key ] );

            // Delete the input error session after all error messages were outputted to the screen
            if ( empty( $_SESSION[ self::INPUT_ERRORS ] ) )
            {
                unset( $_SESSION[ self::INPUT_ERRORS ] );
            }
        }

        return $message;
    }


    // Get all error messages
    public static function getAllErrors()
    {
        $errors = null;

        // There are errors
        if ( isset( $_SESSION[ self::INPUT_ERRORS ] ) )
        {
            $errors = $_SESSION[ self::INPUT_ERRORS ];
            unset( $_SESSION[ self::INPUT_ERRORS ] );

        }

        return $errors;
    }


    // Create a feedback session
    public static function setFeedback( $status )
    {
        switch ( $status )
        {
            case self::SUBMITTED_REGISTRATION:
                $title = "Registration submitted!";
                $info  = "Before accessing your account, you have to follow the verification ";
                $info .= "link we sent you to your email address.";
                $type = self::SUCCESS;
                break;
            case self::COMPLETED_REGISTRATION:
                $title = "Registration completed!";
                $info  = "Thank you for joining us. Your account is now ready for signing in.";
                $type = self::SUCCESS;
                break;
            case self::RESET_PASSWORD:
                $title = "Password reset!";
                $info  = "We sent you a link to change your password.";
                $type = self::SUCCESS;
                break;
            case self::CHANGED_PASSWORD:
                $title = "Password changed!";
                $info  = "User your new password to login next time.";
                $type = self::SUCCESS;
                break;
            case self::UPDATED_PROFILE_INFO:
                $title = "Profile updated!";
                $info  = "Your new profile information was saved.";
                $type = self::SUCCESS;
                break;
            case self::UPLOADED_PROFILE_PHOTO:
                $title = "Profile photo uploaded!";
                $info  = "Your have a new profile image.";
                $type = self::SUCCESS;
                break;
            case self::DELETED_PROFILE_PHOTO:
                $title = "Profile photo deleted!";
                $info  = "You have currently no profile image.";
                $type = self::DANGER;
                break;
            default:
                $title = $info = $type = null;
                break;
        }

        $_SESSION[ self::FEEDBACK ] = [ self::TITLE => $title, self::INFO => $info, self::TYPE => $type ];
    }


    // Check if a feedback has to be displayed
    public static function getFeedback()
    {
        if ( isset( $_SESSION[ self::FEEDBACK ] ) )
        {
            // Retrieve status
            $status = $_SESSION[ self::FEEDBACK ];
            $title = "<strong>" . $status[ self::TITLE ] . "</strong>";
            $info = $status[ self::INFO ];
            $type = $status[ self::TYPE ];

            // Delete session
            unset( $_SESSION[ self::FEEDBACK ] );

            return array( $title, $info, $type );
        }

        return null;
    }


    // Login user
    public static function login( $user )
    {
        // User profile session
        $_SESSION[ self::USER ] = $user;

        // Search related sessions
        $_SESSION[ self::SEARCH_STRING ] = "";
        $_SESSION[ self::SEARCH_CATEGORY ] = "All";
        $_SESSION[ self::SORT ] = "Best Match";
    }


    // Logout user
    public static function logout()
    {
        // Free all session variables
        session_unset();
    }


    // Check if a user has already logged in
    public static function isLoggedIn()
    {
        if ( isset( $_SESSION[ self::USER ] ) )
        {
            return true;
        }

        return false;
    }


    // Get current user session
    public static function getUser()
    {
        if ( isset( $_SESSION[ self::USER ] ) )
        {
            return $_SESSION[ self::USER ];
        }

        return null;
    }


    // Update current user session
    public static function updateUser( $user )
    {
        $_SESSION[ self::USER  ] = $user;
    }


    // Create email session for changing passwords page
    public static function setEmail( $email )
    {
        $_SESSION[ self::EMAIL ] = $email;
    }


    // Get email session
    public static function getEmail()
    {
        return $_SESSION[ self::EMAIL ];
    }


    // Delete email session
    public static function deleteEmail()
    {
        unset( $_SESSION[ self::EMAIL ] );
    }


    // Set search setting sessions
    public static function setSearch( $settings )
    {
        foreach ( $settings as $const => $value )
        {
            $_SESSION[ $const ] = $value;
        }
    }


    // Get a search setting session
    public static function getSearchSetting( $const )
    {
        // Search setting session set
        if( isset( $_SESSION[ $const ] ) )
        {
            return $_SESSION[ $const ];
        }

        // No session set
        return null;
    }


    // Set a live auction session for a auction search result
    public static function setLiveAuction( $auctionId, $liveAuction )
    {
        if ( isset( $_SESSION[ self::LIVE_AUCTIONS ] ) )
        {
            $liveAuctions = $_SESSION[ self::LIVE_AUCTIONS ];
            $liveAuctions[ $auctionId ] = $liveAuction;
            $_SESSION[ self::LIVE_AUCTIONS ] = $liveAuctions;
        }
        else
        {
            $_SESSION[ self::LIVE_AUCTIONS ] = [ $auctionId => $liveAuction ];
        }
    }


    // Get all live auctions from a search
    public static function getLiveAuction( $auctionId )
    {
        if ( isset( $_SESSION[ self::LIVE_AUCTIONS ] ) )
        {
            return $_SESSION[ self::LIVE_AUCTIONS ][ $auctionId ];
        }

        return null;
    }
}