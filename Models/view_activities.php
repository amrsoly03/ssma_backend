<?php
include '../connect.php';

// Select all columns except 'type'
$statement = $connect->prepare("
    SELECT activity_id, name, description, image 
    FROM school_activities
");

$statement->execute();
$data = $statement->fetchAll(PDO::FETCH_ASSOC);
$count = $statement->rowCount();

if ($count > 0) {
    echo json_encode(array('status' => 'success', 'data' => $data), JSON_PRETTY_PRINT);
} else {
    echo json_encode(array('status' => 'failed', 'message' => 'No activities found'));
}
