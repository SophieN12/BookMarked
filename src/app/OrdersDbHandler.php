<?php

class OrdersDbHandler {
    function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function fetchAllOrders() {
        $sql = "
            SELECT * FROM orders
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function fetchOrderInfoById($orderId) {
        $sql = "
            SELECT * FROM orders
            WHERE id = :order_id
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':order_id', $orderId);
        $stmt->execute();

        return $stmt->fetch();
    }
    
    public function fetchOrdersInfoById($orderId) {
        $sql = "
            SELECT * FROM orders
            WHERE id = :order_id
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':order_id', $orderId);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function fetchOrderItemsById($orderId) {
        $sql = "
            SELECT order_items.*, books.img_url 
            FROM `order_items` 
            INNER JOIN books 
            ON order_items.product_id = books.id
            WHERE order_id = :order_id
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':order_id', $orderId);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function fetchOrdersByUserId($userId) {
        $sql = "
            SELECT * FROM orders
            WHERE user_id = :user_id
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function deleteOrder($orderId) {
        $sql = "
            DELETE FROM orders
            WHERE id = :orderId
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':orderId', $orderId);
        return $stmt->execute();
    }
}
