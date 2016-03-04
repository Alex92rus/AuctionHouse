<?php
require_once "../classes/class.auction.php";
require_once "../classes/class.bid.php";
require_once "../classes/class.live_auction.php";

/* @var Auction $auction */
//$auction = $_ENV[ "liveAuction" ];

/*$auction = $liveAuction -> getAuction();
$bids = $liveAuction -> getBids();
$views = $liveAuction -> getViews();
$watches = $liveAuction -> getWatches();*/

if ($origin == "watches"){
    $refer = "&w=1";
}else if($origin == "search"){
    $refer = "&s=1";
}else{
    $refer= "";
}

?>

<div class="row live-auction-to-buyer">

    <div class="col-xs-3 auction-img">
        <img src="<?= $auction->getImage() ?>" class="img-responsive" style="height:150px">
    </div>

    <div class="col-xs-9 auction-info">

        <?php

            if($origin == "watches"){
                include "../includes/remove_watch.php";
            }
        ?>


        <div class="row">
            <div class="col-xs-12">
                <h4>
                    <?php

                    if (new DateTime($auction->getEndTime()) > new DateTime()){
                        echo ('<a href="../views/open_live_auction_view.php?liveAuction='
                            . $auction -> getAuctionId() .$refer.'">'.$auction->getItemName().'</a><br>');

                    }else{
                        //idea is so that you can't click on sold auction and do stupid things like bid
                        echo ('<h4>'.$auction->getItemName().'</h4><br>');
                    }
                    ?>
                    <small><?= $auction -> getItemBrand() ?></small>
                </h4>
            </div>
        </div>

        <div class="row clearfix">
            <div class="col-xs-6">
                <h4>
                    <strong>£
                        <?php
                        if ( empty( $auction->getHighestBid() ) ) {
                            echo $auction -> getStartPrice();
                        } else {
                            echo $auction->getHighestBid(); /*$bids[ 0 ] -> getBidPrice()*/
                        }  ?></strong><br>
                    <small> <?= $auction->getNumBids() ?> Bids</small>
                </h4>
            </div>
            <div class="col-xs-6">

                <?php
                    if (new DateTime($auction->getEndTime()) > new DateTime()){
                        include "../includes/timer_countdown.php";
                    }else{
                        if($auction->getSold() == 1){
                            echo ('<h5 >SOLD</h5>');
                        }else{
                            echo ('<h5 >UNSOLD</h5>');
                        }
                    }
                ?>

            </div>

        </div>

        <div class="row">
            <div class="col-xs-6">
                <p><i class="fa fa-eye"></i> Views <?= $auction->getViews() ?> | <i class="fa fa-desktop"></i> Watching <?= $auction->getNumWatches() ?></p>
            </div>
            <div class="col-xs-6">
                <p><?= $auction -> getCountry() ?></p>
            </div>
        </div>

    </div>

</div>