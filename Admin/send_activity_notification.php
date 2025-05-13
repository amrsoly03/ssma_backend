<?php
include '../connect.php';
$activity_an = filterRequest('activity_an');
$content = filterRequest('content');

// create a new notification
$statment = $connect->prepare(
    'INSERT INTO `activity_notifications`(`activity_an`, `content`) VALUES (?,?)'
);
$statment->execute(array($activity_an, $content));
$count = $statment->rowCount();

if ($count > 0) {
    echo json_encode(["status" => "success", "message" => "Notification sent successfully"]);
} else {
    echo json_encode(["status" => "error", "message" => "Failed to send notification"]);
}
