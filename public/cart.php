<?php 
if (!isset($_SESSION['cartItems'])) {
    $_SESSION['cartItems'] = [];
  }

  $cartItemCount = count($_SESSION['cartItems']);
  $cartTotalSum = 0;
  $itemsCount = 0;
  foreach ($_SESSION['cartItems'] as $cartId => $cartItem) {
    $cartTotalSum += $cartItem['price'] * $cartItem['quantity'];
    $itemsCount += $cartItem['quantity']; 
  }
?>

<div class="dropdown cart-icon">
  <img id="shoppingcart" src="../img/header-img/cart.png" alt="shoppingcart icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
  <span class='badge badge-danger' id='cartCount'> <?=$itemsCount ?> </span>
  <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
        <?php foreach($_SESSION['cartItems'] as $cartId => $cartItem): ?>
            <div class="cart-detail row">
                <img src= <?php echo "../admin/products/" . $cartItem['img_url'];?> width="100">
                <div class="cart-detail-product">
                    <p><?=$cartItem['title']?></p>
                    <span class="cart-price"><?=$cartItem['price']?> SEK</span>
                    <span class="cart-quantity">Antal: <?=$cartItem['quantity']?></span>
                    <form class="update-cart-form" action="../update-cart-item.php" method="POST">
                        <input type="hidden" name="cartId" value="<?= $cartId ?>">
                        <input type="number" name="quantity" value="<?= $cartItem['quantity'] ?>" min="0">
                    </form>

                    <form action="../delete-cart-item.php" method="POST">
                        <input type="hidden" name="cartId" value="<?= $cartId ?>">
                            <button type="submit" class="btn">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                                    <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                                </svg>
                            </button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>

    <div class="dropdown-divider"></div>

    <div class="total-section">
      <p>Total</p>
      <p><span class="cart-price"><?=$cartTotalSum ?></span> SEK</p>
    </div>

    <div class="dropdown-divider"></div>

    <div class="row">
      <div class="col-lg-12 col-sm-12 col-12 text-center checkout">
        <a href="../products/checkout.php" class="btn btn-checkout">Checkout</a>
      </div>
    </div>
  </div>
</div>