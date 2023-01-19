<?php 
    $errorMessages = "";
    $email = "";

    if (isset($_POST["submitSearch"])){
        $searchResult =  trim($_POST['search-result']);
        redirect("../products/products.php?search=". trim($_POST['search-result']));
    }

    if (isset($_POST['loginBtn'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $loginUser = $usersDbHandler -> fetchUserByEmail($email);
    
        if (!$loginUser) {
            redirect("?emailDontExists");
        } else if ($loginUser && password_verify($password, $loginUser['password'])){
            $_SESSION['id'] = $loginUser['id'];
            $_SESSION['email'] = $loginUser['email'];
            $_SESSION['img'] = $loginUser['img_url'];
            redirect("?loggedIn");
        } else {
            redirect("?wrongPassword");
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/7057239743.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/checkout.css">
    <link rel="stylesheet" href="../css/users.css">
    <link rel="stylesheet" href="../css/products.css">
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
                        <img src="../img/header-img/avatar-icon.png" data-toggle="modal" data-target="#loginModal" alt="">
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
                        <p id="loginMessages"></p>
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
                                <p>Inget konto? <a href="" data-toggle="modal" data-target="#registerModal">Skapa ett här.</a> </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div> 

        <div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="registerModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="registerModalLabel">Skapa konto</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <p id="registerMessages"></p>
                        <form id="create-account-form" action="../users/create-user.php" method="POST">
                            <div class="form-group">
                                <label for="register-fname">Förnamn:</label>
                                <input type="text" class="form-control" name="register-fname">
                            </div>
                            
                            <div class="form-group">
                                <label for="register-lname">Efternamn:</label>
                                <input type="text" class="form-control" name="register-lname">
                            </div>
                         
                            <div class="form-group">
                                <label for="register-email">E-post:</label>
                                <input type="email" class="form-control" name="register-email">
                            </div>

                            <div class="form-group">
                                <label for="register-password">Lösenord:</label>
                                <input type="password" class="form-control" name="register-password">
                            </div>

                            <div class="form-group">
                                <label for="register-confirm-password">Bekräfta lösenord:</label>
                                <input type="password" class="form-control" name="register-confirm-password">
                            </div>

                            <button type="submit" id="createAccountBtn" class="btn btn-primary" name="createAccountBtn">Registrera</button>
                    
                        </form>
                    </div>
                </div>
            </div>
        </div> 
    </header>

    <?php if(isset($_GET['success'])){?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo $_GET['message']?>
            <button type="button" class="close alert-close-btn" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php } ?>

    <?php if (isset($_GET['logout'])){ ?>
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                Du är nu<strong> utloggad.</strong>
                <button type="button" class="close alert-close-btn" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
    <?php } ?>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="../users/js/login.js"></script>
