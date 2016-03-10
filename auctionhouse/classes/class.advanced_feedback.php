<?php

class AdvancedFeedback
{
    private $oneStars;
    private $twoStars;
    private $threeStars;
    private $fourStars;
    private $fiveStars;
    private $total;

    private $feedbackAsSeller;
    private $feedbackAsBuyer;


    function __construct( $scores, $feedbackAsSeller, $feedbackAsBuyer )
    {
        if ( count( $scores ) == 5 )
        {
            $this -> oneStars = $scores[ 0 ];
            $this -> twoStars = $scores[ 1 ];
            $this -> threeStars = $scores[ 2 ];
            $this -> fourStars = $scores[ 3 ];
            $this -> fiveStars = $scores[ 4 ];
            $total = 0;
            foreach ( $scores as $score )
            {
                $total += $score;
            }
            $this -> total = $total;
        }
        $this -> feedbackAsSeller = $feedbackAsSeller;
        $this -> feedbackAsBuyer = $feedbackAsBuyer;
    }


    /**
     * @return int
     */
    public function getOneStars()
    {
        return $this->oneStars;
    }


    /**
     * @return int
     */
    public function getTwoStars()
    {
        return $this->twoStars;
    }


    /**
     * @return int
     */
    public function getThreeStars()
    {
        return $this->threeStars;
    }


    /**
     * @return int
     */
    public function getFourStars()
    {
        return $this->fourStars;
    }


    /**
     * @return int
     */
    public function getFiveStars()
    {
        return $this->fiveStars;
    }


    /**
     * @return double
     */
    public function getAverage()
    {
        $sum  = 1 * $this -> oneStars;
        $sum += 2 * $this -> twoStars;
        $sum += 3 * $this -> threeStars;
        $sum += 4 * $this -> fourStars;
        $sum += 5 * $this -> fiveStars;
        return ( $this -> total > 0 ) ? $sum / $this -> total : -1;
    }


    /**
     * @return int
     */
    public function getTotal()
    {
        return $this -> total;
    }


    /**
     * @return Feedback
     */
    public function getFeedbackAsSeller()
    {
        return $this -> feedbackAsSeller;
    }


    /**
     * @return Feedback
     */
    public function getFeedbackAsBuyer()
    {
        return $this -> feedbackAsBuyer;
    }
}