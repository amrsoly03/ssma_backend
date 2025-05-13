<?php
include '../connect.php';

$subject_degree = filterRequest('subject_degree');
$std_degree = filterRequest('std_degree');

$final = filterRequest('final');
$mid = filterRequest('mid');
$practical = filterRequest('practical');

// Get current degree values
$query = $connect->prepare("SELECT final, mid, practical FROM degrees WHERE subject_degree = ? AND std_degree = ?");
$query->execute([$subject_degree, $std_degree]);
$current = $query->fetch(PDO::FETCH_ASSOC);

if (!$current) {
    echo json_encode(["status" => "failed", "message" => "Degree record not found"]);
    exit;
}

// Use provided values if not empty, otherwise keep current values
$final = ($final !== "") ? $final : $current['final'];
$mid = ($mid !== "") ? $mid : $current['mid'];
$practical = ($practical !== "") ? $practical : $current['practical'];

// Update the degrees table
$update = $connect->prepare("UPDATE degrees SET final = ?, mid = ?, practical = ? WHERE subject_degree = ? AND std_degree = ?");
$update->execute([$final, $mid, $practical, $subject_degree, $std_degree]);

$count = $update->rowCount();

if ($count > 0) {
    echo json_encode(["status" => "success", "message" => "Degree updated successfully"]);
} else {
    echo json_encode(["status" => "failed", "message" => "No changes made or update failed"]);
}
