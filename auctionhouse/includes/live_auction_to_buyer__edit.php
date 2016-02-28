<?php
require_once "../classes/class.auction.php";
require_once "../classes/class.bid.php";
require_once "../classes/class.live_auction.php";

/* @var Auction $auction */
$auction = $_ENV[ "liveAuction" ];

/*$auction = $liveAuction -> getAuction();
$bids = $liveAuction -> getBids();
$views = $liveAuction -> getViews();
$watches = $liveAuction -> getWatches();*/

SessionOperator::setLiveAuction( $auction -> getAuctionId(), $liveAuction );
?>

<div class="row live-auction-to-buyer">

    <div class="col-xs-3 auction-img">
        <img src="<?= $auction->getImage() ?>" class="img-responsive" style="height:150px">
    </div>

    <div class="col-xs-9 auction-info">

        <div class="row">
            <div class="col-xs-12">
                <h4>
                    <a href="../views/open_live_auction_view.php?liveAuction=<?= $auction -> getAuctionId() ?>" >
                        <?= $auction -> getItemName() ?>
                    </a><br>
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
                <h5 class="text-danger"><span id="timer<?= $auction -> getAuctionId() ?>"></span> left</h5>
            </div>
            <script type="text/javascript">
                var timerId = "#timer" + <?= json_encode( $auction -> getAuctionId() ) ?>;
                var endTime = <?= json_encode( $auction -> getEndTime() ) ?>;
                $(timerId).countdown( endTime, function(event) {
                    $(this).text(
                        event.strftime('%D days %H:%M:%S')
                    );
                });
            </script>
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