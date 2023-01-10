<?php 
require('../../src/config.php');

if (isset($_POST["submitSearch"])){
    $searchResult =  trim($_POST['search-result']);
    header("location: ../products/products.php?search=". trim($_POST['search-result']));
}

$errorMessages = "";
$successMessage = "";

if (isset($_POST['loginBtn'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users 
            WHERE email = :email";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    $user = $stmt->fetch();

    if ($user and $user['password'] == $password) {
        $_SESSION['id'] = $user['id'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['img'] = $user['img_url'];
    } else {
        $errorMessages = "The username or password you entered is incorrect";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$pageTitle?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <header>
        <a href="../products/index.php" id="logo">
            <img src="../img/header-img/Logo.png" alt="" height="70px">
        </a>

        <div id="search-div">
            <form id="search-form" class="d-flex" role="search" method="POST">
				<input class="form-control me-2" id="search-bar" name="search-result" type="search" placeholder="Search after your next read..." aria-label="Search">
				<input type="submit" class="btn" id="submit-search" name="submitSearch" value="Search">
			</form>
        </div>
        
        <div id="profile-btn">
            <?php 
                if(isset($_SESSION['email'])){ ?>
                    <a href="../users/my-page.php">
                        <img src="../img/<?php echo $_SESSION['img']?>">
                    </a>
                    <?php } else { ?>
                        <img src="../img/header-img/owl.png" data-toggle="modal" data-target="#loginModal" alt="">
                        <?php }
            ?>

            <?php include('../cart.php'); ?>
        </div>

        <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="loginModalLabel">Logga in</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div id="loginMessages"></div>
                        <form id="login-form" method="POST">
                            <div class="form-group">
                                <label for="email">E-post:</label>
                                <input type="email" class="form-control" name="email" value="<?=htmlentities($email)?>">
                            </div>
                            <div class="form-group">
                                <label for="password">Lösenord:</label>
                                <input type="password" class="form-control" name="password">
                            </div>

                            <a href="" style="align-self: center">Glömt lösenord?</a>
                            <button type="submit" id="loginBtn" class="btn btn-primary" name="loginBtn">Logga in</button>
                            <div class="modal-footer" style="align-self: center; margin: 10px 0px;">
                                <p>Inget konto? <a href="" >Skapa ett här.</a> </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div> 
        
    </header>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="../products/js/login.js"></script>
</body>

</html>