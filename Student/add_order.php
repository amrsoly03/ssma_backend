<?php
include '../connect.php';
$order_student = filterRequest('order_student');

$statment = $connect->prepare(
    'INSERT INTO `order`(`order_student`) VALUES (?)'
);
$statment->execute(array($order_student));

$count = $statment->rowCount();
if ($count > 0) {

    $lastOrderId = $connect->lastInsertId();
    // Fetch the newly inserted order
    $fetch = $connect->prepare('SELECT * FROM `order` WHERE `order_id` = ?');
    $fetch->execute(array($lastOrderId));
    $data = $fetch->fetch(PDO::FETCH_ASSOC);

    echo json_encode(["status" => "success", "message" => "order added successfully", "data" => $data], JSON_PRETTY_PRINT);
} else {
    echo json_encode(["status" => "error", "message" => "Failed to add order"]);
}
