<?php
include '../connect.php';

$question_quiz = filterRequest('question_quiz');

$statement = $connect->prepare("SELECT * FROM question WHERE question_quiz = ?");
$statement->execute(array($question_quiz));

$data = $statement->fetchAll(PDO::FETCH_ASSOC);
$count = $statement->rowCount();

if ($count > 0) {
    echo json_encode(array('status' => 'success', 'data' => $data), JSON_PRETTY_PRINT);
} else {
    echo json_encode(array('status' => 'failed', 'message' => 'no questions found'));
}
