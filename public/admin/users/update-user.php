<?php 
    $pageTitle = "Update user";
    require('../../../src/config.php');
    
    $message       = "";
    $errorMessages = "";

if (isset($_POST['updateUser'])) {
    $id            = trim($_POST['userId']);
    $first_name   = trim($_POST['fname']);
    $last_name    = trim($_POST['lname']);
    $email        = trim($_POST['email']);
    $password     = trim($_POST['password']);
    $phone        = trim($_POST['phone']);
    $street       = trim($_POST['street']);
    $postal_code  = trim($_POST['postal_code']);
    $city         = trim($_POST['city']);

    if (empty($first_name) || empty($last_name) || empty($email) || empty($password)) {
        $errorMessages .= generateErrorMessageForEmptyField($first_name, "Förnamn");
        $errorMessages .= generateErrorMessageForEmptyField($last_name, "Efternamn");
        $errorMessages .= generateErrorMessageForEmptyField($email, "Email");
        $errorMessages .= generateErrorMessageForEmptyField($password, "Lösenord");
    } 
    if (is_numeric($phone) === false && !empty($phone) || is_numeric($postal_code) === false && !empty($postal_code)){
        if (is_numeric($phone) === false ){
            $errorMessages .= '<li> Fel format för <strong> telefonnummer </strong> (måste vara nummeriskt). </li>';
        }
        else {
            $errorMessages .= '<li> Fel format för <strong> postnummer </strong> (måste vara nummeriskt). </li>';
        }
    }

    if (!empty($errorMessages)) {
        $message .= '<div class="alert alert-danger messages-div"><ul>'. $errorMessages. '</ul></div> ' ;

	} else {
        $usersDbHandler -> updateUser($id, $first_name, $last_name, $email, $password, $phone, $street, $postal_code, $city);
        redirect("manage-users.php");
    }
}    
    $user = $usersDbHandler -> fetchUserById($_POST['userId']);
?>

<?php include('../../layout/admin-header.php')?>

    <div class="container mt-3">
        <h1 class="center">Update user</h1>
        <br>

        <?= $message ?>
        <form class="input-form" action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="userId" value="<?= $user['id']?>">

            <div class="row">
                <div class="form-floating col mb-3 remove-p">
                    <input type="text" class="form-control" id="floatingInput" value="<?=htmlentities($user['first_name'])?>" name="fname">
                    <label class=""for="floatingInput">Förnamn *</label>
                </div>

                <div class="form-floating col mb-3 remove-p">
                    <input type="text" class="form-control" id="floatingInput" value="<?=htmlentities($user['last_name'])?>" name="lname">
                    <label for="floatingInput">Efternamn *</label>
                </div>
            </div>
            
            <div class="form-floating mb-3">
                <input type="email" class="form-control" id="floatingInput" value="<?=htmlentities($user['email'])?>" name="email">
                <label for="floatingInput">Email *</label>
            </div>

            <div class="form-floating mb-3">
                <input type="password" class="form-control" id="floatingInput" value="<?=htmlentities($user['password'])?>" name="password">
                <label for="floatingInput">Lösenord *</label>
            </div>

            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="floatingInput" value="<?=htmlentities($user['phone'])?>" name="phone">
                <label for="floatingInput">Telefonnummer</label>
            </div>
            
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="floatingInput" value="<?=htmlentities($user['street'])?>" name="street">
                <label for="floatingInput">Adress</label>
            </div>
            
            <div class="form-row">
                <div class="form-floating col mb-3">
                    <input type="text" class="form-control" id="floatingInput" value="<?=htmlentities($user['postal_code'])?>" name="postal_code">
                    <label for="floatingInput">Postnummer</label>
                </div>
                <div class="form-floating col mb-3">
                    <input type="text" class="form-control" id="floatingInput" value="<?=htmlentities($user['city'])?>" name="city">
                    <label for="floatingInput">Stad</label>
                </div>
            </div>

            <div class="d-grid gap-3 col-6 mx-auto mt-4 ">
                <input type="submit" class="btn" name="updateUser" value="Update">
                
                <a href="manage-users.php" class="btn btn-secondary cancel-btn">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>
