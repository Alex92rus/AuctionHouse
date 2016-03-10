<?php

class Feedback
{
    private $feedbackId;
    private $feedbackTime;
    private $itemName;
    private $itemBrand;
    private $creatorUsername;
    private $creatorImage;
    private $score;
    private $comment;


    function __construct( $details )
    {
        foreach ( $details as $field => $value )
        {
            if(method_exists($this,"set" . ucfirst( $field )))
            {

                call_user_func( "Feedback::" . "set" . ucfirst( $field ), $value );
            }
        }
    }


    /**
     * @return mixed
     */
    public function getFeedbackId()
    {
        return $this->feedbackId;
    }


    /**
     * @param mixed $feedbackId
     */
    public function setFeedbackId($feedbackId)
    {
        $this->feedbackId = $feedbackId;
    }


    /**
     * @return mixed
     */
    public function getFeedbackTime()
    {
        return $this->feedbackTime;
    }


    /**
     * @param mixed $feedbackId
     */
    public function setFeedbackTime($feedbackTime)
    {
        $this->feedbackTime = $feedbackTime;
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
    public function getCreatorUsername()
    {
        return $this->creatorUsername;
    }


    /**
     * @param mixed $creatorUsername
     */
    public function setCreatorUsername($creatorUsername)
    {
        $this->creatorUsername = $creatorUsername;
    }


    /**
     * @return mixed
     */
    public function getCreatorImage()
    {
        return $this->creatorImage;
    }


    /**
     * @param mixed $creatorImage
     */
    public function setCreatorImage($creatorImage)
    {
        $this->creatorImage = $creatorImage;
    }


    /**
     * @return mixed
     */
    public function getScore()
    {
        return $this->score;
    }


    /**
     * @param mixed $score
     */
    public function setScore($score)
    {
        $this->score = $score;
    }


    /**
     * @return mixed
     */
    public function getComment()
    {
        return $this->comment;
    }


    /**
     * @param mixed $comment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
    }
}