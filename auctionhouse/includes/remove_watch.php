<?php /* @var Auction $auction */ ?>

<div class="col-xs-4 auction-navigation">
    <div class="btn-group pull-right">
        <a
            href="#" data-href="../scripts/delete_watch.php?id=<?=$auction->getWatchId()?>"
            data-toggle="modal" data-target="#confirm-delete" class="btn btn-default">
            <span class="glyphicon glyphicon-trash"></span> Remove
        </a>
    </div>
</div>