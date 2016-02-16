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

            <li>
                <a href="#"><i class="fa fa-gavel fa-fw"></i> My Auctions<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="#"><i class="fa fa-clock-o fa-fw"></i> Current Auctions</a>
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







