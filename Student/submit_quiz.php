<?php 
include '../connect.php';
$qd_quiz = filterRequest('qd_quiz');
$qd_student= filterRequest('qd_student');

$statment = $connect->prepare(
    'INSERT INTO `quiz_done`(`qd_quiz`, `qd_student`, `is_done`) VALUES (?,?,1)'
);
$statment->execute(array($qd_quiz, $qd_student));
    
$count = $statment->rowCount();
if ($count > 0) {
    echo json_encode(["status" => "success", "message" => "quiz submitted successfully"]);  
} else {
    echo json_encode(["status" => "error", "message" => "Failed to submit quiz"]);
}
?>

