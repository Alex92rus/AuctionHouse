<?php

class Auction
{
    private $auctionId;
    private $username;
    private $sellerUsername;
    private $quantity;
    private $startPrice;
    private $reservePrice;
    private $startTime;
    private $endTime;
    private $itemName;
    private $itemBrand;
    private $itemDescription;
    private $image;
    private $sold;
    private $categoryName;
    private $superCategoryName;
    private $conditionName;
    private $countryName;
    private $views;
    private $numBids;
    private $watchId; //for a watched Auction
    private $numWatches;
    private $highestBid;
    private $highestBidderId;
    private $highestBidderUsername;
    private $currentPrice;
    private $isUserWinning;
    private $hasBuyerFeedback;
    private $hasSellerFeedback;
    private $avgSellerFeedbackPercentage;
    private $numFeedbacksForSeller;

    public function __construct( $details )
    {
        foreach ( $details as $field => $value )
        {
            if(method_exists($this,"set" . ucfirst( $field ))){

                call_user_func( "Auction::" . "set" . ucfirst( $field ), $value );
            }
        }
    }

    /**
     * @return mixed
     */
    public function getAuctionId()
    {
        return $this->auctionId;
    }

    /**
     * @param mixed $auctionId
     */
    public function setAuctionId($auctionId)
    {
        $this->auctionId = $auctionId;
    }

    /**
     * @return mixed
     */
    public function getHighestBidderUsername()
    {
        return $this->highestBidderUsername;
    }

    /**
     * @param mixed $highestBidderUsername
     */
    public function setHighestBidderUsername($highestBidderUsername)
    {
        $this->highestBidderUsername = $highestBidderUsername;
    }

    /**
     * @return mixed
     */
    public function getSellerUsername()
    {
        return $this->sellerUsername;
    }

    /**
     * @param mixed $sellerUsername
     */
    public function setSellerUsername($sellerUsername)
    {
        $this->sellerUsername = $sellerUsername;
    }





    /**
     * @return mixed
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param mixed $quantity
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    /**
     * @return mixed
     */
    public function getStartPrice()
    {
        return $this->startPrice;
    }

    /**
     * @param mixed $startPrice
     */
    public function setStartPrice($startPrice)
    {
        $this->startPrice = $startPrice;
    }

    /**
     * @return mixed
     */
    public function getSold()
    {
        return $this->sold;
    }

    /**
     * @param mixed $sold
     */
    public function setSold($sold)
    {
        $this->sold = $sold;
    }


    /**
     * @return mixed
     */
    public function getReservePrice()
    {
        return $this->reservePrice;
    }


    /**
     * @param mixed $reservePrice
     */
    public function setReservePrice($reservePrice)
    {
        $this->reservePrice = $reservePrice;
    }


    /**
     * @return mixed
     */
    public function getStartTime()
    {
        return $this->startTime;
    }


    /**
     * @param mixed $startTime
     */
    public function setStartTime($startTime)
    {
        $this->startTime = $startTime;
    }


    /**
     * @return mixed
     */
    public function getEndTime()
    {
        return $this->endTime;
    }


    /**
     * @param mixed $endTime
     */
    public function setEndTime($endTime)
    {
        $this->endTime = $endTime;
    }


    /**
     * @return mixed
     */
    public function getItemName()
    {
        return $this->itemName;
    }


    /**
     * @param mixed $itemName
     */
    public function setItemName($itemName)
    {
        $this->itemName = $itemName;
    }


    /**
     * @return mixed
     */
    public function getItemBrand()
    {
        return $this->itemBrand;
    }


    /**
     * @param mixed $itemBrand
     */
    public function setItemBrand($itemBrand)
    {
        $this->itemBrand = $itemBrand;
    }


    /**
     * @return mixed
     */
    public function getItemDescription()
    {
        return $this->itemDescription;
    }


