<?php
require('../../src/config.php');

$message =  "";
$orderInfo = [];
$orderItems =[];

if (isset($_GET['orderId'])) {
    $orderId = $_GET['orderId'];

    $orderItems = $ordersDbHandler -> fetchOrderItemsById($orderId);

    if ($orderItems) {
        $message = "Successfully fetched order information for ordernumber: " . $orderId;
        $status = true;
    } else {
        $message = "Something went wrong! Could not fetch order information for ordernumber: " . $orderId;
        $status = false;
    }
} else {
    $message = "Something went wrong! No orderID could be found.";
}

$data = [
    'status' => $status,
    'message' => $message,
    'orderInfo'   => $orderInfo,
    'orderItems' => $orderItems
];

echo json_encode($data);