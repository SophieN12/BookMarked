<?php

class UsersDbHandler {
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    public function fetchAllUsers () {
        $sql = "
            SELECT * FROM users
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function fetchUserById ($id) {
        $sql = "
            SELECT * FROM users
            WHERE id = :id
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch();
    }

    public function fetchUserByEmail ($email) {
        $sql = "
            SELECT * FROM users
            WHERE email = :email
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        return $stmt->fetch();
    }

    public function deleteUser ($id) {
        $sql = "
            DELETE FROM users
            WHERE id = :id    
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function updateUser ($id, $first_name, $last_name, $email, $encryptedPassword, $phone,
     $street, $postal_code, $city) {
        $sql = "
        UPDATE users
        SET 
        first_name = :first_name, 
        last_name = :last_name, 
        email = :email, 
        password = :password, 
        phone = :phone, 
        street = :street, 
        postal_code = :postal_code, 
        city = :city
        WHERE id = :id
        ";
               
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':first_name', $first_name);
        $stmt->bindParam(':last_name', $last_name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $encryptedPassword);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':street', $street);
        $stmt->bindParam(':postal_code', $postal_code);
        $stmt->bindParam(':city', $city);
        return $stmt->execute();
    }

    public function createUser ($first_name, $last_name, $email, $password, $phone,
     $street, $postal_code, $city) {
        $sql = "
        INSERT INTO users (first_name, last_name, email, password, phone, street, postal_code, city) 
        VALUES (:first_name, :last_name, :email, :password, :phone, :street, :postal_code, :city)";
        
        $encryptedPassword = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':first_name', $first_name);
        $stmt->bindParam(':last_name', $last_name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $encryptedPassword);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':street', $street);
        $stmt->bindParam(':postal_code', $postal_code);
        $stmt->bindParam(':city', $city);
        return $stmt->execute();
    }

    public function createAccount ($first_name, $last_name, $email, $password) {
        $sql = "
        INSERT INTO users (first_name, last_name, email, password, img_url) 
        VALUES (:first_name, :last_name, :email, :password, 'avatar-1.png')";
        
        $encryptedPassword = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':first_name', $first_name);
        $stmt->bindParam(':last_name', $last_name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $encryptedPassword);
        return $stmt->execute();
    }
}
