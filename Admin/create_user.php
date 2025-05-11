<?php
include '../connect.php';

$s_name = filterRequest('s_name');
$email = filterRequest('email');
$student_password = filterRequest('student_password');
$parent_password = filterRequest('parent_password');
$grade = filterRequest('grade');

// create a new parent
$statment = $connect->prepare(
    'INSERT INTO `parent`( `email`, `parent_password`) VALUES (?,?)'
);

$statment->execute(array($email, $parent_password));

$parent_id = $connect->lastInsertId();

$count = $statment->rowCount();

// create a new student
$statment = $connect->prepare(
    'INSERT INTO `student`(`s_name`, `email`, `student_password`, `s_parent_id`, `grade`) VALUES (?,?,?,?,?)'
);

$statment->execute(array($s_name, $email, $student_password, $parent_id, $grade));

$count = $statment->rowCount();


if ($count > 0) {
    echo json_encode(array('status' => 'success'));
} else {
    echo json_encode(array('status' => 'failed'));
}
