<?php
require_once __DIR__ . '/../config/Database.php';

class Product {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function getNewArrivals() {
        $stmt = $this->conn->prepare("SELECT * FROM products WHERE is_new = 1 LIMIT 8");
        $stmt->execute();
        return $stmt;
    }

    public function getOffers() {
        $stmt = $this->conn->prepare("SELECT * FROM products WHERE is_offer = 1");
        $stmt->execute();
        return $stmt;
    }

    public function getByCategory($category, $gender) {
        $stmt = $this->conn->prepare(
            "SELECT * FROM products WHERE category = :cat AND gender = :gen"
        );
        $stmt->execute([
            ':cat' => $category,
            ':gen' => $gender
        ]);
        return $stmt;
    }

    public function countByCategory($category, $gender)
{
    $stmt = $this->conn->prepare("
        SELECT COUNT(*) AS total
        FROM products
        WHERE category = :cat AND gender = :gen
    ");
    $stmt->execute([
        ':cat' => $category,
        ':gen' => $gender
    ]);

    return (int)($stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0);
}

    public function getByCategoryPaged($category, $gender, $limit, $offset)
    {
        $stmt = $this->conn->prepare("
            SELECT *
            FROM products
            WHERE category = :cat AND gender = :gen
            ORDER BY created_at DESC
            LIMIT :lim OFFSET :off
        ");

        $stmt->bindValue(':cat', $category, PDO::PARAM_STR);
        $stmt->bindValue(':gen', $gender, PDO::PARAM_STR);
        $stmt->bindValue(':lim', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':off', (int)$offset, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
