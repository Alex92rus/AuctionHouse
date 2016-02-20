<?php
    $auction = $_ENV[ "auction" ];
    $bids = $auction[ "bids" ];
    $now = new DateTime("now");
    $ready = $auction[ "startTime" ] < $now -> format( "Y-m-d H:i" );
?>

<!-- panel start -->
<div class="panel <?php if ( $ready ) { echo "panel-info"; } else { echo "panel-warning"; } ?> ">

    <!-- header start -->
    <div class="panel-heading clearfix">
        <h4 class="pull-left">
            <?php if ( $ready ) { echo "Time Remaining: "; } else { echo "Starts In: "; } ?><strong><span id="timer<?= $auction[ "auctionId" ]?>"></span></strong>
        </h4>
        <script type="text/javascript">
            var timerId = "#timer" + <?= json_encode( $auction[ "auctionId" ] ) ?>;
            var endTime = <?php if ( $ready ){ echo json_encode( $auction[ "endTime" ] ); } else { echo json_encode( $auction[ "startTime" ] ); } ?>;
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
                <img src="<?= "../uploads/item_images/" . $auction[ "image" ] ?>" class="img-responsive img-rounded">
            </div>
            <!-- item image end -->

            <!-- auction info start -->
            <div class="col-xs-9">

                <!-- auction unhidden start -->
                <div class="row">
                    <div class="col-xs-9">
                        <h3>
                            <?= $auction[ "itemName" ] ?><br>
                            <small><?= $auction[ "itemBrand" ] ?></small>
                        </h3>
                        <p class="text-danger">
                            <i class="fa fa-money"></i> <strong>Bids <?= count( $auction[ "bids" ] ) ?></strong> |
                            <i class="fa fa-eye"></i> <strong>Views <?= $auction[ "views" ] ?></strong> |
                            <i class="fa fa-desktop"></i> <strong>Watching <?= $auction[ "watches" ] ?></strong>
                        </p>
                    </div>
                    <div class="col-xs-3">
                        <?php if ( $ready ) : ?>
                            <?php if ( empty( $bids ) ) { ?>
                                <div class="text-center no-bids">
                                    <h4 class=text-danger"><span class="glyphicon glyphicon-exclamation-sign"></span> Nobody made a bid</h4>
                                </div>
                            <?php } else { ?>
                                <div class="text-center current-bid">
                                    <h3 class=text-success">£<?= $bids[ 0 ][ "bidPrice" ] ?></h3>
                                    <small>Current Bid By</small><br>
                                    <small><strong><a href="#"><?= $bids[ 0 ][ "bidderName" ]?></a></strong></small>
                                </div>
                            <?php } ?>
                        <?php endif ?>
                    </div>
                </div><hr>

                <div class="row">
                    <div class="col-xs-3"><p class="p-title"><i class="fa fa-shopping-cart"></i> <strong>Quantity</strong></p></div>
                    <div class="col-xs-3"><p class="p-info"><?= $auction[ "quantity" ] ?></p></div>
                </div>

                <div class="row">
                    <div class="col-xs-3"><p class="p-title"><i class="fa fa-tags"></i> <strong>Category</strong></p></div>
                    <div class="col-xs-3"><p class="p-info"><?= $auction[ "itemCategoryName" ] ?></p></div>
                    <div class="col-xs-3"><p class="p-title"><i class="fa fa-plus-square"></i> <strong>Condition</strong></p></div>
                    <div class="col-xs-3"><p class="p-info"><?= $auction[ "itemConditionName" ] ?></p></div>
                </div>
                <div class="row">
                    <div class="col-xs-3"><p class="p-title"><i class="fa fa-thumbs-up"></i> <strong>Start Price</strong></p></div>
                    <div class="col-xs-3"><p class="p-info">£<?= $auction[ "startPrice" ] ?></p></div>
                    <div class="col-xs-3"><p class="p-title"><i class="fa fa-hand-paper-o"></i> <strong>Reserve Price</strong></p></div>
                    <div class="col-xs-3"><p class="p-info">
                            <?php
                                $reservePrice = $auction[ "reservePrice" ];
                                if ( is_null( $reservePrice ) ) { echo "Not Set"; } else { echo "£" . $reservePrice; };
                            ?>
                        </p></div>
                </div>
                <!-- auction unhidden end -->

                <!-- auction hidden start -->
                <div id="<?= "more-details-" . $auction[ "auctionId" ] ?>">

                    <!-- item times start -->
                    <div class="row">
                        <div class="col-xs-3"><p class="p-title"><i class="fa fa-calendar-check-o"></i> <strong>Start Time</strong></p></div>
                        <div class="col-xs-3"><p class="p-info"><?= date_create( $auction[ "startTime" ] ) -> format( 'd-m-Y h:i' ) ?></p></div>
                        <div class="col-xs-3"><p class="p-title"><i class="fa fa-calendar-times-o"></i> <strong>End Time</strong></p></div>
                        <div class="col-xs-3"><p class="p-info"><?= date_create( $auction[ "endTime" ] ) -> format( 'd-m-Y H:i' ) ?></p></div>
                    </div>
                    <!-- item times end -->

                    <!-- item description start -->
                    <div class="row">
                        <div class="col-xs-3"><p class="p-title"><i class="fa fa-eye"></i> <strong>Description</strong></p></div>
                        <div class="col-xs-9"><p class="p-info text-justify"><?= $auction[ "itemDescription" ] ?></p>
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
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th>Bid Price</th>
                                <th>Increase</th>
                                <th>Time</th>
                                <th>User</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                                for ( $index = 0; $index < count( $bids ); $index++ ) {
                                    $bid = $bids[ $index ];
                                    $percent = 0;
                                    if ( $index != ( count( $bids ) - 1 )  ) {
                                        $previousBid = $bids[ $index + 1 ];
                                        $percent = round( ( 1 - ( $previousBid[ "bidPrice" ] / $bid[ "bidPrice" ] ) ) * 100, 2 );
                                    }

                                    ?>
                                <tr>
                                    <td class="col-xs-3"><?= $bid[ "bidPrice" ]?></td>
                                    <td class="col-xs-3">+ <?= $percent ?> %</td>
                                    <td class="col-xs-3"><?= $bid[ "bidTime" ]?></td>
                                    <td class="col-xs-3"><?= $bid[ "bidderName" ]?></td>
                                </tr>
                            <?php } ?>
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
        <div class="row toggle text-center" id="more-details" data-toggle="<?= "more-details-" . $auction[ "auctionId" ] ?>">
            <i class="fa fa-chevron-down fa-2x"></i>
        </div>
    </div>
    <!-- footer end -->

</div>
<!-- panel end -->