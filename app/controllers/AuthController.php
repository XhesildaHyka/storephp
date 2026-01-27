<?php

require_once __DIR__ . '/../config/Database.php';

class AuthController
{
    public function login()
    {
        require "../app/views/auth/login.php";
    }

    public function authenticate()
    {
        $db = new Database();
        $conn = $db->connect();

        $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute([':email' => $_POST['email']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($_POST['password'], $user['password'])) {
            $_SESSION['user'] = [
                'id' => $user['id'],
                'name' => $user['name'],
                'role' => $user['role']
            ];

            header("Location: /store-system/public/");
            exit;
        }

        $_SESSION['error'] = "Invalid login";
        header("Location: ?page=login");
    }

    public function logout()
    {
        session_destroy();
        header("Location: ?page=home");
    }

    public function register()
{
    require "../app/views/auth/register.php";
}

public function registerProcess()
{
    $db = new Database();
    $conn = $db->connect();

    // 1️⃣ Check if email already exists
    $check = $conn->prepare("SELECT id FROM users WHERE email = :email");
    $check->execute([
        ':email' => $_POST['email']
    ]);

    if ($check->fetch()) {
        $_SESSION['error'] = "Email already registered. Please login.";
        header("Location: ?page=register");
        exit;
    }

    // 2️⃣ Insert new user
    $stmt = $conn->prepare("
        INSERT INTO users (name, email, password, role)
        VALUES (:name, :email, :password, 'user')
    ");

    $stmt->execute([
        ':name' => $_POST['name'],
        ':email' => $_POST['email'],
        ':password' => password_hash($_POST['password'], PASSWORD_DEFAULT)
    ]);

    $_SESSION['success'] = "Account created successfully. Please login.";
    header("Location: ?page=login");
    exit;
}


}
