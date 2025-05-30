<?php 
include '../connect.php';
$std_report = filterRequest('std_report');
$content= filterRequest('content');

// create a new report
$statment = $connect->prepare(
    'INSERT INTO `report`(`std_report`, `content`, `from_admin`) VALUES (?,?, false)'
);
$statment->execute(array($std_report, $content));
// check if the query was successful    
$count = $statment->rowCount();
if ($count > 0) {
    echo json_encode(["status" => "success", "message" => "Report sent successfully"]);  
} else {
    echo json_encode(["status" => "error", "message" => "Failed to send report"]);
}
?>

