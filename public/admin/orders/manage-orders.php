<?php 
    require("../../../src/config.php");
    $pageTitle = "Manage orders";

    if ($_SESSION['id'] == 1){
        $orders = $ordersDbHandler -> fetchAllOrders();
        
        if (isset($_POST['searchOrderBtn']) && trim($_POST['search-result']) != '') {
            $searchResult = trim($_POST['search-result']);

            $orders = $ordersDbHandler-> fetchOrdersInfoById($searchResult);
        }

    } else {
        redirect("../../products/index.php");
    }
?> 

<?php include('../../layout/admin-header.php')?>

<main class= "manage-container orders-container">

    <a href="../../users/my-page.php" style="color:white; text-decoration:none">
        <button class="btn btn-secondary px-4 mt-3 mb-3"><i class="fa-solid fa-arrow-left">
            </i>&nbsp; Tillbaka till mina sidor 
        </button>
    </a>
    
    <h1>Hantera ordrar</h1>

    <div id="messages"></div>

    <form id="search-form" class="d-flex" role="search" method="post" >
        <input class="form-control me-2" id="search-bar" name="search-result" type="search" placeholder="Sök efter id..." aria-label="Search">
        <input type="submit" class="btn btn-primary px-4" id="search-submit" name="searchOrderBtn" value="Sök">
    </form>

    <table id="orders-tbl">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Namn:</th>
                <th>Fakturaadress:</th>
                <th>Beställningsdatum:</th>
                <th>Total:</th>
                <th>Handlingar:</th>
            </tr>
        </thead>

        <tbody>
        <?php foreach($orders as $order){ ?>
            <tr>
                <td><?= $order['id'] ?></td>
                <td><?= $order['billing_full_name']?> </td>
                <td><?= $order['billing_street'] ." ". $order['billing_postal_code'] ." ". $order['billing_city'] ;?> </td>
                <td><?= substr($order['create_date'], 0, 10) ?></td>
                <td><?= $order['total_price'] ?> SEK</td>
                <td>
                    <input class="modalBtn" type="button" class="btn btn-primary" data-toggle="modal" data-target="#adminOrderModal" data-whatever="<?=$order['id']?>" value="Detaljer">
                    <form class="delete-order-form" method="POST">
                        <input type="hidden" name="orderId" value= "<?=htmlentities($order['id'])?>">
                        <input type="submit" name="deleteOrderBtn" value="Delete">
                    </form>
                </td>
            </tr>
        <?php }?>
        </tbody>
    </table>

    <div class="modal fade bd-example-modal-lg" id="adminOrderModal" tabindex="-1" role="dialog" aria-labelledby="adminOrderModal" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="adminOrderModal">Orderdetaljer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table id="order-items-tbl">
                    <th>ID:</th>
                    <th>Produktbild:</th>
                    <th>Produkt:</th>
                    <th>Pris</th>
                    <th>Antal:</th>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Stäng</button>
            </div>
            </div>
        </div>
    </div>
</main>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="js/get-order-info.js"></script>
<script src="js/delete-order.js"></script>

</body>
</html>
