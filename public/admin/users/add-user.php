<?php 
    $pageTitle = "Add user";
    require('../../../src/config.php');

    $message = "";
    
    $first_name   = "";
    $last_name    = "";
    $email        = "";
    $password     = "";
    $phone        = "";
    $street       = "";
    $postal_code  = "";
    $city         = "";

    if (isset($_POST['addUserBtn'])) {
        $first_name     = trim($_POST['fname']);
        $last_name      = trim($_POST['lname']);
        $email          = trim($_POST['email']);
        $password       = trim($_POST['password']);
        $phone          = trim($_POST['phone']);
        $street         = trim($_POST['street']);
        $postal_code    = trim($_POST['postal_code']);
        $city           = trim($_POST['city']);

        if (empty($first_name) || empty($last_name) || empty($email) || empty($password)) {
            $errorMessages .= generateErrorMessageForEmptyField($first_name, "Förnamn");
            $errorMessages .= generateErrorMessageForEmptyField($last_name, "Efternamn");
            $errorMessages .= generateErrorMessageForEmptyField($email, "E-post");
            $errorMessages .= generateErrorMessageForEmptyField($password, "Lösenord");
        } 

        if (is_numeric($phone) === false && !empty($phone) || is_numeric($postal_code) === false && !empty($postal_code)) {
            if (is_numeric($phone) === false ){
                $errorMessages .= '<li> Fel format för <strong> telefonnummer </strong> (måste vara numeriskt). </li>';
            } else {
                $errorMessages .= '<li> Fel format för <strong> postnummer </strong> (måste vara numeriskt). </li>';
            }
        }
        if (!empty($errorMessages)) {
            $message .= '<div class="alert alert-danger messages-div" ><ul>'. $errorMessages. '</ul></div> ' ;
        
        } else {
            $usersDbHandler -> createUser($first_name, $last_name, $email, $password, $phone, $street, $postal_code, $city);
            redirect('manage-users.php');
        }
    }    
?>

<?php include('../../layout/admin-header.php')?>

    <div class="container mt-3">
        <h1 class="center" >Add new user</h1>
        <br>

        <?= $message ?>

        <form class="input-form" action="" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="form-floating col mb-3 remove-p">
                    <input type="text" class="form-control" id="floatingInput" value="<?=htmlentities($first_name)?>" name="fname">
                    <label class=""for="floatingInput">Förnamn *</label>
                </div>

                <div class="form-floating col mb-3 remove-p">
                    <input type="text" class="form-control" id="floatingInput" value="<?=htmlentities($last_name)?>" name="lname">
                    <label for="floatingInput">Efternamn *</label>
                </div>
            </div>
            
            <div class="form-floating mb-3">
                <input type="email" class="form-control" id="floatingInput" value="<?=htmlentities($email)?>" name="email">
                <label for="floatingInput">Email *</label>
            </div>

            <div class="form-floating mb-3">
                <input type="password" class="form-control" id="floatingInput" name="password">
                <label for="floatingInput">Lösenord *</label>
            </div>

            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="floatingInput" value="<?=htmlentities($phone)?>" name="phone">
                <label for="floatingInput">Telefonnummer</label>
            </div>
            
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="floatingInput" value="<?=htmlentities($street)?>" name="street">
                <label for="floatingInput">Adress</label>
            </div>
            
            <div class="form-row">
                <div class="form-floating col mb-3">
                    <input type="text" class="form-control" id="floatingInput" value="<?=htmlentities($postal_code)?>" name="postal_code">
                    <label for="floatingInput">Postnummer</label>
                </div>
                <div class="form-floating col mb-3">
                    <input type="text" class="form-control" id="floatingInput" value="<?=htmlentities($city)?>" name="city">
                    <label for="floatingInput">Stad</label>
                </div>
            </div>

                <div class="d-grid gap-3 col-6 mx-auto mt-4">
                    <input type="submit" class="btn" name="addUserBtn" value="Add">

                    <a href="manage-products.php" class="btn btn-secondary cancel-btn">Cancel</a>
                </div>
            </form>
    </div>
</body>
</html>