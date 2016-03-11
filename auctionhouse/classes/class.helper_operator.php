<?php

class HelperOperator
{
    // Redirect to a page
    public static function redirectTo( $page )
    {
        header( "Location: " . $page );
        exit();
    }


    // Add active class if necessary
    public static function isActive()
    {
        $current_file_name = basename( $_SERVER[ "REQUEST_URI" ], ".php" );


        if ( $current_file_name == "create_auction_view" )
        {
            echo 'class="active"';
        }
    }


    public static function ref_values($arr)
    {
        $refs = array();

        foreach ($arr as $key => $value)
        {
            $refs[$key] = &$arr[$key];
        }

        return $refs;
    }


    // Get increment for a current bid price
    public static function getIncrement( $current )
    {
        $increment = null;

        if ( 0.01 <= $current && $current <= 0.99 )
        {
            $increment = 0.05;
        }
        else if ( 1.00 <= $current && $current <= 4.99 )
        {
            $increment = 0.20;
        }
        else if ( 5.00 <= $current && $current <= 14.99 )
        {
            $increment = 0.50;
        }
        else if ( 15.00 <= $current && $current <= 59.99 )
        {
            $increment = 1.00;
        }
        else if ( 60.00 <= $current && $current <= 149.99 )
        {
            $increment = 2.00;
        }
        else if ( 150.00 <= $current && $current <= 299.99 )
        {
            $increment = 5.00;
        }
        else if ( 300.00 <= $current && $current <= 599.99 )
        {
            $increment = 10.00;
        }
        else if ( 300.00 <= $current && $current <= 599.99 )
        {
            $increment = 10.00;
        }
        else if ( 600.00 <= $current && $current <= 1499.99 )
        {
            $increment = 20.00;
        }
        else if ( 1500.00 <= $current && $current <= 2999.99 )
        {
            $increment = 50.00;
        }
        else
        {
            $increment = 100.00;
        }


        return $increment;
    }
}