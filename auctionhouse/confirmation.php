<?php
require_once "helperfunctions.php";
require_once "class.session_handler.php";


// Ignore manual calls to 'confirmation.php'
if ( isset( $_GET[ "email" ] ) && isset( $_GET[ "confirm_code" ] ) )
{
    // Retrieve email and confirmation code from link
    $email = $_GET[ "email" ];
    $confirm_code = $_GET[ "confirm_code" ];

    // Check if email and confirmation code originate from an unverified user account
    require_once "class.query_handler.php";
    $result = QueryFactory::checkVerificationLink( $email, $confirm_code );

    // Verification link is correct
    if ( !empty( $result ) )
    {
        // Active user account
        QueryFactory::activateAccount( $result[ "userId" ] );

        // Create a session for completed registration
        SessionFactory::setRegistrationStatus( 'completed' );

        // Email a registration confirmation to the user
        require_once "class.email.php";
        $mail = new Email( $email, $result[ "firstName" ], $result[ "lastName" ] );
        $mail -> prepareConfirmationEmail();
        $mail -> sentEmail();
    }
}

// Redirect to homepage
redirectTo( "index.php" );

