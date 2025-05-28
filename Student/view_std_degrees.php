<?php 
include '../connect.php'; 
$std_degree = filterRequest('std_degree');

$statment = $connect->prepare(
    'SELECT degrees.*, subject.name AS subject_degree_name 
     FROM degrees 
     JOIN subject ON degrees.subject_degree = subject.subject_id 
     WHERE degrees.std_degree = ?'
);

$statment->execute(array($std_degree));
$data = $statment->fetchAll(PDO::FETCH_ASSOC);
$count = $statment->rowCount();

if ($count > 0) {
    echo json_encode(array('status' => 'success', 'data' => $data), JSON_PRETTY_PRINT);
} else {
    echo json_encode(array('status' => 'failed', 'message' => 'No degree found'));
}
?>
