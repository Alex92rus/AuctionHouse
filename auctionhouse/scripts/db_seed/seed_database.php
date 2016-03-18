<?php

require_once ($_SERVER['DOCUMENT_ROOT'] ."/faker/src/autoload.php");
require_once ($_SERVER['DOCUMENT_ROOT'] ."/classes/class.db_user.php");
require_once ($_SERVER['DOCUMENT_ROOT'] ."/classes/class.db_item.php");
require_once ($_SERVER['DOCUMENT_ROOT'] ."/classes/class.db_auction.php");
require_once ($_SERVER['DOCUMENT_ROOT'] ."/classes/class.db_country.php");
require_once ($_SERVER['DOCUMENT_ROOT'] ."/classes/class.db_auction_view.php");
require_once ($_SERVER['DOCUMENT_ROOT'] ."/classes/class.db_bid.php");
require_once ($_SERVER['DOCUMENT_ROOT'] ."/classes/class.db_auction_watch.php");
require_once ($_SERVER['DOCUMENT_ROOT'] ."/classes/class.db_feedback.php");
include     ($_SERVER['DOCUMENT_ROOT'] ."/config/env_variables.php");

set_time_limit(300);

$csvFile = $_SERVER['DOCUMENT_ROOT'] ."/scripts/db_seed/items.csv";
$itemData = parse_csv_file($csvFile);
//var_dump($itemData);

/*$a = DbAuction::find(195);
$a->setField("numBids", 100);

/*return;*/

$faker = Faker\Factory::create();

$reportFrequencies = $_env_reportFrequencies;





seedUsersItemsAndAuctions(1000, 20, 5);


//now get the userIds and auctions for next steps
$userIds = DbUser::listIds();
$auctions = DbAuction::withConditions()->getAsClasses();

seedAuctionBids();





//seedAuctionViews();

seedAuctionWatches();

$soldAuctions = getSoldAuctions($auctions);
seedFeedbacks($soldAuctions);




function parse_csv_file($csvfile) {
    $csv = Array();
    $rowcount = 0;
    if (($handle = fopen($csvfile, "r")) !== FALSE) {
        $max_line_length = defined('MAX_LINE_LENGTH') ? MAX_LINE_LENGTH : 10000;
        $header = fgetcsv($handle, $max_line_length);
        $header_colcount = count($header);
        while (($row = fgetcsv($handle, $max_line_length)) !== FALSE) {
            $row_colcount = count($row);
            if ($row_colcount == $header_colcount) {
                $entry = array_combine($header, $row);
                $csv[] = $entry;
            }
            else {
                error_log("csvreader: Invalid number of columns at line " . ($rowcount + 2) . " (row " . ($rowcount + 1) . "). Expected=$header_colcount Got=$row_colcount");
                return null;
            }
            $rowcount++;
        }
        //echo "Totally $rowcount rows found\n";
        fclose($handle);
    }
    else {
        error_log("csvreader: Could not read CSV \"$csvfile\"");
        return null;
    }
    return $csv;
}


function seedUsersItemsAndAuctions($numUsers =500, $maxItemsPerUser = 20, $maxAuctionsPerItem =5){
    include_once($_SERVER['DOCUMENT_ROOT'] . "/scripts/db_seed/seed_users_items_and_auctions.php");
}


function seedAuctionBids(){

    include_once ($_SERVER['DOCUMENT_ROOT'] ."/scripts/db_seed/seed_auction_bids.php");
}

function seedAuctionViews(){
    include_once ($_SERVER['DOCUMENT_ROOT'] ."/scripts/db_seed/seed_auction_views.php");
}

function seedAuctionWatches(){
    include_once ($_SERVER['DOCUMENT_ROOT'] ."/scripts/db_seed/seed_auction_watches.php");
}


function seedFeedbacks($soldAuctions){
    include_once ($_SERVER['DOCUMENT_ROOT'] ."/scripts/db_seed/seed_feedbacks.php");
}

function getSoldAuctions($auctions){

    $soldAuctions = array();
    $now = new DateTime();

    foreach ($auctions as $auction){
        $endTime = new DateTime($auction->getField("endTime"));
        $numBids =$auction->getField("numBids");
        $highestBid = $auction->getField("highestBid");
        if ($now > $endTime){

            if( $numBids > 0
                && $highestBid > $auction->getField("reservePrice")){

                $soldAuctions[] = $auction;
            }
        }
    }
    return $soldAuctions;

}


/**
 * @param $auction DbAuction
 * @param $userIds array
 * @return mixed
 */

function listUserIdsWithoutAuctionOwner($auction, $userIds){

    $item = DbItem::find($auction->getField("itemId"));
    $ownerId = DbUser::find($item->getField("userId"))->getId();

    $key = array_search($ownerId, $userIds);
    unset($userIds[$key]);
    return$userIds;
}


