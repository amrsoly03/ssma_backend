<?php
include '../connect.php'; 

$student_id = filterRequest('student_id');

$statement = $connect->prepare(
    "SELECT school_activities.* 
     FROM activity_subscriptions
     JOIN school_activities ON activity_subscriptions.activity_as = school_activities.activity_id
     WHERE activity_subscriptions.student_as = ? AND activity_subscriptions.as_approved = 0"
);

$statement->execute(array($student_id));
$data = $statement->fetchAll(PDO::FETCH_ASSOC);

if ($data) {
    echo json_encode(array("status" => "success", "data" => $data), JSON_PRETTY_PRINT);
} else {
    echo json_encode(array("status" => "failed", "message" => "No pending activity subscriptions found"));
}
?>
