<?php /* @var Auction $auction */ ?>
<?php /* @var String $feedbackReceiverUsername */ ?>
<div class="container">
    <div class="row">
        <div class="col-xs-6">
            <div class="well well-sm">
                <div class="text-right">
                    <a class="btn btn-success btn-green" href="#reviews-anchor" id="open-review-box">Leave feedback</a>
                </div>

                <div class="row" id="post-review-box" style="display:none;">
                    <div class="col-md-12">
                        <form accept-charset="UTF-8" action="../scripts/create_feedback.php" method="post">
                            <input id="score-hidden" name="score" type="hidden">
                            <input id="receiverUsername" name="receiverUsername" type="hidden" value="<?= $feedbackReceiverUsername?>">
                            <input id="origin" name="origin" type="hidden" value="<?= $origin?>">
                            <input id="auctionId" name="auctionId" type="hidden" value="<?= $auction->getAuctionId()?>">
                            <textarea class="form-control animated" cols="50" id="new-review" name="comment" placeholder="Leave your feedback comment here..." rows="5"></textarea>

                            <div class="text-right">
                                <div class="stars starrr" data-rating="0"></div>
                                <a class="btn btn-danger btn-sm" href="#" id="close-review-box" style="display:none; margin-right: 10px;">
                                    <span class="glyphicon glyphicon-remove"></span>Cancel</a>
                                <button class="btn btn-success btn-lg" type="submit" name="createFeedback">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>