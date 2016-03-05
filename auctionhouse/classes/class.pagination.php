<?php

class Pagination
{
    private $currentPage;
    private $perPage;
    private $totalCount;


    public function __construct( $currentPage = 1, $perPage, $totalCount = 0 )
    {
        $this -> currentPage = ( int ) $currentPage;
        $this -> perPage = ( int ) $perPage;
        $this -> totalCount = ( int ) $totalCount;
    }


    public function getCurrentPage()
    {
        return $this -> currentPage;
    }


    public function getTotalCount()
    {
        return $this -> totalCount;
    }


    public function fromTo()
    {
        $from = $this -> offset() + 1;
        $to = $this -> offset() + $this -> perPage;
        $to = $to < $this -> totalCount ? $to : $this -> totalCount;
        return $from . "-" . $to;
    }


    public function offset()
    {
        return ( $this -> currentPage - 1 ) * $this -> perPage;
    }


    public function totalPages()
    {
        return ceil( $this -> totalCount / $this -> perPage );
    }


    public function previousPage()
    {
        return $this -> currentPage - 1;
    }


    public function nextPage()
    {
        return $this -> currentPage + 1;
    }


    public function hasPreviousPage()
    {
        return $this -> previousPage() >= 1 ? true : false;
    }


    public function hasNextPage()
    {
        return $this -> nextPage() <= $this -> totalPages() ? true : false;
    }
}