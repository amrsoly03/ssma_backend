<?php
include '../connect.php'; 

$order_id = filterRequest('op_order'); // This is the order ID

$statement = $connect->prepare(
    "SELECT product.* 
     FROM order_products
     JOIN product ON order_products.op_product = product.product_id
     WHERE order_products.op_order = ?"
);

$statement->execute(array($order_id));
$data = $statement->fetchAll(PDO::FETCH_ASSOC);

if ($data) {
    echo json_encode(array("status" => "success", "data" => $data), JSON_PRETTY_PRINT);
} else {
    echo json_encode(array("status" => "failed", "message" => "No products found for this order"));
}
?>
