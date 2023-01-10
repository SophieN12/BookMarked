<?php
require('../src/config.php');

if (isset($_POST['cartId']) 
    && !empty($_POST['quantity']) 
    && isset($_SESSION['cartItems'][$_POST['cartId']])) {
    $_SESSION['cartItems'][$_POST['cartId']]['quantity'] = $_POST['quantity'];
}

if (!empty($_SERVER['HTTP_REFERER']))
    header("Location: ".$_SERVER['HTTP_REFERER']);
else
   echo "No referrer.";
exit;