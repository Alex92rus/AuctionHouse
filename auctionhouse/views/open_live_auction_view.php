<?php
require_once "../classes/class.session_operator.php";
require_once "../classes/class.query_operator.php";
require_once "../classes/class.helper_operator.php";
require_once "../scripts/user_session.php";
require_once "../classes/class.auction.php";
require_once "../classes/class.bid.php";
require_once "../classes/class.live_auction.php";


$liveAuction = null;

if ( isset( $_GET[ "liveAuction" ] ) )
{
    $liveAuction = SessionOperator::getLiveAuction( $_GET[ "liveAuction" ] );
}
else
{
    HelperOperator::redirectTo( "search_view.php" );
}

$auction = $liveAuction -> getAuction();
$bids = $liveAuction -> getBids();
$views = $liveAuction -> getViews();
$watches = $liveAuction -> getWatches();
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?= $auction -> getItemName() . " | AuctionHouse" ?></title>

    <!-- Font -->
    <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>

    <!-- CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link href="../css/animate.css" rel="stylesheet" type="text/css">
    <link href="../css/metisMenu.min.css" rel="stylesheet">
    <link href="../css/sb-admin-2.css" rel="stylesheet">
    <link href="../css/dataTables.bootstrap.css" rel="stylesheet">
    <link href="../css/main.css" rel="stylesheet">

    <!-- JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/bootstrap-notify.min.js"></script>
    <script src="../js/metisMenu.min.js"></script>
    <script src="../js/sb-admin-2.js"></script>
    <script src="../js/jquery.dataTables.min.js"></script>
    <script src="../js/dataTables.bootstrap.min.js"></script>
    <script src="../js/jquery.countdown.min.js"></script>
    <script src="../js/custom/search.js"></script>
    <script src="../js/custom/live_auction.js"></script>

</head>

