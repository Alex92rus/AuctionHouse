<?php
require_once "../classes/class.helper_operator.php";
require_once "../classes/class.validation_operator.php";
require_once "../classes/class.query_operator.php";


// Only process when form button was clicked
if ( !isset( $_POST[ "save" ] ) && !isset( $_POST[ "upload" ] ) )
{
    HelperOperator::redirectTo( "../views/profile_view.php" );
}
// Update profile
else if ( isset( $_POST[ "save" ] ) )
{
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
         !ValidationOperator::hasEmtpyFields( $update ) &&
        ( !isset( $changedFields[ "username" ] ) || !ValidationOperator::isTaken( $update[ "username" ] ) ) )
    {
        // Update user information
        $user = SessionOperator::getUser();
        QueryOperator::updateAccount( $user -> getUserId(), $update );

        // Update user session
        $user = QueryOperator::getAccount( $user -> getUserId() );
        SessionOperator::updateUser( new User( $user ) );

        // Set feedback session
        SessionOperator::setNotification( SessionOperator::UPDATED_PROFILE_INFO );
    }
}
// Upload profile image
else
{
    $error = [];

    if ( ( $upload = ValidationOperator::checkImage() ) != null )
    {
        // A user is logged in
        if ( !is_null( $user = SessionOperator::getUser() ) )
        {
            // Create random image name
            $newImageName = UPLOAD_PROFILE_IMAGE . uniqid( "", true ) . "." . $upload[ "imageExtension" ];

            // Upload new profile picture to file system
            if ( move_uploaded_file( $upload[ "image" ], ROOT . $newImageName ) )
            {
                // Delete old profile pic (if exists)
                if ( !empty( $imageName = $user -> getImage() ) )
                {
                    unlink( ROOT . $imageName );
                }

                // Store image name in database
                QueryOperator::uploadImage( $user -> getUserId(), $newImageName, "users" );

                // Update user session
                $user = QueryOperator::getAccount( $user -> getUserId() );
                SessionOperator::updateUser( new User( $user ) );

                // Set feedback session
                SessionOperator::setNotification( SessionOperator::UPLOADED_PROFILE_PHOTO );
            }
            // Error - image cannot be uploaded
            else
            {
                $error[ "upload" ] = "Image cannot be uploaded ";
                SessionOperator::setInputErrors( $error );
            }
        }
    }
}


// Redirect back
HelperOperator::redirectTo( "../views/profile_view.php" );