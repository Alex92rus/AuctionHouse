<?php
require_once "../classes/class.session_operator.php";
require_once "../scripts/helper_functions.php";
require_once "../scripts/user_session.php";
require_once "../config/config.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>User Profile</title>

    <!-- Font -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300' rel='stylesheet' type='text/css'>
    <link href="../css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/animate.css" rel="stylesheet" type="text/css">
    <link href="../css/metisMenu.min.css" rel="stylesheet">
    <link href="../css/sb-admin-2.css" rel="stylesheet">
    <link href="../css/main.css" rel="stylesheet">

    <!-- JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/bootstrap-notify.min.js"></script>
    <script src="../js/metisMenu.min.js"></script>
    <script src="../js/sb-admin-2.js"></script>
    <script src="../js/auctionhouse.js"></script>
    <script src="../js/bootstrap.file-input.js"></script>
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
            <!-- profile header start -->
            <div class="row">
                <div class="col-lg-12">
                    <h2 class="page-header"><i class="fa fa-plus"></i> Create Auction</h2>
                </div>
            </div>
            <!-- profile header end -->


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