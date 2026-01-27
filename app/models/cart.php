<?php

require_once __DIR__ . '/../config/Database.php';

class Cart
{
    private $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function add($userId, $productId)
    {
        // Check if already in cart
        $stmt = $this->conn->prepare("
            SELECT * FROM cart_items
            WHERE user_id = :uid AND product_id = :pid
        ");
        $stmt->execute([
            ':uid' => $userId,
            ':pid' => $productId
        ]);

        if ($stmt->rowCount() > 0) {
            // Increase quantity
            $this->conn->prepare("
                UPDATE cart_items
                SET quantity = quantity + 1
                WHERE user_id = :uid AND product_id = :pid
            ")->execute([
                ':uid' => $userId,
                ':pid' => $productId
            ]);
        } else {
            // Insert new
            $this->conn->prepare("
                INSERT INTO cart_items (user_id, product_id)
                VALUES (:uid, :pid)
            ")->execute([
                ':uid' => $userId,
                ':pid' => $productId
            ]);
        }
    }

    public function countItems($userId)
    {
        $stmt = $this->conn->prepare("
            SELECT SUM(quantity) AS total
            FROM cart_items
            WHERE user_id = :uid
        ");
        $stmt->execute([':uid' => $userId]);

        return $stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
    }

}
