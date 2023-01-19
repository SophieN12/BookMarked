<?php 
require('../../src/config.php');
$subheading = "";

if (!isset($_SESSION['email'])){
    $subheading = "Du är inte inloggad. Var god att logga in.";
    $pageTitle = "My page - Ej inloggad";

} else {
    $sql = "SELECT * FROM users 
    WHERE email = :email";

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':email', $_SESSION['email']);
    $stmt->execute();
    $loggedInUser= $stmt->fetch();

    $pageTitle = "My page - " . $loggedInUser['first_name'] . " " . $loggedInUser['last_name'];
    $subheading = "Välkommen " . $loggedInUser['first_name'] . " " . $loggedInUser['last_name'] .  "!";
}

if (isset($_POST['delete-account'])){
    $usersDbHandler -> deleteUser($_SESSION['id']);
    $_SESSION = [];
    session_destroy();

    redirect('../products/index.php');
}

?>

<?php include('../layout/header.php')?>

<main id="profile-page-section">
    <?php if (isset($_SESSION['email'])) { ?>
        <button id="logoutBtn" type="button" class="btn btn-secondary" onClick="location.href='logout.php'">Logga ut &nbsp;<i class="fa-solid fa-right-from-bracket"></i></button>
    <?php }?>
    <section class="profile-header">
        <h3><?=$subheading?> </h3>
        <img src="../img/<?=$loggedInUser['img_url']?>" id="user-profile-pic" alt="avatar-pic">
    </section>

    <?php if ($_SESSION['id'] == 1) { ?>
        <div id="manage-admin-div">
            <a href="my-info.php">
                <section class="profile-box">
                    <h3>Mina uppgifter</h3>
                </section>
            </a>
            
            <a href="../admin/users/manage-users.php">
                <section class="profile-box">
                    <h3>Hantera användare</h3>
                </section>
            </a>
            <a href="../admin/products/manage-products.php">
                <section class="profile-box">
                    <h3>Hantera produkter</h3>
                </section>
            </a>
            
            <a href="../admin/orders/manage-orders.php">
                <section class="profile-box">
                    <h3>Hantera ordrar</h3>
                </section>
            </a>
        </div>

    <?php } else { ?> 
        <div id="manage-profile-div">
            <a href="my-info.php">
                <section class="profile-box">
                    <h3>Mina uppgifter</h3>
                </section>
            </a>
        
            <a href="my-orderhistory.php">
                <section class="profile-box">                
                    <h3>Orderhistorik</h3>
                </section>
            </a>
        </div>
        <form id="delete-form" method="POST">
            <input type="hidden" name="delete-account">
        </form>
        <button id="deleteAccBtn" onclick="confirmAction()">RADERA MITT KONTO &nbsp;<i class="fa-solid fa-trash-can"></i></button>
    <?php } ?>
</main>

<script>
    const deleteForm = document.getElementById('delete-form');

    const confirmAction = () => {
        const response = confirm("Är du säker på att du vill radera ditt konto?");

        if (response) {
            deleteForm.submit();
        } else {
            alert("Handling avbruten");
        }
    }
</script>


<?php include('../layout/footer.php')?>

