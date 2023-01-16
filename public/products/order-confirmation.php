<?php
    require('../../src/config.php');
    $pageTitle = 'Order confirmation';

    if(empty($_SESSION['cartItems'])) {
        header('Location: checkout.php');
        exit;
    }

    $cartItems = $_SESSION['cartItems'];
    $totalSum = 0;
    foreach ($cartItems as $cartId => $cartItem) {
        $totalSum += $cartItem['price'] * $cartItem['quantity'];
    }

    $order_details = $ordersDbHandler -> fetchOrderInfoById($_GET['order_id']);

    unset($_SESSION['cartItems']);
?>

<?php include('../layout/header.php'); ?>

<body>
    <div class="container">

        <img src="../" alt="">
        <h1>Tack för din order!</h1>
        <p>Din beställning är mottagen och behandlas. Du kommer att motta ett mejl med beställningsinformation.</p>

        <section class="order-details">
            <h3>Orderdetaljer</h3>
            <hr>
            <p>Ordernummer: <?=$order_details['id']?></p>
            <p>Total: <?=$order_details['total_price']?> SEK</p>
            <p>Beställningsdatum: <?=substr($order_details['create_date'], 0, 10)?></p>
            <p>Betalningssätt: Faktura</p>
            <p>Email: <?= $_GET['email']?></p>
        </section>
    </div>
</body>

<?php include('../layout/footer.php'); ?>

</html>