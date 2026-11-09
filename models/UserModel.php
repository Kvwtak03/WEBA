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

    // Metoda pro smazání uživatele podle ID
    public function deleteUser($id) {
        $stmt = $this->pdo->prepare("DELETE FROM users WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    // Metoda pro získání dat jednoho konkrétního uživatele 
    public function getUserById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    // Metoda pro úpravu stávajícího uživatele
    public function updateUser($id, $jmeno, $prijmeni, $email, $telefon, $pracovna) {
        $stmt = $this->pdo->prepare("UPDATE users SET jmeno = :jmeno, prijmeni = :prijmeni, email = :email, telefon = :telefon, pracovna = :pracovna WHERE id = :id");
        return $stmt->execute([
            'jmeno' => $jmeno,
            'prijmeni' => $prijmeni,
            'email' => $email,
            'telefon' => $telefon,
            'pracovna' => $pracovna,
            'id' => $id
        ]);
    }

    // Metoda pro přidání nového uživatele (zjednodušená verze pro náš formulář)
    public function addUser($jmeno, $prijmeni, $email, $telefon, $pracovna) {
        $stmt = $this->pdo->prepare("INSERT INTO users (jmeno, prijmeni, email, heslo, pracovna, telefon, is_admin) VALUES (:jmeno, :prijmeni, :email, 'heslo123', :pracovna, :telefon, 0)");
        return $stmt->execute([
            'jmeno' => $jmeno,
            'prijmeni' => $prijmeni,
            'email' => $email,
            'pracovna' => $pracovna,
            'telefon' => $telefon
        ]);
    }
}