    /**
     * @param mixed $itemDescription
     */
    public function setItemDescription($itemDescription)
    {
        $this->itemDescription = $itemDescription;
    }


    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }


    /**
     * @param mixed $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }


    /**
     * @return mixed
     */
    public function getCategoryName()
    {
        return $this->categoryName;
    }


    /**
     * @param mixed $categoryName
     */
    public function setCategoryName($categoryName)
    {
        $this->categoryName = $categoryName;
    }


    /**
     * @return mixed
     */
    public function getSuperCategoryName()
    {
        return $this->superCategoryName;
    }


    /**
     * @param mixed $superCategoryName
     */
    public function setSuperCategoryName($superCategoryName)
    {
        $this->superCategoryName = $superCategoryName;
    }


    /**
     * @return mixed
     */
    public function getWatchId()
    {
        return $this->watchId;
    }


    /**
     * @param mixed $watchId
     */
    public function setWatchId($watchId)
    {
        $this->watchId = $watchId;
    }


    /**
     * @return mixed
     */
    public function getConditionName()
    {
        return $this->conditionName;
    }


    /**
     * @param mixed $conditionName
     */
    public function setConditionName($conditionName)
    {
        $this->conditionName = $conditionName;
    }

    /**
     * @return mixed
     */
    public function getCountryName()
    {
        return $this->countryName;
    }

    /**
     * @param mixed $countryName
     */
    public function setCountryName($countryName)
    {
        $this->countryName = $countryName;
    }



    /**
     * @return mixed
     */
    public function getNumBids()
    {
        return $this->numBids;
    }

    /**
     * @param mixed $numBids
     */
    public function setNumBids($numBids)
    {
        $this->numBids = $numBids;
    }


    /**
     * @return mixed
     */
    public function getViews()
    {
        return $this->views;
    }


    /**
     * @param mixed $views
     */
    public function setViews($views)
    {
        $this->views = $views;
    }


    /**
     * @return mixed
     */
    public function getHighestBid()
    {
        return $this->highestBid;
    }


    /**
     * @param mixed $highestBid
     */
    public function setHighestBid($highestBid)
    {
        $this->highestBid = $highestBid;
    }

    /**
     * @return mixed
     */
    public function getCurrentPrice()
    {
        return $this->currentPrice;
    }

    /**
     * @param mixed $currentPrice
     */
    public function setCurrentPrice($currentPrice)
    {
        $this->currentPrice = $currentPrice;
    }




    /**
     * @return mixed
     */
    public function getNumWatches()
    {
        return $this->numWatches;
    }


    /**
     * @param mixed $numWatches
     */
    public function setNumWatches($numWatches)
    {
        $this->numWatches = $numWatches;
    }

    /**
     * @return mixed
     */
    public function getHighestBidderId()
    {
        return $this->highestBidderId;
    }

    /**
     * @param mixed $highestBidderId
     */
    public function setHighestBidderId($highestBidderId)
    {
        $this->highestBidderId = $highestBidderId;
    }

    /**
     * @return mixed
     */
    public function getIsUserWinning()
    {
        return $this->isUserWinning;
    }

    /**
     * @param mixed $isUserWinning
     */
    public function setIsUserWinning($isUserWinning)
    {
        $this->isUserWinning = $isUserWinning;
    }


    /**
     * @return mixed
     */
    public function getHasBuyerFeedback()
    {
        return $this->hasBuyerFeedback;
    }

    /**
     * @param mixed $hasBuyerFeedback
     */
    public function setHasBuyerFeedback($hasBuyerFeedback)
    {
        $this->hasBuyerFeedback = $hasBuyerFeedback;
    }

    /**
     * @return mixed
     */
    public function getHasSellerFeedback()
    {
        return $this->hasSellerFeedback;
    }

    /**
     * @param mixed $hasSellerFeedback
     */
    public function setHasSellerFeedback($hasSellerFeedback)
    {
        $this->hasSellerFeedback = $hasSellerFeedback;
    }

    /**
     * @return mixed
     */
    public function getAvgSellerFeedbackPercentage()
    {
        return $this->avgSellerFeedbackPercentage;
    }

    /**
     * @param mixed $avgSellerFeedbackPercentage
     */
    public function setAvgSellerFeedbackPercentage($avgSellerFeedbackPercentage)
    {
        $this->avgSellerFeedbackPercentage = $avgSellerFeedbackPercentage;
    }

    /**
     * @return mixed
     */
    public function getNumFeedbacksForSeller()
    {
        return $this->numFeedbacksForSeller;
    }

    /**
     * @param mixed $numFeedbacksForSeller
     */
    public function setNumFeedbacksForSeller($numFeedbacksForSeller)
    {
        $this->numFeedbacksForSeller = $numFeedbacksForSeller;
    }






   }