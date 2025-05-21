<?php
include '../connect.php';

$sub_grade = filterRequest('sub_grade');

// Fetch all subjects
$statement = $connect->prepare("SELECT * FROM subject WHERE sub_grade = ?");
$statement->execute([$sub_grade]);
$data = $statement->fetchAll(PDO::FETCH_ASSOC);
$count = $statement->rowCount();

// // Fetch all approvment_subject
// $approvStmt = $connect->prepare("SELECT * FROM approvment_subject");
// $approvStmt->execute();
// $approvments = $approvStmt->fetchAll(PDO::FETCH_ASSOC);
// $count = $approvStmt->rowCount();

if ($count > 0) {
    echo json_encode(array('status' => 'success', 'data' => $data), JSON_PRETTY_PRINT);
} else {
    echo json_encode(array('status' => 'failed', 'message' => 'No subjects found'));
}
