<?php
require('../src/config.php');

    if (isset($_POST['createOrderBtn']) && !empty($_SESSION['cartItems'])) {
        $firstName =      trim($_POST['fname']);
        $lastName =       trim($_POST['lname']);
        $email =          trim($_POST['email']);
        $password =       trim($_POST['password']);
        $street =         trim($_POST['street']);
        $postal_code =     trim($_POST['postal-code']);
        $phone =          trim($_POST['phone']);
        $city =           trim($_POST['city']);
        $cartTotelSum =   $_POST['cartTotalSum'];
        $placeholderProfileImg = "avatar-1.png";
     
        if (empty($firstName) || empty($lastName) || empty($email) || empty($password) || empty($phone) || empty($street) || 
            empty($postal_code) || empty($city)) { 
            redirect("products/checkout.php?infoRequired");
            exit;
        } 
        
        $user = $usersDbHandler-> fetchUserByEmail($email);
        $userId = isset($user['id']) ? $user['id'] : null;


        // CHECKING IF BUYER ENTERED CORRECT PASSWORD
        if ($user && !password_verify($password, $user['password'])){
            redirect("products/checkout.php?wrongPassword");
            exit;
        }
        
        // CREATING NEW USER IF FIRST TIME BUYER
        if (empty($user)) {
            $sql = "
                    INSERT INTO users (first_name, last_name, email, password, phone, street, postal_code, city, img_url) 
                    VALUES (:first_name, :last_name, :email, :password, :phone, :street, :postalCode, :city, :img_url)";

                $encryptedPassword = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':first_name', $firstName);
                $stmt->bindParam(':last_name', $lastName);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':password', $encryptedPassword);
                $stmt->bindParam(':phone', $phone);
                $stmt->bindParam(':street', $street);
                $stmt->bindParam(':postalCode', $postal_code);
                $stmt->bindParam(':city', $city);
                $stmt->bindParam(':img_url', $placeholderProfileImg);
                $stmt->execute();
                $userId = $pdo->lastInsertId();
        }

        // CREATING ORDER

        $sql = "
            INSERT INTO orders (user_id, total_price, billing_full_name, billing_street, billing_postal_code, billing_city) 
            VALUES (:user_id, :total_price, :billing_full_name, :billing_street, :billing_postalCode, :billing_city);
        ";

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':user_id', $userId);
        $stmt->bindValue(':total_price', $cartTotelSum);
        $stmt->bindValue(':billing_full_name', $firstName . " " . $lastName);
        $stmt->bindValue(':billing_street', $street);
        $stmt->bindValue(':billing_postalCode', $postal_code);
        $stmt->bindValue(':billing_city', $city);
        $stmt->execute();
        $orderId = $pdo->lastInsertId();

        foreach ($_SESSION['cartItems'] as $productId => $product) {
            $sql = "
                INSERT INTO order_items (order_id, product_id, product_title, quantity, unit_price)
                VALUES (:order_id, :product_id, :product_title, :quantity, :unit_price);
            ";

            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':order_id', $orderId);
            $stmt->bindValue(':product_id', $product['id']);
            $stmt->bindValue(':product_title', $product['title']);
            $stmt->bindValue(':quantity', $product['quantity']);
            $stmt->bindValue(':unit_price', $product['price']);
            $stmt->execute();
        }

        header('Location: ../public/products/order-confirmation.php?order_id='.$orderId.'&email='. $email);
        exit;
    }

    header('Location: ../public/products/checkout.php');
    exit;

?>