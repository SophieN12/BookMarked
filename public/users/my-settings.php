<?php 
require('../../src/config.php');

if (isset($_POST['delete-account'])){
    $usersDbHandler -> deleteUser($_SESSION['id']);
    $_SESSION = [];
    session_destroy();

    redirect('../products/index.php');
}
?>

<?php include('../layout/header.php')?>

<h1>Mina inställningar</h1>

<form id="delete-form" method="POST">
    <input type="hidden" name="delete-account">
</form>

<button onclick="confirmAction()">RADERA MITT KONTO</button>

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

