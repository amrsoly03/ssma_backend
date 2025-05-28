<?php
include '../connect.php'; 
$student_id = filterRequest('student_id');

$statement = $connect->prepare(
    "SELECT quiz.*, subject.name AS sub_quiz_name
     FROM quiz
     JOIN subject ON quiz.sub_quiz = subject.subject_id
     JOIN student ON student.grade = subject.sub_grade
     LEFT JOIN quiz_done ON quiz.quiz_id = quiz_done.qd_quiz AND quiz_done.qd_student = student.student_id
     WHERE student.student_id = ? AND (quiz_done.is_done IS NULL OR quiz_done.is_done = 0)
     ORDER BY quiz.quiz_id ASC"
);

$statement->execute(array($student_id));
$data = $statement->fetchAll(PDO::FETCH_ASSOC);
$count = $statement->rowCount();

if ($count > 0) {
    echo json_encode(array('status' => 'success', 'data' => $data), JSON_PRETTY_PRINT);
} else {
    echo json_encode(array('status' => 'failed', 'message' => 'No unattempted quizzes found'));
}
?>
