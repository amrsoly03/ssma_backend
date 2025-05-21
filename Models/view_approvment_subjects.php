<?php
include '../connect.php';

$statement = $connect->prepare("
SELECT 
    approvment_subject.as_id,
    approvment_subject.as_student AS as_student_id,
    student.s_name AS as_student,
    subject.name AS as_subject
    FROM approvment_subject
    JOIN student ON approvment_subject.as_student = student.student_id
    JOIN subject ON approvment_subject.as_subject = subject.subject_id
    WHERE approvment_subject.is_approved = 0
");

$statement->execute();

$data = $statement->fetchAll(PDO::FETCH_ASSOC);
$count = $statement->rowCount();

if ($count > 0) {
    echo json_encode(array('status' => 'success', 'data' => $data), JSON_PRETTY_PRINT);
} else {
    echo json_encode(array('status' => 'failed', 'message' => 'no approvment requests found'));
}
