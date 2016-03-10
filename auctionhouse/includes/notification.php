<?php
if ( !is_null( $notification = SessionOperator::getNotification() ) ) : ?>
    <script>
        $.notify({
            icon: "glyphicon glyphicon-ok",
            title: <?php echo json_encode( $notification[ 0 ] ); ?>,
            message: <?php echo json_encode( $notification[ 1 ] ); ?>
        },{
            type: <?php echo json_encode( $notification[ 2 ] ); ?>
        });
    </script>
<?php endif ?>