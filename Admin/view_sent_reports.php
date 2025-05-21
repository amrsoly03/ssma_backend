<?php
include '../connect.php';

//$std_report = filterRequest('std_report');

$statment = $connect->prepare('
    SELECT report.*, student.s_name 
    FROM report 
    JOIN student ON report.std_report = student.student_id 
    WHERE report.from_admin = false
');

$statment->execute();
$data = $statment->fetchAll(PDO::FETCH_ASSOC);
$count = $statment->rowCount();

if ($count > 0) {
    echo json_encode(array('status' => 'success', 'data' => $data), JSON_PRETTY_PRINT);
} else {
    echo json_encode(array('status' => 'failed', 'message' => 'no reports found'));
}
