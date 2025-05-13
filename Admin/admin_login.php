<?php
include '../connect.php';

$email = filterRequest('email');
$admin_password = filterRequest('admin_password');

$statment = $connect->prepare('SELECT * FROM `admin` WHERE `email` = ? And `admin_password`= ?');

$statment -> execute(array($email, $admin_password));

$data = $statment-> fetch(PDO::FETCH_ASSOC);

$count = $statment -> rowCount();


if ($count > 0) {
    echo json_encode(array('status' => 'success', 'data' => $data));

}else {
    echo json_encode(array('status' => 'failed'));
}
//