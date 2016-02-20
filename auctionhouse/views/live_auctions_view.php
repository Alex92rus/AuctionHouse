<?php
require_once "../classes/class.session_operator.php";
require_once "../classes/class.query_operator.php";
require_once "../scripts/helper_functions.php";
require_once "../scripts/user_session.php";
$auctions = QueryOperator::getLiveAuctions( SessionOperator::getUser() -> getUserId() );
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Live Auctions</title>

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
            <div class="row">
                <div class="col-xs-12">
                    <h1 class="page-header">
                        My live auctions
                        <?php if ( !empty( $auctions ) ) : ?>
                            <a class="btn btn-lg btn-primary pull-right" href="create_auction_view.php">Create New Auction</a>
                        <?php endif ?>
                    </h1>
                </div>
            </div>

            <div class="row">
                <!-- no auctions available start -->
                <?php if ( empty( $auctions ) ) { ?>
                    <div class="well text-center">
                        <h1 class="text-danger">No auctions available</h1>
                        <h4>You currently sell now auctions. Click on the button below to create a new auction</h4>
                        <a class="btn btn-lg btn-primary" href="create_auction_view.php">Create New Auction</a>
                    </div>
                <!-- no auctions available end -->

                <!-- auctions available start -->
                <?php } else {
                    foreach ($auctions as $auction) {
                        $_ENV["auction"] = $auction;
                        include "../includes/live_auction.php";
                    }
                    unset($_ENV["auction"]);
                }
                ?>
                <!-- auctions available end -->
            </div>

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