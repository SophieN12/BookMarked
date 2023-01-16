<?php
require('../src/config.php');

if (isset($_POST['productId']) 
    && !empty($_POST['quantity']) 
    && isset($_SESSION['cartItems'][$_POST['productId']])) {
    $_SESSION['cartItems'][$_POST['productId']]['quantity'] = $_POST['quantity'];
}

if (!empty($_SERVER['HTTP_REFERER']))
    header("Location: ".$_SERVER['HTTP_REFERER']);
else
   echo "No referrer.";
exit;