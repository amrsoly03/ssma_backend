<?php
include '../connect.php'; 

$parent_id = filterRequest('parent_id');
$order_id = filterRequest('order_id');
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

// Step 2: Update order to mark order_approved as true
$updateOrder = $connect->prepare(
    "UPDATE `order` SET order_approved = 1 WHERE order_id = ?"
);
$updateOrder->execute([$order_id]);

// Step 3: Deduct coins from parent
$updateCoins = $connect->prepare(
    "UPDATE parent SET coins = coins - ? WHERE parent_id = ?"
);
$updateCoins->execute([$total_price, $parent_id]);

echo json_encode(["status" => "success", "message" => "order approved and paid successfully"]);
?>
