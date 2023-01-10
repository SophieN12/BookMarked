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

?>

<?php include('../layout/header.php')?>

<main id="profile-page-section">
    <section class="profile-header">
        <h3><?=$subheading?> </h3>
        <img src="../img/<?=$loggedInUser['img_url']?>" id="user-profile-pic" alt="avatar-pic">
    </section>

    <div id="manage-profile-div">
        <a href="my-info.php">
            <section class="profile-box">
                <h3>Mina uppgifter</h3>
            </section>
        </a>
    
        <a href="my-favorites.php">
            <section class="profile-box">
                <h3>Favoriter</h3>
            </section>
        </a>
        
        <a href="my-orderhistory.php">
            <section class="profile-box">                
                <h3>Orderhistorik</h3>
            </section>
        </a>
            
        <a href="my-settings.php">
            <section class="profile-box">
                <h3>Inställningar</h3>
            </section>
        </a>
    </div>
</main>

<?php if (isset($_SESSION['email'])) { ?>
    <input id="logoutBtn" type="button" onClick="location.href='logout.php'" value="Logout">
<?php }?>

<?php include('../layout/footer.php')?>

