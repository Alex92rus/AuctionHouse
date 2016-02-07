<?php
require_once "helper_functions.php";
require_once "../classes/class.email.php";
require_once "../classes/class.query_operator.php";
require_once "../classes/class.validation_operator.php";
require_once "../classes/class.session_operator.php";


// Reset password (if user cannot remember)
if ( isset( $_POST[ "resetPassword" ] ) )
{
    // Check if email is associated with an account
    $userInfo = QueryOperator:: getAccountFromEmail($_POST["email"]);

    // Email belongs to an account - send password reset email to that user
    if ($userInfo != null) {
        $mail = new Email($_POST["email"], $userInfo["firstName"], $userInfo["lastName"]);
        $mail->prepareResetEmail();
        $mail->sentEmail();
        SessionOperator::setFeedback(SessionOperator::RESET_PASSWORD);
        redirectTo("../index.php");
    } else {
        // Create a session for not found email
        SessionOperator::setInputErrors(["email" => "Email could not be found in our records"]);
        // Create a session for the inputted email so that it can be recovered after the page reloads
        SessionOperator::setFormInput(["email" => $_POST["email"]]);
        redirectTo("../forgot_password.php");
    }
}
// Change password after password was reset
else if ( isset( $_POST[ "changePassword" ] ) )
{
    // Retrieve Passwords
    $passwordFields = [ "password1" => $_POST[ "password1" ], "password2" => $_POST[ "password2" ] ];
    $email = SessionOperator::getEmail();
    $userDetails = QueryOperator::getAccountFromEmail( $email );

    // Both passwords valid and match
    if ( !ValidationOperator::hasEmtpyFields( $passwordFields ) &&
        ValidationOperator::validPasswords( $passwordFields[ "password1" ], $passwordFields[ "password2" ] ) )
    {
        QueryOperator::updatePassword( $email, $passwordFields[ "password2" ] );
        SessionOperator::deleteEmail();
        SessionOperator::setFeedback( SessionOperator::CHANGED_PASSWORD );

        // Send a password changed confirmation email to the user
        $mail = new Email( $email, $userDetails[ "firstName" ], $userDetails[ "lastName" ] );
        $mail -> preparePasswordConfirmEmail();
        $mail -> sentEmail();

        redirectTo( "../index.php" );
    }
    // Invalid password inputs
    else
    {
        SessionOperator::setFormInput( $passwordFields );
    }

    redirectTo( "../change_password.php?email=" . $email );
}
// Change password from when signed in into account
else if ( isset( $_POST[ "changePasswordSignedIn" ] ) )
{
    // Retrieve Passwords
    $passwordFields = [
        "currentPassword" => $_POST[ "currentPassword" ],
        "password1"   => $_POST[ "password1" ],
        "password2"   => $_POST[ "password2" ]
    ];

    // Get current user session
    $user = SessionOperator::getUser();

    // Current password is correct and both new passwords are valid and match
    if ( !ValidationOperator::hasEmtpyFields( $passwordFields ) &&
        ValidationOperator::isCurrentPassword( $passwordFields[ "currentPassword" ] ) &&
        ValidationOperator::validPasswords( $passwordFields[ "password1" ], $passwordFields[ "password2" ] ) )
    {
        QueryOperator::updatePassword( $user -> getEmail(), $passwordFields[ "password2" ] );
        SessionOperator::setFeedback( SessionOperator::CHANGED_PASSWORD );

        // Send a password changed confirmation email to the user
        $mail = new Email( $user -> getEmail(), $user -> getFirstName(), $user -> getLastName() );
        $mail -> preparePasswordConfirmEmail();
        $mail -> sentEmail();
    }
    // Invalid inputs
    else
    {
        SessionOperator::setFormInput( $passwordFields );
    }

    redirectTo( "../account.php" );
}

