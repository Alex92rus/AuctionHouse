<?php
require_once "../scripts/helper_functions.php";
require_once "../config/config.php";
require_once "../classes/class.query_operator.php";
require_once "../classes/class.session_operator.php";


// Delete profile image from file system and image name from database
$user = SessionOperator::getUser();
unlink( UPLOAD_PROFILE_PATH . $user -> getImage() );
QueryOperator::uploadImage( $user -> getUserId(), null, "users" );

// Update user session
$user = QueryOperator::getAccount( SessionOperator::getUser() -> getUserId() );
SessionOperator::updateUser( new User( $user ) );

// Set feedback session
SessionOperator::setFeedback( SessionOperator::DELETED_PROFILE_PHOTO );

redirectTo(  "../profile.php" );