<?php
require_once "../classes/class.session_operator.php";
require_once "../classes/class.query_operator.php";

$newAlerts = QueryOperator::getNotifications( SessionOperator::getUser() -> getUserId(), QueryOperator::NOTIFICATION_UNNOTIFIED );

$alerts = null;
foreach ( $newAlerts as $newAlert )
{
    $alerts .= "
        <li id=\"notification{$newAlert -> getNotificationId()}\">
            <a href=\"#\">
                <div>
                    <i class=\"{$newAlert -> getCategoryIcon()}\"></i> <span style=\"padding-left: 10px\">{$newAlert -> getCategoryName()}</span>
                    <span class=\"pull-right text-muted small\">{$newAlert -> getTime()}</span><br>
                    <span style=\"padding-left: 26px; color: #253b52; font-style: italic; font-size: 12px\">{$newAlert -> getItemName()}</span><br>
                    <span style=\"padding-left: 26px; color: #253b52; font-style: italic; font-size: 12px\">{$newAlert -> getItemBrand()}</span><br>
                    <span style=\"padding-left: 22px\"><button class=\"btn btn-sm btn-default\" id=\"deleteAlert_{$newAlert -> getNotificationId()}\">Delete</button></span>
                </div>
            </a>
        </li>
        <li class=\"divider\" id=\"divider{$newAlert -> getNotificationId()}\"></li>
    ";
}
echo $alerts;