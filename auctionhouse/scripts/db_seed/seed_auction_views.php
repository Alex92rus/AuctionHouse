<?php




global $auctions;
global $faker;

/*$auction = $auctions[0];
//var_dump($auction);
addViews($auction, 1);
return;*/


foreach ($auctions as $auction){
    if($numBids= $auction->getField("numBids")){
        addViews($auction, $numBids * $faker->numberBetween(5, 50));
    }else{
        addViews($auction, $faker->numberBetween(1, 50));
    }
}



/**
 * @param $auction DbAuction
 * @param $numViews int
 */

function addViews($auction, $numViews )
{
    global $faker;
    //var_dump($auction);

    $startTime = new DateTime($auction->getField("startTime"));
    $endTime = new DateTime($auction->getField("endTime"));
    //echo "startTime: " . $startTime->getTimestamp() . "\t";
    //echo "endTime: " . $endTime->getTimestamp() . "\t";

    date_sub($endTime, date_interval_create_from_date_string("5 seconds"));
    $timeDiff = (int)(($endTime->getTimestamp() - $startTime->getTimestamp()));
    //echo "timeDiff: ".$timeDiff . "\t";


    for ($i = 0; $i < $numViews; $i++) {
        $viewTime = new DateTime('@' . ($startTime->getTimestamp() + $faker->numberBetween(1, $timeDiff)));
        addViedAtTime($auction, $viewTime);
    }

}

/**
 * @param $auction DbAuction
 * @param $time DateTime
 */


function addViedAtTime($auction, $time)
{

    $view = new DbAuctionView(array(
        "auctionId" => $auction->getId(),
        "viewTime" => $time->format('Y-m-d H:i:s')
    ));
    $view->create();

}
