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

$quiz_id = $connect->lastInsertId();
$statement = $connect->prepare("SELECT * FROM quiz WHERE quiz_id = ?");
$statement->execute(array($quiz_id));
$data = $statement->fetch(PDO::FETCH_ASSOC);

if ($count > 0) {
    echo json_encode(["status" => "success", "message" => "Quiz added successfully", "data" => $data] , JSON_PRETTY_PRINT);
} else {
    echo json_encode(["status" => "failed", "message" => "Failed to add quiz"]);
}
