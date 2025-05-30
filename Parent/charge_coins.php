<?php
include '../connect.php';

$parent_id = filterRequest('parent_id');
$increase_by = filterRequest('increase_by');

// Update the coins for the specified parent
$statement = $connect->prepare(
    "UPDATE parent SET coins = coins + ? WHERE parent_id = ?"
);

$success = $statement->execute(array($increase_by, $parent_id));

if ($success && $statement->rowCount() > 0) {
    echo json_encode(array('status' => 'success', 'message' => 'Coins updated successfully'));
} else {
    echo json_encode(array('status' => 'failed', 'message' => 'Update failed or parent not found'));
}