<body>
    <!-- display feedback (if available) start -->
    <?php require_once "../includes/feedback.php" ?>
    <!-- display feedback (if available) end -->


    <div id="wrapper">

        <!-- navigation start -->
        <?php include_once "../includes/navigation.php" ?>
        <!-- navigation end -->


        <!-- main start -->
        <div id="page-wrapper">

            <!-- back start -->
            <div class="row">
                <div class="col-xs-12" id="go-back-navigation">
                    <a href="search_view.php" class="btn btn-primary"><i class="fa fa-chevron-left"></i></a>
                    <a href="search_view.php"> Back to search results</a>
                </div>
            </div>
            <!-- back end -->

            <!-- live auction start -->
            <div class="row">

                <!-- item image start -->
                <div class="col-xs-3">
                    <img src="<?= "../uploads/profile_images/blank_profile.png" ?>" class="img-responsive img-rounded">
                </div>
                <!-- item image end -->

                <!-- auction info start -->
                <div class="col-xs-9">

                    <div class="row">
                        <div class="col-xs-12">
                            <h3 id="live-auction">
                                <?= $auction -> getItemName() ?> - <?= $auction -> getItemBrand() ?>
                            </h3>
                            <p class="text-info">
                                <i class="fa fa-eye"></i> <strong>Views <?= $views ?></strong> |
                                <i class="fa fa-desktop"></i> <strong>Watching <?= $watches ?></strong>
                            </p>
                        </div>
                    </div><hr id="live-auction">

                    <div class="row">
                        <div class="move-in">
                            <div class="col-xs-3"><p class="p-title"><i class="fa fa-plus-square"></i> Condition</p></div>
                            <div class="col-xs-9"><p class="p-info"><?= $auction -> getConditionName() ?></p></div>
                            <div class="col-xs-3"><p class="p-title"><i class="fa fa-clock-o"></i> Time Left</p></div>
                            <div class="col-xs-9"><p class="p-info"><strong><span class="text-danger" id="timer"></span></strong></p></div>
                        </div>
                        <script type="text/javascript">
                            var timerId = "#timer";
                            var endTime = <?= json_encode( $auction -> getEndTime() ) ?>;
                            $(timerId).countdown( endTime, function(event) {
                                $(this).text(
                                    event.strftime('%D days %H:%M:%S')
                                );
                            });
                        </script>

                        <div class="col-xs-12" id="bid-box">
                            <div class="col-xs-3">
                                <p class="p-title" style="padding-top:4px;"><i class="fa fa-money"></i>
                                    <?php if ( empty( $bids ) ) { echo "Starting Bid"; } else { echo "Current Bid"; } ?></p>
                            </div>

                            <div class="col-xs-5">
                                <div class="col-xs-8"><p class="p-info bid-price" style="margin-top: 0">£
                                        <?php
                                        if ( empty( $bids ) ) {
                                            echo $auction -> getStartPrice() . "<br><small>Enter £" . $auction -> getStartPrice() . " or more</small>";
                                        } else {
                                            $bid  = $bids[ 0 ] -> getBidPrice();
                                            $bid .= "<br><small>Enter £ " . ( $bid + HelperOperator::getIncrement( $bid ) ) . " or more</small>";
                                            echo $bid;
                                        }  ?></p>
                                </div>
                                <div class="col-xs-4">
                                    <p class="p-info" style="padding-top:4px;"><a href="#biddings"><?= count( $bids ) ?> bids</a></p>
                                </div>
                                <form method="GET" action="">
                                    <div class="col-xs-8">
                                        <input type="text" class="form-control" name="bidPrice" maxlength="11" style="height: 30px"><br>
                                    </div>
                                    <div class="col-xs-4">
                                        <button type="submit" class="btn btn-primary" name="placeBid" style="height: 30px; padding: 4px 12px">Place Bid</button>
                                    </div>
                                </form>
                                <div class="col-xs-12">
                                    <a href=""><i class="fa fa-eye"></i> Add to watch list</a>
                                </div>
                            </div>

                            <div class="col-xs-4">
                                <div class="panel panel-default" id="seller-info">
                                    <div class="panel-body">
                                        <h4>Seller Information</h4>
                                        <p>
                                            <a href=""><?php // Username Plugin ?> sickAustrian (Fake)</a><br>
                                            From <?php // Country plugin ?> United Kingdom (Fake)<br>
                                            <?php // Feedback plugin ?> 100% Positive Feedback (Fake)
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="move-in">
                            <div class="col-xs-3"><p class="p-title"><i class="fa fa-shopping-cart"></i> Quantity</p></div>
                            <div class="col-xs-9"><p class="p-info"><?= $auction -> getQuantity() ?></p></div>
                            <div class="col-xs-3"><p class="p-title"><i class="fa fa-tags"></i> Category</p></div>
                            <div class="col-xs-9"><p class="p-info"><?= $auction -> getCategoryName() ?></p></div>
                            <div class="col-xs-3"><p class="p-title"><i class="fa fa-calendar-check-o"></i> Start Time</p></div>
                            <div class="col-xs-9"><p class="p-info"><?= date_create( $auction -> getStartTime() ) -> format( 'd-m-Y h:i' ) ?></p></div>
                            <div class="col-xs-3"><p class="p-title"><i class="fa fa-list"></i> Description</p></div>
                            <div class="col-xs-9"><p class="p-info text-justify"><?= $auction -> getItemDescription() ?></p></div>
                        </div>
                    </div>

                    <?php if ( count( $bids ) > 0 ) : ?>
                        <hr>
                        <div class="row">
                            <div class="col-xs-12">
                                <h4 id="biddings">Bidding History</h4>
                            </div>
                        </div>
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
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


                </div>
                <!-- live auction end -->

            </div>
            <!-- main end -->


            <!-- footer start -->
            <div class="footer">
                <div class="container">
                </div>
            </div>
            <!-- footer end -->

        </div>
        <!-- main end -->


    </div>
    <!-- /#wrapper -->

</body>

</html>