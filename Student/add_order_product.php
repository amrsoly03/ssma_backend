<?php
include '../connect.php';
$op_order = filterRequest('op_order');
$op_product = filterRequest('op_product');

$statment = $connect->prepare(
    'INSERT INTO `order_products`(`op_order`, `op_product`) VALUES (?,?)'
);
$statment->execute(array($op_order, $op_product));

$count = $statment->rowCount();
if ($count > 0) {
    echo json_encode(["status" => "success", "message" => "product added successfully"], JSON_PRETTY_PRINT);
} else {
    echo json_encode(["status" => "error", "message" => "Failed to add product"]);
}
