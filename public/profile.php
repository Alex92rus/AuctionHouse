<?php
require_once "classes/class.session_operator.php";
require_once "scripts/helperfunctions.php";
require_once "scripts/user_session.php";
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
    <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/metisMenu.min.css" rel="stylesheet">
    <link href="css/sb-admin-2.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">

    <!-- JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/bootstrap-notify.min.js"></script>
    <script src="js/metisMenu.min.js"></script>
    <script src="js/sb-admin-2.js"></script>
    <script src="js/auctionhouse.js"></script>
    <script src="js/bootstrap.file-input.js"></script>
</head>

<body>

    <div id="wrapper">

        <!-- top menu start -->
        <nav class="navbar navbar-default navbar-static-top navbar-top" role="navigation">

            <!-- header start -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">
                    <img src="images/logo_short.png">
                </a>
            </div>
            <!-- header end -->

            <!-- search start -->
            <form class="navbar-form navbar-top-links navbar-left" role="search" >
                <div class="input-group input-group-lg" style="width: inherit">
                    <div class="input-group-btn search-panel">
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                            <span id="search_concept">All</span> <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#contains">Example 1</a></li>
                            <li><a href="#its_equal">Example 2</a></li>
                            <li><a href="#greather_than">Example 3</a></li>
                            <li><a href="#less_than">Example 4</a></li>
                            <li class="divider"></li>
                            <li><a href="#all">All</a></li>
                        </ul>
                    </div>
                    <input type="text" class="form-control" style="width: 500px;" placeholder="Search for live auctions">
                    <span class="input-group-btn">
                         <button type="button" class="btn btn-primary"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
                    </span>
                </div>
            </form>
            <!-- search end -->

            <!-- right side start -->
            <ul class="nav navbar-top-links navbar-right">

                <!-- notifications start -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-bell fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-alerts">
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-comment fa-fw"></i> New Comment
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-twitter fa-fw"></i> 3 New Followers
                                    <span class="pull-right text-muted small">12 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-envelope fa-fw"></i> Message Sent
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-tasks fa-fw"></i> New Task
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-upload fa-fw"></i> Server Rebooted
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- notifications end -->

                <!-- account start -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li>
                            <a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                        </li>
                        <li>
                            <a href="../app/scripts/logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                </li>
                <!-- account end-->

            </ul>
            <!-- right side end -->

        </nav>
        <!-- top menu end -->


        <!-- side menu start -->
        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">

                    <li>
                        <a href="index.html"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                    </li>

                    <li>
                        <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Charts<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="flot.html">Flot Charts</a>
                            </li>
                            <li>
                                <a href="morris.html">Morris.js Charts</a>
                            </li>
                        </ul>
                    </li>

                </ul>
            </div>
        </div>
        <!-- side menu end -->



        <!-- main start -->
        <div id="page-wrapper">
            <!-- profile header start -->
            <div class="col-xs-12 page-header">
                <div class="col-xs-6">
                    <h2>Profile Details</h2>
                </div>
                <div class="col-xs-6">
                    <a class="btn btn-danger pull-right" id="changePassword" data-toggle="modal" data-toogle="popover" href="#changePasswordModal" title="Password" data-content="Your password was successfully changed" data-placement="right">
                        <span class="glyphicon glyphicon-edit"></span> Change Password
                    </a>
                </div>
            </div>
            <!-- profile header end -->

            <!-- profile image start -->
            <div class="col-xs-4">
                <img src="images/blank_profile_image.png" class="img-responsive">
                <form action="../app/scripts/upload_photo.php" method="POST" class="text-center" enctype="multipart/form-data">
                    <input type="file" data-filename-placement="inside" name="profileImage">
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary" name="upload"><span class="glyphicon glyphicon-upload"></span> Upload</button>
                    </div>
                </form>
                <?php echo SessionOperator::getInputErrors( "upload" ) ?>
            </div>
            <!-- profile image end -->

            <!-- profile details start -->
            <form action="" method="post" class="col-xs-8 form-horizontal" role="form" >
                <div class="form-group">
                    <label class="col-xs-2 control-label">Username</label>
                    <div class="col-xs-10">
                        <input type="text" class="form-control" name="username" value="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-2 control-label">Email</label>
                    <div class="col-xs-10">
                        <input type="text" class="form-control" name="email" value="">
                    </div>
                </div>
                <div class="form-group" >
                    <label class="col-xs-2 control-label">First Name</label>
                    <div class="col-xs-10">
                        <input type="text" class="form-control" name="firstName" value="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-2 control-label">Last Name</label>
                    <div class="col-xs-10">
                        <input type="text" class="form-control" name="lastName" value="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-2 control-label">Address</label>
                    <div class="col-xs-10">
                        <input type="text" class="form-control" name="address" value="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-2 control-label">Postcode</label>
                    <div class="col-xs-10">
                        <input type="text" class="form-control" name="postcode" value="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-2 control-label">City</label>
                    <div class="col-xs-10">
                        <input type="text" class="form-control" name="City" value="">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-2 control-label">Country</label>
                    <div class="col-xs-10">
                        <input type="text" class="form-control" name="country" value="">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-offset-2 col-xs-10">
                        <button type="submit" class="btn btn-primary" name="save"><span class="glyphicon glyphicon-save"></span> Save Changes</button>
                    </div>
                </div>
            </form>
            <!-- profile details end -->

        </div>
        <!-- main end -->


    </div>
    <!-- /#wrapper -->

</body>

</html>