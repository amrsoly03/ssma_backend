<?php
include '../connect.php';

$std_report = filterRequest('std_report');

$statment = $connect->prepare('SELECT * FROM `report` WHERE `std_report` = ?');

$statment->execute(array($std_report));
$data = $statment->fetchAll(PDO::FETCH_ASSOC);
$count = $statment->rowCount();


if ($count > 0) {
    echo json_encode(array('status' => 'success', 'data' => $data));
} else {
    echo json_encode(array('status' => 'failed'));
}
