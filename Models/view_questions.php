<?php
include '../connect.php';

$statement = $connect->prepare("SELECT * FROM question");
$statement->execute();

$data = $statement->fetchAll(PDO::FETCH_ASSOC);
$count = $statement->rowCount();

if ($count > 0) {
    echo json_encode(array('status' => 'success', 'data' => $data), JSON_PRETTY_PRINT);
} else {
    echo json_encode(array('status' => 'failed', 'message' => 'no questions found'));
}
