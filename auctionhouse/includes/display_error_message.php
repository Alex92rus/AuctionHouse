<?php if ( ( $errors =  SessionOperator::getAllErrors() ) != null ) :  ?>
    <div class="alert alert-danger fade in">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Input error!</strong><br>
        <ul>
            <?php
            foreach ( $errors as $key => $message )
            {
                echo "<li>" . $message . "</li>";
            }
            ?>
        </ul>
    </div>
<?php endif ?>