<?php
require_once "../classes/class.auction.php";
require_once "../classes/class.bid.php";
require_once "../classes/class.live_auction.php";

$liveAuction = $_ENV[ "liveAuction" ];

$auction = $liveAuction -> getAuction();
$bids = $liveAuction -> getBids();
$views = $liveAuction -> getViews();
$watches = $liveAuction -> getWatches();

SessionOperator::setLiveAuction( $auction -> getAuctionId(), $liveAuction );
?>

<div class="row live-auction-to-buyer">

    <div class="col-xs-3 auction-img">
        <img src="../uploads/profile_images/blank_profile.png" class="img-responsive" style="height:150px">
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
                        if ( empty( $bids ) ) {
                            echo $auction -> getStartPrice();
                        } else {
                            echo $bids[ 0 ] -> getBidPrice();
                        }  ?></strong><br>
                    <small> <?= count( $bids ) ?> Bids</small>
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
                <p><i class="fa fa-eye"></i> Views <?= $views ?> | <i class="fa fa-desktop"></i> Watching <?= $watches ?></p>
            </div>
            <div class="col-xs-6">
                <p><?php // Country plugin ?> United Kingdom (Fake)</p>
            </div>
        </div>

    </div>

</div>