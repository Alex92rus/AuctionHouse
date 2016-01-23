<?php
session_start();


// Ignore manual calls to 'confirmation.php'
if ( isset( $_GET[ "email" ] ) && isset( $_GET[ "confirm_code" ] ) )
{
    // Retrieve email and confirmation code from link
    $email = $_GET[ "email" ];
    $confirm_code = $_GET[ "confirm_code" ];

    // Check if email and confirmation code originate from an unverified user account
    require_once "class.queryfactory.php";
    $result = QueryFactory::checkVerificationLink( $email, $confirm_code );

    // Verification link is correct
    if ( !empty( $result ) )
    {
        // Active user account
        QueryFactory::activiateAccont( $email );

        // Create a session for the fully completed registration
        $title = "Registration completed!";
        $info  = "Thank you for joining us. Your account is now ready for signing in.";
        $_SESSION[ "registration_status" ] = [ "title" => $title, "info" => $info ];

        // Email a registration confirmation to the user
        require_once "class.email.php";
        $mail = new Email( $email, $result[ "firstName" ], $result[ "lastName" ] );
        $mail -> prepareConfirmationEmail();
        $mail -> sentEmail();
    }
}

// Redirect to homepage
header( "Location: index.php" );
exit();

