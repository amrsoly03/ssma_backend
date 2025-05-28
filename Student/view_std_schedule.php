<?php 
include '../connect.php';
$grade_id = filterRequest('grade_id');

$statment = $connect->prepare('SELECT `schedule_image` FROM `grade` WHERE `grade_id` = ?');
$statment->execute(array($grade_id));

$data = $statment->fetch(PDO::FETCH_ASSOC);
$count = $statment->rowCount();

if ($count > 0) {
    echo json_encode(array('status' => 'success', 'data' => $data), JSON_PRETTY_PRINT);
} else {
    echo json_encode(array('status' => 'failed', 'message' => 'No schedule found'));
}
?>
