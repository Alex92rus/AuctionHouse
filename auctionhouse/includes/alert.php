<li id="notification<?= $alert -> getNotificationId(); ?>">
    <a href="#">
        <div>
            <i class="<?= $alert -> getCategoryIcon() ?>"></i> <span style="padding-left: 10px"><?= $alert -> getCategoryName(); ?></span>
            <span class="pull-right text-muted small"><?= $alert -> getTime() ?></span><br>
            <div style="padding-left: 26px; color: #253b52; margin-bottom: 5px; font-style: italic; font-size: 12px"><?= $alert -> getMessage() ?></div>
            <span style="padding-left: 22px"><button class="btn btn-sm btn-default" id="deleteAlert_<?= $alert -> getNotificationId(); ?>">Delete</button></span>
        </div>
    </a>
</li>
<li class="divider" id="divider<?= $alert -> getNotificationId(); ?>"></li>

