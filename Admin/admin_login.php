<?php
include '../connect.php';

$email = filterRequest('email');
$admin_password = filterRequest('admin_password');
$type = filterRequest('type');

$statment = $connect->prepare('SELECT * FROM `admin` WHERE `email` = ? And `admin_password`= ? And `admin_type` = ?');

$statment -> execute(array($email, $admin_password, $type));

$data = $statment-> fetch(PDO::FETCH_ASSOC);

$count = $statment -> rowCount();


if ($count > 0) {
    echo json_encode(array('status' => 'success', 'data' => $data));

}else {
    echo json_encode(array('status' => 'failed'));
}
//