<?php

class PageController
{
    public function about()
    {
        require "../app/views/pages/about.php";
    }

    public function contact()
    {
        require "../app/views/pages/contact.php";
    }

    public function contactProcess()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: ?page=contact");
            exit;
        }

        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $subject = trim($_POST['subject'] ?? '');
        $message = trim($_POST['message'] ?? '');

        if ($name === '' || $email === '' || $subject === '' || $message === '') {
            $_SESSION['contact_error'] = "Please fill in all fields.";
            header("Location: ?page=contact");
            exit;
        }

        require_once __DIR__ . "/../config/Database.php";
        $db = new Database();
        $conn = $db->connect();

        $stmt = $conn->prepare("
            INSERT INTO contact_messages (name, email, subject, message)
            VALUES (:name, :email, :subject, :message)
        ");

        $stmt->execute([
            ':name' => $name,
            ':email' => $email,
            ':subject' => $subject,
            ':message' => $message
        ]);

        // ✅ FLASH SUCCESS
        $_SESSION['contact_success'] = "✅ Message sent successfully. We’ll reply soon.";

        header("Location: ?page=contact");
        exit;
    }
}
