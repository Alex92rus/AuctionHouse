<?php
require_once "helperfunctions.php";
require_once "../classes/class.session_operator.php";
require_once "../classes/class.query_operator.php";
require_once "../classes/class.user.php";


// Upload button was clicked
if ( isset( $_POST[ "upload" ] ) )
{
    $image;
    $image_name;
    $image_extension;
    $error = [];

    // No file selected
    if ( $_FILES[ "image" ][ "error" ] != UPLOAD_ERR_OK )
    {
        $error[ "upload" ] = "Please select a file";
    }
    else
    {
        $image = ( $_FILES[ "image" ][ "tmp_name" ] );
        $image_name = $_FILES[ "image" ][ "name" ];
        $image_extension = pathinfo( addslashes( $image_name ), PATHINFO_EXTENSION );
        $image_dimensions = getimagesize( $image );
        $image_size = $_FILES[ "image" ][ "size" ];
        $extensions = array( "jpeg", "jpg", "png" );

        // File is not an image
        if ( empty( $error ) && $image_dimensions == False )
        {
            $error[ "upload" ] = "Please select an image file";
        }

        // Image has wrong extension
        if ( empty( $error ) &&  in_array( $image_extension, $extensions ) === false )
        {
            $error[ "upload" ] = "Please choose a JPEG, JPG or PNG file";
        }

        // Image size is too large
        if ( $image_size > 512000 )
        {
            $error[ "upload" ] = "The image size must be less than 500KB";
        }
    }

    // Display errors
    if ( !empty( $error ) )
    {
        SessionOperator::setInputErrors( $error );
    }
    // No errors - upload image
    else
    {
        // A user is logged in
        if ( !is_null( $user = SessionOperator::getUser() ) )
        {
            // Create random image name
            $newImageName = uniqid( "", true ) . "." . $image_extension;

            // Upload new profile picture to file system
            if ( move_uploaded_file( $image, UPLOAD_PROFILE_PATH . $newImageName ) )
            {
                // Delete old profile pic (if exists)
                if ( !empty( $imageName = $user -> getImageName() ) )
                {
                    unlink( UPLOAD_PROFILE_PATH . $imageName );
                }

                // Store image name in database
                QueryOperator::uploadImage( $user -> getUserId(), $newImageName, USERS_TABLE );

                // Update user session
                $user -> setImageName( $newImageName );
                SessionOperator::updateUser( $user );
            }
            // Error - image cannot be uploaded
            else
            {
                $error[ "upload" ] = "Image cannot be uploaded ";
            }
        }
        // Error - no user logged in
        else
        {
            $error[ "upload" ] = "No user logged in. Cannot upload image.";
        }
    }
}


// Stay on profile page
redirectTo( "../profile.php" );