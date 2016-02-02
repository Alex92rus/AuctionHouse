<?php
require_once "helperfunctions.php";
require_once "../classes/class.session_operator.php";


/*if( isset( $_POST[ "upload" ] ) )
{
    $file = $_FILES[ "profileImage" ][ "tmp_name" ];

    if( !isset( $_FILES[ "profileImage" ][ "tmp_name" ] ) )
    {
        echo "hello";
        SessionOperator::setInputErrors( [ "upload" => "Please select a file" ] );
    }
    else
    {

    }
}*/




redirectTo( "../profile.php" );