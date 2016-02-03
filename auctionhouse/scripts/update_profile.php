<?php
require_once "helperfunctions.php";
require_once "../classes/class.validation_operator.php";
require_once "../classes/class.query_operator.php";


// Only process when save button was clicked
if ( !isset( $_POST[ "save" ] ) )
{
    redirectTo( "../home.php" );
}

// Store POST values
$update = [
    "username"  => addslashes( $_POST[ "username" ] ),
    "firstName" => addslashes( $_POST[ "firstName" ] ),
    "lastName"  => addslashes( $_POST[ "lastName" ] ),
    "address"   => addslashes( $_POST[ "address" ] ),
    "postcode"  => addslashes( $_POST[ "postcode" ] ),
    "city"      => addslashes( $_POST[ "city" ] ),
    "country"   => addslashes( $_POST[ "country" ] ) ];

// Add empty string for default country
if ( $update[ "country" ] == "Country" )
{
    $update[ "country" ]  = "";
}
// A country was selected - hence get its id
else
{
    $update[ "country" ] = QueryOperator::getCountryId( $update[ "country" ] );
}

// Get changed input fields (if available)
$changedFields = ValidationOperator::getChangedFields( $update );

// Check inputs
if ( !empty( $changedFields ) &&
     !ValidationOperator::hasEmtpyFields( $update, ValidationOperator::EMPTY_FIELD_UPDATE ) &&
    ( !isset( $changedFields[ "username" ] ) || !ValidationOperator::isTaken( $update[ "username" ] ) ) )
{
    // Update user information
    $user = SessionOperator::getUser();
    QueryOperator::updateAccount( $user -> getUserId(), $update );

    // Update user session
    $user = QueryOperator::getAccount( $user -> getUserId() );
    SessionOperator::updateUser( new User( $user ) );

    // Set feedback session
    SessionOperator::setFeedback( SessionOperator::UPDATED_PROFILE_INFO );
}

// Redirect back
redirectTo( "../profile.php" );