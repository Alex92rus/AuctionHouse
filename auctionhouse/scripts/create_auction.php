<?php
require_once "../classes/class.helper_operator.php";
require_once "../classes/class.session_operator.php";
require_once "../classes/class.validation_operator.php";
require_once "../classes/class.query_operator.php";


// Only process when start auction button was clicked
if ( !isset( $_POST[ "startAuction" ] ) )
{
    HelperOperator::redirectTo( "../views/create_auction_view.php" );
}


// Store POST values
$new_auction = [
    "item"            => $_POST[ "item" ],
    "itemName"        => $_POST[ "itemName" ],
    "itemBrand"       => $_POST[ "itemBrand" ],
    "itemCategory"    => $_POST[ "itemCategory" ],
    "itemCondition"   => $_POST[ "itemCondition" ],
    "itemDescription" => $_POST[ "itemDescription" ],
    "quantity"        => $_POST[ "quantity" ],
    "startPrice"      => $_POST[ "startPrice" ],
    "reservePrice"    => $_POST[ "reservePrice" ],
    "startTime"       => $_POST[ "startTime" ],
    "endTime"         => $_POST[ "endTime" ],
    "reportFrequency" => $_POST[ "reportFrequency"]
];


// Add empty string for default selects
if ( $new_auction[ "itemCategory" ] == "Select" )
{
    $new_auction[ "itemCategory" ]  = "";
}
if ( $new_auction[ "itemCondition" ] == "Select" )
{
    $new_auction[ "itemCondition" ]  = "";
}
if ( $new_auction[ "reportFrequency" ] == null )
{
    $new_auction[ "reportFrequency" ]  = 24;
}



// Check inputs
if ( ValidationOperator::hasEmtpyFields( $new_auction ) ||
     ( $upload = ValidationOperator::checkImage() ) == null ||
     !ValidationOperator::checkPrizes( $new_auction[ "startPrice" ], $new_auction[ "reservePrice" ] ) )
{
    // Create a session for all inputs so that they can be recovered after the page returns
    SessionOperator::setFormInput( $new_auction );

    // Redirect back
    HelperOperator::redirectTo( "../views/create_auction_view.php" );
}
// Form valid - store auction
else
{
    // Create random image name
    $newImageName = UPLOAD_ITEM_IMAGE . uniqid( "", true ) . "." . $upload[ "imageExtension" ];

    // Cannot upload image to file system, otherwise, image uploaded
    if ( !move_uploaded_file( $upload[ "image" ], ROOT . $newImageName ) )
    {
        $error[ "upload" ] = "Image cannot be uploaded ";
        SessionOperator::setInputErrors( $error );
        HelperOperator::redirectTo( "../views/create_auction_view.php" );
    }

    // Get item category and condition id
    $ids = QueryOperator::getItemRelatedIds( $new_auction[ "itemCategory" ], $new_auction[ "itemCondition" ] );

    // Prepare item parameters
    $item[] = SessionOperator::getUser() -> getUserId();
    $item[] = $new_auction[ "itemName" ];
    $item[] = $new_auction[ "itemBrand" ];
    $item[] = $ids[ "categoryId" ];
    $item[] = $ids[ "conditionId" ];
    $item[] = $new_auction[ "itemDescription" ];
    $item[] = $newImageName;

    // Prepare auction parameters
    $auction[] = "";
    $auction[] = $new_auction[ "quantity" ];
    $auction[] = $new_auction[ "startPrice" ];
    $auction[] = $new_auction[ "reservePrice" ];
    $auction[] = date_create($new_auction[ "startTime" ]) -> format('Y-m-d H:i');
    $auction[] = date_create($new_auction[ "endTime" ]) -> format('Y-m-d H:i');
    $auction[] = $new_auction["reportFrequency"];

    // Store auction in database
    $itemId = QueryOperator::addAuction( $item, $auction );

    // Store image name in database
    QueryOperator::uploadImage( $itemId, $newImageName, "items" );

    // Return to live auctions page
    HelperOperator::redirectTo( "../views/my_live_auctions_view.php" );
}



