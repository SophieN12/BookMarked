<?php
require('../../../src/config.php');

$message =  "";

if (isset($_GET['orderId'])) {
    $ordersDbHandler -> deleteOrder($_GET['orderId']);
    $ordersDbHandler -> deleteOrderItems($_GET['orderId']);
    $message = "You have succesfully deleted order with ID: " . $_GET['orderId'];
    $status = true;

} else {
    $message = "Something went wrong! User did not get deleted from the database.";
    $status = false;
}

$data = [
    'status' => $status,
    'message' => $message
];

echo json_encode($data);
