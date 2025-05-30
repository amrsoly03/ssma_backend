<?php
include '../connect.php'; 

$parent_id = filterRequest('parent_id');
$student_as = filterRequest('student_as');
$activity_as = filterRequest('activity_as');
$total_price = filterRequest('total_price');

// Step 1: Get the parent's coin balance
$parentStmt = $connect->prepare("SELECT coins FROM parent WHERE parent_id = ?");
$parentStmt->execute([$parent_id]);
$parent = $parentStmt->fetch(PDO::FETCH_ASSOC);

if (!$parent) {
    echo json_encode(["status" => "failed", "message" => "Parent not found"]);
    exit;
}

$coins = $parent['coins'];

if ($coins < $total_price) {
    echo json_encode(["status" => "failed", "message" => "not enough coins"]);
    exit;
}

// Step 2: Update activity to mark as_approved as true
$updateOrder = $connect->prepare(
    "UPDATE `activity_subscriptions` SET as_approved = 1 WHERE student_as = ? AND `activity_as` = ?"
);
$updateOrder->execute(array($student_as, $activity_as));

// Step 3: Deduct coins from parent
$updateCoins = $connect->prepare(
    "UPDATE parent SET coins = coins - ? WHERE parent_id = ?"
);
$updateCoins->execute([$total_price, $parent_id]);

echo json_encode(["status" => "success", "message" => "activity approved and subscriped successfully"]);
?>
