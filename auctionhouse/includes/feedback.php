<?php
/* @var Feedback $feedback */



$feedbackTime = new DateTime( $feedback -> getFeedbackTime() );
$month = substr( $feedbackTime -> format( 'F' ), 0, 3 );
$day = $feedbackTime -> format( 'd' );
$year = $feedbackTime -> format( 'Y' );

?>

<div class="row">
    <div class="col-xs-12">
        <div class="review-block">

            <div class="row">
                <div class="col-xs-2">
                    <img src="<?= $feedback -> getCreatorImage()?>" class="img-rounded img-responsive" style="height: 100px">
                    <div class="review-block-name">
                        <a href="<?php echo '../views/my_feedbacks_view.php?username=' . $feedback -> getCreatorUsername() ?>"><?= $feedback -> getCreatorUsername()?></a>
                    </div>
                    <div class="review-block-date"><?= $month . " " . $day . ", " . $year ?><br/><?= $feedbackTime -> format( "h:i A" ) ?></div>
                </div>
                <div class="col-xs-10">
                    <div class="review-block-rate">
                        <?php
                        for ( $index = 1; $index <= 5; $index++ ) {
                            $button = "<button type=\"button\" class=\"btn btn-xs";
                            if ( $index > $feedback -> getScore() ) {
                                $button .= " btn-default btn-grey\" ";
                            } else {
                                $button .= " btn-warning\" ";
                            }
                            $button .= " aria-label=\"Left Align\"><span class=\"glyphicon glyphicon-star\" aria-hidden=\"true\"></span></button> ";
                            echo $button;
                        }

                        ?>
                    </div>
                    <div class="review-block-title"><?= $feedback -> getItemName() . "-" . $feedback -> getItemBrand() ?></div>
                    <div class="review-block-description"><?= $feedback -> getComment() ?></div>
                </div>
            </div>

        </div>
    </div>
</div>