<?php
include '../connect.php';
$name = filterRequest('name');
$sub_quiz = filterRequest('sub_quiz');
// create a new quiz
$statment = $connect->prepare(
    query: 'INSERT INTO `quiz`(`name`, `sub_quiz`) VALUES (?,?)'
);
$statment->execute(array($name, $sub_quiz));

$count = $statment->rowCount();

if ($count > 0) {
    echo json_encode(["status" => "success", "message" => "Quiz added successfully"]);
} else {
    echo json_encode(["status" => "failed", "message" => "Failed to add quiz"]);
}
