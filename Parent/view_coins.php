<?php
include '../connect.php';

$parent_id = filterRequest('parent_id');

$statment = $connect->prepare('SELECT `coins` FROM `parent` WHERE `parent_id` = ?');

$statment->execute(array($parent_id));
$data = $statment->fetchAll(PDO::FETCH_ASSOC);
$count = $statment->rowCount();

if ($count > 0) {
    echo json_encode(array('status' => 'success', 'data' => $data), JSON_PRETTY_PRINT);
} else {
    echo json_encode(array('status' => 'failed', 'message' => 'no reports found'));
}
