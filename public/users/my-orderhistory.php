<?php
    require('../../src/config.php');
    $pageTitle = "Min orderhistorik";
    
    $loggedInUser = $usersDbHandler->fetchUserByEmail($_SESSION['email']);

    if ($loggedInUser){
        $orders = $ordersDbHandler->fetchOrdersByUserId($loggedInUser['id']);
    } else {
        $errorMessage = "Please log in to see your orderhistory.";
    }
?>

<?php include('../layout/header.php')?>

<a href="my-page.php" class="btn btn-secondary" style="position:absolute; top:120px; left: 30px;"><i class="fa-solid fa-arrow-left"></i>  Tillbaka till mina sidor</a>
<h1>Min orderhistorik</h1>


<?= $errorMessage ?>
<div class="modal fade bd-example-modal-lg" id="orderModal" tabindex="-1" role="dialog" aria-labelledby="orderModal" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="orderModal">Orderdetaljer</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table id="order-items-table">
          <thead>
            <th>ID:</th>
            <th>Produktbild:</th>
            <th>Produkt:</th>
            <th>Pris</th>
            <th>Antal:</th>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<main class="orderhistory-section">
  <table id="orderhistory-tbl">
      <tr>
          <th> Order ID: </th>
          <th> Fakturaadress: </th>
          <th> Beställningsdatum: </th>
          <th> Total: </th>
          <th> Handling</th>
          
          <?php foreach($orders as $order){ ?>
              <tr>
                  <td><?= $order['id'] ?></td>
                  <td><?= $order['billing_street'] ." ". $order['billing_postal_code'] ." ". $order['billing_city'] ;?> </td>
                  <td><?= substr($order['create_date'], 0, 10) ?></td>
                  <td><?= $order['total_price'] ?> SEK</td>
                  <td>
                    <button type="button" class="modalBtn btn btn-primary" data-toggle="modal" data-target="#orderModal" data-whatever="<?=$order['id']?>">Detaljer</button>
                  </td>
              </tr>
          <?php }?>
  </table>
  <?php if($orders == []){?>
      <h3 style="text-align:center; margin-top: 30px;">Du har inga ordrar...</h3>
  <?php }?>
</main>

<script src="js/get-order-info.js"></script>