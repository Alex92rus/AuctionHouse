<?php
$all = "All";

$searchCategory = SessionOperator::getSearchSetting( SessionOperator::SEARCH_CATEGORY );

$searchString = SessionOperator::getSearchSetting( SessionOperator::SEARCH_STRING );

$superCategories = QueryOperator::getSuperCategoriesList();
?>
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
                    <span id="search_concept"><?= $searchCategory ?></span> <span class="caret"></span>
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
            <input type="hidden" name="searchCategory" value="<?= $searchCategory ?>" id="searchCategory">
            <input type="text" class="form-control" value="<?= $searchString ?>" style="width: 500px;" placeholder="Search for live auctions" name="searchString">
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
                    <a href="../views/profile_view.php"><i class="fa fa-user fa-fw"></i> User Profile</a>
                </li>
                <li>
                    <a href="../views/account_view.php"><i class="fa fa-cog fa-fw"></i> Account Settings</a>
                </li>
                <li>
                    <a href="../scripts/logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
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

            <li>
                <a href="../views/dashboard_view.php"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
            </li>

            <li <?= isActive()?> >
                <a href="#"><i class="fa fa-gavel fa-fw"></i> My Auctions<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="../views/live_auctions_view.php"><i class="fa fa-clock-o fa-fw"></i> Live Auctions</a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-history fa-fw"></i> Sold Auctions</a>
                    </li>
                </ul>

            </li>

            <li>
                <a href="#"><i class="fa fa-money fa-fw"></i> My Biddings</a>
            </li>

            <li>
                <a href="#"><i class="fa fa-eye fa-fw"></i> My Watch List</a>
            </li>

        </ul>
    </div>
</div>
<!-- side menu end -->







