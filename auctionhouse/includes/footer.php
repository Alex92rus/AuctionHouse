<?php
$date = new DateTime( "now", new DateTimeZone( TIMEZONE ) );
?>

<div class="footer">
    <div class="container">
        <div class="navbar-text pull-left">
            <p>Copyright &copy; <?= $date -> format( "Y" ) ?> AuctionHouse</p>
        </div>
        <div class="navbar-text pull-right">
            <p><a href="#">About</a> |  <a href="#">Contact</a> |  <a href="#">Privacy & Cookies</a> |  <a href="#">Developers</a></p>
        </div>
    </div>
</div>