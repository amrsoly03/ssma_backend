<?php 
include '../connect.php';
$qd_quiz = filterRequest('qd_quiz');
$qd_student= filterRequest('qd_student');

$statment = $connect->prepare(
    'INSERT INTO `quiz_done`(`qd_quiz`, `qd_student`) VALUES (?,?)'
);
$statment->execute(array($qd_quiz, $qd_student));
    
$count = $statment->rowCount();
if ($count > 0) {
    echo json_encode(["status" => "success", "message" => "quiz sent successfully"]);  
} else {
    echo json_encode(["status" => "error", "message" => "Failed to send quiz"]);
}
?>

