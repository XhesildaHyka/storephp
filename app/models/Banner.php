<?php
require_once __DIR__ . '/../config/Database.php';

class Banner {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function getActive() {
        $stmt = $this->conn->prepare(
            "SELECT * FROM banners WHERE is_active = 1"
        );
        $stmt->execute();
        return $stmt;
    }
}
