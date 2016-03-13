<?php
require_once "../classes/class.auction.php";
require_once "../classes/class.bid.php";
require_once "../classes/class.advanced_auction.php";
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';

/* @var AdvancedAuction $advancedAuction */
/* @var Auction $auction */
/* @var string $option */

$auction = $advancedAuction -> getAuction();
$bids = $advancedAuction -> getBids();
$views = $advancedAuction -> getViews();
$watches = $advancedAuction -> getWatches();

$now = new DateTime("now", new DateTimeZone(TIMEZONE) );
$ready = $auction -> getStartTime() < $now -> format( "Y-m-d H:i:s" );


// Determine panel type
$panelType =  null;
if ( $option == "live" ) {
    if ( $ready ) {
        $panelType = "panel-info";
    } else {
        $panelType = "panel-default";
    }
} else if ( $option == "sold" ) {
    $panelType = "panel-success";
} else {
    if ( empty( $bids ) ) {
        $panelType = "panel-danger";
    } else {
        $panelType = "panel-warning";
    }
}

?>


<!-- panel start -->
<div class="panel <?= $panelType ?>" id="auction<?= $auction -> getAuctionId() ?>">


    <!-- header start -->
    <div class="panel-heading clearfix">

        <?php if ( $option == "live" ) { ?>
            <h5 class="pull-left">
                <?php if ( $ready ) { echo "Time Remaining: "; } else { echo "Starts In: "; } ?><strong><span id="timer<?= $auction -> getAuctionId() ?>"></span></strong>
            </h5>
            <script type="text/javascript">
                var timerId = "#timer" + <?= json_encode( $auction -> getAuctionId() ) ?>;
                var endTime = <?php if ( $ready ){ echo json_encode( $auction -> getEndTime() ); } else { echo json_encode( $auction -> getStartTime() ); } ?>;
                $(timerId).countdown( endTime )
                    .on('update.countdown', function(event) {
                        $(this).html(
                            event.strftime('%D days %H:%M:%S')
                        );
                    })
                    .on('finish.countdown', function(event) {
                        $("#auction" + <?= json_encode( $auction -> getAuctionId() ) ?>).remove();
                    });

            </script>
            <div class="pull-right auction-navigation">
                <div class="btn-group pull-right">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                        <span class="glyphicon glyphicon-cog"></span>
                    </button>
                    <ul class="dropdown-menu slidedown">
                        <li>
                            <a href="#" data-href="../scripts/delete_auction.php?id=<?php echo $auction->getAuctionId()?>"
                               data-toggle="modal" data-target="#confirm-delete"><span class="glyphicon glyphicon-trash"></span>Delete</a>
                        </li>
                    </ul>
                </div>
            </div>
        <?php } else if ( $option == "sold" ) { ?>
            <h5 class="text-success">Sold to <a href=""><?= $bids[ 0 ] -> getBidderName() ?></a> for <strong>£<?= $bids[ 0 ] -> getBidPrice() ?></strong></h5>
        <?php } else { ?>
            <h5 class="text-danger">
                <?php if( empty( $bids ) ) { echo "Nobody placed a bid"; } else { echo "Reserve price was not reached. Last bid was <strong>£ " .  $bids[ 0 ] -> getBidPrice() . "</strong>"; } ?>
            </h5>
        <?php } ?>

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

                <div class="row">
                    <div class="<?php if ($option == "sold" ){echo "col-xs-6";}else{ echo "col-xs-9";}?>">
                        <h4>
                            <?= $auction -> getItemName() ?><br>
                            <small><?= $auction -> getItemBrand() ?></small>
                        </h4>
                        <p class="<?php if ( $option == "live" ) { echo "text-danger"; } else { echo "text-info"; }?>">
                            <strong>Bids <?= count( $bids) ?></strong> |
                            <i class="fa fa-eye"></i> <strong>Views <?= $views ?></strong> |
                            <i class="fa fa-desktop"></i> <strong>Watching <?= $watches ?></strong>
                        </p>
                    </div>
                    <!-- feedback start -->
                    <?php if( $option == "sold") {
                        $feedbackReceiverUsername = $bids[ 0 ] -> getBidderName();
                        if ($auction->getHasBuyerFeedback()){?>
                            <div class="col-xs-6">
                                <p class="pull-right">Thank you for leaving <a href="../views/my_feedbacks_view.php?username=<?=$feedbackReceiverUsername?>"> feedback</a></p>
                            </div>
                        <?php } else {
                            $feedbackType = "Leave Buyer Feedback";
                            include "feedback_form.php";
                        }
                    } ?>
                    <!-- feedback end -->
                    <?php if( $option == "live" ) : ?>
                        <div class="col-xs-3">
                            <?php if ( $ready ) : ?>
                                <?php if ( empty( $bids ) ) { ?>
                                    <div class="text-center no-bids">
                                        <h5 class=text-danger"><span class="glyphicon glyphicon-exclamation-sign"></span> No bids</h5>
                                    </div>
                                <?php } else { ?>
                                    <div class="text-center current-bid">
                                        <h4 class="text-success">£<?= $bids[ 0 ] -> getBidPrice() ?></h4>
                                        <small>Current Bid By</small><br>
                                        <small><strong><a href="#"><?= $bids[ 0 ] -> getBidderName() ?></a></strong></small>
                                    </div>
                                <?php } ?>
                            <?php endif ?>
                        </div>
                    <?php endif ?>
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