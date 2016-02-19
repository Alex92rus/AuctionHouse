<!-- panel start -->
<div class="panel panel-default">

    <!-- header start -->
    <div class="panel-heading clearfix">
        <h4 class="pull-left">Time remaining:</h4>
        <div class="pull-right auction-navigation">
            <div class="btn-group pull-right">
                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                    <span class="glyphicon glyphicon-cog"></span>
                </button>
                <ul class="dropdown-menu slidedown">
                    <li><a href="#"><span class="glyphicon glyphicon-pencil"></span>Edit</a></li>
                    <li><a href="#"><span class="glyphicon glyphicon-trash"></span>Delete</a></li>
                </ul>
            </div>
        </div>
    </div>
    <!-- header end -->

    <!-- body start -->
    <div class="panel-body">

        <div class="row">
            <div class="col-xs-2">
                <img src="../uploads/profile_images/blank_profile.png" class="img-responsive img-rounded">
            </div>
            <div class="col-xs-10">
                <div class="row">
                    <div class="col-xs-9">
                        <h3>
                            Item Name<br>
                            <small>Item brand</small>
                        </h3>
                        <p class="text-danger">
                            <i class="fa fa-money"></i> <strong>Bids 4</strong> |
                            <i class="fa fa-eye"></i> <strong>Views 10</strong> |
                            <i class="fa fa-desktop"></i> <strong>Watching 4</strong>
                        </p>
                    </div>
                    <div class="col-xs-3">
                        <div class="current-bid text-center">
                            <h3 class="text-success">£20</h3>
                            <small>Current bid by</small><br>
                            <small><strong>SickAustrian</strong></small>
                        </div>
                    </div>
                </div><hr>

                <div class="row">
                    <div class="col-xs-2"><p class="p-title"><i class="fa fa-tags"></i> <strong>Category</strong></p></div>
                    <div class="col-xs-3"><p class="p-info">Text</p></div>
                    <div class="col-xs-2"><p class="p-title"><i class="fa fa-plus-square"></i> <strong>Condition</strong></p></div>
                    <div class="col-xs-3"><p class="p-info">Text Text Text Text</p></div>
                </div>
                <div class="row">
                    <div class="col-xs-2"><p class="p-title"><i class="fa fa-shopping-cart"></i> <strong>Quantity</strong></p></div>
                    <div class="col-xs-3"><p class="p-info">Text Text Text Text</p></div>
                    <div class="col-xs-2"><p class="p-title"><i class="fa fa-hand-paper-o"></i> <strong>Reserve Price</strong></p></div>
                    <div class="col-xs-3"><p class="p-info">£1000</p></div>
                </div>

                <!-- hidden start -->
                <div id="more-details-1">

                    <!-- item times start -->
                    <div class="row">
                        <div class="col-xs-2"><p class="p-title"><i class="fa fa-calendar-check-o"></i> <strong>Start Time</strong></p></div>
                        <div class="col-xs-3"><p class="p-info">13/02/2016 5:00 PM</p></div>
                        <div class="col-xs-2"><p class="p-title"><i class="fa fa-calendar-times-o"></i> <strong>End Time</strong></p></div>
                        <div class="col-xs-3"><p class="p-info">14/02/2016 2:00 PM</p></div>
                    </div>
                    <!-- item times end -->

                    <!-- item description start -->
                    <div class="row">
                        <div class="col-xs-2"><p class="p-title"><i class="fa fa-eye"></i> <strong>Description</strong></p></div>
                        <div class="col-xs-10">
                            <p class="p-info text-justify">
                                UK Prime Minister David Cameron has resumed talks at the EU summit saying there had been "some progress" overnight but "there's still no deal".
                                Mr Cameron was negotiating until 05:30 GMT and is now holding one-to-one meetings with EU leaders.
                                He aims to get a deal by the end of the two day summit later on Friday so that he can push ahead with plans for a referendum in June.
                                But significant sticking points remain on benefit curbs and EU regulations.
                                Follow the latest developments with the BBC's EU Summit live
                                European Council President Donald Tusk said there had been "some progress" but "a lot still remains to be done".
                                The aim is to try and reach a deal at an "English lunch" from 12:30 GMT.
                                German Chancellor Angela Merkel was reported by the Reuters news agency as saying it had become "clear that agreement will not be easy for many, but that the will is there".
                            </p>
                        </div>
                    </div><hr>
                    <!-- item description end -->

                    <!-- bidding history start -->
                    <div class="row">
                        <div class="col-xs-12">
                            <h4>Bidding History</h4>
                        </div>
                    </div>
                    <?php include "../includes/bidding_table.php" ?><hr>
                    <!-- bidding history end -->

                </div>
                <!-- hidden end -->

            </div>
        </div>

    </div>
    <!-- body end -->

    <!-- footer start -->
    <div class="panel-footer">
        <div class="row toggle text-center" id="more-details" data-toggle="more-details-1">
        <i id="view-all" class="fa fa-chevron-down fa-2x"></i>
        </div>
    </div>
    <!-- footer end -->

</div>
<!-- panel end -->