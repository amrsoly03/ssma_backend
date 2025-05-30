<?php
include '../connect.php'; 

$order_student = filterRequest('order_student');
$order_approved = filterRequest('order_approved');

$statement = $connect->prepare(
    "SELECT `order`.*, 
            SUM(product.product_price) AS total_price
     FROM `order`
     JOIN order_products ON `order`.order_id = order_products.op_order
     JOIN product ON order_products.op_product = product.product_id
     WHERE `order`.order_student = ? AND `order`.order_approved = ?
     GROUP BY `order`.order_id"
);

$statement->execute(array($order_student, $order_approved));
$data = $statement->fetchAll(PDO::FETCH_ASSOC);

if ($data) {
    echo json_encode(array("status" => "success", "data" => $data), JSON_PRETTY_PRINT);
} else {
    echo json_encode(array("status" => "failed", "message" => "Order not found"));
}
?>
