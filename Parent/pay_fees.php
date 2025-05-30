<?php
include '../connect.php'; 

$parent_id = filterRequest('parent_id');

// Step 1: Get the parent's coin balance
$parentStmt = $connect->prepare("SELECT coins FROM parent WHERE parent_id = ?");
$parentStmt->execute([$parent_id]);
$parent = $parentStmt->fetch(PDO::FETCH_ASSOC);

if (!$parent) {
    echo json_encode(["status" => "failed", "message" => "Parent not found"]);
    exit;
}

$coins = $parent['coins'];

// Step 2: Get the minimum fee among this parent's students' grades
$feeStmt = $connect->prepare(
    "SELECT MIN(grade.fees) AS required_fees 
     FROM student 
     JOIN grade ON student.grade = grade.grade_id 
     WHERE student.s_parent_id = ?"
);
$feeStmt->execute([$parent_id]);
$feeResult = $feeStmt->fetch(PDO::FETCH_ASSOC);
$required_fees = $feeResult['required_fees'];

if ($coins < $required_fees) {
    echo json_encode(["status" => "failed", "message" => "not enough coins"]);
    exit;
}

// Step 3: Update parent to mark fees as paid
$updateStudent = $connect->prepare(
    "UPDATE parent SET fees_paid = 1 WHERE parent_id = ?"
);
$updateStudent->execute([$parent_id]);

// Step 4: Deduct coins from parent
$updateCoins = $connect->prepare(
    "UPDATE parent SET coins = coins - ? WHERE parent_id = ?"
);
$updateCoins->execute([$required_fees, $parent_id]);

echo json_encode(["status" => "success", "message" => "Fees paid successfully"]);
?>
