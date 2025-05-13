<?php
include '../connect.php';
$as_id = filterRequest('as_id');

$statment = $connect->prepare("UPDATE approvment_subject SET 	is_approved = true WHERE as_id = ? ");

$statment->execute(array($as_id));

$count = $statment->rowCount();

if ($count > 0) {
    echo json_encode(["status" => "success", "message" => "Subject approved successfully"]);
} else {
    echo json_encode(["status" => "failed", "message" => "Failed to approve subject"]);
};
