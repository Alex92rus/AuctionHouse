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

set_time_limit(300);

$csvFile = $_SERVER['DOCUMENT_ROOT'] ."/scripts/db_seed/items.csv";
$itemData = parse_csv_file($csvFile);
//var_dump($itemData);

//return;

$faker = Faker\Factory::create();



seedUsersItemsAndAuctions();


//now get the userIds and auctions for next steps
$userIds = DbUser::listIds();
$auctions = DbAuction::withConditions()->getAsClasses();

seedAuctionBids();

editAuctionsAsSold();

//seedAuctionViews();

seedAuctionWatches();

seedFeedbacks();




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


function seedUsersItemsAndAuctions(){
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


function seedFeedbacks(){
    include_once ($_SERVER['DOCUMENT_ROOT'] ."/scripts/db_seed/seed_feedbacks.php");
}

function editAuctionsAsSold(){
    global $auctions;

    $now = new DateTime();

    foreach ($auctions as $auction){
        $endTime = new DateTime($auction->getField("endTime"));
        $numBids =$auction->getField("numBids");
        $highestBid = $auction->getField("highestBid");
        if ($now > $endTime){
            if( $numBids
                && $numBids > 0
                && $highestBid > $auction->getField("reservePrice")){

                    $auction->setField("sold", 1);
                    $auction->save();
            }
        }
    }

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

