<?php
$host = 'db';
$db = 'univerzita';
$user = 'root';
$pass = 'heslo';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
    echo "";
} catch (\PDOException $e) {
    die("Chyba připojení k databázi: " . $e->getMessage());
}
?>