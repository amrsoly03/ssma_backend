<?php
include '../connect.php';
$student_id = filterRequest('student_as');
$activity_id = filterRequest('activity_as');

// Check if a row already exists
$check = $connect->prepare(
    "SELECT * FROM activity_subscriptions WHERE student_as = ? AND activity_as = ?"
);
$check->execute(array($student_id, $activity_id));
$count = $check->rowCount();

if ($count > 0) {
    // Duplicate found — return failure message
    echo json_encode(array('status' => 'failed', 'message' => 'you are already subscribed to this activity'));
} else {
    // No duplicate — proceed with insert
    $insert = $connect->prepare(
        "INSERT INTO activity_subscriptions (student_as, activity_as) VALUES (?, ?)"
    );
    $insert->execute(array($student_id, $activity_id));
    $count = $insert->rowCount();

    if ($count > 0) {
        echo json_encode(["status" => "success", "message" => "Activity subscribed successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to subscribe to activity"]);
    }
}
