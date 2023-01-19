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
        <div class="order-confirmation-text">
            <h1>Tack för din order!</h1>
            <p>Din beställning är mottagen och behandlas. Du kommer att motta ett mejl med beställningsinformation.</p>
        </div>

        <section class="order-details">
            <h4>Orderdetaljer</h4>
            <hr>
            <div>
                <div>
                    <h6>Ordernummer:</h6>
                    <p> <?=$order_details['id']?></p>
                </div>
                <div>
                    <h6>E-post:</h6>
                    <p><?= $_GET['email']?></p>
                </div>
                
                <div>
                    <h6>Beställningsdatum: </h6>
                    <p><?=substr($order_details['create_date'], 0, 10)?></p>
                </div>
                <div>
                    <h6>Betalningssätt: </h6>
                    <p>Faktura</p>
                </div>
                <div>
                    <h6>Total: </h6>
                    <p><?=$order_details['total_price']?> SEK</p>
                </div>
            </div>
        </section>
    </div>
</body>

<?php include('../layout/footer.php'); ?>

</html>