<?php
require_once 'controllers/BaseController.php';

class AuthController extends BaseController {
    private $pdo;

    public function __construct($pdo) {             // Controller potřebuje přístup k databázi pro ověření přihlášení
        $this->pdo = $pdo;
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email']) && isset($_POST['password'])) {             // Zpracování odeslaného formuláře (Business logika)
            $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = :email AND heslo = :heslo");
            $stmt->execute([
                'email' => $_POST['email'],
                'heslo' => $_POST['password']
            ]);
            
            $user = $stmt->fetch(); 
            
            if ($user) {
                $_SESSION['user'] = $user['jmeno'] . ' ' . $user['prijmeni'];
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['is_admin'] = $user['is_admin'];
                
                $updateStmt = $this->pdo->prepare("UPDATE users SET last_login = NOW() WHERE id = :id");
                $updateStmt->execute(['id' => $user['id']]);
                
                header("Location: index.php?url=dashboard");
                exit;
            } else {
                $login_error = "Neplatný e-mail nebo heslo.";
                require 'views/login.php';
                return;
            }
        }
        
        require 'views/login.php';
    }

    public function logout() {
        session_destroy();
        header("Location: index.php?url=login");
        exit;
    }
}