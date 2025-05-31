<?php 
include '../connect.php';

$student_id = filterRequest('student_id');

$statment = $connect->prepare(
    'SELECT grade.schedule_image 
     FROM student 
     JOIN grade ON student.grade = grade.grade_id 
     WHERE student.student_id = ?'
);

$statment->execute(array($student_id));

$data = $statment->fetch(PDO::FETCH_ASSOC);
$count = $statment->rowCount();

if ($count > 0) {
    echo json_encode(array('status' => 'success', 'data' => $data), JSON_PRETTY_PRINT);
} else {
    echo json_encode(array('status' => 'failed', 'message' => 'No schedule found'));
}
?>
