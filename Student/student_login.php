<?php 
include '../connect.php';
$student_Id = filterRequest('student_Id');
$student_password = filterRequest('student_password');

$statment = $connect->prepare('SELECT * FROM `student` WHERE `student_Id` = ? And `student_password`= ?');
$statment -> execute(array($student_Id, $student_password));

$data = $statment-> fetch(PDO::FETCH_ASSOC);

$count = $statment -> rowCount();
if ($count > 0) {
    echo json_encode(array('status' => 'success', 'data' => $data), JSON_PRETTY_PRINT);
} else {
    echo json_encode(array('status' => 'failed', 'message' => 'Invalid ID or password'));
}   
