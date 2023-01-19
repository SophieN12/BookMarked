<?php 
    require('../../src/config.php');

    $first_name         = "";
    $last_name          = "";
    $street             = "";
    $postal_code        = "";
    $city               = "";
    $email              = "";
    $phone              = "";
    $password           = "";
    $updateMessages      = "";
    $errorMessages      = "";

    if(isset($_POST['saveChangesBtn'])){
        $phone              = trim($_POST['phone']);
        $street             = trim($_POST['street']);
        $postal_code        = trim($_POST['postal_code']);
        $city               = trim($_POST['city']);

        $changesList = [$phone, $street, $postal_code, $city];
        $emptyFieldsAmount = 0;

        foreach ($changesList as $listItem){
            if ($listItem == ""){
                $emptyFieldsAmount += 1;
            } 
        }

        if ($emptyFieldsAmount != 0){
            $errorMessages .= generateErrorMessageForEmptyField($phone, "Telefonnummer");
            $errorMessages .= generateErrorMessageForEmptyField($street, "Address");
            $errorMessages .= generateErrorMessageForEmptyField($postal_code, "Postnumemr");
            $errorMessages .= generateErrorMessageForEmptyField($city, "Stad");

            $updateMessages = '<div class="alert alert-danger" role="alert">' . $emptyFieldsAmount . '</div>';
            
        } else {
            $sql = "
                    UPDATE users SET 
                    phone = :phone,
                    street = :street,
                    postal_code = :postal_code,
                    city = :city
                    WHERE id= :id
                 ";
               
                $id = $_SESSION['id'];
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':phone', $phone);
                $stmt->bindParam(':street', $street);
                $stmt->bindParam(':postal_code', $postal_code);
                $stmt->bindParam(':city', $city);
                $stmt->bindParam(':id', $id);

                $stmt->execute();

                $updateMessages = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                        Dina uppgifter har uppdaterats!
                                        <button type="button" class="close alert-close-btn" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>';
        }
    }

   $sql = "SELECT * FROM users WHERE email = :email"; 
   $stmt = $pdo->prepare($sql);
   $stmt->bindParam(':email', $_SESSION['email']);
   $stmt->execute();
   $userInfo = $stmt->fetch();
?>

<?php include('../layout/header.php');?>

<main id="my-info-section">
    <?=$updateMessages?>
    <a href="my-page.php" class="btn btn-secondary" style="position:absolute; top:120px; left: 30px;"><i class="fa-solid fa-arrow-left"></i>  Tillbaka till mina sidor</a>
    <h1>Mina uppgifter</h1>

    <form id="my-info-form" method="POST">
        <div class="form-group">
            <label for="fname">Förnamn:</label>
            <input type="text" class="form-control" name="fname" value= "<?=htmlentities($userInfo['first_name'])?>" class="input-readonly" readonly>
        </div>
        <div class="form-group">
            <label for="lname">Efternamn:</label>
            <input type="text" class="form-control col" name="lname" value= "<?= htmlentities($userInfo['last_name'])?>" class="input-readonly" readonly>
        </div>
        <div class="form-group">
            <label for="email">E-post:</label>
            <input type="email" class="form-control" name="email" value= "<?=htmlentities($userInfo['email'])?>" class="input-readonly" size="30" readonly>
        </div>
        <div class="form-group">
            <label for="phone">Telefonnummer:</label>
            <input type="text" class="form-control" name="phone" value= "<?=htmlentities($userInfo['phone'])?>">
        </div>
        <div class="form-group">
            <label for="street">Adress:</label>
            <input type="text" class="form-control" name="street" value= "<?=htmlentities($userInfo['street'])?>">
        </div>
        <div class="form-group">
            <label for="postal_code">Postnummer:</label>
            <input type="text" class="form-control"name="postal_code" value= "<?=htmlentities($userInfo['postal_code'])?>">
        </div>
        <div class="form-group">
            <label for="city">Stad:</label>
            <input type="text" class="form-control" name="city" value= "<?=htmlentities($userInfo['city'])?>">
        </div>
        <p> Medlemskap skapad: <?=substr($userInfo['create_date'], 0, 10)?></p>
        <button type="submit" class="btn btn-primary" name="saveChangesBtn">Spara ändringar</button>
        <a href="my-page.php" class= "btn btn-secondary">Tillbaka</a>
    </form>

</main>

<?php include('../layout/footer.php');?>

