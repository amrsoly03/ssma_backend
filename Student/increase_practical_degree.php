<?php
include '../connect.php'; 

$std_degree = filterRequest('std_degree');        // Student ID
$subject_degree = filterRequest('subject_degree');    // Subject ID
$increase_by = filterRequest('increase_by');  // How much to increase

$update = $connect->prepare(
    "UPDATE degrees 
     SET practical = practical + ? 
     WHERE std_degree = ? AND subject_degree = ?"
);

$success = $update->execute(array($increase_by, $std_degree, $subject_degree));
$count = $update->rowCount();

if ($count > 0) {
    echo json_encode(array('status' => 'success', 'message' => 'Practical degree increased by ' . $increase_by));
} else {
    echo json_encode(array('status' => 'failed', 'message' => 'Update failed or no matching record'));
}
?>
