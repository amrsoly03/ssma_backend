<?php
include '../connect.php';

$student_id = filterRequest('student_id');
$s_name = filterRequest('s_name');
$email = filterRequest('email');
$student_password = filterRequest('student_password');
$parent_password = filterRequest('parent_password');

// Get current student and parent info
$studentQuery = $connect->prepare("SELECT s_name, email, student_password, s_parent_id FROM student WHERE student_id = ?");
$studentQuery->execute([$student_id]);
$student = $studentQuery->fetch(PDO::FETCH_ASSOC);

if (!$student) {
    echo json_encode(["status" => "failed", "message" => "Student not found"]);
    exit;
}

$s_parent_id = $student['s_parent_id'];

// Use current values if new ones aren't provided
$s_name = $s_name ?: $student['s_name'];
$email = $email ?: $student['email'];
$student_password = $student_password ?: $student['student_password'];

// Update student
$updateStudent = $connect->prepare("UPDATE student SET s_name = ?, email = ?, student_password = ? WHERE student_id = ?");
$updateStudent->execute([$s_name, $email, $student_password, $student_id]);
$count = $updateStudent->rowCount();

// If parent password is provided, update it
if (!empty($parent_password)) {
    $updateParent = $connect->prepare("UPDATE parent SET parent_password = ? WHERE parent_id = ?");
    $updateParent->execute([$parent_password, $s_parent_id]);
}

if ($count > 0) {
    echo json_encode(["status" => "success", "message" => "Student updated successfully"]);
} else {
    echo json_encode(["status" => "failed", "message" => "No changes made or update failed"]);
}