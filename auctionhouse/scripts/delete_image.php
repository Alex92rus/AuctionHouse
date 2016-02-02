<?php
require_once "../scripts/helperfunctions.php";
require_once "../config/config.php";
require_once "../classes/class.query_operator.php";
require_once "../classes/class.session_operator.php";


// Delete profile image from file system and image name from database
$user = SessionOperator::getUser();
unlink( UPLOAD_PROFILE_PATH . $user -> getImageName() );
QueryOperator::uploadImage( $user -> getUserId(), null, USERS_TABLE );

// Delete profile image
$user -> setImageName( null );
SessionOperator::updateUser( $user );

redirectTo(  "../profile.php" );