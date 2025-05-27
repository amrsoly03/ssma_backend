<?php
include '../connect.php';
$product_name = filterRequest('product_name');
$product_category = filterRequest('product_category');
$product_price = filterRequest('product_price');
$product_image = userImageUpload('product_image', 'products_images');

if ($product_image != 'failed') {
    // create a new product
    $statment = $connect->prepare(
        'INSERT INTO `product`(`product_name`, `product_category`, `product_price`, `product_image`) VALUES (?,?,?,?)'
    );
    $statment->execute(array($product_name, $product_category, $product_price, $product_image));
    $count = $statment->rowCount();


    if ($count > 0) {
        echo json_encode(["status" => "success", "message" => "Product added successfully"]);
    } else {
        echo json_encode(["status" => "failed", "message" => "Failed to add product"]);
    }
} else {
    echo json_encode(["status" => "failed", "message" => "Failed to upload image"]);
}
