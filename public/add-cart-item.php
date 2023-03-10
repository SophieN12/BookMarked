<?php
require('../src/config.php');

if (isset($_POST['addToCart'])) {
    $productId = (int) $_POST['productId'];
    $quantity = 1;

    $sql = "
        SELECT * FROM books
        WHERE id = :id;
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $productId);
    $stmt->execute();
    $product = $stmt->fetch();

    
    if ($product) {
        $product = array_merge($product, ['quantity' => $quantity]);
        
        $cartItem = [$productId => $product];
        
        if (empty($_SESSION['cartItems'])) {
            $_SESSION['cartItems'] = $cartItem;
        } else {
            if (isset($_SESSION['cartItems'][$productId])) {
                $_SESSION['cartItems'][$productId]['quantity'] += $quantity;
            } else {
                $_SESSION['cartItems'] += $cartItem;
            }
        }
    }
}

if (!empty($_SERVER['HTTP_REFERER']))
    header("Location: ".$_SERVER['HTTP_REFERER']);
else
   echo "No referrer.";
exit;