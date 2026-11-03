<?php           //jediné místo v celé aplikaci, kde se smí psát SQL dotazy
class UserModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;                  // Při vytvoření Modelu mu předáme spojení s databází ($pdo)

    }

    public function getAllUsers() {             // Metoda pro načtení všech uživatelů
        $stmt = $this->pdo->query("SELECT * FROM users");
        return $stmt->fetchAll();
    }

    public function getRecentLogins() {
        $stmt = $this->pdo->query("SELECT * FROM users WHERE last_login IS NOT NULL ORDER BY last_login DESC LIMIT 5");
        return $stmt->fetchAll();
    }
}