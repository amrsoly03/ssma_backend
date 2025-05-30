<?php
include '../connect.php';

$product_category = filterRequest('product_category');


// Select all products from the database
$statement = $connect->prepare('SELECT * FROM `product` WHERE `product_category` = ?');
$statement->execute(array($product_category));

$data = $statement->fetchAll(PDO::FETCH_ASSOC);
$count = $statement->rowCount();

if ($count > 0) {
    echo json_encode(array('status' => 'success', 'data' => $data), JSON_PRETTY_PRINT);
} else {
    echo json_encode(array('status' => 'failed', 'message' => 'no products found'));
}
