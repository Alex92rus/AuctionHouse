<?php
session_start();


// Ignore manual calls to 'confirmation.php'
if ( isset( $_GET[ "email" ] ) && isset( $_GET[ "confirmation_code" ] ) )
{
    // Retrieve email and confirmation code from link
    $email = $_GET[ "email" ];
    $code = $_GET[ "confirmation_code" ];

    // Create database object
    require_once "class.database.php";
    $database = new Database();

    // SQL query for retrieving users for the given email and confirmation code
    $confirmationQuery = "SELECT firstName, lastName, confirmId, verified FROM users WHERE email = '$email' AND confirmId = " . $code;

    // Query database
    $result = $database -> selectQuery( $confirmationQuery );

    // Fetch row from result table (there could be none)
    $row = $result -> fetch_assoc();

    // Query returned a row with an unverified user
    if ( $result -> num_rows == 1 && $row[ "confirmId" ] != null && $row[ "verified" ] == 0 )
    {
        // SQL query for verify user's account
        $verifyUserQuery = "UPDATE users SET verified = 1, confirmId = NULL WHERE email = '$email' AND confirmId = '$code'";

        // Query database
        $database -> updateQuery( $verifyUserQuery );

        // Create a session for the fully completed registration
        $title = "Registration completed!";
        $info  = "Thank you for joining us. Your account is now ready for signing in.";
        $_SESSION[ "registration_status" ] = [ "title" => $title, "info" => $info ];

        // Email a registration confirmation to the user
        require_once "class.email.php";
        $mail = new Email( $email, $row[ 'firstName' ], $row[ 'lastName' ] );
        $mail -> prepareConfirmationEmail();
        $mail -> sentEmail();
    }

    // Close database connection
    $database -> closeConnection();
}

// Redirect to homepage
header( "Location: index.php" );
exit();

