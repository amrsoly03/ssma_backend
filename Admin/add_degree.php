<?php
include '../connect.php';
$student_id = filterRequest('student_id');
$subject_id = filterRequest('subject_id');
$grade = filterRequest('grade');
// create a new degree
$statment = $connect->prepare(
    'INSERT INTO `degrees`(`student_id`, `subject_id`, `grade`) VALUES (?,?,?)'
);
$statment->execute(array($student_id, $subject_id, $grade));
// check if the query was successful
$count = $statment->rowCount();
if ($count > 0) {
    echo json_encode(["status" => "success", "message" => "Degree added successfully"]);
} else {
    echo json_encode(["status" => "failed", "message" => "Failed to add degree"]);
}
