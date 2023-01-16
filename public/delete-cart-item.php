<?php
require('../src/config.php');

// echo "<pre>";
// print_r($_POST);
// echo "</pre>";

if (isset($_POST['productId']) && isset($_SESSION['cartItems'][$_POST['productId']])) {
    unset($_SESSION['cartItems'][$_POST['productId']]);
}

if (!empty($_SERVER['HTTP_REFERER']))
    header("Location: ".$_SERVER['HTTP_REFERER']);
else
   echo "No referrer.";
exit;
