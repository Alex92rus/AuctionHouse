<?php
include_once "../classes/class.session_operator.php";
include_once "../classes/class.query_operator.php";
require_once "../scripts/user_session.php";


$username = null;
$userImage = null;

if ( isset ( $_GET[ "username" ] ) && $_GET[ "username" ] != SessionOperator::getUser() -> getUsername() ) {
    $username = $_GET[ "username" ];
    $userImage = QueryOperator::getUserImage( $username );
} else {
    $username =  SessionOperator::getUser() -> getUsername();
    $userImage = SessionOperator::getUser() -> getImage();
}

$advancedFeedback = QueryOperator::getFeedback( $username );
$buyerActive = ( empty( $advancedFeedback -> getFeedbackAsSeller() ) && !empty( $advancedFeedback -> getFeedbackAsBuyer() ) ) ? true : false;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>My Feedbacks</title>

    <!-- Font -->
    <link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>

    <!-- CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
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
    <script src="../js/custom/search.js"></script>
</head>


<body>
    <!-- display feedback (if available) start -->
    <?php require_once "../includes/notification.php" ?>
    <!-- display feedback (if available) end -->

    <div id="wrapper">

        <!-- navigation start -->
        <?php include_once "../includes/navigation.php" ?>
        <!-- navigation end -->


        <!-- main start -->
        <div id="page-wrapper">

            <?php if ( $advancedFeedback -> getAverage() != -1 ) { ?>
                <!-- feedback header start -->
                <div class="row feedbacks-header">
                    <div class="col-xs-12">
                        <h4 class="text-primary">
                            <?php if ( $_GET[ "username" ] == SessionOperator::getUser() -> getUsername() ) { $username = "Me (" . $username . ")"; } echo $username ?>
                        </h4>
                    </div>
                    <div class="col-xs-6">
                        <div class="col-xs-5 no-padding-left">
                            <img src="..<?= $userImage ?>" class="img-rounded img-responsive" style="height: 170px">
                        </div>
                        <div class="col-xs-7">
                            <h4>Average user rating</h4>
                            <h2 class="bold padding-bottom-7"><?= $advancedFeedback -> getAverage() ?> <small>/ 5</small></h2>
                            <button type="button" class="btn btn-warning btn-xs" aria-label="Left Align">
                                <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                            </button>
                            <button type="button" class="btn btn-warning btn-xs" aria-label="Left Align">
                                <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                            </button>
                            <button type="button" class="btn btn-warning btn-xs" aria-label="Left Align">
                                <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                            </button>
                            <button type="button" class="btn btn-default btn-grey btn-xs" aria-label="Left Align">
                                <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                            </button>
                            <button type="button" class="btn btn-default btn-grey btn-xs" aria-label="Left Align">
                                <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                            </button>
                        </div>
                    </div>

                    <div class="col-xs-6" style="display:block;">
                        <h4>Rating breakdown</h4>
                        <div class="col-xs-12 no-padding-left">
                            <div class="pull-left">
                                <div class="pull-left" style="width:35px; line-height:1;">
                                    <div style="height:9px; margin:5px 0;">5 <span class="glyphicon glyphicon-star"></span></div>
                                </div>
                                <div class="pull-left" style="width:180px;">
                                    <div class="progress" style="height:9px; margin:8px 0;">
                                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="3.4" aria-valuemin="0" aria-valuemax="5"
                                             style="width: <?php echo round( ( $advancedFeedback -> getFiveStars() / $advancedFeedback -> getTotal() ) * 100 ) . "%" ?>">
                                            <span class="sr-only">80% Complete (danger)</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="pull-right" style="margin-left:10px;"><?= $advancedFeedback ->getFiveStars() ?></div>
                            </div>
                        </div>
                        <div class="col-xs-12 no-padding-left">
                            <div class="pull-left">
                                <div class="pull-left" style="width:35px; line-height:1;">
                                    <div style="height:9px; margin:5px 0;">4 <span class="glyphicon glyphicon-star"></span></div>
                                </div>
                                <div class="pull-left" style="width:180px;">
                                    <div class="progress" style="height:9px; margin:8px 0;">
                                        <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="4" aria-valuemin="0" aria-valuemax="5"
                                             style="width: <?php echo round( ( $advancedFeedback -> getFourStars() / $advancedFeedback -> getTotal() ) * 100 ) . "%" ?>">
                                            <span class="sr-only">80% Complete (danger)</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="pull-right" style="margin-left:10px;"><?= $advancedFeedback ->getFourStars() ?></div>
                            </div>
                        </div>
                        <div class="col-xs-12 no-padding-left">
                            <div class="pull-left">
                                <div class="pull-left" style="width:35px; line-height:1;">
                                    <div style="height:9px; margin:5px 0;">3 <span class="glyphicon glyphicon-star"></span></div>
                                </div>
                                <div class="pull-left" style="width:180px;">
                                    <div class="progress" style="height:9px; margin:8px 0;">
                                        <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="3" aria-valuemin="0" aria-valuemax="5"
                                             style="width: <?php echo round( ( $advancedFeedback -> getThreeStars() / $advancedFeedback -> getTotal() ) * 100 ) . "%" ?>">
                                            <span class="sr-only">80% Complete (danger)</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="pull-right" style="margin-left:10px;"><?= $advancedFeedback ->getThreeStars() ?></div>
                            </div>
                        </div>
                        <div class="col-xs-12 no-padding-left">
                            <div class="pull-left">
                                <div class="pull-left" style="width:35px; line-height:1;">
                                    <div style="height:9px; margin:5px 0;">2 <span class="glyphicon glyphicon-star"></span></div>
                                </div>
                                <div class="pull-left" style="width:180px;">
                                    <div class="progress" style="height:9px; margin:8px 0;">
                                        <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="2" aria-valuemin="0" aria-valuemax="5"
                                             style="width: <?php echo round( ( $advancedFeedback -> getTwoStars() / $advancedFeedback -> getTotal() ) * 100 ) . "%" ?>">
                                            <span class="sr-only">80% Complete (danger)</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="pull-right" style="margin-left:10px;"><?= $advancedFeedback -> getTwoStars() ?></div>
                            </div>
                        </div>
                        <div class="col-xs-12 no-padding-left">
                            <div class="pull-left">
                                <div class="pull-left" style="width:35px; line-height:1;">
                                    <div style="height:9px; margin:5px 0;">1 <span class="glyphicon glyphicon-star"></span></div>
                                </div>
                                <div class="pull-left" style="width:180px;">
                                    <div class="progress" style="height:9px; margin:8px 0;">
                                        <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="1" aria-valuemin="0" aria-valuemax="5"
                                             style="width: <?php echo round( ( $advancedFeedback -> getOneStars() / $advancedFeedback -> getTotal() ) * 100 ) . "%" ?>">
                                            <span class="sr-only">80% Complete (danger)</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="pull-right" style="margin-left:10px;"><?= $advancedFeedback ->getOneStars() ?></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- feedback header end -->


                <!-- feedback navigation start -->
                <ul class="nav nav-tabs">
                    <li class="<?php if ( !$buyerActive ) { echo "active"; } ?>"><a data-toggle="tab" href="#seller">As Seller</a></li>
                    <li class="<?php if ( $buyerActive ) { echo "active"; } ?>"><a data-toggle="tab" href="#buyer">As Buyer</a></li>
                </ul>
                <!-- feedback navigation end -->


                <!-- feedbacks start -->
                <div class="tab-content">
                    <div id="seller" class="tab-pane fade<?php if ( !$buyerActive ) { echo " in active"; } ?>" >
                        <?php
                        if ( !empty( $advancedFeedback -> getFeedbackAsSeller() ) ) {
                            foreach ($advancedFeedback->getFeedbackAsSeller() as $feedback) {
                                include "../includes/feedback.php";
                            }
                        } else {
                            echo "<br><h5>Nobody gave you a seller feedback!</h5>";
                        }
                        ?>
                    </div>
                    <div id="buyer" class="tab-pane fade<?php if ( $buyerActive ) { echo " in active"; } ?>">
                        <?php
                        if ( !empty( $advancedFeedback -> getFeedbackAsBuyer() ) ) {
                            foreach ($advancedFeedback->getFeedbackAsBuyer() as $feedback) {
                                include "../includes/feedback.php";
                            }
                        } else {
                            echo "<br><h5>Nobody gave you a buyer feedback!</h5>";
                        }
                        ?>
                    </div>
                </div>
                <!-- feedbacks end -->

            <?php } else {  ?>
                <div class="row">
                    <div class="well text-center">
                        <h1 class="text-danger">No feedback available</h1>
                        <h4>In order to receive feedbacks, you must sell or win an auction. Only then, a buyer or a seller can rate you.</h4>
                    </div>
                </div>
            <?php } ?>


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