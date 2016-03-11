<?php
require_once "../classes/class.auction.php";
require_once "../classes/class.bid.php";
require_once "../classes/class.advanced_auction.php";


/* @var Auction $auction */
/* @var String $origin */

if ($origin == "watches"){
    $refer = "&w=1";
}else if($origin == "search") {
    $refer = "&s=1";
}else if($origin == "liveWithBid"){
    $refer = "&l=1";
}else{
    $refer= "";
}

?>

<div class="row">
    <div class="col-xs-12 live-auction-to-buyer">
        <?php if( $origin == "watches" ) : ?>
            <section id="auction<?= $auction -> getAuctionId() ?>">
         <?php endif ?>

        <div class="col-xs-3 auction-img">
            <img src="<?= $auction->getImage() ?>" class="img-responsive" style="height:150px">
        </div>

        <div class="col-xs-9 auction-info">

            <div class="row">
                <div class="col-xs-8">
                    <h4>
                        <?php
                        if (new DateTime($auction->getEndTime()) > new DateTime()){
                            echo ('<a href="../views/open_live_auction_view.php?liveAuction='
                                . $auction -> getAuctionId() .$refer.'">'.$auction->getItemName().'</a><br>');

                        }else{
                            echo ( $auction->getItemName().'<br>');
                        }
                        ?>
                        <small><?= $auction -> getItemBrand() ?></small>
                    </h4>
                </div>
                <?php
                if($origin == "watches"){
                    include "../includes/remove_watch.php";
                }
                ?>
            </div>

            <div class="row clearfix">

                <div class="col-xs-6">
                    <h4>
                        <strong>
                            <?php
                            $currentPrice = "£";
                            if ( empty( $auction->getHighestBid() ) ) {
                                $currentPrice .= $auction -> getStartPrice();
                            } else {
                                $currentPrice .= $auction->getHighestBid();
                            }

                            if($auction->getSold() == 1){
                                echo "<span class='text-success'>SOLD FOR " . $currentPrice . "</span>";
                            } else if(new DateTime($auction->getEndTime()) < new DateTime() ) {
                                echo "<span class='text-danger'>UNSOLD - LAST PRICE " . $currentPrice . "</span>";
                            } else {
                                echo $currentPrice;
                            }
                            ?>
                        </strong><br>
                        <small> <?= $auction->getNumBids() ?> Bids</small>
                    </h4>
                </div>

                <div class="col-xs-6">
                    <?php if (new DateTime($auction->getEndTime()) > new DateTime()) : ?>
                        <h5 class="text-danger"><span id="timer<?= $auction ->getAuctionId()?>"></span> left</h5>

                        <script type="text/javascript">
                            var timerId = "#timer" + <?= json_encode( $auction -> getAuctionId() ) ?>;
                                        var endTime = <?= json_encode( $auction -> getEndTime() ) ?>;
                                        $(timerId).countdown( endTime, function(event) {
                                        $(this).text(
                                        event.strftime('%D days %H:%M:%S')
                                        );
                                        });
                        </script>

                    <?php endif ?>
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

            <div class="row">
                <div class="col-xs-6">
                    <?php
                    if($origin == "liveWithBid"){
                        if($auction->getIsUserWinning()){?>
                            <p id="bid" class="alert-success">Currently the highest bidder!</p> <?php
                        }else{?>
                            <p id="bid" class="alert-warning">Outbidded, bid again to win!</p> <?php

                        }
                    }
                    ?>
                </div>
            </div>

        </div>
    </div>

</div>