<?php
    require('../../src/config.php');

    $first_name         = "";
    $last_name          = "";
    $email              = "";
    $password           = "";
    $confirmPassword    = "";
    $successMessage     = "";
    $errorMessages      = "";

    if (isset($_POST['createAccountBtn'])) {
        $confirmPassword = trim($_POST['register-confirm-password']);

        if (empty($_POST['register-fname'])) {
            $errorMessages .= "Please enter your first name<br>";
        } else {
            $first_name = trim($_POST['register-fname']);
            if(preg_match('/[\^£$%&"*()}{@#~?><>,|=_+¬]/', $_POST['register-fname'])) {
                $errorMessages .= "Special characters in 'First name' are not allowed, please try again<br>";
            };
        }

        if (empty($_POST['register-lname'])) {
            $errorMessages .= "Please enter your last name<br>";
        } else {
            $last_name = trim($_POST['register-lname']);
            if(preg_match('/[\^£$%&"*()}{@#~?><>,|=_+¬]/', $_POST['register-lname'])) {
                $errorMessages .= "Special characters in 'Last name' are not allowed, please try again<br>";
            };
        }

        if (empty($_POST['register-email'])) {
            $errorMessages .= "Please enter your email<br>";
        } else {
            $email = trim($_POST['register-email']);
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errorMessages .= "Not a valid email, please try again<br>";
            }
        }

        if (empty($_POST['register-password'])) {
            $errorMessages .= "Please enter a password<br>";
        } else {
            $password = trim($_POST['register-password']);
        }

        if (empty($confirmPassword)) {
            $errorMessages .= "Please confirm your password<br>";
        } else {
            if ($_POST['register-password'] !== $confirmPassword) {
                $errorMessages .= "Confirmed password incorrect!<br>";
            }
        }
        
        // If no errors then create user in database
        if (empty($errorMessages)) {
            try {
                $usersDbHandler->createAccount (
                    $first_name, $last_name, $email, $password);
                
                $successMessage = "User succesfully created!";
                header('Location: ' . $_SERVER['HTTP_REFERER']. '?userCreated');
                exit;
                // redirect("../products/index.php?userCreated");
                
            } catch (\PDOException $e ){
                if ((int) $e->getCode() === 23000) {
                    $errorMessages .= "Email address already registred, please enter a different email";
                } else {
                    throw new \PDOException($e->getMessage(), (int) $e->getCode());
                }
            }
        }
    }

    $data = [
        'successMessage' => $successMessage,
        'errorMessages' => $errorMessages
    ];
    
    echo json_encode($data);

    
