<?php
include '../connect.php'; 

$student_id = filterRequest('student_id');
$parent_password = filterRequest('parent_password');

$statement = $connect->prepare(
    "SELECT parent.*, student.student_id, student.s_name
     FROM parent
     JOIN student ON parent.parent_id = student.s_parent_id
     WHERE student.student_id = ? AND parent.parent_password = ?"
);

$statement->execute(array($student_id, $parent_password));
$data = $statement->fetch(PDO::FETCH_ASSOC);

if ($data) {
    echo json_encode(array("status" => "success", "data" => $data), JSON_PRETTY_PRINT);
} else {
    echo json_encode(array("status" => "failed", "message" => "Invalid student ID or password"));
}
?>
