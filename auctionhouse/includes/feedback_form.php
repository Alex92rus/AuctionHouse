<?php
/* @var Auction $auction */
/* @var String $feedbackReceiverUsername */
$seller = $feedbackType == "Leave Seller Feedback";
$auctionId = $auction->getAuctionId();
?>

<div class="<?php if ( $seller ) { echo "row";}else{ echo "col-xs-6";}?>">
    <?php if ( $seller ) : ?><div class="col-xs-12"><?php endif ?>

        <div class="<?php if ( !$seller ) { echo "text-right";}?>" style="margin-bottom: 10px">
            <a class="btn btn-success btn-green open-review-box" href="#reviews-anchor" id="open-review-box-<?= $auctionId ?>" data-id="post-review-box-<?= $auctionId ?>"><?= $feedbackType ?> <i class="fa fa-caret-down"></i></a>
        </div>

        <div class="row post-review-box" id="post-review-box-<?= $auctionId ?>" style="display:none;">
            <div class="col-md-12">
                <form accept-charset="UTF-8" action="../scripts/create_feedback.php" method="post">
                    <input id="score-hidden" name="score" type="hidden">
                    <input id="receiverUsername" name="receiverUsername" type="hidden" value="<?= $feedbackReceiverUsername?>">
                    <input id="origin" name="origin" type="hidden" value="<?= $origin ?>">
                    <input id="auctionId" name="auctionId" type="hidden" value="<?= $auctionId ?>">
                    <textarea class="form-control animated new-review" cols="50" id="new-review" name="comment" placeholder="Leave your feedback comment here..." rows="5" maxlength="500"></textarea>
                    <div class="row" style="margin-top: 7px">
                        <div class="col-xs-6 feedback-menu">
                            <div class="pull-left stars starrr" data-rating="0"></div>
                        </div>
                        <div class="col-xs-6 feedback-menu text-right">
                            <a class="btn btn-sm btn-danger close-review-box" href="#" id="close-review-box" data-id="post-review-box-<?= $auctionId ?>" style="display:none; margin-right: 10px;">Cancel</a>
                            <button class="btn btn-sm btn-success" type="submit" name="createFeedback">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    <?php if ( $seller ) : ?></div><?php endif ?>
</div>

