<?php
require_once "../classes/class.session_operator.php";
require_once "../classes/class.query_operator.php";
require_once "../scripts/user_session.php";

$allNotifications = QueryOperator::getNotifications( SessionOperator::getUser() -> getUserId() );
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Notifications</title>

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
    <script src="../js/custom/search.js"></script>
    <script src="../js/custom/notification.js"></script>

</head>

<body>

    <div id="wrapper">

        <!-- navigation start -->
        <?php include_once "../includes/navigation.php" ?>
        <!-- navigation end -->


        <!-- main start -->
        <div id="page-wrapper">
            <div class="row">
                <div class="col-xs-12">
                    <h4 class="page-header">
                        All Notifications <span class="text-danger">(<?= count( $allNotifications ) ?>)</span>
                    </h4>
                </div>
            </div>

            <!-- notifications start -->
            <table class="table table-striped table-bordered table-hover"  cellspacing="0" id="dataTables-notifications">
                <thead>
                <tr>
                    <th>Notification Type</th>
                    <th>Auction</th>
                    <th>Time</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach( $allNotifications as $alert ) : ?>
                    <tr>
                        <td class="col-xs-2"><i class="<?= $alert -> getCategoryIcon() ?>"></i> <span style="padding-left: 10px"><?= $alert -> getCategoryName() ?></span></td>
                        <td class="col-xs-6"><?= $alert -> getMessage() ?></td>
                        <td class="col-xs-4"><?= $alert -> getTime() ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <!-- notifications end -->

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