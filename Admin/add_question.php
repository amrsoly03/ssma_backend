<?php
include '../connect.php';
$question_quiz = filterRequest('question_quiz');
$description = filterRequest('description');
$answer1 = filterRequest('answer1');
$answer2 = filterRequest('answer2');
$answer3 = filterRequest('answer3');
$right_answer = filterRequest('right_answer');
// create a new question
$statment = $connect->prepare(
    'INSERT INTO `question`(`question_quiz`, `description`, `answer1`, `answer2`, `answer3`, `right_answer`) VALUES (?,?,?,?,?,?)'
);
$statment->execute(array($question_quiz, $description, $answer1, $answer2, $answer3, $right_answer));

$count = $statment->rowCount();

if ($count > 0) {
    echo json_encode(["status" => "success", "message" => "Question added successfully"], JSON_PRETTY_PRINT);
} else {
    echo json_encode(["status" => "failed", "message" => "Failed to add question"]);
}
