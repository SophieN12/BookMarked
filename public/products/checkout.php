<?php
require('../../src/config.php');
$pageTitle = 'Checkout';

if (isset($_SESSION['email'])){
    $activeUser = $usersDbHandler-> fetchUserByEmail($_SESSION['email']);
} 

?>

<?php include('../layout/header.php'); ?>

<body>
    <div class="container">
        <h1>Checkout</h1>
        
        <div class="inner-container">
            <section class="checkout-item-list">
            <?php if($_SESSION['cartItems'] == []){?>
                <h3>Din varukorg är tom.</h3>
            <?php }?>
                <ul>
                    <?php foreach ($_SESSION['cartItems'] as $productId => $cartItem) : ?>
                        <li>
                            <article class="checkout-item-module">
                                <img src="../admin/products/<?= $cartItem['img_url'] ?>" width="80">
                                <div class="cart-item-details">
                                    <h4><?= $cartItem['title'] ?></h4>
                                    <p><?= $cartItem['price'] ?> SEK</p>
                                </div>

                                <form class="update-cart-form" action="../update-cart-item.php" method="POST">
                                    <input type="hidden" name="productId" value="<?= $productId ?>">
                                    <input type="number" name="quantity" value="<?= $cartItem['quantity'] ?>" min="0">
                                </form>

                                <form action="../delete-cart-item.php" method="POST">
                                    <input type="hidden" name="productId" value="<?= $productId ?>">

                                    <button type="submit" class="btn">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                                            <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                                        </svg>
                                    </button>
                                </form>

                            </article>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <div class="total-section-checkout">
                    <p>Total:</p>
                    <p><span class="cart-price"><?=$cartTotalSum ?></span> SEK</p>
                </div>
            </section>

            <section class="checkout-sidebar">
                <h5 style="margin-bottom:20px;">Kunduppgifter</h5>
                <hr>
                <?php if (isset($_GET['infoRequired'])){ ?>
                    <div class="alert alert-danger" role="alert" style="margin-bottom:30px">
                        Var vänligen och fyll i alla fält.
                    </div>
                <?php } ?>
                <?php if (isset($_GET['wrongPasswordCheckout'])){ ?>
                    <div class="alert alert-danger" role="alert" style="margin-bottom:30px">
                        Fel lösenord
                    </div>
                <?php } ?>

                <form id="create-order-form" action="../create-order.php" method="POST">
                    <input type="hidden" name="cartTotalSum" value="<?= $cartTotalSum ?>">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="fname">Förnamn:</label>
                            <input type="text" class="form-control" name="fname" value="<?=htmlentities($activeUser['first_name'])?>">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="lname">Efternamn:</label>
                            <input type="text" class="form-control" name="lname" value="<?=htmlentities($activeUser['last_name'])?>">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-xl">
                            <label for="email">E-post:</label>
                            <input type="email" class="form-control" name="email" value="<?=htmlentities($activeUser['email'])?>">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-xl">
                            <label for="password">Lösenord:</label>
                            <input type="password" class="form-control" name="password" value="">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group col-xl">
                            <label for="street">Address:</label>
                            <input type="text" class="form-control" name="street" value="<?=htmlentities($activeUser['street'])?>">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="postal-code">Postnummer:</label>
                            <input type="text" class="form-control" name="postal-code" value="<?=htmlentities($activeUser['postal_code'])?>">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="city">Stad:</label>
                            <input type="text" class="form-control" name="city" value="<?=htmlentities($activeUser['city'])?>">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group col-xl">
                            <label for="phone">Telefonnummer:</label>
                            <input type="text" class="form-control" name="phone" value="<?=htmlentities($activeUser['phone'])?>">
                        </div>
                    </div>
        
                    <div class="checkout-button-submit">
                        <button type="submit" name="createOrderBtn" class="btn btn-info btn-checkout">Slutför order</button>
                    </div>
                </form>
            </section>

        </div>
    </div>

    <script type="text/javascript">
        $('.update-cart-form input[name="quantity"]').on('change', function() {
            $(this).parent().submit();
        });
    </script>

</body>
<?php include('../layout/footer.php'); ?>
</html>