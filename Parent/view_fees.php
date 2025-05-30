<?php
include '../connect.php'; 

$student_id = filterRequest('student_id');

$statement = $connect->prepare(
    "SELECT grade.fees 
     FROM student
     JOIN parent ON student.s_parent_id = parent.parent_id
     JOIN grade ON student.grade = grade.grade_id
     WHERE student.student_id = ? AND parent.fees_paid = 0"
);

$statement->execute(array($student_id));
$data = $statement->fetch(PDO::FETCH_ASSOC);

if ($data) {
    echo json_encode(array("status" => "success", "data" => $data), JSON_PRETTY_PRINT);
} else {
    echo json_encode(array("status" => "failed", "message" => "No unpaid fees found"));
}
?>
