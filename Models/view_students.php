<?php
include '../connect.php';

// Prepare the SQL query to fetch student data
$statement = $connect->prepare("
    SELECT student_id, s_name, student_password, grade, s_parent_id, email 
    FROM student
");

$statement->execute();
$data = $statement->fetchAll(PDO::FETCH_ASSOC);
$count = $statement->rowCount();

if ($count > 0) {
    echo json_encode(array('status' => 'success', 'data' => $data), JSON_PRETTY_PRINT);
} else {
    echo json_encode(array('status' => 'failed', 'message' => 'No students found'));
}
