<?php 
    require('../../src/config.php');
    require('../../src/app/common_functions.php');

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
        // $first_name         = trim($_POST['fname']);
        // $last_name          = trim($_POST['lname']);
        // $password           = trim($_POST['password']);
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
            // $errorMessages .= generateErrorMessageForEmptyField($first_name, "Förnamn");
            // $errorMessages .= generateErrorMessageForEmptyField($last_name, "Efternamn");
            // $errorMessages .= generateErrorMessageForEmptyField($password, "Lösenord");
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

<main>
    <?=$updateMessages?>
    
    <h1>Mina uppgifter</h1>

    <form id="my-info-form" method="POST">
        <label for="fname">Förnamn:</label>
        <input type="text" name="fname" value= "<?=htmlentities($userInfo['first_name'])?>" class="input-readonly" readonly>
        <label for="lname">Efternamn:</label>
        <input type="text" name="lname" value= "<?= htmlentities($userInfo['last_name'])?>" class="input-readonly" readonly>
        <label for="email">E-post:</label>
        <input type="email" name="email" value= "<?=htmlentities($userInfo['email'])?>" class="input-readonly" size="30" readonly>
        <label for="phone">Mobilnummer:</label>
        <input type="text" name="phone" value= "<?=htmlentities($userInfo['phone'])?>">
        <label for="street">Address:</label>
        <input type="text" name="street" value= "<?=htmlentities($userInfo['street'])?>">
        <label for="postal_code">Postnummer:</label>
        <input type="text" name="postal_code" value= "<?=htmlentities($userInfo['postal_code'])?>">
        <label for="city">Stad:</label>
        <input type="text" name="city" value= "<?=htmlentities($userInfo['city'])?>">
        <button>Change password</button>
        <p> Medlemskap skapad: <?=substr($userInfo['create_date'], 0, 10)?></p>
        <button type="submit" name="saveChangesBtn">Spara ändringar</button>
        <a href="my-page.php" class="button">Tillbaka</a>
    </form>

</main>

<?php include('../layout/footer.php');?>

