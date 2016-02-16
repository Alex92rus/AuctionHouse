<?php
if ( !is_null( $feedback = SessionOperator::getFeedback() ) ) : ?>
    <script>
        $.notify({
            icon: "glyphicon glyphicon-ok",
            title: <?php echo json_encode( $feedback[ 0 ] ); ?>,
            message: <?php echo json_encode( $feedback[ 1 ] ); ?>
        },{
            type: <?php echo json_encode( $feedback[ 2 ] ); ?>
        });
    </script>
<?php endif ?>