<?php
require_once "../classes/class.helper_operator.php";
require_once "../classes/class.query_operator.php";
$all = "All";

$searchCategory = SessionOperator::getSearchSetting( SessionOperator::SEARCH_CATEGORY );

$searchString = SessionOperator::getSearchSetting( SessionOperator::SEARCH_STRING );

$superCategories = QueryOperator::getSuperCategoriesList();

$userId = SessionOperator::getUser() -> getUserId();

$allAlerts = count( QueryOperator::getNotifications( $userId ) );
$alerts = QueryOperator::getNotifications( $userId, QueryOperator::NOTIFICATION_UNSEEN );
$newAlerts = count($alerts);
?>
<script src="../js/custom/navigation.js"></script>
<!-- header start -->
<nav class="navbar navbar-default navbar-static-top navbar-top" role="navigation">

    <!-- header start -->
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="../index.php">
            <img src="../images/logo_short.png">
        </a>
    </div>
    <!-- header end -->

    <!-- search start -->
    <form class="navbar-form navbar-top-links navbar-left" method="GET" action="../scripts/search.php" role="search" >
        <div class="input-group input-group-lg" style="width: inherit">
            <div class="input-group-btn search-panel">
                <button type="button" class="form-control btn btn-default dropdown-toggle" data-toggle="dropdown" name="test">
                    <span id="search_concept"><?= htmlspecialchars(stripslashes($searchCategory)) ?></span> <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" id="scrollable-menu" role="menu">
                    <?php if ( !in_array( $searchCategory, $superCategories ) && $searchCategory != $all ) : ?>
                        <li><a href="#<?= $searchCategory ?>"><?= $searchCategory ?></a></li>
                    <?php endif ?>
                    <li><a href="#<?= $all ?>"><?= $all ?></a></li>
                    <li class="divider"></li>
                    <?php
                    foreach ( $superCategories as $category )
                    {
                        $category = htmlspecialchars( $category );
                        ?>
                        <li><a href="#<?= $category ?>"><?= $category ?></a></li>
                    <?php } ?>
                </ul>
            </div>
            <input type="hidden" name="searchCategory" value="<?= htmlspecialchars(stripslashes($searchCategory)) ?>" id="searchCategory">
            <input type="text" class="form-control" value="<?= htmlspecialchars(stripslashes($searchString)) ?>" style="width: 500px;" placeholder="Search for live auctions" name="searchString">
            <span class="input-group-btn">
                 <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
            </span>
        </div>
    </form>
    <!-- search end -->

    <!-- top menu start -->
    <ul class="nav navbar-top-links navbar-right">

        <!-- notifications start -->
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <span id="alertCounter" class="badge" <?php if( $newAlerts == 0 ) { echo "style=\"display:none\""; }?> ><?= $newAlerts ?></span>
                <i class="fa fa-bell fa-fw"></i> <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-alerts" id="alerts">
                <?php
                foreach ( $alerts as $alert ) {;
                    include "../includes/alert.php";
                }
                if ( $allAlerts > 0 ) { ?>
                    <li id="last">
                        <a class="text-center" href="../views/my_notifications_view.php">
                            <strong>See All Alerts</strong> <i class="fa fa-angle-right"></i>
                        </a>
                    </li>
                <?php } else { ?>
                    <li class="text-center" style="padding: 10px 0" id="last">
                        <strong>No Alerts Available</strong>
                    </li>
                <?php } ?>
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
                    <a href="../views/profile_view.php"><i class="fa fa-user fa-fw"></i> User Profile</a>
                </li>
                <li>
                    <a href="../views/account_view.php"><i class="fa fa-cog fa-fw"></i> Account Settings</a>
                </li>
                <li>
                    <a href="#" data-href="../scripts/logout.php" data-toggle="modal" data-target="#logout">
                        <i class="fa fa-sign-out fa-fw"></i> Logout
                    </a>
                </li>
            </ul>
        </li>
        <!-- account end-->

    </ul>
    <!-- top menu end -->

</nav>
<!-- header end -->


<!-- side menu start -->
<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            <li <?= HelperOperator::isActive()?> >
                <a href="#"><i class="fa fa-gavel fa-fw"></i> My Auctions<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="../views/my_live_auctions_view.php"><i class="fa fa-clock-o fa-fw"></i> Live Auctions</a>
                    </li>
                    <li>
                        <a href="../views/my_sold_auctions_view.php"><i class="fa fa-history fa-fw"></i> Sold Auctions</a>
                    </li>
                    <li>
                        <a href="../views/my_unsold_auctions_view.php"><i class="fa fa-minus-circle fa-fw"></i> Unsold Auctions</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#"><i class="fa fa-money fa-fw"></i> My Biddings<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="../views/my_current_bids_view.php"><i class="fa fa-clock-o fa-fw"></i> Current Bids</a>
                    </li>
                    <li>
                        <a href="../views/my_successful_bids_view.php"><i class="fa fa fa-thumbs-up fa-fw"></i> Won Auctions</a>
                    </li>
                    <li>
                        <a href="../views/my_unsuccessful_bids_view.php"><i class="fa fa-thumbs-down fa-fw"></i> Outbidded Auctions</a>
                    </li>

                </ul>
            </li>
            <li>
                <a href="../views/my_watch_list_view.php"><i class="fa fa-eye fa-fw"></i> My Watch List</a>
            </li>
            <li>
                <a href="../views/my_feedbacks_view.php?username=<?= SessionOperator::getUser() -> getUsername() ?>">
                    <i class="fa fa-envelope fa-fw"></i> My Feedbacks
                </a>
            </li>
        </ul>
    </div>
</div>
<!-- side menu end -->


<!-- logout modal start -->
<div class="modal fade" id="logout" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                Logout
            </div>
            <div class="modal-body">
                Are you sure you want to sign out?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a class="btn btn-danger btn-ok">Logout</a>
            </div>
        </div>
    </div>
</div>
<script>
    $('#logout').on('show.bs.modal', function(e) {
        $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
    });
</script>
<!-- logout modal end -->







