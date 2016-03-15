<?php
require_once "../classes/class.session_operator.php";
require_once "../classes/class.query_operator.php";
require_once "../scripts/user_session.php";
$user = SessionOperator::getUser();
$didNotWinAuctions = QueryOperator::getEndedAuctionsWhereBuyerHasLost($user->getUserId());
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Watched Auctions</title>

    <!-- Font -->
    <link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>

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

    <div id="wrapper">



        <!-- navigation start -->
        <?php include_once "../includes/navigation.php" ?>
        <!-- navigation end -->


        <!-- main start -->
        <div id="page-wrapper">

            <?php include_once "../includes/recommender_carousel.php" ?>

            <div class="row">
                <div class="col-xs-12">
                    <h4 class="page-header">
                        Sorry, you did not win <span class="text-danger"><?= count( $didNotWinAuctions ) ?> auctions</span>
                    </h4>
                </div>
            </div>

            <!-- search main start -->
            <div class="row" id="search-main">

                <!-- live auctions list start -->
                <div class="col-xs-12">
                    <?php
                    if ( count( $didNotWinAuctions ) == 0 ) {
                        echo "<h4>There are no auctions you failed to win</h4>";
                    } else {
                        foreach ( $didNotWinAuctions as $auction ) {
                            echo $auction -> getUsername();
                            $origin = "didNotWin";
                            include "../includes/live_auction_to_buyer.php";
                        }
                    }
                    ?>
                </div>
                <!-- live auctions list end -->

            </div>
            <!-- search main end -->

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