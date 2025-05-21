<?php
include '../connect.php';
$as_id = filterRequest('as_id');

$statment = $connect->prepare("UPDATE approvment_subject SET is_approved = true WHERE as_id = ? ");

$statment->execute(array($as_id));

$count = $statment->rowCount();


if ($count > 0) {
    // Get student_id and subject_id for the approved record
    $statement = $connect->prepare("SELECT as_student, as_subject FROM approvment_subject WHERE as_id = ?");
    $statement->execute(array($as_id));
    $row = $statement->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        $student_id = $row['as_student'];
        $subject_id = $row['as_subject'];

        // Insert degree record for this student and subject
        $insert = $connect->prepare("
            INSERT INTO degrees (std_degree, subject_degree, final, mid, practical)
            VALUES (?, ?, 0, 0, 0)
        ");
        $insert->execute(array($student_id, $subject_id));
        $count = $insert->rowCount();
    }
}

if ($count > 0) {
    echo json_encode(["status" => "success", "message" => "Subject approved successfully"]);
} else {
    echo json_encode(["status" => "failed", "message" => "Failed to approve subject"]);
};
