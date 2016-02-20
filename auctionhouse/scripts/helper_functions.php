<?php


// Redirect to a page
function redirectTo( $page )
{
    header( "Location: " . $page );
    exit();
}


// Add active class if necessary
function isActive()
{
    $current_file_name = basename( $_SERVER[ "REQUEST_URI" ], ".php" );

    if ( $current_file_name == "create_auction_view" )
    {
        echo 'class="active"';
    }
}


function ref_values($arr)
{
    $refs = array();

    foreach ($arr as $key => $value)
    {
        $refs[$key] = &$arr[$key];
    }

    return $refs;
}