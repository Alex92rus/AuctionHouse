<?php
$recommendedAuctions = QueryOperator::getBuyersRecommendedAuctions( SessionOperator::getUser()->getUserId());

if(count($recommendedAuctions ) < 20 )
{
    $recommendedAuctions = array_merge($recommendedAuctions, QueryOperator::getMostPopularAuctions(20 - count($recommendedAuctions )));
}

?>

<!-- recommendations start -->
<div class="panel panel-default recommendation-box" <?php if ( $page == "search" ) :?>style="margin-top: 60px"<?php endif ?>>

    <div class="panel-heading">
        <h5>
            <?php /*if ($collaborative){
                echo "Recommended auctions inspired by your bidding history";
            }else{
                echo "The Most popular auctions right now";
            }*/
                echo "Recommended auctions";
            ?>

        </h5>
    </div>

    <div class="panel-body">

        <div class="carousel slide" id="myCarousel" data-interval="false" data-ride="carousel">
            <div class="carousel-inner">

                <?php for ($splitIndex= 0 ; $splitIndex < ceil(count($recommendedAuctions) / 4 ); $splitIndex++){ ?>
                    <div class="item <?php echo $splitIndex == 0 ? ' active' : '';?>">
                        <ul class="thumbnails recommendations">

                        <?php for ($index = $splitIndex * 4 ; $index < (min(count($recommendedAuctions), ($splitIndex +1) *4)) ; $index++){
                            /* @var Auction $auction */
                            $auction = $recommendedAuctions[$index]; ?>
                            <li class="col-xs-3">
                                <div class="fff">
                                    <div class="thumbnail">
                                        <a href="../views/open_live_auction_view.php?liveAuction=<?=$auction->getAuctionId()?>&o=<?=basename($_SERVER["REQUEST_URI"])?>">
                                            <img src="<?= $auction->getImage() ?>" class="img-responsive" style="height:120px;">
                                        </a>
                                    </div>
                                    <div class="caption">
                                        <h5 class="text-info">
                                            <a href="../views/open_live_auction_view.php?liveAuction=<?=$auction->getAuctionId()?>">
                                                <?= $auction->getItemName() ?><br>
                                                <small><?= $auction->getItemBrand() ?></small>
                                            </a>
                                        </h5>
                                        <h5>
                                            <strong>
                                                <?= "£". $auction->getCurrentPrice()?>

                                            </strong><small> | <?= $auction->getNumBids() ?> Bids</small>
                                        </h5>
                                    </div>
                                </div>
                            </li>

                        <?php
                        }?>
                        </ul>
                    </div>
                <?php
                }?>
            </div>

            <nav>
                <ul class="control-box">
                    <li><a data-slide="prev" href="#myCarousel" class="left carousel-control"><i class="glyphicon glyphicon-chevron-left"></i></a></li>
                    <li><a data-slide="next" href="#myCarousel" class="right carousel-control"><i class="glyphicon glyphicon-chevron-right"></i></a></li>
                </ul>
            </nav>

        </div>
    </div>

</div>
<!-- recommendations end -->