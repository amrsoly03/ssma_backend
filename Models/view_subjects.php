<?php
include '../connect.php';

// Fetch all subjects
$subjectStmt = $connect->prepare("SELECT * FROM subject");
$subjectStmt->execute();
$subjects = $subjectStmt->fetchAll(PDO::FETCH_ASSOC);
$count = $subjectStmt->rowCount();

// Fetch all approvment_subject
$approvStmt = $connect->prepare("SELECT * FROM approvment_subject");
$approvStmt->execute();
$approvments = $approvStmt->fetchAll(PDO::FETCH_ASSOC);
$count = $approvStmt->rowCount();

if ($count > 0) {
    echo json_encode(array('status' => 'success', 'subjects' => $subjects, 'approvments' => $approvments), JSON_PRETTY_PRINT);
} else {
    echo json_encode(array('status' => 'failed', 'message' => 'No activities found'));
}
