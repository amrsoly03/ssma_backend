<?php
include '../connect.php';
$name = filterRequest('name');
$description = filterRequest('description');
$image = userImageUpload('image', 'activities_images');

if ($image != 'failed') {
    // create a new activity
    $statment = $connect->prepare(
        query: 'INSERT INTO `school_activities`(`name`, `description`, `image`) VALUES (?,?,?)'
    );
    $statment->execute(array($name, $description, $image));
    $count = $statment->rowCount();


    if ($count > 0) {
        echo json_encode(["status" => "success", "message" => "Activity added successfully"]);
    } else {
        echo json_encode(["status" => "failed", "message" => "Failed to add activity"]);
    }
} else {
    echo json_encode(["status" => "failed", "message" => "Failed to upload image"]);
}
