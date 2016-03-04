
<h5 class="text-danger"><span id="timer<?= $auction ->getAuctionId()?>"></span> left</h5>

<script type="text/javascript">
    var timerId = "#timer" + <?= json_encode( $auction -> getAuctionId() ) ?>;
    var endTime = <?= json_encode( $auction -> getEndTime() ) ?>;
    $(timerId).countdown( endTime, function(event) {
        $(this).text(
            event.strftime('%D days %H:%M:%S')
        );
    });
</script>