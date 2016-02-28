<?php
require_once "../classes/class.auction.php";
require_once "../classes/class.bid.php";
require_once "../classes/class.live_auction.php";

$liveAuction = $_ENV[ "liveAuction" ];

$auction = $liveAuction -> getAuction();
$bids = $liveAuction -> getBids();
$views = $liveAuction -> getViews();
$watches = $liveAuction -> getWatches();

$now = new DateTime("now");
$ready = $auction -> getStartTime() < $now -> format( "Y-m-d H:i" );
?>

<!-- panel start -->
<div class="panel <?php if ( $ready ) { echo "panel-info"; } else { echo "panel-warning"; } ?> ">

    <!-- header start -->
    <div class="panel-heading clearfix">
        <h4 class="pull-left">
            <?php if ( $ready ) { echo "Time Remaining: "; } else { echo "Starts In: "; } ?><strong><span id="timer<?= $auction -> getAuctionId() ?>"></span></strong>
        </h4>
        <script type="text/javascript">
            var timerId = "#timer" + <?= json_encode( $auction -> getAuctionId() ) ?>;
            var endTime = <?php if ( $ready ){ echo json_encode( $auction -> getEndTime() ); } else { echo json_encode( $auction -> getStartTime() ); } ?>;
            $(timerId).countdown( endTime, function(event) {
                $(this).text(
                    event.strftime('%D days %H:%M:%S')
                );
            });
        </script>
        <div class="pull-right auction-navigation">
            <div class="btn-group pull-right">
                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                    <span class="glyphicon glyphicon-cog"></span>
                </button>
                <ul class="dropdown-menu slidedown">
                    <li><a href="#"><span class="glyphicon glyphicon-pencil"></span>Edit</a></li>
                    <li><a href="#"><span class="glyphicon glyphicon-trash"></span>Delete</a></li>
                </ul>
            </div>
        </div>
    </div>
    <!-- header end -->

    <!-- body start -->
    <div class="panel-body">
        <div class="row">

            <!-- item image start -->
            <div class="col-xs-3">
                <img src="<?= $auction->getImage() ?>" class="img-responsive img-rounded" style="height:160px">
            </div>
            <!-- item image end -->

            <!-- auction info start -->
            <div class="col-xs-9">

                <!-- auction unhidden start -->
                <div class="row">
                    <div class="col-xs-9">
                        <h3>
                            <?= $auction -> getItemName() ?><br>
                            <small><?= $auction -> getItemBrand() ?></small>
                        </h3>
                        <p class="text-danger">
                            <strong>Bids <?= count( $bids) ?></strong> |
                            <i class="fa fa-eye"></i> <strong>Views <?= $views ?></strong> |
                            <i class="fa fa-desktop"></i> <strong>Watching <?= $watches ?></strong>
                        </p>
                    </div>
                    <div class="col-xs-3">
                        <?php if ( $ready ) : ?>
                            <?php if ( empty( $bids ) ) { ?>
                                <div class="text-center no-bids">
                                    <h5 class=text-danger"><span class="glyphicon glyphicon-exclamation-sign"></span> No bids</h5>
                                </div>
                            <?php } else { ?>
                                <div class="text-center current-bid">
                                    <h3 class=text-success">£<?= $bids[ 0 ] -> getBidPrice() ?></h3>
                                    <small>Current Bid By</small><br>
                                    <small><strong><a href="#"><?= $bids[ 0 ] -> getBidderName() ?></a></strong></small>
                                </div>
                            <?php } ?>
                        <?php endif ?>
                    </div>
                </div><hr>

                <div class="row">
                    <div class="col-xs-3"><p class="p-title"><i class="fa fa-shopping-cart"></i> Quantity</p></div>
                    <div class="col-xs-3"><p class="p-info"><?= $auction -> getQuantity() ?></p></div>
                </div>

                <div class="row">
                    <div class="col-xs-3"><p class="p-title"><i class="fa fa-tags"></i> Category</p></div>
                    <div class="col-xs-3"><p class="p-info"><?= $auction -> getCategoryName() ?></p></div>
                    <div class="col-xs-3"><p class="p-title"><i class="fa fa-plus-square"></i> Condition</p></div>
                    <div class="col-xs-3"><p class="p-info"><?= $auction -> getConditionName() ?></p></div>
                </div>
                <!-- auction unhidden end -->

                <!-- auction hidden start -->
                <div id="<?= "more-details-" . $auction -> getAuctionId() ?>">

                    <!-- item prices start -->
                    <div class="row">
                        <div class="col-xs-3"><p class="p-title"><i class="fa fa-thumbs-up"></i> Start Price</p></div>
                        <div class="col-xs-3"><p class="p-info">£<?= $auction -> getStartPrice() ?></p></div>
                        <div class="col-xs-3"><p class="p-title"><i class="fa fa-hand-paper-o"></i> Reserve Price</p></div>
                        <div class="col-xs-3">
                            <p class="p-info">
                                <?php
                                $reservePrice = $auction -> getReservePrice();
                                if ( $reservePrice == 0 ) { echo "Not Set"; } else { echo "£" . $reservePrice; };
                                ?>
                            </p>
                        </div>
                    </div>
                    <!-- item prices end -->

                    <!-- item times start -->
                    <div class="row">
                        <div class="col-xs-3"><p class="p-title"><i class="fa fa-calendar-check-o"></i> Start Time</p></div>
                        <div class="col-xs-3"><p class="p-info"><?= date_create( $auction -> getStartTime() ) -> format( 'd-m-Y h:i' ) ?></p></div>
                        <div class="col-xs-3"><p class="p-title"><i class="fa fa-calendar-times-o"></i> End Time</p></div>
                        <div class="col-xs-3"><p class="p-info"><?= date_create( $auction -> getEndTime() ) -> format( 'd-m-Y H:i' ) ?></p></div>
                    </div>
                    <!-- item times end -->

                    <!-- item description start -->
                    <div class="row">
                        <div class="col-xs-3"><p class="p-title"><i class="fa fa-list"></i>Description</p></div>
                        <div class="col-xs-9"><p class="p-info text-justify"><?= $auction -> getItemDescription() ?></p>
                        </div>
                    </div>
                    <!-- item description end -->

                    <!-- bidding history start -->
                    <?php if ( count( $bids ) > 0 ) : ?>
                        <hr>
                        <div class="row">
                            <div class="col-xs-12">
                                <h4>Bidding History</h4>
                            </div>
                        </div>
                        <table class="table table-striped table-bordered table-hover"  cellspacing="0" id="dataTables-example">
                            <thead>
                            <tr>
                                <th>Bid Price</th>
                                <th>Time</th>
                                <th>User</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                                foreach( $bids as $bid ) : ?>
                                    <tr>
                                        <td class="col-xs-3"><?= $bid -> getBidPrice()?></td>
                                        <td class="col-xs-3"><?= date_create( $bid -> getBidTime() ) -> format( 'd-m-Y h:i' ) ?></td>
                                        <td class="col-xs-3"><?= $bid -> getBidderName() ?></td>
                                    </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif ?>
                    <!-- bidding history end -->

                </div>
                <!-- auction hidden end -->

            </div>
            <!-- auction info end -->

        </div>
    </div>
    <!-- body end -->

    <!-- footer start -->
    <div class="panel-footer">
        <div class="row toggle text-center" id="more-details" data-toggle="<?= "more-details-" . $auction -> getAuctionId() ?>">
            <i class="fa fa-chevron-down"></i>
        </div>
    </div>
    <!-- footer end -->

</div>
<!-- panel end -->